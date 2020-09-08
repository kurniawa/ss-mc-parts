<?php
include_once "01-header.php";
?>

<div class="header"></div>
<a href="04-03-pelanggan-baru.php" class="btn-atas-kanan">
    + Pelanggan Baru
</a>

<div class="grid-2-auto mt-1em ml-1em mr-1em pb-1em div-cari-filter">
    <div class="justify-self-left grid-2-auto b-1px-solid-grey b-radius-50px mr-1em pl-1em pr-0_4em w-11em">
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
    $arrayBgColors = ["#FFB08E", "#DEDEDE", "#D1FFCA", "#FFB800"];

    $.ajax({
        type: "POST",
        url: "04-02-get-pelanggan.php",
        async: false,
        success: function(responseText) {
            console.log(responseText);
            responseText = JSON.parse(responseText);
            console.log(responseText);
            for (const pelanggan of responseText) {
                $randomIndex = Math.floor(Math.random() * 4);
                console.log("$randomIndex: " + $randomIndex);

                $newElement = "<div class='ml-1em mr-1em pb-1em bb-1px-solid-grey pt-1em font-size-0_9em'>" +
                    "<div class='grid-3-10_80_10'>" +
                    "<div class='singkatan circle-medium grid-1-auto justify-items-center font-weight-bold' style='background-color: " + $arrayBgColors[$randomIndex] + "'>" + pelanggan.singkatan + "</div>" +
                    "<div class='justify-self-left font-weight-bold'>" + pelanggan.nama + " - " + pelanggan.daerah + "</div>" +
                    "<div id='divDropdown-" + pelanggan.id + "' class='justify-self-right' onclick='showDropDown(" + pelanggan.id + ");'><img class='w-0_7em' src='img/icons/dropdown.svg'></div>" +
                    "</div>" +

                    // DROPDOWN
                    "<div id='divDetailDropDown-" + pelanggan.id + "' class='d-none b-1px-solid-grey p-0_5em mt-1em'>" +

                    "<div class='grid-2-10-auto'>" +

                    "<div><img class='w-2em' src='img/icons/real-estate.svg'></div>" +
                    "<div>" + pelanggan.alamat.replace(new RegExp('\r?\n', 'g'), '<br />') + "</div>" +
                    "<div><img class='w-2em' src='img/icons/phonebook.svg'></div>" +
                    "<div>" + pelanggan.kontak + "</div>" +

                    "</div>" +

                    "<div class='grid-1-auto justify-items-right mt-1em'>" +
                    "<a href='04-05-detail-pelanggan.php?id=" + pelanggan.id + "' class='bg-color-orange-1 b-radius-50px pl-1em pr-1em'>Lebih Detail >></a>" +
                    "</div>" +
                    "</div>" +

                    // END OF DROPDOWN
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
        width: 2.5em;
        height: 2.5em;
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