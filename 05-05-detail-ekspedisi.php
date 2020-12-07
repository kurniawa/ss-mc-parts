<?php
include_once "01-header.php";
// var_dump($_GET["id"]);

$id = $_GET["id"];
?>
<div id="pageDetailEkspedisi">
    <div class="header grid-2-auto">
        <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="backToEkspedisi();">

        <div class="grid-1-auto justify-self-right grid-row-gap-0_2em mr-1_5em z-index-3" onclick="showMenu();">
            <div class="w-0_4em h-0_4em b-radius-100 bg-color-white"></div>
            <div class="w-0_4em h-0_4em b-radius-100 bg-color-white"></div>
            <div class="w-0_4em h-0_4em b-radius-100 bg-color-white"></div>
        </div>
    </div>

    <div id="showDotMenuContent" class="position-absolute bg-color-white z-index-3">
        <a href="05-06-edit-ekspedisi.php?id=<?= $id; ?>" class="dotMenuItem grid-2-auto grid-column-gap-0_5em pl-1em pr-1em pt-0_5em pb-0_5em">
            <img class="w-1em" src="img/icons/edit.svg" alt="">
            <div class="">Edit</div>
        </a>
    </div>

    <div id="areaClosingDotMenu" onclick="closingDotMenuContent();"></div>

    <div class="ml-1em mr-1em">
        <div class="grid-2-10-auto">
            <h3 id="bentukPerusahaan"></h3>
            <h3 id="namaEkspedisi"></h3>

        </div>

        <div class="grid-2-15-auto grid-row-gap-0_5em">
            <img class="w-2_5em" src="img/icons/real-estate.svg" alt="">
            <div id="alamatEkspedisi"></div>
            <div><img class="w-2_5em" src="img/icons/phonebook.svg" alt=""></div>
            <div id="kontakEkspedisi"></div>
            <img class="w-2_5em" src="img/icons/pencil.svg" alt="">
            <div class="font-weight-bold">Daftar Pelanggan dengan Ekspedisi ini:</div>
            <img class="w-2_5em" src="img/icons/email.svg" alt="">
            <div class="font-weight-bold">Daftar Surat Jalan dengan Ekspedisi ini:</div>
        </div>
    </div>


</div>

<style>
    #showDotMenuContent {
        display: none;
        top: 3em;
        right: 1.5em;
        border: 1px solid #E4E4E4;
    }

    .dotMenuItem:hover {
        background-color: grey;
    }

    #areaClosingDotMenu {
        display: none;
        position: absolute;
        top: 0;
        width: 100vw;
        height: 100vh;
        z-index: 2;
        /* border: 1px solid red; */
    }
</style>

<script>
    $id = <?php echo $id ?>;

    $(document).ready(function() {
        $.ajax({
            url: "05-02-get-ekspedisi.php",
            type: "POST",
            async: false,
            data: {
                id: $id
            },
            success: function(responseText) {
                console.log(responseText);
                $ekspedisi = JSON.parse(responseText);
                console.log($ekspedisi);
                $bentukEkspedisi = $ekspedisi[0].bentuk;
                $namaEkspedisi = $ekspedisi[0].nama;
                $alamatEkspedisi = $ekspedisi[0].alamat;
                $alamatEkspedisiBr = $ekspedisi[0].alamat.replace(new RegExp('\r?\n', 'g'), '<br />');
                $kontakEkspedisi = $ekspedisi[0].kontak;
                $keterangan = $ekspedisi[0].keterangan;
                console.log($alamatEkspedisi);
                console.log($alamatEkspedisi.replace(new RegExp('\r?\n', 'g'), '<br />'));
                $("#bentukPerusahaan").html($bentukEkspedisi);
                $("#namaEkspedisi").html($namaEkspedisi);
                $("#alamatEkspedisi").html($alamatEkspedisiBr);
                $("#kontakEkspedisi").html($kontakEkspedisi);
            }
        });
    });

    function showMenu() {
        $("#showDotMenuContent").toggle(200);
        $("#areaClosingDotMenu").css("display", "block");

    }

    function closingDotMenuContent() {
        $("#showDotMenuContent").toggle();
        $("#areaClosingDotMenu").css("display", "none");

    }

    function moveToEditEkspedisi() {
        $("#pageDetailEkspedisi").toggle(1000);
        $("#pageEditEkspedisi").toggle(1000);
        $("#showDotMenuContent").toggle();
        $("#areaClosingDotMenu").toggle();
        history.pushState(null, null, "./edit-ekspedisi");
    }

    function backToEkspedisi() {
        window.location.replace("05-01-ekspedisi.php");
    }
</script>

<?php
include_once "01-footer.php";
?>