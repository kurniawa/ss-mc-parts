<?php
include_once "01-header.php";
include_once "01-config.php";

$mode = "";
$id_spk = "none";
$id_spk_contains_item = "none";
$id_produk = "none";
$item_to_edit = "none";
$spk_contains_item = "none";
$id = "undefined";
$action = "03-03-02-sj-varia-addItemFromNewSJVaria.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $table = $_GET['table'];

    $item_to_edit = dbGet($table);

    if ($item_to_edit[0] !== "ERROR") {
        $status = "OK";
    } else {
        $status = "ERROR";
    }
} else if (isset($_GET["id_spk"]) && isset($_GET["id_spk_contains_item"]) && isset($_GET["id_produk"])) {
    $mode = "edit";
    $id_spk = $_GET["id_spk"];
    $id_spk_contains_item = $_GET["id_spk_contains_item"];
    $id_produk = $_GET["id_produk"];
    $action = "03-03-02-sj-varia-3.php";

    $htmlLogOK = $htmlLogOK .
        "
    id_spk: $id_spk<br>
    id_spk_contains_item: $id_spk_contains_item<br>
    id_produk: $id_produk<br><br>
    ";

    $item_to_edit = dbGetWithFilter("produk", "id", $id_produk);
    $spk_contains_item = dbGetWithFilter("spk_contains_produk", "id", $id_spk_contains_item);
} else {
    $id = 'undefined';
}

// var_dump($item_to_edit);

$htmlLogError = $htmlLogError . "</div>";
$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";
?>

<form action="<?= $action; ?>" method="POST" id="containerSJVaria">

    <div class="ml-0_5em mr-0_5em mt-2em">
        <div>
            <h2>Tipe: Sarung Jok Variasi</h2>
        </div>

        <div id="divArraySJVaria">

        </div>

        <br><br>

        <div id="warningSJVaria" class="d-none"></div>

        <!-- <div id="divBtnKunciItem" class="grid-1-auto justify-items-center">
            <div id="btnKunciItem" class="b-radius-50px bg-color-orange-1 pt-0_5em pb-0_5em pl-1em pr-1em">
                <span class="ui-icon ui-icon-locked"></span>
                <span class="font-weight-bold">kunci item</span>
            </div>
        </div>

        <div id="divPilihanTambahItemSejenis" class="grid-1-auto m-1em">
            <div id="divRadioPilihan" class="justify-self-center b-1px-solid-grey p-1em">
            </div>
        </div> -->

        <div id="divAvailableOptions" class="position-absolute bottom-5em w-calc-100-1em">
            Available options:
            <div id="availableOptions">

            </div>

        </div>
        <div class="position-absolute bottom-0_5em w-calc-100-1em">
            <button type="submit" id="bottomDiv" class="w-100 h-4em bg-color-orange-2 grid-1-auto">

                <span class="justify-self-center font-weight-bold">TAMBAH ITEM KE SPK</span>

            </button>
        </div>
        <div class="position-absolute bottom-0_5em w-calc-100-1em">
            <input id="inputIDItemToEdit" type="hidden" name="id_item_to_edit">
            <!-- <button type="submit" id="bottomDiv2" class="w-100 h-4em bg-color-orange-2 grid-1-auto" onclick="confirmEditItemSPK();"> -->
            <button type="submit" id="bottomDiv2" class="w-100 h-4em bg-color-orange-2 grid-1-auto">

                <span class="justify-self-center font-weight-bold">EDIT ITEM SPK</span>

            </button>

        </div>

    </div>
    <input type="hidden" name="mode" value="<?= $mode; ?>">
    <input type="hidden" name="id_spk" value="<?= $id_spk ?>">
    <input type="hidden" name="id_spk_contains_item" value="<?= $id_spk_contains_item ?>">
    <input type="hidden" name="id_produk" value="<?= $id_produk ?>">
    <input type="hidden" name="harga_jahit">
    <input type="hidden" name="harga_ukuran">
</form>

<div class="divLogError"></div>
<div class="divLogWarning"></div>
<div class="divLogOK"></div>

