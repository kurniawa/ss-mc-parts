<?php
include_once "01-header.php";
include_once "01-config.php";

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
$harga_jahit = 0;
$harga_item = 0;
$harga_price_list = 0;

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

// MENENTUKAN ID DARI SPK ITEM, apakah mode edit atau insert baru
$id_spk_item = 0;
$mode = "INSERT";
if ($status == "OK") {
    if (isset($_POST["id_item_to_edit"])) {
        $htmlLogWarning = $htmlLogWarning . "MASUK KE MODE EDIT<br><br>";
        $id_spk_item = $_POST["id_item_to_edit"];
        $htmlLogWarning = $htmlLogWarning . "id_spk_item to_edit: " . $id_spk_item . "<br><br>";
        $mode = "EDIT";
    } else {
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
}

//MENENTUKAN harga_price_list dan nama_lengkap
if ($status == "OK") {
    $harga_price_list = $harga_price_list + $harga_bahan + $harga_jahit + $harga_ukuran;
    $harga_item = $harga_price_list * $jumlah;
    $htmlLogOK = $htmlLogOK . "harga_price_list: " . $harga_price_list . "<br><br>";
    $htmlLogOK = $htmlLogOK . "harga_item: " . $harga_item . "<br><br>";

    $nama_lengkap = $nama_lengkap . $bahan . " " . $varia;
    if ($tipe_ukuran !== "") {
        $nama_lengkap = $nama_lengkap . " uk. " . $tipe_ukuran;
    }

    if ($jahit !== "") {
        $nama_lengkap = $nama_lengkap . " + jht " . $jahit;
    }

    $htmlLogOK = $htmlLogOK . "nama_lengkap: " . $nama_lengkap . "<br><br>";
}

// MULAI INSERT KE spk_item

if ($status == "OK" && $mode == "INSERT") {
    $table = "spk_item";
    $column = ["id", "tipe", "bahan", "varia", "ukuran", "jahit", "nama_lengkap", "harga_price_list", "ktrg", "jumlah", "harga_item"];
    $value = [$id_spk_item, "sj-varia", $bahan, $varia, $tipe_ukuran, $jahit, $nama_lengkap, $harga_price_list, $ktrg, $jumlah, $harga_item];
    dbInsert($table, $column, $value);
} else if ($status == "OK" && $mode == "EDIT") {
    $table = "spk_item";
    $column = ["tipe", "bahan", "varia", "ukuran", "jahit", "nama_lengkap", "harga_price_list", "ktrg", "jumlah", "harga_item"];
    $value = ["sj-varia", $bahan, $varia, $tipe_ukuran, $jahit, $nama_lengkap, $harga_price_list, $ktrg, $jumlah, $harga_item];
    $key = "id";
    $key_value = $id_spk_item;
    dbUpdate($table, $column, $value, $key, $key_value);
}

// // Mulai insert ke temp_produk
// if ($status == "OK") {
//     $query_insert_temp_produk = "INSERT INTO temp_produk
//     (id, tipe, bahan, varia, ukuran, jahit, nama_lengkap, harga_price_list) VALUES
//     ($id_temp_produk, 'sj-varia', '$bahan', '$varia', '$tipe_ukuran', '$jahit', '$nama_lengkap', $harga_price_list)";

//     $res_query_insert_temp_produk = mysqli_query($con, $query_insert_temp_produk);

//     if (!$res_query_insert_temp_produk) {
//         $htmlLogError = $htmlLogError . $query_insert_temp_produk . " - FAILED! " . mysqli_error($con) . "<br><br>";
//         $status = "NOT OK";
//     } else {
//         $status = "OK";
//         $htmlLogOK = $htmlLogOK . $query_insert_temp_produk . "SUCCEED!<br><br>";
//     }
// }

// // MULAI INSERT KE temp_spk_contains_produk
// if ($status == "OK") {
//     // MENENTUKAN next_id temp_spk_contains_produk
//     $query_max_id_temp_spk_contains_produk = "SELECT max(id) FROM temp_spk_contains_produk";
//     $res_query_max_id_temp_spk_contains_produk = mysqli_query($con, $query_max_id_temp_spk_contains_produk);
//     $next_id_temp_spk_contains_produk = 0;
//     if (!$res_query_max_id_temp_spk_contains_produk) {
//         $status = "ERROR";
//         $htmlLogError = $htmlLogError . $query_max_id_temp_spk_contains_produk . " - FAILED! " . mysqli_error($con) . "<br><br>";
//     } else {
//         $status = "OK";
//         $htmlLogOK = $htmlLogOK . $query_max_id_temp_spk_contains_produk . " - SUCCEED!<br><br>";

//         $max_id_temp_spk_contains_produk = mysqli_fetch_row($res_query_max_id_temp_spk_contains_produk);

//         if ($max_id_temp_produk[0] == null) {
//             $next_id_temp_spk_contains_produk = 1;
//         } else {
//             $next_id_temp_spk_contains_produk = $max_id_temp_spk_contains_produk[0] + 1;
//         }

//         $htmlLogOK = $htmlLogOK . "next_id_temp_spk_contains_produk : $next_id_temp_spk_contains_produk<br><br>";

//         // MULAI INSERT KE temp_spk_contains_produk
//         $id_spk = nextID("spk", "id");
//         $id_produk = nextID("temp_spk_contains_produk", "id_produk");
//         // if ($id_spk["status"] !== "OK") {
//         //     $status = "ERROR";
//         //     $htmlLogError = $htmlLogError . $id_spk["log_error"];
//         // } else {
//         //     $status = "OK";
//         //     $htmlLogOK = $htmlLogOK . $id_spk["log_ok"];
//         // }
//         $table = "temp_spk_contains_produk";
//         $column = ["id", "id_spk", "id_produk", "ktrg", "jumlah", "harga_item"];
//         $value = [$next_id_temp_spk_contains_produk, $id_spk, $id_produk, $ktrg, $jumlah, $harga_item];

//         dbInsert($table, $column, $value);
//         // $query_insert_temp_spk_contains_produk = "INSERT INTO temp_spk_contains_produk
//         // (id, id_spk, id_produk, ktrg, jumlah, harga_item) VALUES
//         // ($next_id_temp_spk_contains_produk, $id_spk, $id_produk, '$ktrg', $jumlah, $harga_item)";

//         // $res_query_insert_temp_spk_contains_produk = mysqli_query($con, $query_insert_temp_spk_contains_produk);


//     }
// }

// if ($status == "OK") {
// }

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