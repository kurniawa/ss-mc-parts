<?php
include_once "01-header.php";
?>

<div class="header"></div>
<a href="06-02-produk-baru.php" id="btnNewProduct" class="btn-atas-kanan">
    + Tambah Produk Baru
</a>

<div id="containerProductList" class="mt-0_5em ml-0_5em mr-0_5em">

    <div id="filterProductType" class="">
        <div class="d-inline-block b-1px-solid-grey pt-0_5em pb-0_5em pl-1em pr-1em mb-0_5em b-radius-25px">All</div>
        <div class="d-inline-block b-1px-solid-grey pt-0_5em pb-0_5em pl-1em pr-1em mb-0_5em b-radius-25px">SJ Basic</div>
        <div class="d-inline-block b-1px-solid-grey pt-0_5em pb-0_5em pl-1em pr-1em mb-0_5em b-radius-25px">SJ Kombi</div>
        <div class="d-inline-block b-1px-solid-grey pt-0_5em pb-0_5em pl-1em pr-1em mb-0_5em b-radius-25px">SJ Std</div>
        <div class="d-inline-block b-1px-solid-grey pt-0_5em pb-0_5em pl-1em pr-1em mb-0_5em b-radius-25px">Busa Stang</div>
        <div class="d-inline-block b-1px-solid-grey pt-0_5em pb-0_5em pl-1em pr-1em mb-0_5em b-radius-25px">Tank Pad</div>
    </div>

    <div class="grid-2-auto mt-0_5em pb-1em bb-0_5px-solid-grey">
        <div class="justify-self-left grid-2-auto b-1px-solid-grey b-radius-50px mr-1em pl-1em pr-0_4em w-11em">
            <input class="input-2 mt-0_4em mb-0_4em" type="text" placeholder="Cari...">
            <div class="justify-self-right grid-1-auto justify-items-center circle-small bg-color-orange-1">
                <img class="w-0_8em" src="img/icons/loupe.svg" alt="">
            </div>
        </div>
        <div class="justify-self-right">

            <div class="icon-small-circle grid-1-auto justify-items-center bg-color-orange-1">
                <img class="w-0_9em" src="img/icons/sort-by-attributes.svg" alt="sort-icon">
            </div>
        </div>
    </div>

    <div id="div-daftar-spk">
    </div>
</div>

<script>

</script>

<style>
    /* .input-cari {
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
    
    .icon-img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    
    */

    .icon-small-circle {
        border-radius: 100%;
        width: 2em;
        height: 2em;
    }
</style>

<?php
include_once "01-footer.php";
?>