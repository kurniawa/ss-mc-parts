<?php

include_once "01-config.php";
include_once "01-header.php";

// CEK REQUEST_METHOD POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id_spk"]) && isset($_POST["tgl_selesai"])) {
        $status = "OK";
        $id_spk = $_POST["id_spk"];
        // var_dump($_POST["tgl_selesai"]);
        $tgl_selesai = date("Y-m-d", strtotime($_POST["tgl_selesai"]));
        $htmlLogOK = $htmlLogOK . "REQUEST_METHOD: POST<br>id_spk: $id_spk<br>tgl_selesai: $tgl_selesai";
    }
} else {
    $status = "ERROR";
}

// GET ID PELANGGAN FROM SPK
if ($status == "OK") {
    $no_nota = "N-$id_spk";
    $no_surat_jalan = "SJ-$id_spk";
    $column = ["tgl_selesai", "no_nota", "tgl_nota", "no_surat_jalan", "tgl_surat_jalan"];
    $value = [$tgl_selesai, $no_nota, $tgl_selesai, $no_surat_jalan, $tgl_selesai];
    $key = "id";
    $key_value = $id_spk;

    dbUpdate("spk", $column, $value, $key, $key_value);
}


$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogError = $htmlLogError . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";
?>

<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="goBack();" style="display: none">
    <div class="justify-self-right pr-0_5em">
    </div>
</header>
<div>
    <input type="hidden" name="id_spk" id="inputIDSPK">
    <div class="text-center mt-1em">
        <button type="submit" id='btnGoToHome' class="btn-1 d-inline-block bg-color-orange-1" onclick="backToHome();">Kembali Ke Home ==></button>
    </div>

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

    function backToHome() {
        window.history.go(1 - window.history.length);
    }
</script>

<?php
include_once '01-footer.php';
?>