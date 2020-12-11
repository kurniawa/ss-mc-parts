<?php
include_once "01-config.php";
include_once "01-header.php";

$htmlLogError = "<div class='logError'>";
$htmlLogOK = "<div class='logOK'>";
$htmlLogWarning = "<div class='logWarning'>";
$status = "";

$nama_pelanggan = "";
$alamat_pelanggan = "";
$kontak_pelanggan = "";
$singkatan_pelanggan = "";
$pulau = "";
$daerah = "";
$keterangan = "";
$id_reseller = "";
$ekspedisi_transit = array();
$id_ekspedisi_transit = array();
$ekspedisi_normal = array();
$id_ekspedisi_normal = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $htmlLogOK = $htmlLogOK . "REQUEST_METHOD: POST<br><br>";

    $query_max_id = "SELECT max(id) FROM pelanggan";
    $res_query_max_id = mysqli_query($con, $query_max_id);
    if (!$res_query_max_id) {
        $htmlLogError = $htmlLogError . $query_max_id . " - FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $status = "OK";
        $htmlLogOK = $htmlLogOK . $query_max_id . " - SUCCEED!<br><br>";
        $max_id = mysqli_fetch_row($res_query_max_id);

        if ($max_id[0] == null) {
            $last_id = 1;
        } else {
            $last_id = $max_id[0] + 1;
        }

        $nama_pelanggan = trim(htmlspecialchars($_POST["nama_pelanggan"]));
        $alamat_pelanggan = trim(htmlspecialchars($_POST["alamat_pelanggan"]));
        $kontak_pelanggan = trim(htmlspecialchars($_POST["kontak_pelanggan"]));
        $singkatan_pelanggan = trim(htmlspecialchars($_POST["singkatan_pelanggan"]));
        $pulau = trim(htmlspecialchars($_POST["pulau"]));
        $daerah = trim(htmlspecialchars($_POST["daerah"]));
        $keterangan = trim(htmlspecialchars($_POST["keterangan"]));

        if (isset($_POST["id_reseller"])) {
            $id_reseller = trim(htmlspecialchars($_POST["id_reseller"]));
        }

        if (isset($_POST["ekspedisi_normal"])) {
            $ekspedisi_normal = $_POST["ekspedisi_normal"];
            $id_ekspedisi_normal = $_POST["id_ekspedisi_normal"];
        }

        if (isset($_POST["ekspedisi_transit"])) {
            $ekspedisi_transit = $_POST["ekspedisi_transit"];
            $id_ekspedisi_transit = $_POST["id_ekspedisi_transit"];
        }

        if ($nama_pelanggan !== "" && $alamat_pelanggan !== "") {
            // INSERT PELANGGAN BARU
            $query_input_pelanggan_baru =
                "INSERT INTO pelanggan
            (id, nama, alamat, pulau, daerah, kontak, keterangan, singkatan, id_reseller)
            VALUES($last_id, '$nama_pelanggan', '$alamat_pelanggan', '$pulau', '$daerah', '$kontak_pelanggan', '$keterangan', '$singkatan_pelanggan', '$id_reseller')";

            $res_query_input_pelanggan_baru = mysqli_query($con, $query_input_pelanggan_baru);
            if (!$res_query_input_pelanggan_baru) {
                $htmlLogError = $htmlLogError . $query_input_pelanggan_baru . " - FAILED! " . mysqli_error($con) . "<br><br>";
            } else {
                $htmlLogOK = $htmlLogOK . $query_input_pelanggan_baru . " - SUCCEED!<br><br>";

                // CREATE RELASI pelanggan_use_ekspedisi
                if (empty($ekspedisi_normal)) {
                    $status = "OK";
                    $htmlLogWarning = $htmlLogWarning . "Tidak ada input ekspedisi normal!<br><br>";
                } else {
                    for ($i = 0; $i < count($ekspedisi_normal); $i++) {
                        $query_max_id_pelanggan_use_ekspedisi = "SELECT max(id) FROM pelanggan_use_ekspedisi";
                        $res_query_max_id_pelanggan_use_ekspedisi = mysqli_query($con, $query_max_id_pelanggan_use_ekspedisi);
                        if (!$res_query_max_id_pelanggan_use_ekspedisi) {
                            $htmlLogError = $htmlLogError . $query_max_id_pelanggan_use_ekspedisi . " - FAILED! " . mysqli_error($con) . "<br><br>";
                            $status = "ADA ERROR";
                            break;
                        } else {
                            $status = "OK";
                            $htmlLogOK = $htmlLogOK . $query_max_id_pelanggan_use_ekspedisi . " - SUCCEED!<br><br>";
                            $max_id_pelanggan_use_ekspedisi = mysqli_fetch_row($res_query_max_id_pelanggan_use_ekspedisi);

                            if ($max_id_pelanggan_use_ekspedisi[0] == null) {
                                $next_id_pelanggan_use_ekspedisi = 1;
                            } else {
                                $next_id_pelanggan_use_ekspedisi = $max_id_pelanggan_use_ekspedisi[0] + 1;
                            }

                            $query_input_ekspedisi_normal = "INSERT INTO pelanggan_use_ekspedisi
                                (id, id_ekspedisi, id_pelanggan, ekspedisi_transit, ekspedisi_utama) VALUES
                                ($next_id_pelanggan_use_ekspedisi, $id_ekspedisi_normal[$i], $last_id, 'n', 'y')";
                            $res_query_input_ekspedisi_normal = mysqli_query($con, $query_input_ekspedisi_normal);
                            if (!$res_query_input_ekspedisi_normal) {
                                $htmlLogError = $htmlLogError . $query_input_ekspedisi_normal . " - FAILED! " . mysqli_error($con) . "<br><br>";
                                $status = "ADA ERROR";
                                break;
                            } else {
                                $status = "OK";
                                $htmlLogOK = $htmlLogOK . $query_input_ekspedisi_normal . " - SUCCEED!<br><br>";
                            }
                        }
                    }
                }

                if (empty($ekspedisi_transit)) {
                    $status = "OK";
                    $htmlLogWarning = $htmlLogWarning . "Tidak ada input ekspedisi transit!<br><br>";
                } else {
                    for ($i = 0; $i < count($ekspedisi_transit); $i++) {
                        $query_max_id_pelanggan_use_ekspedisi = "SELECT max(id) FROM pelanggan_use_ekspedisi";
                        $res_query_max_id_pelanggan_use_ekspedisi = mysqli_query($con, $res_query_max_id_pelanggan_use_ekspedisi);
                        if (!$res_query_max_id_pelanggan_use_ekspedisi) {
                            $htmlLogError = $htmlLogError . $query_max_id_pelanggan_use_ekspedisi . " - FAILED! " . mysqli_error($con) . "<br><br>";
                            $status = "ADA ERROR";
                            break;
                        } else {
                            $status = "OK";
                            $htmlLogOK = $htmlLogOK . $res_query_max_id_pelanggan_use_ekspedisi . " - SUCCEED!<br><br>";
                            $max_id_pelanggan_use_ekspedisi = mysqli_fetch_row($res_query_max_id_pelanggan_use_ekspedisi);

                            if ($max_id_pelanggan_use_ekspedisi[0] == null) {
                                $next_id_pelanggan_use_ekspedisi = 1;
                            } else {
                                $next_id_pelanggan_use_ekspedisi = $max_id_pelanggan_use_ekspedisi[0] + 1;
                            }

                            $query_input_ekspedisi_transit = "INSERT INTO pelanggan_use_ekspedisi
                                (id, id_ekspedisi, id_pelanggan, ekspedisi_transit, ekspedisi_utama) VALUES
                                ($next_id_pelanggan_use_ekspedisi, $id_ekspedisi_transit[$i], $last_id, 'y', 'n')";
                            $res_query_input_ekspedisi_transit = mysqli_query($con, $query_input_ekspedisi_transit);
                            if (!$res_query_input_ekspedisi_transit) {
                                $htmlLogError = $htmlLogError . $query_input_ekspedisi_transit . " - FAILED! " . mysqli_error($con) . "<br><br>";
                                $status = "ADA ERROR";
                                break;
                            } else {
                                $status = "OK";
                                $htmlLogOK = $htmlLogOK . $query_input_ekspedisi_transit . " - SUCCEED!<br><br>";
                            }
                        }
                    }
                }
            }
        }
    }
} else {
    $status = "ADA ERROR";
    $htmlLogError = $htmlLogError . "REQUEST_METHOD: I DON'T KNOW!<br><br>";
}

