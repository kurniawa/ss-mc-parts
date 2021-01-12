<?php
include_once "01-header.php";
include_once "01-config.php";

include_once "01-backUpSQLTable.php";
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

$nama_lengkap = "";
$nama_nota = "";
$harga_jahit = 0;
$harga_kali_jumlah = 0;
$harga_price_list = 0;

$id_spk = null;

// Definisi column yang nantinya berguna untuk pengecekan (bukan dalam scope selection ini)
$column_to_check = ["tipe"];
$value_to_check = ["sj-varia"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = "OK";
    $htmlLogOK = $htmlLogOK . "REQUEST METHOD: POST<br><br>";

    $id_spk = $_POST["id_spk"];

    $bahan = $_POST["bahan"];
    $varia = $_POST["varia"];
    $harga_bahan = $_POST["harga_bahan"];

    array_push($column_to_check, "bahan", "varia");
    array_push($value_to_check, $bahan, $varia);
    $harga_price_list += (int)$harga_bahan;

    $nama_lengkap .= "$bahan $varia";
    $nama_nota = $nama_lengkap;
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
        array_push($column_to_check, "ukuran");
        array_push($value_to_check, $tipe_ukuran);
        $nama_lengkap .= " $tipe_ukuran";
        $nama_nota .= " $nama_nota_ukuran";
        $harga_price_list += (int)$harga_ukuran;
    }

    if (isset($_POST["jahit"])) {
        $jahit = $_POST["jahit"];
        $jahit = json_decode($jahit, true);
        $tipe_jahit = $jahit["tipeJahit"];
        $harga_jahit = $jahit["hargaJahit"];
        // $data_harga_jahit = dbGetWithFilter("harga_lain", "nama", $jahit);

        br_2x();
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

    array_push($column_to_check, "harga_price_list");
    array_push($value_to_check, $harga_price_list);

    $htmlLogOK = $htmlLogOK .
        "bahan: " . $bahan . "<br>" .
        "varia: " . $varia . "<br>" .
        "harga_bahan: " . $harga_bahan . "<br>" .
        "jahit: " . $tipe_jahit . "<br>" .
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

// MULAI INSERT ke produk
$id_produk = 0;
if ($status == "OK") {
    // Cek apakah produk yang diedit tersebut sudah ada atau belum
    var_dump($column_to_check);
    echo "<br><br>";
    var_dump($value_to_check);
    echo "<br><br>";
    $check_produk = dbCheck("produk", $column_to_check, $value_to_check);
    var_dump($check_produk[0]);
    br_2x();
    var_dump($check_produk);
    br_2x();
    if ($check_produk == "BELUM ADA") {
        $id_produk = nextID("produk", "id");
        dbInsert("produk", $column_to_check, $value_to_check);
    } else {
        $id_produk = $check_produk[1];
    }

    array_unshift($column_to_check, "id");
    array_unshift($value_to_check, $id_produk);
    array_push($column_to_check, "nama_lengkap");
    array_push($value_to_check, $nama_lengkap);
}

// MENENTUKAN ID DARI SPK ITEM, apakah mode edit atau insert baru
$id_spk_item = 0;
$mode = "INSERT";
if ($status == "OK") {
    // Menentukan max id dari spk_item
    $query_max_id_spk_item = "SELECT max(id) FROM spk_item";
    $res_query_max_id_spk_item = mysqli_query($con, $query_max_id_spk_item);

    if (!$res_query_max_id_spk_item) {
        $status = "ADA ERROR";
        $htmlLogError = $htmlLogError . $query_max_id_spk_item . " - FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $status = "OK";
        $htmlLogOK = $htmlLogOK . $query_max_id_spk_item . " - SUCCEED!<br><br>";

        $max_id_spk_item = mysqli_fetch_row($res_query_max_id_spk_item);

        // var_dump($max_id_spk_item);

        if ($max_id_spk_item[0] == NULL) {
            $id_spk_item = 1;
        } else {
            $id_spk_item = $max_id_spk_item[0] + 1;
        }

        $htmlLogOK = $htmlLogOK . "id_spk_item :" . $id_spk_item . "<br><br>";
    }
}

// MULAI INSERT KE spk_item
// EDIT CODE DISINI!!!!!!!!!!!!!!!!!!!!!!
if ($status == "OK" && $mode == "INSERT") {
    $table = "spk_item";
    $column = ["id", "tipe", "bahan", "varia", "ukuran", "jahit", "nama_lengkap", "harga_price_list", "ktrg", "jumlah", "harga_item"];
    $value = [$id_spk_item, "sj-varia", $bahan, $varia, $tipe_ukuran, $jahit, $nama_lengkap, $harga_price_list, $ktrg, $jumlah, $harga_item];
    dbInsert($table, $column, $value);
}

$htmlLogError = $htmlLogError . "</div>";
$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";

?>

<div class="text-center mt-1em">
    <div id='btnBackToBeginInsertingProduct' class="btn-1 d-inline-block bg-color-orange-1" onclick="backToBeginInsertingProduct();">Kembali ke SPK -> input item</div>
</div>
<div class="divLogError"></div>
<div class="divLogWarning"></div>
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

    var status = '<?= $status; ?>';
    console.log('status: ' + status);

    function backToBeginInsertingProduct() {
        window.history.go(-2);
    }
</script>