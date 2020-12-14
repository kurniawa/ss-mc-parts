<?php
include_once "01-header.php";
include_once "01-config.php";

$htmlLogError = "<div class='logError'>";
$htmlLogOK = "<div class='logOK'>";
$htmlLogWarning = "<div class='logWarning'>";
$status = "";

$tipe = "sj-varia";
$bahan = "";
$varia = "";
$harga_bahan = "";
$jahit = "";

$ukuran = "";
$tipe_ukuran = "";
$nama_nota_ukuran = "";
$harga_ukuran = 0;

$jumlah = "";
$ktrg = "";

$harga_jahit = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = "OK";
    $htmlLogOK = $htmlLogOK . "REQUEST METHOD: POST<br><br>";

    $bahan = $_POST["bahan"];
    $varia = $_POST["varia"];
    $harga_bahan = $_POST["harga_bahan"];

    if (isset($_POST["jahit"])) {
        $jahit = $_POST["jahit"];
        $harga_jahit = 1000;
    }
    if (isset($_POST["ukuran"])) {
        $ukuran = $_POST["ukuran"];
        // var_dump($ukuran);
        $ukuran = json_decode($ukuran, true);
        // echo "<br><br>";
        // var_dump($ukuran);
        // $tipe_ukuran = $ukuran->tipeUkuran;
        $tipe_ukuran = $ukuran["tipeUkuran"];
        $nama_nota_ukuran = $ukuran["namaNotaUkuran"];
        $harga_ukuran = $ukuran["hargaUkuran"];
    }
    if (isset($_POST["ktrg"])) {
        $ktrg = $_POST["ktrg"];
    }

    $jumlah = $_POST["jumlah"];

    $htmlLogOK = $htmlLogOK .
        "bahan: " . $bahan . "<br>" .
        "varia: " . $varia . "<br>" .
        "harga_bahan: " . $harga_bahan . "<br>" .
        "jahit: " . $jahit . "<br>" .
        "harga_jahit: " . $harga_jahit . "<br>" .
        "ukuran (encoded): " . json_encode($ukuran) . "<br>" .
        "tipe_ukuran: " . $tipe_ukuran . "<br>" .
        "nama_nota_ukuran: " . $nama_nota_ukuran . "<br>" .
        "harga_ukuran: " . $harga_ukuran . "<br>" .
        "ktrg: " . $ktrg . "<br>" .
        "jumlah: " . $jumlah . "<br><br>";
} else {
    $status = "NOT OK";
    $htmlLogError = $htmlLogError . "REQUEST METHOD: ENTAHLAH!<br><br>";
}

// Menentukan max id dari temp_produk
$next_id = 0;
if ($status == "OK") {
    $query_max_id_temp_produk = "SELECT max(id) FROM temp_produk";
    $res_query_max_id_temp_produk = mysqli_query($con, $query_max_id_temp_produk);

    if (!$res_query_max_id_temp_produk) {
        $status = "ADA ERROR";
        $htmlLogError = $htmlLogError . $query_max_id_temp_produk . " - FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $status = "OK";
        $htmlLogOK = $htmlLogOK . $query_max_id_temp_produk . " - SUCCEED!<br><br>";

        $max_id_temp_produk = mysqli_fetch_row($res_query_max_id_temp_produk);

        // var_dump($max_id_temp_produk);

        if ($max_id_temp_produk[0] == NULL) {
            $next_id = 1;
        } else {
            $next_id = $max_id_temp_produk[0] + 1;
        }

        $htmlLogOK = $htmlLogOK . "next_id :" . $next_id . "<br><br>";
    }
}

// Mulai insert ke temp_produk
if ($status == "OK") {
    $harga_price_list = $harga_bahan + $harga_jahit + $harga_ukuran;
    $htmlLogOK = $htmlLogOK . "harga_price_list: " . $harga_price_list . "<br><br>";

    $nama_lengkap = $bahan . " " . $varia;
    if ($tipe_ukuran !== "") {
        $nama_lengkap = $nama_lengkap . " uk. " . $tipe_ukuran;
    }

    if ($jahit !== "") {
        $nama_lengkap = $nama_lengkap . " + jht " . $jahit;
    }
    $htmlLogOK = $htmlLogOK . "nama_lengkap: " . $nama_lengkap . "<br><br>";

    $query_insert_temp_produk = "INSERT INTO temp_produk
    (id, tipe, bahan, varia, ukuran, jahit, nama_lengkap, harga_price_list) VALUES
    ($next_id, 'sj-varia', '$bahan', '$tipe_ukuran', '$jahit',)";
} else {
}


$htmlLogError = $htmlLogError . "</div>";
$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";

?>

<div class="divLogError"></div>
<div class="divLogOK"></div>

<script>
    var htmlLogError = `<?= $htmlLogError; ?>`;
    var htmlLogOK = `<?= $htmlLogOK; ?>`;
    var htmlLogWarning = `<?= $htmlLogWarning; ?>`;

    $('.divLogError').html(htmlLogError);
    $('.divLogWarning').html(htmlLogWarning);
    $('.divLogOK').html(htmlLogOK);

    if ($('.logError').html() === '') {
        $('.divLogError').hide();
    } else {
        $('.divLogError').show();
    }

    if ($('.logWarning').html() === '') {
        $('.divLogWarning').hide();
    } else {
        $('.divLogWarning').show();
    }

    if ($('.logOK').html() === '') {
        $('.divLogOK').hide();
    } else {
        $('.divLogOK').show();
    }
</script>