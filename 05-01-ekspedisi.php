<?php
include_once "01-header.php";
?>

<div class="header"></div>
<a href="05-03-ekspedisi-baru.php" class="btn-atas-kanan">
    + Ekspedisi Baru
</a>

<div class="grid-2-auto mt-1em ml-1em mr-1em pb-1em div-cari-filter">
    <div class="justify-self-left grid-2-auto b-1px-grey b-radius-25px mr-1em pl-1em pr-0_4em w-11em">
        <input class="input-2 mt-0_4em mb-0_4em" type="text" placeholder="Cari...">
        <div class="justify-self-right grid-1-auto justify-items-center circle-small bg-color-orange-1">
            <img class="w-0_8em" src="img/icons/loupe.svg" alt="">
        </div>
    </div>
    <div class="div-filter-icon">

        <div class="icon-small-circle bg-color-orange-1">
            <img class="icon-img w-1em" src="img/icons/sort-by-attributes.svg" alt="sort-icon">
        </div>
    </div>
</div>

<div id="div-daftar-spk">
</div>

<script>
    $.ajax({
        type: "POST",
        url: "05-02-get-ekspedisi.php",
        async: false,
        success: function(responseText) {
            console.log(responseText);
            responseText = JSON.parse(responseText);
            console.log(responseText);
            for (const pelanggan of responseText) {
                $newElement = "<div class='grid-3-auto ml-1em mr-1em'>" +
                    "<div class='singkatan circle-medium grid-1-auto bg-color-orange-2 justify-items-center'>" + pelanggan.singkatan + "</div>" +
                    "<div class='nama'>" + pelanggan.nama + "</div>" +
                    "<div class='alamat justify-self-right text-right'>" + pelanggan.alamat.replace(new RegExp('\r?\n', 'g'), '<br />') + "</div>" +
                    "</div>";
                $("#div-daftar-spk").append($newElement);
            }
        }
    });
</script>

<style>
    .header {
        height: 4em;
        background-color: #ffb800;
    }

    .btn-atas-kanan {
        display: inline;
        border-radius: 25px;
        background-color: #FFED50;
        padding: 0.5em 1em 0.5em 1em;
        position: absolute;
        top: 1em;
        right: 0.5em;
    }

    .input-cari {
        border: none;
        width: 10em;
        border-radius: 25px;
        padding: 0.5em 1em 0.5em 1em;
        box-shadow: 0 0 2px gray;
    }

    .input-cari:focus {
        box-shadow: 0 0 6px #23FFAD;
    }

    .field {
        margin: 1em;
    }

    .div-filter-icon {
        justify-self: end;
    }

    .icon-small-circle {
        border-radius: 100%;
        width: 2.5em;
        height: 2.5em;
        position: relative;
    }

    .circle-medium {
        border-radius: 100%;
        width: 3em;
        height: 3em;
    }

    .icon-img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* .hr {
        box-shadow: none;
    } */
    .div-cari-filter {
        border-bottom: 0.5px solid #E4E4E4;
    }
</style>

<?php
include_once "01-footer.php";
?>