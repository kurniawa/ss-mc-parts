<?php
include_once "01-header.php";
?>

<div class="header"></div>

<div class="grid-2-10-auto mt-1em ml-1em">
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
                <option value="PT">PT</option>
                <option value="CV">CV</option>
            </select>
        </div>
        <input id="nama" class="input-1 pb-1em" type="text" placeholder="Nama Ekspedisi">
    </div>

    <textarea id="alamat" class="mt-1em pt-1em pl-1em" name="alamat" placeholder="Alamat"></textarea>
    <div class="mt-1em">
        <input id="kontak" class="input-1 pb-1em" type="text" placeholder="No. Kontak">
    </div>
    <textarea id="keterangan" class="mt-1em pt-1em pl-1em" name="keterangan" placeholder="Keterangan lain (opsional)"></textarea>
</div>
<div id="peringatan" class="d-none color-red p-1em">

</div>
<div>
    <div class="m-1em h-4em bg-color-orange-2 grid-1-auto" onclick="inputEkspedisiBaru();">
        <span class="justify-self-center font-weight-bold">Input Ekspedisi Baru</span>
    </div>
</div>

<script>
    function inputEkspedisiBaru() {
        $bentuk = $("#bentukPerusahaan").val();
        $nama = $("#nama").val();
        $alamat = $("#alamat").val();
        $kontak = $("#kontak").val();
        $keterangan = $("#keterangan").val();
        $peringatan = $("#peringatan");

        console.log($alamat);
        if ($nama == "") {
            $peringatan.html("Nama Ekspedisi harus diisi!");
            if ($peringatan.css("display") == "none") {
                $peringatan.toggle(100);
            }
        } else if ($nama != "" && $peringatan.css("display") != "none") {
            $peringatan.toggle(100);
        }

        $.ajax({
            url: "05-04-insert-edit-ekspedisi.php",
            type: "POST",
            async: false,
            data: {
                id: "",
                nama: $nama,
                bentuk: $bentuk,
                alamat: $alamat,
                kontak: $kontak,
                keterangan: $keterangan
            },
            success: function(responseText) {
                console.log(responseText);
            }
        });
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


    #alamat,
    #keterangan {
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