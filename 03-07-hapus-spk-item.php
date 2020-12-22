<?php
include_once '01-header.php';
include_once '01-config.php';

// PASTIKAN REQUEST METHOD nya: POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = "OK";
    $htmlLogOK = $htmlLogOK . "REQUEST METHOD: POST<br><br>";
} else {
    $status = "NOT OK";
    $htmlLogError = $htmlLogError . "REQUEST METHOD: ENTAHLAH!<br><br>";
}

if ($status == "OK") {
    $table_spk_item = "spk_item";
    dbDeleteAllFromTable($table_spk_item);
}

$htmlLogError = $htmlLogError . "</div>";
$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";
?>

<header class="header"></header>

<div id="containerPrintOutSPK" class="p-0_5em">

    <div id="divTableToPrint"></div>

    <br><br>

    <div class="text-center">
        <button id='goToSPK' class="btn-1 d-inline-block bg-color-orange-1" onclick="goToSPK();">Kembali SPK</button>
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

    var status = '<?= $status; ?>';
    console.log('status: ' + status);

    var spk, pelanggan, spk_contains_produk, produk;

    if (status == "OK") {
        $('#goToSPK').show();
    } else {
        $('#goToSPK').hide();
    }

    function goToSPK() {
        window.history.go(2 - window.history.length);
    }
    // test 
</script>

<?php
include_once '01-footer.php';
?>