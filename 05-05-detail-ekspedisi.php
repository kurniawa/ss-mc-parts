<?php
include_once "01-header.php";
// var_dump($_GET["id"]);

// $id = $_GET["id"];
?>

<div class="header"></div>

<div class="ml-1em mr-1em">
    <div class="grid-2-10-auto">
        <h2 id="bentukPerusahaan"></h2>
        <h2 id="namaEkspedisi"></h2>
    </div>

    <div class="grid-2-15-auto">
        <img class="w-2_5em" src="img/icons/real-estate.svg" alt="">
        <div id="alamatEkspedisi"></div>
    </div>

    <div class="grid-2-15-auto">
        <div><img class="w-2_5em" src="img/icons/phonebook.svg" alt=""></div>
        <div id="kontakEkspedisi"></div>
    </div>

</div>

<script>
    $id = <?php echo $_GET["id"] ?>;
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
                $alamatEkspedisi = $ekspedisi[0].alamat.replace(new RegExp('\r?\n', 'g'), '<br />');
                $kontakEkspedisi = $ekspedisi[0].kontak;
                console.log($alamatEkspedisi);
                console.log($alamatEkspedisi.replace(new RegExp('\r?\n', 'g'), '<br />'));
                $("#bentukPerusahaan").html($bentukEkspedisi);
                $("#namaEkspedisi").html($namaEkspedisi);
                $("#alamatEkspedisi").html($alamatEkspedisi);
                $("#kontakEkspedisi").html($kontakEkspedisi);
            }
        });
    });
</script>

<?php
include_once "01-footer.php";
?>