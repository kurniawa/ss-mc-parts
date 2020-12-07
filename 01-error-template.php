<?php

$htmlLogOK = "<div class='logOK'>";
$htmlLogError = "<div class='logError'>";


$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogError = $htmlLogError . "</div>";

?>

<div class="divLogError"></div>
<div class="divLogOK"></div>

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
</script>