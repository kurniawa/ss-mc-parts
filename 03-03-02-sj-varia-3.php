<?php

include_once "01-config.php";
include_once "01-header.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST);
    $status = "OK";
    $htmlLogOK = $htmlLogOK . "REQUEST METHOD: POST<br><br>";
    $bahan = $_POST["bahan"];
    $varia = $_POST["varia"];
    $jumlah = $_POST["jumlah"];
    $jahit = "none";
    $ukuran = "none";
    $ktrg = "none";
    $harga_bahan = $_POST["harga_bahan"];

    $id_spk = $_POST["id_spk"];
    $id_produk = $_POST["id_produk"];
    $id_spk_contains_item = $_POST["id_spk_contains_item"];

    // Definisi column yang nantinya berguna untuk pengecekan (bukan dalam scope selection ini)
    $column_to_check = ["tipe", "bahan", "varia"];
    $value_to_check = ["sj-varia", $bahan, $varia];
    $harga_jahit = 0;
    $harga_ukuran = 0;
    $harga = 0;

    if (isset($_POST["ukuran"])) {
        $ukuran = $_POST["ukuran"];
        array_push($column_to_check, "ukuran");
        array_push($value_to_check, $ukuran);
        if ($ukuran == "JB 93x53") {
            $db_harga_ukuran = dbGetWithFilter("harga_lain", "keterangan", "uk. jb");
        } elseif ($ukuran == "Super-JB 97x53") {
            $db_harga_ukuran = dbGetWithFilter("harga_lain", "keterangan", "uk. super-jb");
        }
    } else {
        array_push($column_to_check, "ukuran");
        array_push($value_to_check, "");
    }

    if (isset($_POST["jahit"])) {
        $jahit = $_POST["jahit"];
        array_push($column_to_check, "jahit");
        array_push($value_to_check, $jahit);
        $db_harga_jahit = dbGetWithFilter("harga_lain", "keterangan", "jht");
        // echo "<br><br>";
        // var_dump($db_harga_jahit);
        if ($status == "OK") {
            $harga_jahit =  $db_harga_jahit[0]["harga"];
            // echo "<br><br>";
            // var_dump($harga_jahit);
            $htmlLogOK = $htmlLogOK . "harga_jahit: $harga_jahit<br><br>";
        }
    } else {
        array_push($column_to_check, "jahit");
        array_push($value_to_check, "");
    }

    if (isset($_POST["ktrg"])) {
        $ktrg = $_POST["ktrg"];
    } else {
        $ktrg = "";
    }

    $htmlLogOK = $htmlLogOK .
        "bahan: $bahan<br>" .
        "varia: $varia<br>" .
        "jumlah: $jumlah<br>" .
        "jahit: $jahit<br>" .
        "ukuran: $ukuran<br>" .
        "keterangan: $ktrg<br><br>";
} else {
    $status = "ERROR";
    $htmlLogError = $htmlLogError . "REQUEST METHOD: Entahlah!<br><br>";
}

if ($status == "OK") {
    // Cek apakah produk yang diedit tersebut sudah ada atau belum
    var_dump($column_to_check);
    echo "<br><br>";
    var_dump($value_to_check);
    echo "<br><br>";
    $check_produk = dbCheck("produk", $column_to_check, $value_to_check);
    // var_dump($check_produk[0]);
    if ($check_produk == "BELUM ADA") {
        $id_produk = nextID("produk", "id");
        $nama_lengkap_produk = "$bahan $varia";

        if ($ukuran !== "none") {
            $nama_lengkap_produk = $nama_lengkap_produk . " $ukuran";
        }

        if ($jahit !== "none") {
            $nama_lengkap_produk = $nama_lengkap_produk . " + jht $jahit";
        }

        if ($status == "OK") {
            array_unshift($column_to_check, "id");
            array_unshift($value_to_check, $id_produk);
            array_push($column_to_check, "nama_lengkap");
            array_push($value_to_check, $nama_lengkap_produk);
            dbInsert("produk", $column_to_check, $value_to_check);
        }
    }
}

// Mulai update data spk, spk_contains_produk
if ($status == "OK") {
    $harga = (int)$harga_bahan + (int)$harga_jahit + (int)$harga_ukuran;
    // var_dump($harga);
    $column_spk_contains_produk_to_update = ["id_produk", "ktrg", "jumlah", "harga_item"];
    $value_spk_contains_produk_to_update = [$id_produk, $ktrg, $jumlah, $harga];
    dbUpdate("spk_contains_produk", $column_spk_contains_produk_to_update, $value_spk_contains_produk_to_update, "id", $id_spk_contains_item);
}

$htmlLogError = $htmlLogError . "</div>";
$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";

?>

<div class="text-center mt-1em">
    <div class="btn-1 d-inline-block bg-color-orange-1" onclick="backToEditSPK();">Kembali ke Edit SPK</div>
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

    function backToEditSPK() {
        window.history.go(-2);
    }
</script>

<?php
include_once "01-footer.php";
?>