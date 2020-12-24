<?php
include_once "01-config.php";
include_once "01-header.php";

// CEK REQUEST_METHOD POST
// var_dump($_SERVER["REQUEST_METHOD"]);
// var_dump($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id_spk"]) && isset($_POST["tgl_pembuatan"]) && isset($_POST["ket_judul"]) && isset($_POST["id_pelanggan"])) {
        $status = "OK";
        $id_spk = $_POST["id_spk"];
        $tgl_pembuatan = date("Y-m-d", strtotime($_POST["tgl_pembuatan"]));
        $ket_judul = $_POST["ket_judul"];
        $id_pelanggan = $_POST["id_pelanggan"];
        $htmlLogOK = $htmlLogOK . "REQUEST_METHOD: POST<br>id_spk: $id_spk<br>
        tgl_pembuatan = $tgl_pembuatan<br>
        ket_judul = $ket_judul<br>
        id_pelanggan = $id_pelanggan<br><br>";
    } else {
        $status = "ERROR";
        $htmlLogError = $htmlLogError . "Ada variable POST yang tidak sesuai!<br><br>";
    }
} else {
    $status = "ERROR";
}

// MULAI UPDATE SPK
if ($status == "OK") {
    $column = ["tgl_pembuatan", "ket_judul", "id_pelanggan"];
    $value = [$tgl_pembuatan, $ket_judul, $id_pelanggan];
    $key = "id";
    $key_value = $id_spk;
    dbUpdate("spk", $column, $value, $key, $key_value);
}

$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogError = $htmlLogError . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";
?>

<div class="text-center mt-1em">
    <button type="submit" id='backToSPK' class="btn-1 d-inline-block bg-color-orange-1" onclick="backToSPK();">Kembali ke SPK</button>
</div>

<div class="divLogError"></div>
<div class="divLogWarning"></div>
<div class="divLogOK"></div>

<script>
    // LOG ERROR DAN OK
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
    // ----- END -----

    function backToSPK() {
        window.history.go(2 - window.history.length);
    }
</script>