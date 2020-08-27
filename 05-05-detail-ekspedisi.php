<?php
include_once "01-header.php";
// var_dump($_GET["id"]);

$id = $_GET["id"];
?>
<div id="pageDetailEkspedisi">
    <div class="header grid-1-auto justify-items-end">
        <div class="grid-1-auto grid-row-gap-0_2em mr-1_5em z-index-3" onclick="showMenu();">
            <div class="w-0_4em h-0_4em b-radius-100 bg-color-white"></div>
            <div class="w-0_4em h-0_4em b-radius-100 bg-color-white"></div>
            <div class="w-0_4em h-0_4em b-radius-100 bg-color-white"></div>
        </div>
    </div>

    <div id="showDotMenuContent" class="position-absolute bg-color-white z-index-3">
        <div class="dotMenuItem grid-2-auto grid-column-gap-0_5em pl-1em pr-1em pt-0_5em pb-0_5em" onclick="moveToEditEkspedisi();">
            <img class="w-1em" src="img/icons/edit.svg" alt="">
            <div class="">Edit</div>
        </div>
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
                    $alamatEkspedisi = $ekspedisi[0].alamat.replace(new RegExp('\r?\n', 'g'), '<br />');
                    $kontakEkspedisi = $ekspedisi[0].kontak;
                    $keterangan = $ekspedisi[0].keterangan;
                    console.log($alamatEkspedisi);
                    console.log($alamatEkspedisi.replace(new RegExp('\r?\n', 'g'), '<br />'));
                    $("#bentukPerusahaan").html($bentukEkspedisi);
                    $("#namaEkspedisi").html($namaEkspedisi);
                    $("#alamatEkspedisi").html($alamatEkspedisi);
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
            history.pushState(null, null, "./edit-ekspedisi");
        }
    </script>
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
</div>



<div id="pageEditEkspedisi" class="d-none">
    <div class="header"></div>

    <div class="grid-2-10-auto mt-1em ml-1em">
        <div>
            <img class="w-2em" src="img/icons/pencil.svg" alt="Data Pelanggan Baru">
        </div>
        <div class="font-weight-bold">
            Edit Data Ekspedisi
        </div>
    </div>

    <div class="ml-1em mr-1em mt-2em">
        <div class="grid-2-auto grid-column-gap-1em">
            <div class="bb-0_5px-grey pb-1em">
                <select class="b-none" name="bentuk-perusahaan" id="selectBentukPerusahaan" required>
                    <option value="" disabled>Bentuk</option>
                    <option value="">-</option>
                    <option value="PT.">PT</option>
                    <option value="CV.">CV</option>
                </select>
            </div>
            <input id="namaEdited" class="input-1 pb-1em" type="text" placeholder="Nama Ekspedisi">
        </div>

        <textarea id="alamatEdited" class="text-area-mode-1 mt-1em pt-1em pl-1em" name="alamat" placeholder="Alamat"></textarea>
        <div class="mt-1em">
            <input id="kontakEdited" class="input-1 pb-1em" type="text" placeholder="No. Kontak">
        </div>
        <textarea id="keteranganEdited" class="text-area-mode-1 mt-1em pt-1em pl-1em" name="keterangan" placeholder="Keterangan lain (opsional)"></textarea>
    </div>
    <div id="peringatan" class="d-none color-red p-1em">

    </div>
    <div>
        <div class="m-1em h-4em bg-color-orange-2 grid-1-auto" onclick="simpanPerubahan();">
            <span class="justify-self-center font-weight-bold">Simpan Perubahan</span>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // console.log($("#selectBentukPerusahaan"));
            $("#selectBentukPerusahaan option[value='" + $bentukEkspedisi + "']").prop("selected", true);
            $("#namaEdited").val($namaEkspedisi);
            $("#alamatEdited").val($alamatEkspedisi);
            $("#kontakEdited").val($kontakEkspedisi);
            $("#keteranganEdited").val($keterangan);
        });

        function simpanPerubahan() {
            $bentuk = $("#selectBentukPerusahaan").val();
            $nama = $("#namaEdited").val();
            $alamat = $("#alamatEdited").val();
            $kontak = $("#kontakEdited").val();
            $keterangan = $("#keteranganEdited").val();
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
                url: "05-04-insert-edit-ekspedisi-baru.php",
                type: "POST",
                async: false,
                data: {
                    id: $id,
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

        window.onpopstate = function() {
            // history.back();
            $("#pageDetailEkspedisi").toggle(1000);
            $("#pageEditEkspedisi").toggle(1000);
        }
    </script>

</div>



<?php
include_once "01-footer.php";
?>