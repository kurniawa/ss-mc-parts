<?php
include_once "01-header.php";

error_reporting(E_ALL & E_STRICT);
ini_set('display_errors', '1');
ini_set('log_errors', '0');
ini_set('error_log', './');

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
$jsonDecodeDataIdEkspedisi = json_decode($dataIdEkspedisi);
// var_dump($jsonDecodeDataIdEkspedisi[0]);
if ($jsonDecodeDataIdEkspedisi[0] === 'NOT FOUND!') {
    # code...
    $statusEkspedisi = json_encode("TIDAK ADA KETERANGAN EKSPEDISI!");
} else {
    $statusEkspedisi = json_encode("EKSPEDISI DITEMUKAN!");
    $idEkspedisi = json_decode($dataIdEkspedisi);
    // var_dump($dataIdEkspedisi);
    // echo "<br><br>";
    // var_dump($dataIdEkspedisi[0]);
    // echo "<br><br>";
    // var_dump($dataIdEkspedisi[0]->id)
    // $idEkspedisi = $dataIdEkspedisi[0]->id_ekspedisi;
    // var_dump($idEkspedisi);
    $dataDetailEkspedisi = array();
    for ($i = 0; $i < count($idEkspedisi); $i++) {
        # code...
        array_push($dataDetailEkspedisi, funcSelect("ekspedisi", ["id"], $idEkspedisi[$i]->id_ekspedisi, null));
    }
    // var_dump($dataDetailEkspedisi);
    // $decodeDataDetailEkspedisi = json_decode($dataDetailEkspedisi);
    // var_dump($decodeDataDetailEkspedisi);
    // var_dump($dataDetailEkspedisi[0]->id);
}
$dataEkspedisiAll = funcSelect("ekspedisi", null, null, null);
// var_dump($dataEkspedisiAll);


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

<form id="pageEditCustomer" method="POST" action="04-07-edit-data-pelanggan-2.php">

    <div class="mt-1em ml-1em grid-2-10_auto">
        <div class="">
            <img class="w-2em" src="img/icons/pencil.svg" alt="Data Pelanggan Baru">
        </div>
        <div class="font-weight-bold">
            Edit Data Pelanggan
        </div>
    </div>

    <div class="ml-1em mr-1em mt-2em">
        <label for="nama">Nama Pelanggan:</label>
        <input id="nama" name="nama" class="input-1 pb-1em" type="text" placeholder="Nama/Perusahaan/Pabrik" onkeyup="cekAdanyaPerubahanData('#nama', '#nama2');">
        <input id="nama2" type="hidden">
        <input id="idPelanggan" name="idPelanggan" type="hidden" value="<?= $id; ?>">
        <br><br>
        <label for="alamat">Alamat Pelanggan:</label>
        <textarea class="mt-1em pt-1em pl-1em text-area-mode-1" name="alamat" id="alamat" onkeyup="cekAdanyaPerubahanData('#alamat', '#alamat2');"></textarea>
        <textarea id="alamat2" style="display: none;"></textarea>
        <div class="grid-2-auto grid-column-gap-1em mt-1em">
            <div>
                <label for="pulau">Pulau:</label>
                <input id="pulau" name="pulau" class="input-1 pb-1em" type="text" placeholder="Pulau" onkeyup="cekAdanyaPerubahanData('#pulau', '#pulau2');">
                <input id="pulau2" type="hidden">
            </div>
            <div>
                <label for="daerah">Daerah:</label>
                <input id="daerah" name="daerah" class="input-1 pb-1em" type="text" placeholder="Daerah" onkeyup="cekAdanyaPerubahanData('#daerah', '#daerah2');">
                <input id="daerah2" type="hidden">
            </div>
        </div>
        <div class="grid-2-auto grid-column-gap-1em mt-1em">
            <div>
                <label for="kontak">Kontak:</label>
                <input id="kontak" name="kontak" class="input-1 pb-1em" type="text" placeholder="No. Kontak" onkeyup="cekAdanyaPerubahanData('#kontak', '#kontak2');">
                <input id="kontak2" type="hidden">
            </div>
            <div>
                <label for="singkatan">Singkatan:</label>
                <input id="singkatan" name="singkatan" class="input-1 pb-1em" type="text" placeholder="Singkatan (opsional)" onkeyup="cekAdanyaPerubahanData('#singkatan', '#singkatan2');">
                <input id="singkatan2" type="hidden">
            </div>
        </div>

        <div id="divInputEkspedisi" class="mt-1em">
        </div>

        <!-- MENAMBAHKAN EKSPEDISI UNTUK PELANGGAN INI -->

        <div class="grid-1-auto justify-items-center">
            <div class="bg-color-orange-1 pl-1em pr-1em pt-0_5em pb-0_5em b-radius-50px" onclick="showPertanyaanEkspedisiTransit();">+ Tambah Ekspedisi</div>
        </div>
        <label for="keterangan">Keterangan:</label>
        <textarea id="keterangan" name="keterangan" class="mt-1em pt-1em pl-1em text-area-mode-1" name="keterangan" placeholder="Keterangan lain (opsional)" onkeyup="cekAdanyaPerubahanData('#keterangan', '#keterangan2');"></textarea>
        <textarea id="keterangan2" style="display: none;"></textarea>
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

    <div id="warning" style="display: none;"></div>

    <!-- <div> -->
    <div class="grid-1-auto">
        <button onclick="editCustomerInfo();" id="divBtnEditDataPelanggan" class="m-1em h-4em bg-color-orange-2 grid-1-auto">
            <span id="btnEditDataPelanggan" class="justify-self-center font-weight-bold">Konfirmasi Edit Data Pelanggan</span>
        </button>
    </div>
    <!-- </div> -->

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
</form>


