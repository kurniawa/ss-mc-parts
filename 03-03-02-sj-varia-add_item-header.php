<?php
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
        $harga_price_list += (int)$harga_ukuran;
    }

    if (isset($_POST["jahit"])) {
        $jahit = $_POST["jahit"];
        $data_harga_jahit = dbGetWithFilter("harga_lain", "nama", $jahit);

        br_2x();
        var_dump($data_harga_jahit);
        br_2x();

        var_dump(json_encode($data_harga_jahit));

        if ($status == "OK") {
            array_push($column_to_check, "jahit");
            array_push($value_to_check, $jahit);
            $harga_price_list += (int)$data_harga_jahit[0]["harga"];
            $nama_lengkap .= " + jht $jahit";
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

// Mulai insert produk dan spk_contains_produk
$id_produk = 0;
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

        if ($status == "OK") {
            array_unshift($column_to_check, "id");
            array_unshift($value_to_check, $id_produk);
            array_push($column_to_check, "nama_lengkap");
            array_push($value_to_check, $nama_lengkap);
            dbInsert("produk", $column_to_check, $value_to_check);
        }
    }
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
