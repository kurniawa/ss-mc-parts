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
    }

    if (isset($_POST["ktrg"])) {
        $ktrg = $_POST["ktrg"];
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
    $check_produk = dbCheck("produk", $column_to_check, $value_to_check);
    // var_dump($check_produk[0]);
    if ($check_produk == "BELUM ADA") {
        $id_produk = nextID("produk", "id");
        if ($status == "OK") {
            array_unshift($column_to_check, "id");
            array_unshift($value_to_check, $id_produk);
            dbInsert("produk", $column_to_check, $value_to_check);
        }
    }
}

// Mulai update data spk, spk_contains_produk
if ($status == "OK") {
}

$htmlLogError = $htmlLogError . "</div>";
$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";

?>

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
</script>

<?php
include_once "01-footer.php";
?>