<script>
    // DATA PELANGGAN
    var dataPelanggan = <?= $dataPelanggan; ?>;
    console.log(dataPelanggan);
    console.log(dataPelanggan[0].alamat);

    // dataPelanggan[0].alamat = dataPelanggan[0].alamat.replace(new RegExp('\r?\n', 'g'), '<br />');
    $inputNamaPelanggan = $('#nama');
    var txtAreaAlamat = document.getElementById('alamat');
    $pulau = $('#pulau');
    $daerah = $('#daerah');
    $kontak = $('#kontak');
    $singkatan = $('#singkatan');
    $keterangan = $('#keterangan');

    // set semua value 2 kali, untuk pengecekan, apabila terjadi perubahan data
    $inputNamaPelanggan.val(dataPelanggan[0].nama);
    document.getElementById('nama2').value = dataPelanggan[0].nama;

    txtAreaAlamat.value = dataPelanggan[0].alamat;
    $('#alamat2').val(dataPelanggan[0].alamat);

    $pulau.val(dataPelanggan[0].pulau);
    $('#pulau2').val(dataPelanggan[0].pulau);

    $daerah.val(dataPelanggan[0].daerah);
    $('#daerah2').val(dataPelanggan[0].daerah);

    $kontak.val(dataPelanggan[0].kontak);
    $('#kontak2').val(dataPelanggan[0].kontak);

    $singkatan.val(dataPelanggan[0].singkatan);
    $('#singkatan2').val(dataPelanggan[0].singkatan);

    $keterangan.val(dataPelanggan[0].keterangan);
    $('#keterangan2').val(dataPelanggan[0].keterangan);

    // DATA EKSPEDISI
    // untuk autocomplete, ditampung dulu array ekspedisi
    var statusEkspedisi = <?= $statusEkspedisi; ?>;
    console.log(statusEkspedisi);

    var arrayEkspedisi = <?= $dataEkspedisiAll ?>;
    var arrayNamaEkspedisi = new Array();
    for (const ekspedisi of arrayEkspedisi) {
        arrayNamaEkspedisi.push(ekspedisi.nama);
    }
    console.log(arrayNamaEkspedisi);

    var arrayKombNamaIdEkspedisi = new Array();
    for (const ekspedisi of arrayEkspedisi) {
        arrayKombNamaIdEkspedisi.push(ekspedisi.id + '---' + ekspedisi.nama);
    }
    var dataIdEkspedisi = <?= $dataIdEkspedisi; ?>;
    console.log(dataIdEkspedisi);

    if (statusEkspedisi === 'TIDAK ADA KETERANGAN EKSPEDISI!') {
        console.log('TIDAK ADA KETERANGAN EKSPEDISI!');

    } else {
        // --
        var dataDetailEkspedisi = <?= json_encode($dataDetailEkspedisi); ?>;
        console.log(dataDetailEkspedisi);
        for (var i = 0; i < dataDetailEkspedisi.length; i++) {
            var parsedItem = JSON.parse(dataDetailEkspedisi[i]);
            console.log(parsedItem);
            $tipeEkspedisi = '';
            var htmlEkspedisi = '';
            $name = '';
            if (dataIdEkspedisi[i].ekspedisi_transit === 'y') {
                htmlEkspedisi = `${htmlEkspedisi}
            <div id="divInputID-${i}" class="containerInputEkspedisi grid-2-auto_15 mb-1em">
            <div class="bb-1px-solid-grey">
            <label for='inputID-${i}'>Ekspedisi Transit:</label>
            `;
                $tipeEkspedisi = 'inputEkspedisiTransit';
                $name = 'idEkspedisiTransit[]'
            } else {
                htmlEkspedisi = `${htmlEkspedisi}
            <div id="divInputID-${i}" class="containerInputEkspedisi grid-2-auto_15 mb-1em">
            <div class="bb-1px-solid-grey">
            <label for='inputID-${i}'>Ekspedisi Utama:</label>
            `;
                $tipeEkspedisi = 'inputEkspedisiNormal';
                $name = 'idEkspedisi[]';
            }
            htmlEkspedisi = `${htmlEkspedisi}
            <input id="inputID-${i}" class="input-1 pb-1em bb-none" type="text" value="${parsedItem[0].nama}">
            <input type="hidden" name="${$name}" value="${parsedItem[0].id}" class="inputEkspedisiAll">
            <input id="inputIDHidden-${i}" type="hidden" value="${parsedItem[0].nama}" class="${$tipeEkspedisi}">
            </div>
            <div class="btnTambahKurangEkspedisi justify-self-right grid-1-auto circle-medium bg-color-soft-red" onclick="btnKurangEkspedisi(${i});">
            <div class="justify-self-center w-1em h-0_3em bg-color-white b-radius-50px"></div>
            </div>
            </div>
        `;

            $("#divInputEkspedisi").append(htmlEkspedisi);
            setAutoCompletePlusPerubahan(`#inputID-${i}`, arrayKombNamaIdEkspedisi, `#inputIDHidden-${i}`);

        }
    }

    function setAutoComplete(elementToAutoComplete, sourceArray) {
        $(elementToAutoComplete).autocomplete({
            source: sourceArray,
            select: function(event, ui) {
                console.log(ui);
                console.log(ui.item.value);
            }
        });
    }

    function showPertanyaanEkspedisiTransit() {
        // history.pushState(2, null, "./pertanyaan-ekspedisi-transit");
        $("#closingAreaPertanyaan").toggle(300);
        $("#pertanyaanEkspedisiTransit").toggle(300);
    }

    console.log($('#divInputEkspedisi').length);

    function addInputEkspedisi($jawaban) {

        $("#closingAreaPertanyaan").css("display", "none");
        $("#pertanyaanEkspedisiTransit").css("display", "none");
        $name = '';
        if ($jawaban == 'tidak') {
            $placeholder = "Ekspedisi";
            $tipeEkspedisi = "inputEkspedisiNormal";
            $name = "idEkspedisi[]";
        } else {
            $placeholder = "Ekspedisi Transit";
            $tipeEkspedisi = "inputEkspedisiTransit";
            $name = 'idEkspedisiTransit[]';
        }

        $index = $('#divInputEkspedisi').children().length;
        $newDiv = '<div id="divInputID-' + $index + '" class="containerInputEkspedisi grid-2-auto_15 mb-1em">' +
            '<div class="bb-1px-solid-grey">' +
            '<input id="inputID-' + $index + '" class="input-1 pb-1em bb-none" type="text" placeholder="' + $placeholder + '");">' +
            '<input id="inputIDHidden-' + $index + '" type="hidden" name="' + $name + '" class="inputEkspedisiAll ' + $tipeEkspedisi + '">' +
            '</div>' +
            `<div class="btnTambahKurangEkspedisi justify-self-right grid-1-auto circle-medium bg-color-soft-red" onclick="btnKurangEkspedisi('${'#divInputID-' + $('#divInputEkspedisi').children().length-1}');">` +
            '<div class="justify-self-center w-1em h-0_3em bg-color-white b-radius-50px"></div>' +
            '</div>' +
            '</div>';

        $("#divInputEkspedisi").append($newDiv);
        setAutoCompletePlusPenambahan(`#inputID-${$index}`, arrayKombNamaIdEkspedisi, `#inputIDHidden-${$index}`);
    }

    function btnKurangEkspedisi(idElementToRemove) {
        console.log("btnKurangEkspedisi");
        console.log(idElementToRemove);
        $(idElementToRemove).remove();
        // $("#searchResults-" + $id).removeClass("grid-1-auto").addClass("d-none");
    }

    // FUNGSI UNTUK CEK APAKAH TERJADI PERUBAHAN DATA
    // Hide button pengeditan di awal membuka halaman
    $('#divBtnEditDataPelanggan').hide();

    function cekAdanyaPerubahanData(id1, id2) {
        console.log('Jalankan: Pen cek an perubahan data!');
        $val1 = $(id1).val();
        $val2 = $(id2).val();

        console.log('value1:');
        console.log($val1);
        console.log('value2:');
        console.log($val2);

        if ($val1 !== $val2) {
            console.log('Ada perubahan data!');
            $('#divBtnEditDataPelanggan').show();
        } else {
            console.log('Data tidak berubah!');
            $('#divBtnEditDataPelanggan').hide();
        }

    }

    function setAutoCompletePlusPerubahan(elementToAutoComplete, sourceArray, elementToCompare) {
        $(elementToAutoComplete).autocomplete({
            source: sourceArray,
            select: function(event, ui) {
                console.log(ui);
                console.log(ui.item.value);
                cekAdanyaPerubahanData(elementToAutoComplete, elementToCompare);
            }
        });
    }

    // Set length awal dari data ekspedisi
    const lengthDataEkspedisi = $('#divInputEkspedisi').children().length;
    console.log('Length divInputEkspedisi Awal:');
    console.log(lengthDataEkspedisi);

    function setAutoCompletePlusPenambahan(elementToAutoComplete, sourceArray, elementValueToSet) {
        console.log('Menambahakan feature autocomplete untuk: ' + elementToAutoComplete);
        console.log('Plus pengecekan adanya penambahan data.');
        $(elementToAutoComplete).autocomplete({
            source: sourceArray,
            select: function(event, ui) {
                console.log(ui);
                console.log(ui.item.value);
                cekAdanyaPenambahanData(lengthDataEkspedisi, $('#divInputEkspedisi').children().length);
                $value = ui.item.value.split('---');
                console.log($value);
                $id = $value[0];
                console.log('chosen ID: ' + $id);
                console.log('elementValueToSet: ' + elementValueToSet);
                $(elementValueToSet).val($id);
                console.log(elementValueToSet + '.val()= ' + $(elementValueToSet).val());
            }
        });
    }

    function cekAdanyaPenambahanData(length1, length2) {
        console.log('Jalankan: pengecekan adanya penambahan data!');
        console.log('length1: ' + length1);
        console.log('length2: ' + length2);
        if (length1 !== length2) {
            console.log('Penambahan/Pengurangan data: ADA');
            $('#divBtnEditDataPelanggan').show();

        } else {
            console.log('Penambahan/Pengurangan data: TIDAK ADA');
            $('#divBtnEditDataPelanggan').hide();

        }
    }

    function editCustomerInfo() {
        console.log('\n\n\n\n***** JALANKAN: editCustomerInfo() *****\n\n\n\n');
        $id = <?php echo ($id) ?>;
        $nama = $("#nama").val();
        $alamat = $("#alamat").val();
        $pulau = $("#pulau").val();
        $daerah = $("#daerah").val();
        $kontak = $("#kontak").val();
        $singkatan = $("#singkatan").val();
        $keterangan = $("#keterangan").val();
        $warning = "";

        $arrayGaPenting = [$nama, $alamat, $pulau, $daerah, $kontak, $singkatan, $keterangan];
        console.log($arrayGaPenting);
        // Cek apakah nama, pulau, daerah nya belum terisi

        // Sebelum Insert, cek terlebih dahulu apakah ekspedisi yang diinput terdaftar di database
        // Sebelumnya cek dulu apakah input ekspedisi kosong

        console.log("$('.inputEkspedisiNormal').length : " + $(".inputEkspedisiNormal").length);
        console.log("$('.inputEkspedisiTransit').length : " + $(".inputEkspedisiTransit").length);
        var arrayEkspedisiNormalID = new Array();
        var arrayEkspedisiTransitID = new Array();
        console.log("arrayEkspedisiNormalID: " + arrayEkspedisiNormalID);
        console.log("arrayEkspedisiTransitID: " + arrayEkspedisiTransitID);

        // Delete terlebih dahulu semua Ekspedisi untuk pelanggan ini

        if ($(".inputEkspedisiAll").length != 0) {

            $inputEkspedisiNormalIndex = 0;
            $inputEkspedisiTransitIndex = 0;

            $(".inputEkspedisiAll").each(function(index) {
                // cek ekspedisi sekaligus kalo emang ada, return id
                console.log('ID Ekspedisi: ' + $(this).val());
                // $resultCekEkspedisi = cekEkspedisi($(this).val());
                // if ($resultCekEkspedisi === "No result!") {
                //     $warning = $warning + "<div>Ekspedisi tidak sesuai. Silahkan input ulang ekspedisi atau tambahkan ekspedisi baru terlebih dahulu.</div>";
                //     $("#warning").html($warning).show();
                //     return false;
                // } else {

                //     if ($(".inputEkspedisiNormal:eq(" + $inputEkspedisiNormalIndex + ")").val() == null) {
                //         arrayEkspedisiTransitID.push($resultCekEkspedisi);
                //         $inputEkspedisiTransitIndex++;
                //     } else {
                //         arrayEkspedisiNormalID.push($resultCekEkspedisi);
                //         $inputEkspedisiNormalIndex++;
                //     }
                // }

            });

            console.log("arrayEkspedisiNormalID: " + JSON.stringify(arrayEkspedisiNormalID));
            console.log("arrayEkspedisiTransitID: " + JSON.stringify(arrayEkspedisiTransitID));

        }

        // Penghapusan semua ekspedisi yang ada

        // END
        // $.ajax({
        //     type: "POST",
        //     url: "04-05-insert-edit-customer.php",
        //     async: false,
        //     data: {
        //         id: $id,
        //         nama: $nama,
        //         alamat: $alamat,
        //         pulau: $pulau,
        //         daerah: $daerah,
        //         kontak: $kontak,
        //         singkatan: $singkatan,
        //         keterangan: $keterangan,
        //         arrayEkspedisiNormalID: arrayEkspedisiNormalID,
        //         arrayEkspedisiTransitID: arrayEkspedisiTransitID
        //     },
        //     success: function(responseText) {
        //         console.log(responseText);
        //     }
        // });

    }

    function cekEkspedisi(params) {
        console.log(params);
        $idToReturn = "";
        if (params != "") {
            $.ajax({
                type: "POST",
                url: "04-04-cek-ekspedisi.php",
                async: false,
                data: {
                    nama: params
                },
                success: function(responseText) {
                    console.log(responseText);
                    $idToReturn = responseText;
                }
            });
        }
        console.log($idToReturn);
        return $idToReturn;

    }
</script>

<?php
include_once '01-footer.php';
?>