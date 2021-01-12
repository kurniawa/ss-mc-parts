<?php

include_once "01-config.php";
include_once "01-header.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $status = "OK";
    $htmlLogOK .= "REQUEST METHOD = GET<br><br>";
} else {
    $status = "ERROR";
    $htmlLogError .= "REQUEST METHOD = ENTAHLAH<br><br>";
}

if ($status == "OK") {
    if (isset($_GET["id_spk_contains_item"])) {
        $status = "OK";
        $id_spk_contains_item = $_GET["id_spk_contains_item"];
        $htmlLogOK .= "id_spk_contains_item = $id_spk_contains_item<br><br>";
    } else {
        $status = "ERROR";
        $htmlLogError .= "id_spk_contains_item was not sent";
    }
}

if ($status == "OK") {
    dbDelete("spk_contains_produk", "id", $id_spk_contains_item);
}

$htmlLogError = $htmlLogError . "</div>";
$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";

?>

<div class="mt-2em text-center">
    <button id='backToSPK' class="btn-1 d-inline-block bg-color-orange-1" onclick="backToSPK();">Kembali ke Detail SPK</button>
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

    function backToSPK() {
        window.history.go(-1);
    }
</script>

<?php
include_once "01-footer.php";
?>