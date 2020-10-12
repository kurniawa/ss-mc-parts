<?php
include_once "01-header.php";
?>

<div class="header"></div>
<div id="btn-spk-baru" class="btn-atas-kanan" onclick="addNewSPK();">
    + Buat SPK Baru
</div>

<div class="grid-2-auto mt-1em ml-1em mr-1em pb-1em bb-0_5px-solid-grey">
    <div class="justify-self-left grid-2-auto b-1px-solid-grey b-radius-50px mr-1em pl-1em pr-0_4em w-11em">
        <input class="input-2 mt-0_4em mb-0_4em" type="text" placeholder="Cari...">
        <div class="justify-self-right grid-1-auto justify-items-center circle-small bg-color-orange-1">
            <img class="w-0_8em" src="img/icons/loupe.svg" alt="">
        </div>
    </div>
    <div class="div-filter-icon">

        <div class="icon-small-circle grid-1-auto justify-items-center bg-color-orange-1">
            <img class="w-0_9em" src="img/icons/sort-by-attributes.svg" alt="sort-icon">
        </div>
    </div>
</div>

<div id="div-daftar-spk">
</div>

<script>
    $.ajax({
        type: "POST",
        url: "01-crud.php",
        async: false,
        cache: false,
        data: {
            type: 'SELECT',
            table: 'spk'
        },
        success: function(data) {
            console.log(data);
        }
    });

    function addNewSPK() {
        localStorage.setItem('SPKItems', '');
        window.location.href = '03-03-spk-baru.php';
    }
</script>

<style>
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
        width: 2em;
        height: 2em;
    }

    .icon-img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>

<?php
include_once "01-footer.php";
?>