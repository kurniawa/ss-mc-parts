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
    $id_ekspedisi = $_POST["id_ekspedisi"];
    $htmlLogOK = $htmlLogOK . "REQUEST_METHOD: POST<br><br>";

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
        $query_update_ekspedisi =
            "UPDATE ekspedisi
            SET nama='$nama_ekspedisi', bentuk='$bentuk_perusahaan', alamat='$alamat_ekspedisi',
            pulau_tujuan='$pulau_tujuan', daerah_tujuan='$daerah_tujuan', kontak='$kontak_ekspedisi',
            keterangan='$keterangan' WHERE id=$id_ekspedisi";

        $res_query_update_ekspedisi = mysqli_query($con, $query_update_ekspedisi);
        if (!$res_query_update_ekspedisi) {
            $htmlLogError = $htmlLogError . $query_update_ekspedisi . " - FAILED! " . mysqli_error($con) . "<br><br>";
        } else {
            $htmlLogOK = $htmlLogOK . $query_update_ekspedisi . " - SUCCEED!<br><br>";
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
