<?php
include_once "01-header.php";
?>

<div class="header"></div>

<div id="containerChosingProductType" class="mt-0_5em ml-0_5em mr-0_5em">

    <div class="grid-2-10_auto">
        <div class="">
            <img class="w-2em" src="img/icons/speech-bubble.svg" alt="">
        </div>
        <div class="font-weight-bold">
            Ada produk baru ya?
            <br>
            Pilih tipe produk terlebih dahulu ya!
        </div>
    </div>

    <div class="grid-3-auto justify-items-center mt-4em grid-row-gap-3em">
        <div onclick="inputNewProduct(1);">
            <img class="w-4em" src="img/icons/products.svg" alt="">
            <div class="text-center">SJ<br>Basic</div>
        </div>
        <div>
            <img class="w-4em" src="img/icons/products.svg" alt="">
            <div class="text-center">SJ<br>Kombi</div>
        </div>
        <div>
            <img class="w-4em" src="img/icons/products.svg" alt="">
            <div class="text-center">SJ<br>Standard</div>
        </div>
        <div>
            <img class="w-4em" src="img/icons/products.svg" alt="">
            <div class="text-center">Busa<br>Stang</div>
        </div>
        <div>
            <img class="w-4em" src="img/icons/products.svg" alt="">
            <div class="text-center">Tank<br>Pad</div>
        </div>
    </div>

</div>

<div id="closingAreaPertanyaan" class="d-none position-absolute z-index-2 w-100vw h-100vh bg-color-grey top-0 opacity-0_5">
</div>

<script>
    $(document).ready(function name(params) {
        $(".inputNewProduct").css("display", "none");
    });

    function inputNewProduct(type) {
        if (type === 1) {
            $("#containerChosingProductType").toggle();
            $("#inputSJBasic").toggle();
        }
    }
</script>

<style>
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
</style>

<?php
include_once "06-02-01-input-produk-baru.php";
include_once "01-footer.php";
?>