// BACK-UP SYSTEM
if ($status == "OK") {
    $file_pelanggan = fopen('back-up/pelanggan.sql', 'w');
    if (!$file_pelanggan) {
        $status = "NOT OK";
        $htmlLogError = $htmlLogError . "Open file pelanggan.sql - FAILED!<br><br>";
    } else {
        $status = "OK";
        $htmlLogOK = $htmlLogOK . "Open file pelanggan.sql - SUCCEED!<br><br>";

        $query_select_all_pelanggan = "SELECT * FROM pelanggan";
        $res_query_select_all_pelanggan = mysqli_query($con, $query_select_all_pelanggan);

        if (!$res_query_select_all_pelanggan) {
            $status = "NOT OK";
            $htmlLogError = $htmlLogError . $query_select_all_pelanggan . " - FAILED! " . mysqli_error($con) . "<br><br>";
        } else {
            $status = "OK";
            $htmlLogOK = $htmlLogOK . $query_select_all_pelanggan . " - SUCCEED!<br><br>";

            // TOTAL DATA YANG ADA DI DB
            $query_count_all_pelanggan = "SELECT count(*) as jumlah_pelanggan FROM pelanggan";
            $res_query_count_all_pelanggan = mysqli_query($con, $query_count_all_pelanggan);

            if (!$res_query_count_all_pelanggan) {
                $status = "NOT OK";
                $htmlLogError = $htmlLogError . $query_count_all_pelanggan . " - FAILED! " . mysqli_error($con) . "<br><br>";
            } else {
                $status = "OK";
                $htmlLogOK = $htmlLogOK . $query_count_all_pelanggan . " - SUCCEED!<br><br>";
                $jumlah_pelanggan = mysqli_fetch_assoc($res_query_count_all_pelanggan);

                $htmlLogOK = $htmlLogOK . "Jumlah data pelanggan: " . $jumlah_pelanggan['jumlah_pelanggan'] . "<br><br>";
                $sql_insert_all_pelanggan = "INSERT INTO pelanggan (id, nama, alamat, pulau, daerah, kontak, keterangan, singkatan, id_reseller) VALUES ";
                $i = 0;
                while ($pelanggan = mysqli_fetch_assoc($res_query_select_all_pelanggan)) {
                    $sql_insert_all_pelanggan = $sql_insert_all_pelanggan . "(" . $pelanggan['id'] . ",'" .  $pelanggan['nama'] . "','" .
                        $pelanggan['alamat'] . "','" . $pelanggan['pulau'] . "','" . $pelanggan['daerah'] . "','" . $pelanggan['kontak'] . "','" . $pelanggan['keterangan'] . "','" . $pelanggan['singkatan'] . "','" . $pelanggan['id_reseller'] . "')";
                    if ($i !== $jumlah_pelanggan['jumlah_pelanggan'] - 1) {
                        $sql_insert_all_pelanggan = $sql_insert_all_pelanggan . ",";
                    }
                    $i++;
                }
                $htmlLogOK = $htmlLogOK . $sql_insert_all_pelanggan . "<br><br>";
                fwrite($file_pelanggan, $sql_insert_all_pelanggan);
                fclose($file_pelanggan);
            }
        }
    }
}

