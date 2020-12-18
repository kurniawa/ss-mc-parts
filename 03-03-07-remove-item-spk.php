<?php
include_once "01-header.php";
include_once "01-config.php";

// PASTIKAN REQUEST METHOD nya: GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $status = "OK";
    $htmlLogOK = $htmlLogOK . "REQUEST METHOD: GET<br><br>";
} else {
    $status = "NOT OK";
    $htmlLogError = $htmlLogError . "REQUEST METHOD: ENTAHLAH!<br><br>";
}

// DECLARE Variable ID
if ($status == "OK") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $status = "OK";
        $htmlLogOK = $htmlLogOK . "ID to remove: $id<br><br>";
    } else {
        $status = "ERROR";
        $htmlLogError = $htmlLogError . "id_to_remove tidak di set!<br><br>";
    }
}

// MULAI HAPUS SPK item dengan ID yang telah ditentukan
if ($status == "OK") {
    $table = "spk_item";
    $column = "id";
    dbDelete($table, $column, $id);
}

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
        window.history.back();
    }
</script>