<script>
    // LOG REPORT
    var htmlLogError = `<?= $htmlLogError; ?>`;
    var htmlLogOK = `<?= $htmlLogOK; ?>`;
    var htmlLogWarning = `<?= $htmlLogWarning; ?>`;

    $('.divLogError').html(htmlLogError);
    $('.divLogWarning').html(htmlLogWarning);
    $('.divLogOK').html(htmlLogOK);

    if ($('.logError').html() === '') {
        $('.divLogError').hide();
    } else {
        $('.divLogError').show();
    }

    if ($('.logWarning').html() === '') {
        $('.divLogWarning').hide();
    } else {
        $('.divLogWarning').show();
    }

    if ($('.logOK').html() === '') {
        $('.divLogOK').hide();
    } else {
        $('.divLogOK').show();
    }
    // END: LOG REPORT

    // codingan untuk antisipasi editing item

    var indexSJVaria = 0; // index yang akan memudahkan apabila nantinya ada item sejenis yang sekaligus mau ditambahkan, yang hanya beda gambar atau warna misalnya.
    var sjVaria = [{}];
    var pilihanSJVariaSejenis = [] // ini nanti untuk pilihan item sejenis yang mau ditambahkan
    var arrayBahan = new Array();
    var arrayNamaBahan = new Array();
    var arrayVariasi = new Array();
    var arrayJenisLG = [],
        arrayGambarLGBludru = [],
        arrayGambarLGPolimas = [],
        arrayGambarLGSablon = [],
        arrayGambarLGBayang = [],
        arrayGambarLGStiker = [],
        arrayJht = [],
        arrayJenisTato = [];

    var arrayHargaJahit = new Array();

    var arrayTipeUkuran = new Array();
    var arrayNamaNotaUkuran = new Array();
    var arrayHargaUkuran = new Array();

    // ini nantinya untuk menampung id - id element yang mau di remove atau di reset
    var idElementToRemove;
    var idElementToReset;

    // console.log('Length divSJVaria: ' + $('div.divSJVaria').length);

    // let testArray = ["test1", "test1", "test1", "test1", "test1", "test1", "test1", "test1"];

    // console.log(testArray);


    fetch('json/products.json').then(response => response.json()).then(data => {
        console.log(data);
        for (const bahan of data[0].bahan) {
            // console.log(bahan.nama_bahan);
            arrayBahan.push({
                bahan: bahan.nama_bahan,
                harga: bahan.harga
            });
            arrayNamaBahan.push(bahan.nama_bahan);
        }
        console.log(arrayBahan);
        for (const variasi of data[0].variasi[0].jenis_variasi) {
            // console.log(variasi.nama);
            arrayVariasi.push(variasi.nama);
        }
        for (const jenisLG of data[0].variasi[0].jenis_variasi[1].jenis_logo) {
            // console.log(jenisLG.nama);
            arrayJenisLG.push(jenisLG.nama);
        }
        for (const gambarLGBludru of data[0].variasi[0].jenis_variasi[1].jenis_logo[0].gambar) {
            arrayGambarLGBludru.push(gambarLGBludru);
        }
        for (const gambarLGPolimas of data[0].variasi[0].jenis_variasi[1].jenis_logo[1].gambar) {
            // console.log(data[0].variasi[0].jenis_variasi[1].jenis_logo[1].gambar);
            arrayGambarLGPolimas.push(gambarLGPolimas);
        }
        for (const gambarLGSablon of data[0].variasi[0].jenis_variasi[1].jenis_logo[2].gambar) {
            arrayGambarLGSablon.push(gambarLGSablon);
        }
        for (const gambarLGBayang of data[0].variasi[0].jenis_variasi[1].jenis_logo[3].gambar) {
            arrayGambarLGBayang.push(gambarLGBayang);
        }
        for (const gambarLGStiker of data[0].variasi[0].jenis_variasi[1].jenis_logo[4].gambar) {
            arrayGambarLGStiker.push(gambarLGStiker);
        }
        for (const jht of data[0].jahit) {
            arrayJht.push(jht.tipe_jht);
            arrayHargaJahit.push(jht.harga);
        }
        for (const ukuran of data[0].ukuran) {
            arrayTipeUkuran.push(ukuran.tipe_ukuran);
            arrayNamaNotaUkuran.push(ukuran.nama_nota);
            arrayHargaUkuran.push(ukuran.harga);
        }
    });

    // console.log(arrayBahan);
    // console.log(arrayJht);
    // console.log(arrayHargaJahit);

    $('#divPilihanTambahItemSejenis').hide();

    // $("#variasi2").autocomplete({
    //     source: arrayVariasi
    // });

    // $('#variasi').selectmenu();

    function addSJVaria() {
        var elementsToAppend =
            `<div id="divSJVaria-${indexSJVaria}" class="divSJVaria b-1px-solid-grey pt-1em pb-1em pl-1em pr-1em">
                <div id='divInputBahan-${indexSJVaria}'></div>
                <div id='divVaria-${indexSJVaria}'></div>
                <div id='divJenisLGTato-${indexSJVaria}'></div>
                <div id='divGambar-${indexSJVaria}'></div>
                <div id='divUkuran-${indexSJVaria}'></div>
                <div id='divJht-${indexSJVaria}'></div>
                <div id='divDesc-${indexSJVaria}'></div>
                <div id='divJumlah-${indexSJVaria}'></div>
            </div>`;

        $('#divArraySJVaria').append(elementsToAppend);
    }

    var indexElementSystem = 0;
    var elementSystem = [
        [`#divInputBahan-${indexSJVaria}`, `#inputBahan-${indexSJVaria}`],
        [`#divVaria-${indexSJVaria}`, `#divSelectVaria-${indexSJVaria}`],
        [
            [`#availableOptions`, `#boxJumlah`],
            [`#availableOptions`, `#boxJht`],
            [`#availableOptions`, `#boxDesc`],
            [`#availableOptions`, `#boxUkuran`]
        ],
        [
            [`#divJumlah-${indexSJVaria}`, `#divInputJumlah-${indexSJVaria}`],
            [`#divJht-${indexSJVaria}`, `#divSelectJht-${indexSJVaria}`],
            [`#divDesc-${indexSJVaria}`, `#divTADesc-${indexSJVaria}`],
            [`#divUkuran-${indexSJVaria}`, `#divSelectUkuran-${indexSJVaria}`]
        ]
    ];

    // console.log(elementSystem);
    var removeElementSystem = [`#selectPolosLGTato-${indexSJVaria}`, 'removeSelectTipeLG', 'removeSelectTipeTato', 'removeSelectTipeJahit', 'removeInputJumlah', 'removeBoxJumlah', 'removeBoxJhtKepala'];

    var htmlBoxJumlah =
        `<div id="boxJumlah" class="d-inline-block mr-0_5em pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red" onclick='addLvl3ElementFromBox("Jumlah");'>
        Jumlah
    </div>`;

    var htmlBoxUkuran =
        `<div id="boxUkuran" class="d-inline-block mr-0_5em pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red" onclick='addLvl3ElementFromBox("Ukuran");'>
        + Ukuran
    </div>`;

    var htmlBoxJht =
        `<div id="boxJht" class="d-inline-block mr-0_5em pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red" onclick='addLvl3ElementFromBox("Jht");'>
        + Jahit
    </div>`;

    var htmlBoxDesc =
        `<div id="boxDesc" class="d-inline-block mr-0_5em pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red" onclick='addLvl3ElementFromBox("Desc");'>
        + Ktrgn
    </div>`;

    var htmlDivInputJumlah =
        `<div id="divInputJumlah-${indexSJVaria}" class="mt-1em">
            <input type="number" name="jumlah" id="inputJumlah-${indexSJVaria}" min="0" step="1" placeholder="Jumlah" class="pt-0_5em pb-0_5em">
        </div>`;

    var htmlDivSelectUkuran =
        `<div id='divSelectUkuran-${indexSJVaria}' class="grid-2-auto_10 mt-1em">
            <select name="ukuran" id="selectUkuran-${indexSJVaria}" class="pt-0_5em pb-0_5em" onchange='namaDanHargaUkuran(this.value)'>
                <option value="" disabled selected>Pilih Jenis Ukuran</option>
            </select>
            <span class="ui-icon ui-icon-closethick justify-self-center" onclick='closeAndAddBox("${elementSystem[3][3][1]}","${elementSystem[2][3][0]}","${elementSystem[2][3][1]}", 2, 3);'></span>
        </div>`;

    var htmlDivSelectJht =
        `<div id='divSelectJht-${indexSJVaria}' class="grid-2-auto_10 mt-1em">
            <select name="jahit" id="selectJht-${indexSJVaria}" class="pt-0_5em pb-0_5em">
                <option value="" disabled selected>Pilih Jenis Jahit</option>
            </select>
            <span class="ui-icon ui-icon-closethick justify-self-center" onclick='closeAndAddBox("${elementSystem[3][1][1]}","${elementSystem[2][1][0]}","${elementSystem[2][1][1]}", 2, 1);'></span>
        </div>`;

    var htmlDivTADesc =
        `<div id="divTADesc-${indexSJVaria}" class="mt-1em">
            <div class='text-right'><span class='ui-icon ui-icon-closethick' onclick='closeAndAddBox("${elementSystem[3][2][1]}", "${elementSystem[2][2][0]}","${elementSystem[2][2][1]}", 2, 2);'></span></div>
            <textarea class="pt-1em pl-1em text-area-mode-1" name="ktrg" id="taDesc-${indexSJVaria}" placeholder="Keterangan"></textarea>
        </div>`;


    var elementHTML = [
        `<input name="bahan" id="inputBahan-${indexSJVaria}" class="input-1 mt-1em pb-1em" type="text" placeholder="Nama/Tipe Bahan" onkeyup="cekBahanAddSelectVariasi(this.value);">`,

        `<div id='divSelectVaria-${indexSJVaria}' class="grid-1-auto mt-1em mb-0_5em">
            <select name="varia" id="selectVaria-${indexSJVaria}" class="pt-0_5em pb-0_5em" onchange="cekVariaAddBoxes(this.value);">
                <option value="" disabled selected>Pilih Variasi</option>
            </select>
            <input name="harga_bahan" id='inputHargaBahan-${indexSJVaria}' type='hidden'>
        </div>`,

        [htmlBoxJumlah, htmlBoxJht, htmlBoxDesc, htmlBoxUkuran],

        [htmlDivInputJumlah, htmlDivSelectJht, htmlDivTADesc, htmlDivSelectUkuran]

    ];

    function namaDanHargaUkuran(dataUkuran) {
        console.log(dataUkuran);
        dataUkuran = JSON.parse(dataUkuran);
        console.log(dataUkuran);
        var ukuran = JSON.parse($(`#selectUkuran-${indexSJVaria}`).val());
        console.log(ukuran);
        console.log(ukuran.tipeUkuran);
        console.log(ukuran.namaNotaUkuran);
        console.log(ukuran.hargaUkuran);
    }

    async function pilihFungsi(namaFungsi, divID, elementID, elementHTML) {
        window[namaFungsi](divID, elementID, elementHTML);
        console.log('pilih fungsi dijalankan: ' + namaFungsi + '\n' + divID + '\n' + elementHTML);
    }

    function createElement(divID, elementID, elementHTML) {
        console.log('running create Element');
        console.log(divID + ' ' + elementHTML);
        console.log('elementID: ' + elementID);

        if (divID === '#availableOptions') {
            $(divID).append(elementHTML);
            return;
        }
        $(divID).html(elementHTML);

        if (elementID === `#inputBahan-${indexSJVaria}`) {
            $("#inputBahan-" + indexSJVaria).autocomplete({
                source: arrayNamaBahan,
                select: function(event, ui) {
                    console.log(ui);
                    console.log(ui.item.value);
                    cekBahanAddSelectVariasi(ui.item.value, indexSJVaria);
                    // sjVaria.push({
                    //     'nama_bahan': ui.item.value
                    // });
                    sjVaria[indexSJVaria]['nama_bahan'] = ui.item.value;
                    console.log('sjVaria: ' + sjVaria);
                }
            });

        } else if (elementID === elementSystem[1][1]) {
            arrayVariasi.forEach(variasi => {
                $("#selectVaria-" + indexSJVaria).append('<option value="' + variasi + '">' + variasi + '</option>');
            });
        } else if (elementID === `#divSelectJht-${indexSJVaria}`) {
            for (var i = 0; i < arrayJht.length; i++) {
                $("#selectJht-" + indexSJVaria).append(`<option value='{"tipeJahit": "${arrayJht[i]}", "hargaJahit":" ${arrayHargaJahit[i]}"}'>${arrayJht[i]}</option>`);
            }
        } else if (elementID === `#divSelectUkuran-${indexSJVaria}`) {
            for (var i = 0; i < arrayTipeUkuran.length; i++) {
                $("#selectUkuran-" + indexSJVaria).append(`<option value='{"tipeUkuran":"${arrayTipeUkuran[i]}","namaNotaUkuran":"${arrayNamaNotaUkuran[i]}","hargaUkuran":${arrayHargaUkuran[i]}}'>${arrayTipeUkuran[i]}</option>`);
            }
        } else if (elementID === `#divSelectJenisLG-${indexSJVaria}`) {
            arrayJenisLG.forEach(tipeJht => {
                $("#selectJenisLG-" + indexSJVaria).append('<option value="' + tipeJht + '">' + tipeJht + '</option>');
            });
        } else if (elementID === `#divSelectJenisTato-${indexSJVaria}`) {
            arrayJenisTato.forEach(tipeJht => {
                $("#selectJenisTato-" + indexSJVaria).append('<option value="' + tipeJht + '">' + tipeJht + '</option>');
            });
        }

    }

    addSJVaria();
    createElement(elementSystem[indexElementSystem][0], elementSystem[indexElementSystem][1], elementHTML[indexElementSystem]);

    // fungsi langsung dipanggil untuk langsung menambahkan element2 input SJ Varia pertama pada halaman web.

    function cekBahanAddSelectVariasi(namaBahan) {
        // console.log(namaBahan);
        try {
            for (const bahan of arrayBahan) {
                if (namaBahan === bahan.bahan) {
                    console.log('namaBahan1:' + namaBahan);
                    console.log('namaBahan2:' + bahan.bahan);
                    console.log('hargaBahan:' + bahan.harga);

                    if ($(`#divSelectVaria-${indexSJVaria}`).length === 0) {
                        indexElementSystem = 1;
                        createElement(elementSystem[indexElementSystem][0], elementSystem[indexElementSystem][1], elementHTML[indexElementSystem]);
                    }
                    $(`#inputHargaBahan-${indexSJVaria}`).val(bahan.harga);
                    console.log('Harga Bahan:');
                    console.log($(`#inputHargaBahan-${indexSJVaria}`).val());
                    throw Error("Actually this error is to break the loop only. Because break; cannot used for forEach loop.");
                } else {
                    console.log("Nama Bahan not found!");
                    indexElementSystem = 1;
                    removeElement(indexElementSystem);
                }

            }
        } catch (error) {
            console.log(error);
        }
    }

    function closeAndAddBox(elementToRemove, divID, divElementID, i, j) {
        $(elementToRemove).remove();
        createElement(divID, divElementID, elementHTML[i][j]);
    }

    function cekVariaAddBoxes(value) {
        console.log(value);

        indexElementSystem = 2;
        removeElement(indexElementSystem);
        for (let i = 0; i < elementSystem[indexElementSystem].length; i++) {
            console.log('i: ' + i);
            if ($(elementSystem[indexElementSystem][i][1]).length === 0) {
                createElement(elementSystem[indexElementSystem][i][0], elementSystem[indexElementSystem][i][1], elementHTML[indexElementSystem][i]);
            }
        }

    }

    function addLvl3ElementFromBox(value) {
        indexElementSystem = 3;
        if (value === 'Jumlah') {
            // removeElement(indexElementSystem);
            $('#boxJumlah').remove();
            createElement(elementSystem[indexElementSystem][0][0], elementSystem[indexElementSystem][0][1], elementHTML[indexElementSystem][0]);
        } else if (value === 'Jht') {
            // removeElement(indexElementSystem);
            $('#boxJht').remove();
            createElement(elementSystem[indexElementSystem][1][0], elementSystem[indexElementSystem][1][1], elementHTML[indexElementSystem][1]);
        } else if (value === 'Desc') {
            // removeElement(indexElementSystem);
            $('#boxDesc').remove();
            createElement(elementSystem[indexElementSystem][2][0], elementSystem[indexElementSystem][2][1], elementHTML[indexElementSystem][2]);
        } else if (value === 'Ukuran') {
            $('#boxUkuran').remove();
            createElement(elementSystem[indexElementSystem][3][0], elementSystem[indexElementSystem][3][1], elementHTML[indexElementSystem][3]);
        }
    }

    function removeElement2(idElement) {
        if ($(idElement).length !== 0) {
            console.log('removeElement: ' + idElement);
            $(idElement).remove();
        } else {
            return;
        }
    }

    function removeElement(pointerElementSystemNow) {
        for (let i = pointerElementSystemNow; i < elementSystem.length; i++) {
            if (i === 2 || i === 3) {
                for (let j = 0; j < elementSystem[i].length; j++) {
                    removeElement2(elementSystem[i][j][1]);
                    console.log(i + ' ' + j + ' ' + ' ' + 1);
                }
            } else {
                removeElement2(elementSystem[i][1]);
            }
        }
    }

    function resetElement2(idElements) {
        for (const element of idElements) {
            $(element.id).prop('selectedIndex', 0);
        }
    }

    // document.getElementById('btnKunciItem').addEventListener('click', () => {
    //     let htmlRadioToAppend = pilihanSJVariaSejenis[0] + pilihanSJVariaSejenis[1];
    //     $('#divRadioPilihan').html(htmlRadioToAppend);
    //     $('#divPilihanTambahItemSejenis').show();

    // });

    function insertItemToLocal() {
        // console.log('clicked');
        $tipe = 'sj-varia'
        $bahan = $(`#inputBahan-${indexSJVaria}`).val();
        $varia = $(`#selectVaria-${indexSJVaria}`).val();
        $jht = '';
        $plusJahit = '';
        $desc = '';
        $namaLengkap = '';
        $jumlah = 0;
        var ukuran = '';


        $hargaBahan = $(`#inputHargaBahan-${indexSJVaria}`).val();
        var hargaJht = 0;
        var hargaItem = 0;

        console.log('$bahan: ' + $bahan);
        console.log('$varia: ' + $varia);
        console.log('$jht: ' + $jht);
        console.log('$desc: ' + $desc);
        console.log('$jumlah: ' + $jumlah);

        if ($(`#divSelectJht-${indexSJVaria}`).length !== 0) {
            $jht = $(`#selectJht-${indexSJVaria}`).val();
            hargaJht = 1000;
        }
        if ($(`#divSelectUkuran-${indexSJVaria}`).length !== 0) {
            ukuran = $(`#selectUkuran-${indexSJVaria}`).val();
            if (ukuran !== '') {
                ukuran = JSON.parse(ukuran);
                console.log(ukuran);
                console.log(ukuran.tipeUkuran);
                console.log(ukuran.namaNotaUkuran);
                console.log(ukuran.hargaUkuran);
            }
        }
        if ($(`#divTADesc-${indexSJVaria}`).length !== 0) {
            $desc = $(`#taDesc-${indexSJVaria}`).val();
        }
        if ($(`#divInputJumlah-${indexSJVaria}`).length !== 0) {
            $jumlah = $(`#inputJumlah-${indexSJVaria}`).val();
        }

        if ($bahan === '') {
            $textWarning = '<span class="color-red">Bahan masih belum ditentukan!</span>';
            $('#warningSJVaria').html($textWarning).removeClass('d-none');
            return;
        }

        if ($varia == undefined) {
            console.log('warning untuk Select Variasi');
            $textWarning = '<span class="color-red">Variasi Sarung Jok masih belum ditentukan!</span>';
            $('#warningSJVaria').html($textWarning).removeClass('d-none');
            return;
        }

        if ($jumlah <= 0) {
            console.log('warning untuk jumlah');
            $textWarning = '<span class="color-red">Jumlah barang masih belum diinput dengan benar!</span>';
            $('#warningSJVaria').html($textWarning).removeClass('d-none');
            return;
        }

        if ($jht !== '') {
            $plusJahit = '+ jht ' + $jht;
        }

        $namaLengkap = $namaLengkap + $bahan + ' ' + $varia;
        var hargaPcs = 0;
        if (ukuran !== '') {
            $namaLengkap = $namaLengkap + ' uk. ' + ukuran.tipeUkuran;
            hargaPcs = parseFloat($hargaBahan) + hargaJht + ukuran.hargaUkuran;
        } else {
            $namaLengkap = $namaLengkap + ' ' + $plusJahit;
            hargaPcs = parseFloat($hargaBahan) + hargaJht;
        }

        hargaItem = hargaPcs * $jumlah;
        $namaLengkap = $namaLengkap.trim();

        console.log(hargaPcs);
        console.log(hargaJht);
        console.log(ukuran.hargaUkuran);

        var itemObj = {
            tipe: $tipe,
            bahan: $bahan,
            varia: $varia,
            jahit: $jht,
            desc: $desc,
            jumlah: $jumlah,
            namaLengkap: $namaLengkap,
            hargaBahan: $hargaBahan,
            hargaJht: hargaJht,
            hargaPcs: hargaPcs,
            hargaItem: hargaItem,
            ukuran_tipe: ukuran.tipeUkuran,
            ukuran_nama_nota: ukuran.namaNotaUkuran,
            ukuran_harga: ukuran.hargaUkuran
        }
        console.log(itemObj);
        var newSPK = localStorage.getItem('dataSPKToEdit');
        newSPK = JSON.parse(newSPK);
        console.log(newSPK);

        newSPK.item.push(itemObj);
        console.log(newSPK);
        localStorage.setItem('dataSPKToEdit', JSON.stringify(newSPK));
        window.history.back();
    }

    // var id = php echo $id ;
    // console.log(id);
    // $('#bottomDiv2').hide();
    // setTimeout(() => {

    //     if (id !== undefined) {
    //         editMode();
    //         $('#bottomDiv2').show();
    //         $('#bottomDiv').hide();
    //     }

    // }, 300);

    var status = '<?= $status; ?>';
    var spkItem = <?= json_encode($item_to_edit); ?>;
    var spk_contains_item = <?= json_encode($spk_contains_item); ?>;
    var id = '<?= $id_produk; ?>';
    console.log(status);
    var mode = '<?= $mode; ?>';
    setTimeout(() => {
        if (mode == "edit") {
            editMode();
        } else {
            console.log("BUKAN MODE EDIT");
            $('#inputIDItemToEdit').remove();
            $('#bottomDiv2').hide();
            $('#bottomDiv').show();
        }

    }, 500);

    function editMode() {
        console.log('MASUK KE edit mode');
        // let newSPK = localStorage.getItem('dataSPKToEdit');
        // newSPK = JSON.parse(newSPK);
        // addSJVaria();
        // createElement(elementSystem[indexElementSystem][0], elementSystem[indexElementSystem][1], elementHTML[indexElementSystem]);

        console.log(`spkItem[0]: `);
        console.log(spkItem[0]);

        $('#bottomDiv2').show();
        $('#bottomDiv').hide();

        $("#inputIDItemToEdit").val(id);

        if (spkItem[0].bahan !== '') {
            console.log(spkItem[0].bahan);
            $(`#inputBahan-${indexSJVaria}`).val(spkItem[0].bahan);
        }

        if (spkItem[0].varia !== '') {
            console.log(elementSystem[1][1]);
            cekBahanAddSelectVariasi(spkItem[0].bahan);
            $(`#selectVaria-${indexSJVaria}`).val(spkItem[0].varia);
        }

        console.log(spkItem[0].jahit);
        // if (spkItem[0].jht !== '' || spkItem[0].desc !== '' || spkItem[0].jumlah !== '') {
        //     if (spkItem[0].jht !== '') {
        //         addLvl3ElementFromBox('Jht');
        //         $(`#selectJht-${indexSJVaria}`).val(spkItem[0].jht);

        //     }
        //     if (spkItem[0].desc !== '') {
        //         addLvl3ElementFromBox('Desc');
        //         $(`#taDesc-${indexSJVaria}`).val(spkItem[0].desc);
        //     }
        //     if (spkItem[0].jumlah !== '') {
        //         addLvl3ElementFromBox('Jumlah');
        //         $(`#inputJumlah-${indexSJVaria}`).val(spkItem[0].jumlah);
        //     }
        // }

        if (spkItem[0].jahit !== '') {
            addLvl3ElementFromBox('Jht');
            $(`#selectJht-${indexSJVaria}`).val(spkItem[0].jahit);
        }
        if (spk_contains_item[0].ktrg !== '') {
            addLvl3ElementFromBox('Desc');
            $(`#taDesc-${indexSJVaria}`).val(spk_contains_item[0].ktrg);
        }

        if (spk_contains_item[0].jumlah !== '') {
            addLvl3ElementFromBox('Jumlah');
            $(`#inputJumlah-${indexSJVaria}`).val(spk_contains_item[0].jumlah);
        }

        if (spkItem[0].ukuran !== '') {
            addLvl3ElementFromBox('Ukuran');
            // $(`#boxUkuran`).remove();
            var selectUkuran = document.getElementById(`selectUkuran-${indexSJVaria}`);
            for (var i = 0; i < selectUkuran.options.length; i++) {
                console.log('ukuran:');
                console.log(selectUkuran.options[i]);
                if (selectUkuran.options[i].value !== '') {
                    var valueSelectUkuran = JSON.parse(selectUkuran.options[i].value);
                    var tipeUkuran = valueSelectUkuran.tipeUkuran;
                    if (tipeUkuran === spkItem[0].ukuran) {
                        selectUkuran.selectedIndex = i;
                        break;
                    }
                }
            }
            // $(`#selectUkuran-${indexSJVaria}`).val(spkItem[0].ukuran);
        }

        cekVariaAddBoxes2();
    }

    function cekVariaAddBoxes2() {
        indexElementSystem = 3;
        var elementBoxToShow = indexElementSystem - 1;
        for (let i = 0; i < elementSystem[indexElementSystem].length; i++) {
            console.log('i: ' + i);
            if ($(elementSystem[indexElementSystem][i][1]).length === 0) {
                createElement(elementSystem[elementBoxToShow][i][0], elementSystem[elementBoxToShow][i][1], elementHTML[elementBoxToShow][i]);
            }
        }
    }

    function confirmEditItemSPK() {
        console.log('confirm edit item SPK');
        $tipe = 'sj-varia'
        $bahan = $(`#inputBahan-${indexSJVaria}`).val();
        $varia = $(`#selectVaria-${indexSJVaria}`).val();
        $jht = '';
        $plusJahit = '';
        $ktrg = '';
        $namaLengkap = '';
        $jumlah = 0;
        var ukuran = '';

        $hargaBahan = $(`#inputHargaBahan-${indexSJVaria}`).val();
        var hargaJht = 0;
        var hargaItem = 0;

        console.log('$bahan: ' + $bahan);
        console.log('$varia: ' + $varia);
        console.log('$jht: ' + $jht);
        console.log('$ktrg: ' + $ktrg);
        console.log('$jumlah: ' + $jumlah);

        if ($(`#divSelectJht-${indexSJVaria}`).length !== 0) {
            $jht = $(`#selectJht-${indexSJVaria}`).val();
            hargaJht = 1000;
        }
        if ($(`#divSelectUkuran-${indexSJVaria}`).length !== 0) {
            ukuran = $(`#selectUkuran-${indexSJVaria}`).val();
            if (ukuran !== '') {
                ukuran = JSON.parse(ukuran);
                console.log(ukuran);
                console.log(ukuran.tipeUkuran);
                console.log(ukuran.namaNotaUkuran);
                console.log(ukuran.hargaUkuran);
            }
        }
        if ($(`#divTADesc-${indexSJVaria}`).length !== 0) {
            $ktrg = $(`#taDesc-${indexSJVaria}`).val();
        }
        if ($(`#divInputJumlah-${indexSJVaria}`).length !== 0) {
            $jumlah = $(`#inputJumlah-${indexSJVaria}`).val();
        }

        if ($bahan === '') {
            $textWarning = '<span class="color-red">Bahan masih belum ditentukan!</span>';
            $('#warningSJVaria').html($textWarning).removeClass('d-none');
            return;
        }

        if ($varia == undefined) {
            console.log('warning untuk Select Variasi');
            $textWarning = '<span class="color-red">Variasi Sarung Jok masih belum ditentukan!</span>';
            $('#warningSJVaria').html($textWarning).removeClass('d-none');
            return;
        }

        if ($jumlah <= 0) {
            console.log('warning untuk jumlah');
            $textWarning = '<span class="color-red">Jumlah barang masih belum diinput dengan benar!</span>';
            $('#warningSJVaria').html($textWarning).removeClass('d-none');
            return;
        }

        if ($jht !== '') {
            $plusJahit = '+ jht ' + $jht;
        }

        $namaLengkap = $namaLengkap + $bahan + ' ' + $varia;
        if (ukuran !== '') {
            $namaLengkap = $namaLengkap + ' uk. ' + ukuran.tipeUkuran;
            hargaPcs = parseFloat($hargaBahan) + hargaJht + ukuran.hargaUkuran;
        } else {
            $namaLengkap = $namaLengkap + ' ' + $plusJahit;
            hargaPcs = parseFloat($hargaBahan) + hargaJht + ukuran.hargaUkuran;
        }

        hargaItem = hargaPcs * $jumlah;

        $namaLengkap = $namaLengkap.trim();
        var hargaPcs = parseFloat($hargaBahan) + hargaJht;
        hargaItem = hargaPcs * $jumlah;

        var itemObj = {
            tipe: $tipe,
            bahan: $bahan,
            varia: $varia,
            jahit: $jht,
            ktrg: $ktrg,
            jumlah: $jumlah,
            namaLengkap: $namaLengkap,
            hargaBahan: $hargaBahan,
            hargaJht: hargaJht,
            hargaPcs: hargaPcs,
            hargaItem: hargaItem,
            ukuran_tipe: ukuran.tipeUkuran,
            ukuran_nama_nota: ukuran.namaNotaUkuran,
            ukuran_harga: ukuran.hargaUkuran
        }
        console.log(itemObj);
        // var newSPK = localStorage.getItem('dataSPKToEdit');
        // newSPK = JSON.parse(newSPK);
        // console.log(newSPK);

        // newSPK.item[m] = itemObj;
        // console.log(newSPK);
        // localStorage.setItem('dataSPKToEdit', JSON.stringify(newSPK));
        // // location.href = '03-03-01-inserting-items.php';
        // window.history.back();
    }
</script>

<style>

</style>

<?php
include_once "01-footer.php";
?>