if ($status == "OK") {
    $file_pelanggan_use_ekspedisi = fopen('back-up/pelanggan_use_ekspedisi.sql', 'w');
    if (!$file_pelanggan_use_ekspedisi) {
        $status = "NOT OK";
        $htmlLogError = $htmlLogError . "Open file pelanggan_use_ekspedisi.sql - FAILED!<br><br>";
    } else {
        $status = "OK";
        $htmlLogOK = $htmlLogOK . "Open file pelanggan_use_ekspedisi.sql - SUCCEED!<br><br>";

        $query_select_all_pelanggan_use_ekspedisi = "SELECT * FROM pelanggan_use_ekspedisi";
        $res_query_select_all_pelanggan_use_ekspedisi = mysqli_query($con, $query_select_all_pelanggan_use_ekspedisi);

        if (!$res_query_select_all_pelanggan_use_ekspedisi) {
            $status = "NOT OK";
            $htmlLogError = $htmlLogError . $query_select_all_pelanggan_use_ekspedisi . " - FAILED! " . mysqli_error($con) . "<br><br>";
        } else {
            $status = "OK";
            $htmlLogOK = $htmlLogOK . $query_select_all_pelanggan_use_ekspedisi . " - SUCCEED!<br><br>";

            // TOTAL DATA YANG ADA DI DB
            $query_count_all_pelanggan_use_ekspedisi = "SELECT count(*) as jumlah_pelanggan_use_ekspedisi FROM pelanggan_use_ekspedisi";
            $res_query_count_all_pelanggan_use_ekspedisi = mysqli_query($con, $query_count_all_pelanggan_use_ekspedisi);

            if (!$res_query_count_all_pelanggan_use_ekspedisi) {
                $status = "NOT OK";
                $htmlLogError = $htmlLogError . $query_count_all_pelanggan_use_ekspedisi . " - FAILED! " . mysqli_error($con) . "<br><br>";
            } else {
                $status = "OK";
                $htmlLogOK = $htmlLogOK . $query_count_all_pelanggan_use_ekspedisi . " - SUCCEED!<br><br>";
                $jumlah_pelanggan_use_ekspedisi = mysqli_fetch_assoc($res_query_count_all_pelanggan_use_ekspedisi);

                $htmlLogOK = $htmlLogOK . "Jumlah data pelanggan_use_ekspedisi: " . $jumlah_pelanggan_use_ekspedisi['jumlah_pelanggan_use_ekspedisi'] . "<br><br>";
                $sql_insert_all_pelanggan_use_ekspedisi = "INSERT INTO pelanggan_use_ekspedisi (id, id_ekspedisi, id_pelanggan, ekspedisi_transit, ekspedisi_utama) VALUES ";
                $i = 0;
                while ($pelanggan_use_ekspedisi = mysqli_fetch_assoc($res_query_select_all_pelanggan_use_ekspedisi)) {
                    $sql_insert_all_pelanggan_use_ekspedisi = $sql_insert_all_pelanggan_use_ekspedisi . "(" . $pelanggan_use_ekspedisi['id'] . ",'" .  $pelanggan_use_ekspedisi['id_ekspedisi'] . "','" .
                        $pelanggan_use_ekspedisi['id_pelanggan'] . "','" . $pelanggan_use_ekspedisi['ekspedisi_transit'] . "','" . $pelanggan_use_ekspedisi['ekspedisi_utama'] . "')";
                    if ($i !== $jumlah_pelanggan_use_ekspedisi['jumlah_pelanggan_use_ekspedisi'] - 1) {
                        $sql_insert_all_pelanggan_use_ekspedisi = $sql_insert_all_pelanggan_use_ekspedisi . ",";
                    }
                    $i++;
                }
                $htmlLogOK = $htmlLogOK . $sql_insert_all_pelanggan . "<br><br>";
                fwrite($file_pelanggan_use_ekspedisi, $sql_insert_all_pelanggan_use_ekspedisi);
                fclose($file_pelanggan_use_ekspedisi);
            }
        }
    }
}

$htmlLogError = $htmlLogError . "</div>";
$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";

?>

<div class="header grid-2-auto">
    <!-- <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="goBack();"> -->
</div>
<br>
<div class="text-center">
    <div id='goToPelanggan' class="btn-1 d-inline-block bg-color-orange-1" onclick="goToPelanggan();">Kembali ke Daftar Pelanggan</div>
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

    function goToPelanggan() {
        console.log('window.history.length:');
        console.log(window.history.length);
        console.log('1 - window.history.length');
        console.log(1 - window.history.length);

        window.history.go(2 - window.history.length);
    }
</script>

<?php

include_once "01-footer.php";
