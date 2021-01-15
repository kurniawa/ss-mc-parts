<?php
include_once "01-config.php";
include_once "01-header.php";
include_once "01-backUpSQLTable.php";
$tipe = "sj-std";
$std = "";
$harga_std = "";
$jahit = "";

$jumlah = "";
$ktrg = "";

$nama_lengkap = "";
$nama_nota = "";
$harga_jahit = 0;
$harga_kali_jumlah = 0;
$harga_price_list = 0;

$tipe_jahit = "";
$harga_jahit = 0;

$id_spk = null;

// Definisi column yang nantinya berguna untuk pengecekan (bukan dalam scope selection ini)
$column_to_check = ["tipe"];
$value_to_check = ["sj-std"];

// var_dump($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = "OK";
    $htmlLogOK = $htmlLogOK . "REQUEST METHOD: POST<br><br>";

    $id_spk = $_POST["id_spk"];
    $std = $_POST["std"];
    $harga_std = $_POST["harga_std"];

    $harga_price_list += (int)$harga_std;

    $nama_lengkap .= "SJ STD $std";
    $nama_nota = $nama_lengkap;

    // var_dump($nama_lengkap);
    if (isset($_POST["jahit"])) {
        $jahit = $_POST["jahit"];
        $jahit = json_decode($jahit, true);
        $tipe_jahit = $jahit["tipeJahit"];
        $harga_jahit = $jahit["hargaJahit"];
        // $data_harga_jahit = dbGetWithFilter("harga_lain", "nama", $jahit);

        // br_2x();
        // var_dump($data_harga_jahit);
        // br_2x();

        // var_dump(json_encode($data_harga_jahit));

        if ($status == "OK") {
            array_push($column_to_check, "jahit");
            array_push($value_to_check, $tipe_jahit);
            $harga_price_list += (int)$harga_jahit;
            $nama_lengkap .= " + jht $tipe_jahit";
            $nama_nota .= " + jht $tipe_jahit";
        }
    }
    if (isset($_POST["ktrg"])) {
        $ktrg = $_POST["ktrg"];
    }

    $jumlah = $_POST["jumlah"];

    array_push($column_to_check, "nama_lengkap", "nama_nota");
    array_push($value_to_check, $nama_lengkap, $nama_nota);

    array_push($column_to_check, "harga_price_list");
    array_push($value_to_check, $harga_price_list);

    $htmlLogOK = $htmlLogOK .
        "std: " . $std . "<br>" .
        "harga_std: " . $harga_std . "<br>" .
        "jahit: " . $tipe_jahit . "<br>" .
        "harga_jahit: " . $harga_jahit . "<br>" .
        "nama_lengkap: " . $nama_lengkap . "<br>" .
        "ktrg: " . $ktrg . "<br>" .
        "jumlah: " . $jumlah . "<br><br>";
} else {
    $status = "NOT OK";
    $htmlLogError = $htmlLogError . "REQUEST METHOD: ENTAHLAH!<br><br>";
}

// MULAI INSERT ke produk
$id_produk = 0;
if ($status == "OK") {
    // Cek apakah produk yang diedit tersebut sudah ada atau belum
    // var_dump($column_to_check);
    // echo "<br><br>";
    // var_dump($value_to_check);
    // echo "<br><br>";
    $check_produk = dbCheck("produk", $column_to_check, $value_to_check);
    // var_dump($check_produk[0]);
    // br_2x();
    // var_dump($check_produk);
    // br_2x();
    if ($check_produk == "BELUM ADA") {
        $id_produk = nextID("produk", "id");

        array_unshift($column_to_check, "id");
        array_unshift($value_to_check, $id_produk);
        dbInsert("produk", $column_to_check, $value_to_check);
        backUpSQLTable("produk");
    } else {
        array_unshift($column_to_check, "id");
        array_unshift($value_to_check, $id_produk);
        $id_produk = $check_produk[1];
    }

    array_push($column_to_check, "nama_lengkap");
    array_push($value_to_check, $nama_lengkap);
}

// MULAI INSERT KE spk_contains_produk
if ($status == "OK") {
    // TENTUKAN next_id pada tabel spk_contains_produk
    $id_spk_contains_produk = nextID("spk_contains_produk", "id");

    $harga_kali_jumlah = (int)$harga_price_list * $jumlah;

    $column = ["id", "id_spk", "id_produk", "ktrg", "jumlah", "harga_item"];
    $value = [$id_spk_contains_produk, $id_spk, $id_produk, $ktrg, $jumlah, $harga_kali_jumlah];
    dbInsert("spk_contains_produk", $column, $value);
    backUpSQLTable("spk_contains_produk");
}

$htmlLogError = $htmlLogError . "</div>";
$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";

?>

<div class="mt-2em text-center">
    <button id='backToSPK' class="btn-1 d-inline-block bg-color-orange-1" onclick="backToSPK();">Kembali ke SPK</button>
</div>

<div class="divLogError"></div>
<div class="divLogOK"></div>
<div class="divLogWarning"></div>

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

    function backToSPK() {
        window.history.go(-2);
    }
</script>

<?php
include_once "01-footer.php";
?>