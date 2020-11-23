<?php
include_once "01-header.php";

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

include_once "01-crud.php";

$table = "pelanggan";
$column = ["id"];
$value = [$id];
$order = null;
$dataPelanggan = funcSelect($table, $column, $value, $order);
// var_dump($dataPelanggan);
// echo "<br><br>";
// var_dump(json_decode($dataPelanggan));
$dataIdEkspedisi = funcSelect("pelanggan_use_ekspedisi", ["id_pelanggan"], $value, null);
// var_dump($dataIdEkspedisi);
$dataIdEkspedisi = json_decode($dataIdEkspedisi);
// var_dump($dataIdEkspedisi);
// echo "<br><br>";
// var_dump($dataIdEkspedisi[0]);
// echo "<br><br>";
// var_dump($dataIdEkspedisi[0]->id)
$idEkspedisi = $dataIdEkspedisi[0]->id_ekspedisi;
var_dump($idEkspedisi);
// $dataDetailEkspedisi = 

?>

<!-- PAGE: EDIT CUSTOMER -->
<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="goBack();">
    <!-- <div class="justify-self-right pr-0_5em">
        <a href="05-03-ekspedisi-baru.php" class="btn-atas-kanan2">
            + Ekspedisi Baru
        </a>
    </div> -->
</header>

<div id="pageEditCustomer">

    <div class="mt-1em ml-1em grid-2-10_auto">
        <div class="">
            <img class="w-2em" src="img/icons/pencil.svg" alt="Data Pelanggan Baru">
        </div>
        <div class="font-weight-bold">
            Edit Data Pelanggan
        </div>
    </div>

    <div class="ml-1em mr-1em mt-2em">
        <input id="nama" class="input-1 pb-1em" type="text" placeholder="Nama/Perusahaan/Pabrik">
        <textarea class="mt-1em pt-1em pl-1em text-area-mode-1" name="alamat" id="alamat" placeholder="Alamat"></textarea>
        <div class="grid-2-auto grid-column-gap-1em mt-1em">
            <input id="pulau" class="input-1 pb-1em" type="text" placeholder="Pulau">
            <input id="daerah" class="input-1 pb-1em" type="text" placeholder="Daerah">
        </div>
        <div class="grid-2-auto grid-column-gap-1em mt-1em">
            <input id="kontak" class="input-1 pb-1em" type="text" placeholder="No. Kontak">
            <input id="singkatan" class="input-1 pb-1em" type="text" placeholder="Singkatan (opsional)">
        </div>

        <div id="divInputEkspedisi" class="mt-1em">
        </div>

        <!-- MENAMBAHKAN EKSPEDISI UNTUK PELANGGAN INI -->

        <div class="grid-1-auto justify-items-center">
            <div class="bg-color-orange-1 pl-1em pr-1em pt-0_5em pb-0_5em b-radius-50px" onclick="showPertanyaanEkspedisiTransit();">+ Tambah Ekspedisi</div>
        </div>
        <textarea id="keterangan" class="mt-1em pt-1em pl-1em text-area-mode-1" name="alamat" placeholder="Keterangan lain (opsional)"></textarea>
    </div>

    <div class="grid-2-10_auto_auto mt-1em ml-1em mr-1em">
        <div class="">
            <img class="w-2em" src="img/icons/speech-bubble.svg" alt="Reseller?">
        </div>
        <div class="font-weight-bold">
            Pelanggan ini tidak memiliki Reseller. Apakah ingin menambahkan Reseller?
        </div>
        <div>
            <div id="divToggleReseller" class="position-relative b-radius-50px b-1px-solid-grey bg-color-grey w-4_5em h-1_5em" onclick="showInputReseller();">
                <div id="toggleReseller" class="position-absolute w-3em text-center b-radius-50px b-1px-solid-grey color-grey bg-color-white">tidak</div>
            </div>
        </div>
    </div>

    <div id="divInputNamaReseller" class="d-none ml-2em mr-2em mt-1em b-1px-solid-grey p-1em">
        <input class="input-1 pb-1em" type="text" placeholder="Nama Reseller">

    </div>

    <br><br>

    <!-- Warning apabila ada yang kurang -->

    <div id="warning" class="d-none"></div>

    <div>
        <div class="m-1em h-4em bg-color-orange-2 grid-1-auto" onclick="editCustomerInfo();">
            <span class="justify-self-center font-weight-bold">Input Pelanggan Baru</span>
        </div>
    </div>

    <div id="closingAreaPertanyaan" class="d-none position-absolute z-index-2 w-100vw h-100vh bg-color-grey top-0 opacity-0_5">
    </div>

    <div class="position-absolute z-index-3 top-50vh grid-1-auto w-100vw">
        <div id="pertanyaanEkspedisiTransit" class="d-none justify-self-center bg-color-white p-1em">
            <div class="grid-2-auto">
                <div><img class="w-2em" src="img/icons/speech-bubble.svg" alt=""></div>
                <div>
                    <h3>
                        Apakah Anda ingin menambahkan Ekspedisi Transit?
                    </h3>
                </div>
            </div>
            <div class="grid-2-auto justify-items-center">
                <div class="color-soft-red" onclick="addInputEkspedisi('tidak')">
                    <h3>Tidak</h3>
                </div>
                <div class="color-bright-green" onclick="addInputEkspedisi('ya')">
                    <h3>Ya</h3>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var dataPelanggan = <?= $dataPelanggan; ?>;
    console.log(dataPelanggan);
</script>

<?php
include_once '01-footer.php';
?>