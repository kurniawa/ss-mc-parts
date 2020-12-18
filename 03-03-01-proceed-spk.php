<?php
include_once "01-header.php";
include_once "01-config.php";

// PASTIKAN REQUEST METHOD nya: GET
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = "OK";
    $htmlLogOK = $htmlLogOK . "REQUEST METHOD: POST<br><br>";
} else {
    $status = "NOT OK";
    $htmlLogError = $htmlLogError . "REQUEST METHOD: ENTAHLAH!<br><br>";
}

// DECLARE semua variable yang di post
if ($status == "OK") {
    $id_pelanggan = $_POST["id_pelanggan"];
    $tgl_pembuatan = $_POST["tgl_pembuatan"];
    $ket_judul = $_POST["ket_judul"];
}

// MULAI INSERT ke table produk, kemudian spk, kemudian spk_contains_produk
// MULAI Insert ke table produk
// Get apa yang ada di table spk_item
if ($status == "OK") {
    $table_spk_item = "spk_item";
    $spk_item = dbGet($table_spk_item);

    if ($status == "OK") {
        $spk_item_length = count($spk_item);
        for ($i = 0; $i < $spk_item_length; $i++) {
            // CEK apakah produk sudah terdaftar di table produk
            $table_cek_produk = "produk";
            $column_cek_produk = ["tipe", "bahan", "varia", "ukuran", "jahit", "nama_lengkap", "harga_price_list"];
            $value_cek_produk = [$spk_item[$i]["tipe"], $spk_item[$i]["bahan"], $spk_item[$i]["varia"], $spk_item[$i]["ukuran"], $spk_item[$i]["jahit"], $spk_item[$i]["nama_lengkap"], $spk_item[$i]["harga_price_list"]];

            $check_produk = dbCheck($table_cek_produk, $column_cek_produk, $value_cek_produk);

            if ($check_produk == "BELUM ADA") {
                # code...
            }
            $next_id_produk = nextID("produk", "id");

            $table_produk = "produk";
            $column_produk = ["id", "tipe", "bahan", "varia", "ukuran", "jahit", "nama_lengkap", "harga_price_list"];
            $value_produk = [];
        }
    }
}
// Cek next_id di spk
$table = "spk";
$column = [];
dbInsert($table, $column, $value);

// MULAI HAPUS SPK item dengan ID yang telah ditentukan
if ($status == "OK") {
    $table = "spk_item";
    $column = "id";
    dbDelete($table, $column, $id);
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
        window.history.back();
    }
</script>