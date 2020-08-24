<?php
include_once "01-header.php";
?>

<div class="header"></div>

<div class="mt-1em ml-1em">
    <div class="d-inline">
        <img class="w-2em" src="img/icons/pencil.svg" alt="Data Pelanggan Baru">
    </div>
    <div class="d-inline font-weight-bold">
        Data Pelanggan Baru
    </div>
</div>

<div class="ml-1em mr-1em mt-2em">
    <input class="input-1 pb-1em" type="text" placeholder="Nama/Perusahaan/Pabrik">
    <textarea class="mt-1em pt-1em pl-1em" name="alamat" id="alamat" placeholder="Alamat"></textarea>
    <div class="grid-2-auto grid-column-gap-1em mt-1em">
        <input class="input-1 pb-1em" type="text" placeholder="Pulau">
        <input class="input-1 pb-1em" type="text" placeholder="Daerah">
    </div>
    <div class="grid-2-auto grid-column-gap-1em mt-1em">
        <input class="input-1 pb-1em" type="text" placeholder="No. Kontak">
        <input class="input-1 pb-1em" type="text" placeholder="Singkatan (opsional)">
    </div>
    <div class="grid-2-auto mt-1em">
        <input class="input-1 pb-1em" type="text" placeholder="Ekspedisi">
        <div class="justify-self-center grid-1-auto circle-medium bg-orange-2"><span class="justify-self-center font-size-2em font-weight-bold color-white">+</span></div>
    </div>
    <textarea class="mt-1em pt-1em pl-1em" name="alamat" id="alamat" placeholder="Keterangan (opsional)"></textarea>
</div>

<div class="grid-2-10_auto_auto mt-1em ml-1em mr-1em">
    <div class="">
        <img class="w-2em" src="img/icons/speech-bubble.svg" alt="Reseller?">
    </div>
    <div class="font-weight-bold">
        Apakah Pelanggan ini memiliki Reseller?
    </div>
    <div>
        <div id="divToggleReseller" class="position-relative b-radius-25px b-1px-grey bg-color-grey w-4_5em" onclick="showInputReseller();">
            <div id="toggleReseller" class="position-absolute w-3em text-center b-radius-25px b-1px-grey color-grey bg-color-white">tidak</div>
        </div>
    </div>
</div>

<div class="ml-2em mr-2em mt-1em b-1px-grey p-1em">
    <input class="input-1 pb-1em" type="text" placeholder="Nama Reseller">

</div>

<br><br>

<div>
    <div class="m-1em h-4em bg-color-orange-2 grid-1-auto">
        <span class="justify-self-center font-weight-bold">Input Pelanggan Baru</span>
    </div>
</div>

<script>
    function showInputReseller() {
        if ($("#toggleReseller").html() == "tidak") {
            $("#toggleReseller").animate({
                left: "1.35em"
            }, 200);
            $("#divToggleReseller").css("background-color", "#FFED50");
            $("#toggleReseller").html("ya");

        } else {

            $("#toggleReseller").animate({
                left: '0em'
            }, 200);
            $("#divToggleReseller").css("background-color", "#E4E4E4");
            $("#toggleReseller").html("tidak");


        }
    }
</script>

<style>
    #divToggleReseller {
        height: 1.5em;
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


    #alamat {
        box-sizing: border-box;
        width: 100%;
        height: 8em;
        border: 1px solid #E4E4E4;
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

    .div-cari-filter {
        border-bottom: 0.5px solid #E4E4E4;
    }
</style>

<?php
include_once "01-footer.php";
?>