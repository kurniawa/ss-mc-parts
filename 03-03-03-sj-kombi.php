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

if (isset($_GET["id_spk"]) && isset($_GET["id_spk_contains_item"]) && isset($_GET["id_produk"])) {
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

<form action="03-03-03-addKombiFNewSPK.php" method="POST" id="containerSJKombi">

    <div class="ml-0_5em mr-0_5em mt-2em">
        <div>
            <h2>Tipe: Sarung Jok Kombinasi</h2>
        </div>

        <div id="divArraySJKombi">

        </div>

        <br><br>

        <div id="warningSJVaria" class="d-none"></div>

        <div id="divAvailableOptions" class="position-absolute bottom-5em w-calc-100-1em">
            Available options:
            <div id="availableOptions">

            </div>

        </div>
        <button type="submit" id="bottomDiv" class="position-absolute bottom-0_5em w-calc-100-1em h-4em bg-color-orange-2 grid-1-auto" onclick="insertItemToLocal();">

            <span class="justify-self-center font-weight-bold">TAMBAH ITEM KE SPK</span>

        </button>

    </div>
    <input type="hidden" name="id_spk" value="<?= $id_spk ?>">
    <input type="hidden" name="id_spk_contains_item" value="<?= $id_spk_contains_item ?>">
    <input type="hidden" name="id_produk" value="<?= $id_produk ?>">
    <input type="hidden" name="harga_jahit">
    <input type="hidden" name="harga_ukuran">
</form>

<div class="divLogError"></div>
<div class="divLogOK"></div>
<div class="divLogWarning"></div>

<script>
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

    function backToSPK() {
        window.history.go(-2);
    }

    var status = "<?= $status; ?>";
    var id_spk = 0;
    if (status == "OK") {
        id_spk = <?= $id_spk; ?>;
    }
</script>

<script src="js/variableForNewSPK.js"></script>

<script>
    function addSJKombi() {
        let elementsToAppend =
            `<div id="divSJKombi" class="b-1px-solid-grey pt-1em pb-1em pl-1em pr-1em">
                <div id='divKombi'></div>
                <div id='divJht'></div>
                <div id='divDesc'></div>
                <div id='divJumlah'></div>
            </div>`;

        $('#divArraySJKombi').append(elementsToAppend);
    }

    let indexElementSystem = 0;
    let elementSystem = [
        [`#divKombi`, `#inputKombi`],
        [
            [`#availableOptions`, `#boxJumlah`],
            [`#availableOptions`, `#boxJht`],
            [`#availableOptions`, `#boxDesc`]
        ],
        [
            [`#divJumlah`, `#divInputJumlah`],
            [`#divJht`, `#divSelectJht`],
            [`#divDesc`, `#divTADesc`]
        ]
    ];

    // console.log(elementSystem);
    let removeElementSystem = [`#selectPolosLGTato`, 'removeSelectTipeLG', 'removeSelectTipeTato', 'removeSelectTipeJahit', 'removeInputJumlah', 'removeBoxJumlah', 'removeBoxJhtKepala'];

    let htmlBoxJumlah =
        `<div id="boxJumlah" class="d-inline-block mr-0_5em pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red" onclick='addLvl2ElementFromBox("Jumlah");'>
        Jumlah
    </div>`;

    let htmlBoxJht =
        `<div id="boxJht" class="d-inline-block mr-0_5em pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red" onclick='addLvl2ElementFromBox("Jht");'>
        + Jahit
    </div>`;

    let htmlBoxDesc =
        `<div id="boxDesc" class="d-inline-block mr-0_5em pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red" onclick='addLvl2ElementFromBox("Desc");'>
        + Ktrgn
    </div>`;

    let htmlDivInputJumlah =
        `<div id="divInputJumlah" class="mt-1em">
            <input type="number" name="jumlah" id="inputJumlah" min="0" step="1" placeholder="Jumlah" class="pt-0_5em pb-0_5em">
        </div>`;

    let htmlDivSelectJht =
        `<div id='divSelectJht' class="grid-2-auto_10 mt-1em">
            <select name="jahit" id="selectJht" class="pt-0_5em pb-0_5em">
                <option value="" disabled selected>Pilih Jenis Jahit</option>
            </select>
            <span class="ui-icon ui-icon-closethick justify-self-center" onclick='closeAndAddBox("${elementSystem[2][1][1]}","${elementSystem[1][1][0]}","${elementSystem[1][1][1]}", 1, 1);'></span>
        </div>`;

    let htmlDivTADesc =
        `<div id="divTADesc" class="mt-1em">
            <div class='text-right'><span class='ui-icon ui-icon-closethick' onclick='closeAndAddBox("${elementSystem[2][2][1]}", "${elementSystem[1][2][0]}","${elementSystem[1][2][1]}", 1, 2);'></span></div>
            <textarea class="pt-1em pl-1em text-area-mode-1" name="taDesc" id="taDesc" placeholder="Keterangan"></textarea>
        </div>`;


    let elementHTML = [
        `<input id="inputKombi" name="kombi" class="input-1 mt-1em pb-1em" type="text" placeholder="Nama/Tipe Kombinasi" onkeyup="cekKombiAddBoxes(this.value);">
        <input id='inputHargaKombi' name="harga_kombi" type='hidden'>
        `,

        [htmlBoxJumlah, htmlBoxJht, htmlBoxDesc],

        [htmlDivInputJumlah, htmlDivSelectJht, htmlDivTADesc]

    ];

    // async function pilihFungsi(namaFungsi, divID, elementID, elementHTML) {
    //     window[namaFungsi](divID, elementID, elementHTML);
    //     console.log('pilih fungsi dijalankan: ' + namaFungsi + '\n' + divID + '\n' + elementHTML);
    // }

    async function createElement(divID, elementID, elementHTML) {
        console.log('running create Element');
        console.log(divID + ' ' + elementHTML);
        console.log('elementID: ' + elementID);

        if (divID === '#availableOptions') {
            $(divID).append(elementHTML);
            return;
        }
        $(divID).html(elementHTML);

        if (elementID === `#inputKombi`) {
            $("#inputKombi").autocomplete({
                source: arrayTipeKombi,
                select: function(event, ui) {
                    console.log(ui);
                    console.log(ui.item.value);
                    cekKombiAddBoxes(ui.item.value);
                    // sjVaria.push({
                    //     'nama_bahan': ui.item.value
                    // });
                    sjVaria['nama_bahan'] = ui.item.value;
                    console.log('sjVaria: ' + sjVaria);
                }
            });

        } else if (elementID === elementSystem[1][1]) {
            arrayVariasi.forEach(variasi => {
                $("#selectVaria").append('<option value="' + variasi + '">' + variasi + '</option>');
            });
        } else if (elementID === `#divSelectJht`) {
            for (var i = 0; i < arrayJht.length; i++) {
                $("#selectJht-" + indexSJVaria).append(`<option value='{"tipeJahit": "${arrayJht[i]}", "hargaJahit":" ${arrayHargaJahit[i]}"}'>${arrayJht[i]}</option>`);
            }
        }
    }

    addSJKombi();
    createElement(elementSystem[indexElementSystem][0], elementSystem[indexElementSystem][1], elementHTML[indexElementSystem]);

    // fungsi langsung dipanggil untuk langsung menambahkan element2 input SJ Varia pertama pada halaman web.

    function cekKombiAddBoxes(tipeKombi) {
        console.log('namaKombi1:' + tipeKombi);
        try {
            for (const kombi of arrayKombi) {
                if (tipeKombi === kombi.nama) {
                    console.log('namaKombi2:' + kombi.nama);
                    console.log('hargaKombi:' + kombi.harga);

                    indexElementSystem = 1;
                    removeElement(indexElementSystem);
                    for (let i = 0; i < elementSystem[indexElementSystem].length; i++) {
                        console.log('i: ' + i);
                        if ($(elementSystem[indexElementSystem][i][1]).length === 0) {
                            createElement(elementSystem[indexElementSystem][i][0], elementSystem[indexElementSystem][i][1], elementHTML[indexElementSystem][i]);
                        }
                    }
                    $(`#inputHargaKombi`).val(kombi.harga);
                    console.log('Harga Kombi:');
                    console.log($(`#inputHargaKombi`).val());
                    throw Error("Actually this error is to break the loop only. Because break; cannot used for forEach loop.");
                } else {
                    console.log("Nama Kombi not found!")
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

    function addLvl2ElementFromBox(value) {
        indexElementSystem = 2;
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
        $tipe = 'sj-kombi'
        $kombi = $(`#inputKombi`).val();
        $jht = '';
        $plusJahit = '';
        $desc = '';
        $namaLengkap = '';
        $jumlah = 0;

        $hargaKombi = $(`#inputHargaKombi`).val();
        let hargaJht = 0;
        let hargaItem = 0;

        console.log('$kombi: ' + $kombi);
        console.log('$jht: ' + $jht);
        console.log('$desc: ' + $desc);
        console.log('$jumlah: ' + $jumlah);

        if ($(`#divSelectJht`).length !== 0) {
            $jht = $(`#selectJht`).val();
            hargaJht = 1000;
        }
        if ($(`#divTADesc`).length !== 0) {
            $desc = $(`#taDesc`).val();
        }
        if ($(`#divInputJumlah`).length !== 0) {
            $jumlah = $(`#inputJumlah`).val();
        }

        if ($kombi === '') {
            $textWarning = '<span class="color-red">Kombinasi masih belum ditentukan!</span>';
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
        $namaLengkap = $kombi + ' ' + $plusJahit;
        $namaLengkap = $namaLengkap.trim();
        let hargaPcs = parseFloat($hargaKombi) + hargaJht;
        hargaItem = hargaPcs * $jumlah;

        let itemObj = {
            tipe: $tipe,
            kombi: $kombi,
            jahit: $jht,
            desc: $desc,
            jumlah: $jumlah,
            namaLengkap: $namaLengkap,
            hargaKombi: $hargaKombi,
            hargaJht: hargaJht,
            hargaPcs: hargaPcs,
            hargaItem: hargaItem
        }
        console.log(itemObj);
        let newSPK = localStorage.getItem('dataSPKToEdit');
        newSPK = JSON.parse(newSPK);
        console.log(newSPK);

        newSPK.item.push(itemObj);
        console.log(newSPK);
        localStorage.setItem('dataSPKToEdit', JSON.stringify(newSPK));
        location.href = '03-03-01-inserting-items.php';
    }

    // let m = <-?php echo $m ?>;
    // console.log(m);
    // $('#bottomDiv2').hide()
    // setTimeout(() => {

    //     if (m !== undefined) {
    //         editMode();
    //         $('#bottomDiv2').show();
    //         $('#bottomDiv').hide();
    //     }

    // }, 300);

    function editMode() {
        console.log('edit mode');
        let newSPK = localStorage.getItem('dataSPKToEdit');
        newSPK = JSON.parse(newSPK);

        if (newSPK.item[m].kombi !== '') {
            console.log(newSPK.item[m].kombi);
            $(`#inputKombi`).val(newSPK.item[m].kombi);
        }

        // if (newSPK.item[m].varia !== '') {
        //     console.log(elementSystem[1][1]);
        //     cekKombiAddBoxes(newSPK.item[m].kombi);
        //     $(`#selectVaria`).val(newSPK.item[m].varia);
        // }

        console.log(newSPK.item[m].jht);
        // if (newSPK.item[m].jht !== '' || newSPK.item[m].desc !== '' || newSPK.item[m].jumlah !== '') {
        //     if (newSPK.item[m].jht !== '') {
        //         addLvl2ElementFromBox('Jht');
        //         $(`#selectJht`).val(newSPK.item[m].jht);

        //     }
        //     if (newSPK.item[m].desc !== '') {
        //         addLvl2ElementFromBox('Desc');
        //         $(`#taDesc`).val(newSPK.item[m].desc);
        //     }
        //     if (newSPK.item[m].jumlah !== '') {
        //         addLvl2ElementFromBox('Jumlah');
        //         $(`#inputJumlah`).val(newSPK.item[m].jumlah);
        //     }
        // }

        if (newSPK.item[m].jht !== '') {
            addLvl2ElementFromBox('Jht');
            $(`#selectJht`).val(newSPK.item[m].jht);
        }
        if (newSPK.item[m].desc !== '') {
            addLvl2ElementFromBox('Desc');
            $(`#taDesc`).val(newSPK.item[m].desc);
        }

        if (newSPK.item[m].jumlah !== '') {
            addLvl2ElementFromBox('Jumlah');
            $(`#inputJumlah`).val(newSPK.item[m].jumlah);
        }

        cekKombiAddBoxes2();
    }

    function cekKombiAddBoxes2() {
        indexElementSystem = 1;
        for (let i = 0; i < elementSystem[indexElementSystem].length; i++) {
            console.log('i: ' + i);
            if ($(elementSystem[indexElementSystem][i][1]).length === 0) {
                createElement(elementSystem[indexElementSystem][i][0], elementSystem[indexElementSystem][i][1], elementHTML[indexElementSystem][i]);
            }
        }
    }

    function confirmEditItemSPK() {
        console.log('confirm edit item SPK');
        $tipe = 'sj-varia'
        $kombi = $(`#inputKombi`).val();
        $jht = '';
        $plusJahit = '';
        $desc = '';
        $namaLengkap = '';
        $jumlah = 0;

        $hargaKombi = $(`#inputHargaKombi`).val();
        let hargaJht = 0;
        let hargaItem = 0;

        console.log('$kombi: ' + $kombi);
        console.log('$jht: ' + $jht);
        console.log('$desc: ' + $desc);
        console.log('$jumlah: ' + $jumlah);

        if ($(`#divSelectJht`).length !== 0) {
            $jht = $(`#selectJht`).val();
            hargaJht = 1000;
        }
        if ($(`#divTADesc`).length !== 0) {
            $desc = $(`#taDesc`).val();
        }
        if ($(`#divInputJumlah`).length !== 0) {
            $jumlah = $(`#inputJumlah`).val();
        }

        if ($kombi === '') {
            $textWarning = '<span class="color-red">Kombinasi masih belum ditentukan!</span>';
            $('#warningSJVaria').html($textWarning).removeClass('d-none');
            return;
        }

        // if ($varia == undefined) {
        //     console.log('warning untuk Select Variasi');
        //     $textWarning = '<span class="color-red">Variasi Sarung Jok masih belum ditentukan!</span>';
        //     $('#warningSJVaria').html($textWarning).removeClass('d-none');
        //     return;
        // }

        if ($jumlah <= 0) {
            console.log('warning untuk jumlah');
            $textWarning = '<span class="color-red">Jumlah barang masih belum diinput dengan benar!</span>';
            $('#warningSJVaria').html($textWarning).removeClass('d-none');
            return;
        }

        if ($jht !== '') {
            $plusJahit = '+ jht ' + $jht;
        }
        $namaLengkap = $kombi + ' ' + $plusJahit;
        $namaLengkap = $namaLengkap.trim();
        let hargaPcs = parseFloat($hargaKombi) + hargaJht;
        hargaItem = hargaPcs * $jumlah;

        let itemObj = {
            tipe: $tipe,
            kombi: $kombi,
            jahit: $jht,
            desc: $desc,
            jumlah: $jumlah,
            namaLengkap: $namaLengkap,
            hargaKombi: $hargaKombi,
            hargaJht: hargaJht,
            hargaPcs: hargaPcs,
            hargaItem: hargaItem
        }
        console.log(itemObj);
        let newSPK = localStorage.getItem('dataSPKToEdit');
        newSPK = JSON.parse(newSPK);
        console.log(newSPK);

        newSPK.item[m] = itemObj;
        console.log(newSPK);
        localStorage.setItem('dataSPKToEdit', JSON.stringify(newSPK));
        location.href = '03-03-01-inserting-items.php';
    }
</script>

<style>

</style>

<?php
include_once "01-footer.php";
?>