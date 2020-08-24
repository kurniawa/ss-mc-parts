<?php
include_once "01-header.php";
?>

<div class="header"></div>
<div id="btn-spk-baru">
    + Buat SPK Baru
</div>

<div class="grid-auto-2 mt-1em ml-1em mr-1em pb-1em div-cari-filter">
    <div class="cari">
        <input class="input-cari" type="text" placeholder="Cari...">
    </div>
    <div class="div-filter-icon">

        <div class="icon-small-circle bg-orange-1">
            <img class="icon-img w-1em" src="img/icons/sort-by-attributes.svg" alt="sort-icon">
        </div>
    </div>
</div>

<div id="div-daftar-spk">
</div>

<script>
    $.ajax({
        type: "POST",
        url: "03-02-get-spk.php",
        async: false,
        success: function(data) {
            console.log(data);
        }
    });
</script>

<style>
    .header {
        height: 4em;
        background-color: #ffb800;
    }

    .grid-auto-2 {
        display: grid;
        grid-template-columns: auto auto;
        align-items: center;
    }

    #btn-spk-baru {
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