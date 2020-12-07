<?php
include_once "01-config.php";
include_once "01-header.php";

$htmlLogError = "<div class='logError'>";
$htmlLogOK = "<div class='logOK'>";

$bentuk_perusahaan = "";
$nama_ekspedisi = "";
$alamat_ekspedisi = "";
$kontak_ekspedisi = "";
$pulau_tujuan = "";
$daerah_tujuan = "";
$keterangan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $htmlLogOK = $htmlLogOK . "REQUEST_METHOD: POST<br><br>";

    $query_max_id = "SELECT max(id) FROM ekspedisi";
    $res_query_max_id = mysqli_query($con, $query_max_id);
    if (!$res_query_max_id) {
        $htmlLogError = $htmlLogError . $query_max_id . " - FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $htmlLogOK = $htmlLogOK . $query_max_id . " - SUCCEED!<br><br>";
        $max_id = mysqli_fetch_row($res_query_max_id);

        if ($max_id[0] == null) {
            $last_id = 1;
        } else {
            $last_id = $max_id[0] + 1;
        }

        if (isset($_POST["bentuk_perusahaan"])) {
            $bentuk_perusahaan = trim(htmlspecialchars($_POST["bentuk_perusahaan"]));
        } else {
            $bentuk_perusahaan = "";
        }

        $nama_ekspedisi = trim(htmlspecialchars($_POST["nama_ekspedisi"]));
        $alamat_ekspedisi = trim(htmlspecialchars($_POST["alamat_ekspedisi"]));
        $kontak_ekspedisi = trim(htmlspecialchars($_POST["kontak_ekspedisi"]));
        $pulau_tujuan = trim(htmlspecialchars($_POST["pulau_tujuan"]));
        $daerah_tujuan = trim(htmlspecialchars($_POST["daerah_tujuan"]));
        $keterangan = trim(htmlspecialchars($_POST["keterangan"]));

        if ($nama_ekspedisi !== "" && $alamat_ekspedisi !== "") {
            $query_input_ekspedisi_baru =
                "INSERT INTO ekspedisi
            (id, nama, bentuk, alamat, pulau_tujuan, daerah_tujuan, kontak, keterangan)
            VALUES($last_id, '$nama_ekspedisi', '$bentuk_perusahaan', '$alamat_ekspedisi', '$pulau_tujuan', '$daerah_tujuan', '$kontak_ekspedisi', '$keterangan')";

            $res_query_input_ekspedisi_baru = mysqli_query($con, $query_input_ekspedisi_baru);
            if (!$res_query_input_ekspedisi_baru) {
                $htmlLogError = $htmlLogError . $query_input_ekspedisi_baru . " - FAILED! " . mysqli_error($con) . "<br><br>";
            } else {
                $htmlLogOK = $htmlLogOK . $query_input_ekspedisi_baru . " - SUCCEED!<br><br>";
            }
        }
    }
} else {

    $htmlLogError = $htmlLogError . "REQUEST_METHOD: I DON'T KNOW!<br><br>";
}

$htmlLogError = $htmlLogError . "</div>";
$htmlLogOK = $htmlLogOK . "</div>";

?>

<div class="header grid-2-auto">
    <!-- <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="goBack();"> -->
</div>

<div class="divLogError"></div>
<div class="divLogOK"></div>

<div class="text-center">
    <div id='goToEkspedisi' class="btn-1 d-inline-block bg-color-orange-1" onclick="goToEkspedisi();">Kembali ke Daftar Ekspedisi</div>
</div>

<script>
    var htmlLogError = `<?= $htmlLogError; ?>`;
    var htmlLogOK = `<?= $htmlLogOK; ?>`;

    $('.divLogError').html(htmlLogError);
    $('.divLogOK').html(htmlLogOK);

    if ($('.logError').html() === '') {
        $('.divLogError').hide();
    } else {
        $('.divLogError').show();
    }

    if ($('.logOK').html() === '') {
        $('.divLogOK').hide();
    } else {
        $('.divLogOK').show();
    }

    function goToEkspedisi() {
        console.log('window.history.length:');
        console.log(window.history.length);
        console.log('1 - window.history.length');
        console.log(1 - window.history.length);

        window.history.go(2 - window.history.length);
    }
</script>

<?php


include_once "01-footer.php";
