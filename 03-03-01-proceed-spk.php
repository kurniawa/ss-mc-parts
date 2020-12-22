<?php
include_once "01-header.php";
include_once "01-config.php";

// PASTIKAN REQUEST METHOD nya: POST
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
    $tgl_pembuatan = date("Y-m-d", strtotime($_POST["tgl_pembuatan"]));
    $ket_judul = $_POST["ket_judul"];
    $total_harga = $_POST["total_harga"];

    $htmlLogOK = $htmlLogOK .
        "id_pelanggan: $id_pelanggan<br>" .
        "tgl_pembuatan: $tgl_pembuatan<br>" .
        "ket_judul: $ket_judul<br>" .
        "total_harga: $total_harga<br><br>";
}

// MULAI INSERT ke spk, table produk, kemudian spk_contains_produk
if ($status == "OK") {
    $table_spk = "spk";
    $column_spk = "id";
    $next_id_spk = nextID($table_spk, $column_spk);

    if ($next_id_spk !== "ERROR") {
        $column_spk = ["id", "tgl_pembuatan", "ket_judul", "id_pelanggan", "harga"];
        $value_spk = [$next_id_spk, $tgl_pembuatan, $ket_judul, $id_pelanggan, $total_harga];
        dbInsert($table_spk, $column_spk, $value_spk);
    }
}
// MULAI Insert ke table produk
// Get apa yang ada di table spk_item
if ($status == "OK") {
    $table_spk_item = "spk_item";
    $spk_item = dbGet($table_spk_item);

    if ($status == "OK") {
        $spk_item_length = count($spk_item);
        for ($i = 0; $i < $spk_item_length; $i++) {
            // CEK apakah produk sudah terdaftar di table produk
            $id_produk_spk_contains_produk = 0;
            $table_cek_produk = "produk";
            $column_cek_produk = ["tipe", "bahan", "varia", "ukuran", "jahit", "nama_lengkap", "harga_price_list"];
            $value_cek_produk = [$spk_item[$i]["tipe"], $spk_item[$i]["bahan"], $spk_item[$i]["varia"], $spk_item[$i]["ukuran"], $spk_item[$i]["jahit"], $spk_item[$i]["nama_lengkap"], $spk_item[$i]["harga_price_list"]];

            $check_produk = dbCheck($table_cek_produk, $column_cek_produk, $value_cek_produk);

            if ($check_produk == "BELUM ADA") {
                // INSERT produk baru ke Database
                $next_id_produk = nextID("produk", "id");
                if ($next_id_produk !== "ERROR") {
                    $table_produk = "produk";
                    $column_produk = ["id", "tipe", "bahan", "varia", "ukuran", "jahit", "nama_lengkap", "harga_price_list"];
                    $value_produk = [$next_id_produk, $spk_item[$i]["tipe"], $spk_item[$i]["bahan"], $spk_item[$i]["varia"], $spk_item[$i]["ukuran"], $spk_item[$i]["jahit"], $spk_item[$i]["nama_lengkap"], $spk_item[$i]["harga_price_list"]];

                    dbInsert($table_produk, $column_produk, $value_produk);
                }
                $id_produk_spk_contains_produk = $next_id_produk;
            } else {
                $id_produk_spk_contains_produk = $check_produk[1];
            }

            // MULAI INSERT ke spk_contains_produk
            // MENENTUKAN NEXT ID dari spk_contains_produk
            $table_spk_contains_produk = "spk_contains_produk";
            $next_id_spk_contains_produk = nextID($table_spk_contains_produk, "id");

            if ($next_id_spk_contains_produk !== "ERROR") {
                $column_spk_contains_produk = ["id", "id_spk", "id_produk", "ktrg", "jumlah", "harga_item"];
                $value_spk_contains_produk = [$next_id_spk_contains_produk, $next_id_spk, $id_produk_spk_contains_produk, $spk_item[$i]["ktrg"], $spk_item[$i]["jumlah"], $spk_item[$i]["harga_item"]];
                dbInsert($table_spk_contains_produk, $column_spk_contains_produk, $value_spk_contains_produk);
            }
        }
    }
}
// Cek next_id di spk
$table = "spk";
$column = [];
// dbInsert($table, $column, $value);

// MULAI HAPUS SPK item dengan ID yang telah ditentukan
if ($status == "OK") {
    $table = "spk_item";
    $column = "id";
    // dbDelete($table, $column, $id);
}

$htmlLogError = $htmlLogError . "</div>";
$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";

?>

<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="goBack();" style="display: none">
    <div class="justify-self-right pr-0_5em">
        <!-- <a href="06-02-produk-baru.php" id="btnNewProduct" class="btn-atas-kanan2">
            + Tambah Produk Baru
        </a> -->
    </div>
</header>
<form action="03-06-print-out-spk.php" method="GET">
    <input type="hidden" name="id_spk" id="inputIDSPK">
    <div class="text-center mt-1em">
        <button type="submit" id='btnGoToPrintOutSPK' class="btn-1 d-inline-block bg-color-orange-1" onclick="goToPrintOutSPK();">print-out-spk ==></button>
    </div>

</form>
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

    if (status == "OK") {
        var id_spk = <?= $next_id_spk; ?>;
        console.log(`id_spk: ${id_spk}`);
        $('#inputIDSPK').val(id_spk);
    }
</script>