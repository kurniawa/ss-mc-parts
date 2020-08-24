<?php
include_once "01-header.php";
?>

<div class="header"></div>

<div class="grid-2-10_auto mt-1em ml-1em">
    <div>
        <img class="w-2em" src="img/icons/pencil.svg" alt="Data Pelanggan Baru">
    </div>
    <div class="font-weight-bold">
        Input Data Ekspedisi Baru
    </div>
</div>

<div class="ml-1em mr-1em mt-2em">
    <div class="grid-2-auto grid-column-gap-1em">
        <div class="bb-0_5px-grey pb-1em">
            <select class="b-none" name="bentuk-perusahaan" id="bentukPerusahaan" required>
                <option value="" selected disabled>Bentuk</option>
                <option value="">-</option>
                <option value="pt">PT</option>
                <option value="cv">CV</option>
            </select>
        </div>
        <input class="input-1 pb-1em" type="text" placeholder="Nama Ekspedisi">
    </div>

    <textarea class="mt-1em pt-1em pl-1em" name="alamat" id="alamat" placeholder="Alamat"></textarea>
    <div class="mt-1em">
        <input class="input-1 pb-1em" type="text" placeholder="No. Kontak">
    </div>
    <textarea class="mt-1em pt-1em pl-1em" name="alamat" id="alamat" placeholder="Keterangan lain (opsional)"></textarea>
</div>

<div>
    <div class="m-1em h-4em bg-color-orange-2 grid-1-auto">
        <span class="justify-self-center font-weight-bold">Input Ekspedisi Baru</span>
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

            $("#divInputNamaReseller").toggle(200);
        } else {

            $("#toggleReseller").animate({
                left: '0em'
            }, 200);
            $("#divToggleReseller").css("background-color", "#E4E4E4");
            $("#toggleReseller").html("tidak");

            $("#divInputNamaReseller").toggle(200);
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