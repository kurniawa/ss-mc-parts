<?php
$query_all_spk = "SELECT * FROM spk ORDER BY tgl_pembuatan DESC";
$res_query_all_spk = mysqli_query($con, $query_all_spk);

if (!$res_query_all_spk) {
    $status = "ERROR";
    $htmlLogError = $htmlLogError . $query_all_spk . ": FAILED! " . mysqli_error($con) . "<br><br>";
} else {
    $status = "OK";
    $htmlLogOK = "$htmlLogOK $query_all_spk - SUCCEED!<br><br>";
}

$spk = array();
$spk_item = array();
$pelanggan = array();
$spk_contains_item = array();

if (mysqli_num_rows($res_query_all_spk) <= 0) {
    $htmlLogOK = $htmlLogOK . $query_all_spk . ": NOT FOUND! ";
} else {
    while ($row_spk = mysqli_fetch_assoc($res_query_all_spk)) {
        $row_spk_contains_item = array();
        $row_spk_item = array();
        $id_spk = $row_spk['id'];
        $query_get_spk_contains_produk = "SELECT * FROM spk_contains_produk WHERE id_spk=$id_spk";
        $res_query_get_spk_contains_produk = mysqli_query($con, $query_get_spk_contains_produk);

        if (!$res_query_get_spk_contains_produk) {
            $htmlLogError = $htmlLogError . $query_get_spk_contains_produk . " - FAILED! " . mysqli_error($con) . "<br><br>";
        } else {
            $htmlLogOK = $htmlLogOK . $query_get_spk_contains_produk . " - SUCCEED!<br><br>";
            while ($row_spk_contains_produk = mysqli_fetch_assoc($res_query_get_spk_contains_produk)) {
                array_push($row_spk_contains_item, $row_spk_contains_produk);
                $id_produk = $row_spk_contains_produk['id_produk'];
                $query_get_produk = "SELECT * FROM produk WHERE id=$id_produk";
                $res_query_get_produk = mysqli_query($con, $query_get_produk);

                if (!$res_query_get_produk) {
                    $htmlLogError = $htmlLogError . $query_get_produk . " - FAILED! " . mysqli_error($con) . "<br><br>";
                } else {
                    $htmlLogOK = $htmlLogOK . $query_get_produk . " - SUCCEED!<br><br>";
                    $row_produk = mysqli_fetch_assoc($res_query_get_produk);
                    array_push($row_spk_item, $row_produk);
                }
            }
        }
        array_push($spk, $row_spk);

        // MULAI GET pelanggan
        if ($spk !== "ERROR") {
            $table_pelanggan = "pelanggan";
            $filter_table_pelanggan = "id";
            $filter_value_table_pelanggan = $spk[0]["id_pelanggan"];

            $row_pelanggan = dbGetWithFilter($table_pelanggan, $filter_table_pelanggan, $filter_value_table_pelanggan);
        }
        array_push($pelanggan, $row_pelanggan[0]);
        array_push($spk_item, $row_spk_item);
        array_push($spk_contains_item, $row_spk_contains_item);
    }
}
