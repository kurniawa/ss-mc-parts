<?php

if (isset($_POST['SPKID'])) {
    // var_dump($_POST);
    // echo ('POST isset');
    $mode = 'EDIT SPK';
    $SPKID = $_POST["SPKID"];
    $custName = $_POST["custName"];
    $custID = $_POST["custID"];
    $daerah = $_POST["daerah"];
    $tglPembuatan = date("d-m-Y", strtotime($_POST["tglPembuatan"]));
    $tglPembuatan2 = $_POST["tglPembuatan"];
    // echo $_POST["tglPembuatan"];
    $tglSelesai = $_POST["tglSelesai"];
    $ketSPK = $_POST["ketSPK"];
    $jmlTotal = $_POST["jmlTotal"];
    $SPKItem = [];
    $jmlItem = array();
    $descEachItem = array();

    $hargaPcs = array();
    $bahan = array();
    $varia = array();
    $ukuran = array();
    $logo = array();
    $tato = array();
    $jahit = array();
    $japstyle = array();
    $tipe = array();
    $hargaItem = array();

    // var_dump($_POST["hargaPcs"]);
    if (isset($_POST["SPKItem"])) {

        foreach ($_POST["SPKItem"] as $key) {
            array_push($SPKItem, $key);
        }
        foreach ($_POST["jmlItem"] as $key) {
            array_push($jmlItem, $key);
        }
        foreach ($_POST["descEachItem"] as $key) {
            array_push($descEachItem, $key);
        }
        // var_dump($SPKItem);
        foreach ($_POST["hargaPcs"] as $key) {
            array_push($hargaPcs, $key);
        }
        foreach ($_POST["bahan"] as $key) {
            array_push($bahan, $key);
        }
        foreach ($_POST["varia"] as $key) {
            array_push($varia, $key);
        }
        foreach ($_POST["ukuran"] as $key) {
            array_push($ukuran, $key);
        }
        foreach ($_POST["logo"] as $key) {
            array_push($logo, $key);
        }
        foreach ($_POST["tato"] as $key) {
            array_push($tato, $key);
        }
        foreach ($_POST["jahit"] as $key) {
            array_push($jahit, $key);
        }
        foreach ($_POST["japstyle"] as $key) {
            array_push($japstyle, $key);
        }
        foreach ($_POST["tipe"] as $key) {
            array_push($tipe, $key);
        }
        foreach ($_POST["hargaItem"] as $key) {
            array_push($hargaItem, $key);
        }
    }
    // var_dump($bahan);
} else {
    $mode = 'NEW SPK';
    $SPKID = 'none';
    $custName = 'none';
    $custID = 'none';
    $daerah = 'none';
    $tglPembuatan = 'none';
    $tglPembuatan2 = 'none';
    $tglSelesai = 'none';
    $ketSPK = 'none';
    $SPKItem = 'none';
    $jmlItem = 'none';
    $descEachItem = 'none';

    $hargaPcs = 'none';
    $bahan = 'none';
    $varia = 'none';
    $ukuran = 'none';
    $logo = 'none';
    $tato = 'none';
    $jahit = 'none';
    $japstyle = 'none';
    $tipe = 'none';
    $hargaItem = 'none';
}

include_once "01-header.php";
?>

<div class="header"></div>

<div class="threeDotMenu">
    <div class="threeDot">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
    <div class="divThreeDotMenuContent">
        <div id="editKopSPK" class="threeDotMenuItem">
            <img src="img/icons/edit.svg" alt=""><span>Edit Data SPK</span>
        </div>
        <div id="downloadExcel" class="threeDotMenuItem">
            <img src="img/icons/download.svg" alt=""><span>Download Excel</span>
        </div>
    </div>
</div>
<style>
    .threeDotMenu {
        position: absolute;
        top: 1em;
        right: 1.5em;
    }

    .threeDot {
        display: grid;
        grid-template-columns: auto;
        grid-row-gap: 0.3em;
        justify-items: end;
    }

    .dot {
        border-radius: 100%;
        width: 0.5em;
        height: 0.5em;
        background-color: white;
    }

    .divThreeDotMenuContent {
        background-color: white;
        border: 1px solid #C4C4C4;
    }

    .threeDotMenuItem {
        padding: 1em;
        display: grid;
        grid-template-columns: 15% 85%;
        grid-column-gap: 0.5em;
        align-items: center;
    }

    .threeDotMenuItem:hover {
        background-color: #C4C4C4;
    }

    .threeDotMenuItem img {
        width: 1em;
    }
</style>

<div id="containerBeginSPK" class="m-0_5em">

    <div class="b-1px-solid-grey">
        <div class="text-center">
            <h2>Surat Perintah Kerja</h2>
        </div>
        <div class="grid-3-25_10_auto m-0_5em grid-row-gap-1em">
            <div>No.</div>
            <div>:</div>
            <div id="divSPKNumber" class="font-weight-bold">8888</div>
            <div>Tanggal</div>
            <div>:</div>
            <div id="divTglPembuatan" class="font-weight-bold">15-10-2020</div>
            <div>Untuk</div>
            <div>:</div>
            <div id="divSPKCustomer" class="font-weight-bold">Akong - Pluit</div>
            <input id="inputIDCustomer" type="hidden" name="inputIDCustomer">
        </div>
        <div class="grid-1-auto justify-items-right m-0_5em">
            <div>
                <img class="w-1em" src="img/icons/edit-grey.svg" alt="">
            </div>
        </div>
    </div>

    <div id="divTitleDesc" class="grid-1-auto justify-items-center mt-0_5em">Kirim Ke Biran Bangka</div>

    <div id="divItemList" class="bt-1px-solid-grey font-weight-bold"></div>
    <input id="inputHargaTotalSPK" type="hidden">

    <div id="divJmlTotal" class="text-right">
        <div id="divJmlTotal2" class="font-weight-bold font-size-2em color-green"></div>
        <div class="font-weight-bold color-red font-size-1_5em">Total</div>
    </div>

    <div id="divAddItems" class="h-9em position-relative mt-1em">
        <a href="03-03-02-sj-varia3.php" class="productType position-absolute top-0 left-50 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Varia</span>
        </a>
        <a href="03-03-03-sj-kombi.php" class="productType position-absolute top-1em left-35 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Kombi</span>
        </a>
        <a href="03-03-04-sj-std.php" class="productType position-absolute top-1em left-65 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Std</span>
        </a>
        <a href="03-03-05-tankpad.php" class="productType position-absolute top-5em left-30 transform-translate--50_0 circle-L bg-color-soft-red grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">Tank<br>Pad</span>
        </a>
        <a href="03-03-06-busa-stang.php" class="productType position-absolute top-5em left-70 transform-translate--50_0 circle-L bg-color-grey grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">Busa<br>Stang</span>
        </a>
        <div class="position-absolute top-5em left-50 transform-translate--50_0 grid-1-auto justify-items-center" onclick="toggleProductType();">
            <div class="circle-medium bg-color-orange-2 grid-1-auto justify-items-center">
                <span class="color-white font-weight-bold font-size-1_5em">+</span>
            </div>
        </div>

    </div>

    <div id="divBtnShowEditOptItemSPK" class="text-center">
        <div class="d-inline-block btn-1 bg-color-purple-blue font-weight-bold color-white" onclick="showEditOptItemSPK();">Edit Item</div>
    </div>
    <div id="divBtnHideEditOptItemSPK" class="text-center">
        <div class="d-inline-block btn-1 font-weight-bold color-white" style="background-color: gray;" onclick="hideEditOptItemSPK();">Finish Editing</div>
    </div>

    <div id="btnProsesSPK" class="position-fixed bottom-0_5em w-calc-100-1em h-4em bg-color-orange-2 grid-1-auto" onclick="proceedSPK();">
        <span class="justify-self-center font-weight-900">PROSES SPK</span>
    </div>

    <div id="btnEditSPKItem" class="position-fixed bottom-0_5em w-calc-100-1em h-4em bg-color-orange-1 grid-1-auto" onclick="updateSPK();">
        <span class="justify-self-center font-weight-900">Konfirmasi Perubahan</span>
    </div>

    <div id="divBtnSPKSelesai" class="position-fixed bottom-0_5em w-calc-100-1em">
        <div class="h-4em bg-color-orange-2 grid-1-auto" onclick="finishSPK();">
            <span class="justify-self-center font-weight-900">SPK SELESAI</span>
        </div>
    </div>

    <div id="divMarginBottom" style="height: 20vh;">

    </div>

    <div id="closingGreyArea" class="closingGreyArea" style="display: none;"></div>
    <div class="lightBox" style="display:none;">
        <div class="grid-2-10_auto">
            <div><img src="img/icons/speech-bubble.svg" alt="" style="width: 2em;"></div>
            <div class="font-weight-bold">Tanggal Selesai / Pengiriman</div>
        </div>
        <br><br>
        <div class="text-center">
            <input id="inputTglSelesaiSPK" type="date" class="input-select-option-1 w-12em" name="date" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <br><br>
        <div class="text-center">
            <div id="btnSPKSelesai" class="btn-tipis bg-color-orange-1 d-inline-block">Lanjutkan >></div>
        </div>
    </div>

    <style>
        .closingGreyArea {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: black;
            opacity: 0.2;
        }

        .lightBox {
            position: absolute;
            top: 25vh;
            left: 0.5em;
            right: 0.5em;
            height: 13em;
            background-color: white;
            padding: 1em;
        }
    </style>

</div>

<script>
    // keadaan awal apa aja yang di hide
    $('.divThreeDotMenuContent').hide();
    $('.threeDotMenu').css('display', 'none'); // -> untuk new SPK
    $('.productType').hide();
    $('#btnProsesSPK').hide();
    $('#divJmlTotal').hide();
    $('#divBtnSPKSelesai').hide();
    $('#btnEditSPKItem').hide();

    let mode = '<?= $mode; ?>';
    let SPKID = 'none';
    let custName = 'none';
    let custID = 'none';
    let daerah = 'none';
    let tglPembuatan = 'none';
    let tglSelesai = 'none';
    let ketSPK = 'none';
    let SPKItem = 'none';
    let jmlItem = 'none';
    let descEachItem = 'none';

    let hargaPcs = 'none';
    let bahan = 'none';
    let varia = 'none';
    let ukuran = 'none';
    let logo = 'none';
    let tato = 'none';
    let jahit = 'none';
    let japstyle = 'none';
    let tipe = 'none';
    let hargaItem = 'none';

    let newSPK;
    let SPKBefore;
    let dataSPK;

    if (mode == 'EDIT SPK') {
        SPKBefore = localStorage.getItem('dataSPKBefore');
        if (SPKBefore != null) {
            SPKBefore = JSON.parse(SPKBefore);
        }
        runningModeEdit();
    } else {
        // IF MODE === 'NEW SPK'
        let statusCekMode = cekMode();
        console.log(statusCekMode);
        if (statusCekMode == false) {
            newSPK = localStorage.getItem('dataSPKToEdit');
            getSPKItems();
        }
    }

    function cekMode() {
        console.log('menjalankan cek mode');
        let cekMode = localStorage.getItem('dataSPKToEdit');
        cekMode = JSON.parse(cekMode);
        SPKBefore = localStorage.getItem('dataSPKBefore');
        SPKBefore = JSON.parse(SPKBefore);
        newSPK = localStorage.getItem('newSPK');

        if (cekMode.hasOwnProperty('mode')) {
            if (cekMode.mode === 'edit') {
                runningModeEdit();
                return true;
            } else {
                return false;
            }
        } else if (newSPK !== null) {
            return false;
        }
    }

    function runningModeEdit() {
        console.log('masuk ke mode edit');
        // Apa yang dimunculkan dalam mode edit ini dan apa yang dihide
        // deklarasi awal variabel-variable yang di send melalui post
        $('#btnProsesSPK').hide();
        $('#divBtnSPKSelesai').show();
        $('.threeDotMenu').css('display', 'grid');
        SPKID = <?= json_encode($SPKID) ?>;
        custName = <?= json_encode($custName) ?>;
        custID = <?= json_encode($custID) ?>;
        daerah = <?= json_encode($daerah) ?>;
        tglPembuatan = <?= json_encode($tglPembuatan2) ?>;
        tglSelesai = <?= json_encode($tglSelesai) ?>;
        ketSPK = <?= json_encode($ketSPK) ?>;
        SPKItem = <?= json_encode($SPKItem); ?>;
        jmlItem = <?= json_encode($jmlItem); ?>;
        descEachItem = <?= json_encode($descEachItem); ?>;

        hargaPcs = <?= json_encode($hargaPcs); ?>;
        bahan = <?= json_encode($bahan); ?>;
        varia = <?= json_encode($varia); ?>;
        ukuran = <?= json_encode($ukuran); ?>;
        logo = <?= json_encode($logo); ?>;
        tato = <?= json_encode($tato); ?>;
        jahit = <?= json_encode($jahit); ?>;
        japstyle = <?= json_encode($japstyle); ?>;
        tipe = <?= json_encode($tipe); ?>;
        hargaItem = <?= json_encode($hargaItem); ?>;

        console.log(SPKItem);
        console.log(jmlItem);
        console.log(descEachItem);

        $('#divSPKNumber').html(SPKID);
        $('#divTglPembuatan').html(formatDate(tglPembuatan));
        $('#divSPKCustomer').html(`${custName} - ${daerah}`);
        $('#divTitleDesc').html(ketSPK);

        let dataSPK = localStorage.getItem('dataSPKToEdit');
        console.log(dataSPK);
        console.log('dataSPK is defined!!');

        if (dataSPK != null) {
            dataSPK = JSON.parse(dataSPK);
            custName = dataSPK.custName;
            custID = dataSPK.custID;
            tglPembuatan = dataSPK.tglPembuatan;
            daerah = dataSPK.daerah;
            ketSPK = dataSPK.ketSPK;

            $('#divTglPembuatan').html(formatDate(tglPembuatan));
            $('#divSPKCustomer').html(custName + ' - ' + daerah);
            $('#divTitleDesc').html(ketSPK);

            let beda = 'tidak';
            let namaKeyItem = ['bahan', 'desc', 'hargaItem', 'hargaPcs', 'jahit', 'japstyle', 'jumlah', 'logo', 'namaLengkap', 'tato', 'tipe', 'ukuran', 'varia'];
            if (dataSPK.item.length === SPKBefore.item.length) {

                for (let i = 0; i < dataSPK.item.length; i++) {
                    for (let k = 0; k < namaKeyItem.length; k++) {
                        console.log(dataSPK.item[i][namaKeyItem[k]]);
                        if (dataSPK.item[i][namaKeyItem[k]] !== SPKBefore.item[i][namaKeyItem[k]]) {
                            beda = 'ya';
                        }
                    }
                }

                if (beda === 'ya') {
                    console.log('masuk ke mode perubahan item SPK');
                    $('#btnEditSPKItem').show();
                    $('#divBtnSPKSelesai').hide();
                } else {
                    dataSPK.mode = 'edit';
                    localStorage.setItem('dataSPKToEdit', JSON.stringify(dataSPK));
                    localStorage.setItem('dataSPKBefore', JSON.stringify(dataSPK));
                    console.log('key mode = edit, added!');
                    if (dataSPK.tglSelesai === null || dataSPK.tglSelesai === '') {
                        $('#divBtnSPKSelesai').show();
                    } else {
                        $('#divBtnSPKSelesai').hide();
                    }
                }

            } else {
                console.log('masuk ke mode perubahan item SPK');
                // for (let indexAwal = SPKBefore.item.length; indexAwal < dataSPK.item.length; indexAwal++) {
                //     SPKBefore.item.push(dataSPK.item[indexAwal]);
                // }
                $('#btnEditSPKItem').show();
                $('#divBtnSPKSelesai').hide();
            }


        } else {
            console.log('Set localstorage pertama kali buka SPK: dataSPKToEdit dan dataSPKBefore');
            let dataSPK = {
                id: SPKID,
                custName: custName,
                custID: custID,
                daerah: daerah,
                tglPembuatan: tglPembuatan,
                tglSelesai: tglSelesai,
                ketSPK: ketSPK,
                mode: 'edit'
            };

            let SPKItems = new Array();
            for (let i = 0; i < SPKItem.length; i++) {
                SPKItems.push({
                    tipe: tipe[i],
                    bahan: bahan[i],
                    varia: varia[i],
                    ukuran: ukuran[i],
                    logo: logo[i],
                    tato: tato[i],
                    jahit: jahit[i],
                    namaLengkap: SPKItem[i],
                    japstyle: japstyle[i],
                    hargaPcs: hargaPcs[i],
                    desc: descEachItem[i],
                    jumlah: jmlItem[i],
                    hargaItem: hargaItem[i]
                });
            }
            dataSPK.item = SPKItems;
            console.log(dataSPK);
            localStorage.setItem('dataSPKToEdit', JSON.stringify(dataSPK));
            localStorage.setItem('dataSPKBefore', JSON.stringify(dataSPK));
            console.log(localStorage.getItem('dataSPKToEdit'));

            if (dataSPK.tglSelesai === null || dataSPK.tglSelesai === '') {
                $('#divBtnSPKSelesai').show();
            } else {
                $('#divBtnSPKSelesai').hide();
            }

        }

        let htmlSPKItem = '';
        if (dataSPK) {
            for (let i = 0; i < dataSPK.item.length; i++) {
                htmlSPKItem = htmlSPKItem +
                    `<div class='divItem grid-3-auto_auto_10 pt-0_5em pb-0_5em bb-1px-solid-grey'>
                        <div class='divItemName grid-2-15_auto'>
                            <div id='btnRemoveItem-${i}' class='btnRemoveItem grid-1-auto justify-items-center circle-medium bg-color-soft-red' onclick='removeSPKItem(${i});'><img style='width: 1.3em;' src='img/icons/minus-white.svg'></div>
                            ${dataSPK.item[i].namaLengkap}
                        </div>
                    <div class='grid-1-auto'>
                    <div class='color-green justify-self-right font-size-1_2em'>
                        ${dataSPK.item[i].jumlah}
                    </div>
                    <div class='color-grey justify-self-right'>Jumlah</div>
                    </div>
                    <div id='btnEditItem-${i}' class='btnEditItem grid-1-auto justify-items-center circle-medium bg-color-purple-blue' onclick='editSPKItem(${i});'><img style='width: 1.3em;' src='img/icons/pencil2-white.svg'></div>
                    <div class='pl-0_5em color-blue-purple'>${dataSPK.item[i].desc}</div>
                    </div>`;
            }

            $('#divSPKNumber').html(dataSPK.id);
            $('#divTitleDesc').html(dataSPK.desc);

        } else {
            for (let i = 0; i < SPKItem.length; i++) {
                htmlSPKItem = htmlSPKItem +
                    `<div class='divItem grid-3-auto_auto_10 pt-0_5em pb-0_5em bb-1px-solid-grey'>
                        <div class='divItemName grid-2-15_auto'>
                            <div id='btnRemoveItem-${i}' class='btnRemoveItem grid-1-auto justify-items-center circle-medium bg-color-soft-red' onclick='removeSPKItem(${i});'><img style='width: 1.3em;' src='img/icons/minus-white.svg'></div>
                            ${SPKItem[i]}
                        </div>
                    <div class='grid-1-auto'>
                    <div class='color-green justify-self-right font-size-1_2em'>
                        ${jmlItem[i]}
                    </div>
                    <div class='color-grey justify-self-right'>Jumlah</div>
                    </div>
                    <div id='btnEditItem-${i}' class='btnEditItem grid-1-auto justify-items-center circle-medium bg-color-purple-blue' onclick='editSPKItem(${i});'><img style='width: 1.3em;' src='img/icons/pencil2-white.svg'></div>
                    <div class='pl-0_5em color-blue-purple'>${descEachItem[i]}</div>
                    </div>`;
            }
        }
        $('#divItemList').html(htmlSPKItem);
    }



    document.getElementById('editKopSPK').addEventListener('click', function() {
        console.log('clicked');
        window.location.href = '03-05-edit-data-spk.php';
    });

    function finishSPK() {
        $('.closingGreyArea').show();
        $('.lightBox').show();
    }

    document.querySelector('.closingGreyArea').addEventListener('click', (event) => {
        $('.closingGreyArea').hide();
        $('.lightBox').hide();
    });

    document.getElementById('btnSPKSelesai').addEventListener('click', (event) => {
        let tglSelesai = $('#inputTglSelesaiSPK').val();
        let noNota = `N${custID}-${SPKID}`;
        let noSrjalan = `SJ${custID}-${SPKID}`;
        console.log(tglSelesai);
        $.ajax({
            type: 'POST',
            url: '01-crud.php',
            async: false,
            cache: false,
            data: {
                type: 'UPDATE',
                table: 'spk',
                column: ['tgl_selesai', 'no_nota', 'tgl_nota', 'no_surat_jalan', 'tgl_surat_jalan'],
                value: [tglSelesai, noNota, tglSelesai, noSrjalan, tglSelesai],
                dateIndex: [0, 2, 4],
                key: 'id',
                keyValue: SPKID
            },
            success: function(res) {
                res = JSON.parse(res);
                console.log(res);
                console.log(res[0]);
                if (res[0] === 'UPDATE SUCCEED') {
                    console.log('goToMainMenu');
                    window.history.go(1 - (history.length));
                }

            }
        });
    });

    document.getElementById('downloadExcel').addEventListener('click', (event) => {
        console.log(event);
        let itemToPrint = new Array();

        for (let i = 0; i < SPKItem.length; i++) {
            itemToPrint.push({
                namaLengkap: SPKItem[i],
                desc: descEachItem[i],
                jumlah: jmlItem[i]
            });
        }

        let spkToPrint = {
            custID: custID,
            custName: custName,
            daerah: daerah,
            tglPembuatan: tglPembuatan,
            ketSPK: ketSPK,
            id: SPKID,
            item: itemToPrint
        }

        localStorage.setItem('dataSPKToPrint', JSON.stringify(spkToPrint));

        location.href = '03-06-print-out-spk.php';
    });

    document.querySelector('.threeDot').addEventListener('click', function() {
        let element = [{
            id: '.divThreeDotMenuContent',
            time: 300
        }];
        elementToToggle(element);
    });

    function getSPKItems() {
        console.log('menjalankan getSPKItems()');
        newSPK = localStorage.getItem('dataSPKToEdit');
        newSPK = JSON.parse(newSPK);
        $('#divSPKNumber').html(newSPK.id);
        $('#divTglPembuatan').html(newSPK.tglPembuatan);
        $('#divSPKCustomer').html(newSPK.custName + '-' + newSPK.daerah);
        $('#divTitleDesc').html(newSPK.ketSPK);

        console.log(newSPK.item);
        if (newSPK.item === undefined || newSPK.item.length == 0) {
            console.log('return');
            // $('#divBtnEditItem').hide();
            $('#divBtnShowEditOptItemSPK div').hide();
            $('#divBtnShowEditOptItemSPK').hide();
            return;
        }
        console.log(newSPK);
        let htmlItemList = '';
        let totalJumlahItem = 0;
        let totalHarga = 0;
        let i = 0;
        for (const item of newSPK.item) {
            var textItemJht = item.jahit;
            if (textItemJht != '') {
                textItemJht = '+ jahit ' + textItemJht;
            }
            htmlItemList = htmlItemList +
                `<div class='divItem grid-3-auto_auto_10 pt-0_5em pb-0_5em bb-1px-solid-grey'>
                <div class='divItemName grid-2-15_auto'>
                    <div id='btnRemoveItem-${i}' class='btnRemoveItem grid-1-auto justify-items-center circle-medium bg-color-soft-red' onclick='removeSPKItem(${i});'><img style='width: 1.3em;' src='img/icons/minus-white.svg'></div>
                    ${item.namaLengkap}
                </div>
                <div class='grid-1-auto'>
                <div class='color-green justify-self-right font-size-1_2em'>
                ${item.jumlah}
                </div>
                <div class='color-grey justify-self-right'>Jumlah</div>
                </div>
                <div id='btnEditItem-${i}' class='btnEditItem grid-1-auto justify-items-center circle-medium bg-color-purple-blue' onclick='editSPKItem(${i});'><img style='width: 1.3em;' src='img/icons/pencil2-white.svg'></div>
                <div class='pl-0_5em color-blue-purple'>${item.desc}</div>
                </div>`;

            // kita jumlah harga semua item untuk satu SPK
            totalHarga = totalHarga + item.hargaItem;
            i++;
        }
        $('#inputHargaTotalSPK').val(totalHarga);
        $('#divItemList').html(htmlItemList);
        $('#btnProsesSPK').show();
    }

    async function insertNewSPK() {
        console.log('SPKNo: ' + newSPK.id);
        let result = [];
        let totalHarga = $('#inputHargaTotalSPK').val();

        // cek dulu apakah ini edit SPK yang udah ada, atau mau insert SPK baru
        $.ajax({
            type: 'POST',
            url: '01-crud.php',
            async: false,
            cache: false,
            data: {
                type: 'cek',
                table: 'spk',
                column: ['id'],
                value: [dataSPK.id]
            },
            success: function(res) {
                res = JSON.parse(res);
                console.log(res);
                if (res[0] == 'udah ada') {

                    $.ajax({
                        type: 'POST',
                        url: '01-crud.php',
                        async: false,
                        cache: false,
                        data: {
                            type: 'UPDATE',
                            table: 'spk',
                            column: ['harga'],
                            value: [totalHarga],
                            key: 'id',
                            keyValue: dataSPK.id
                        },
                        success: function(res) {
                            console.log(res);
                        }
                    });
                    result = ['INSERT OK', 'SPK UPDATED', dataSPK.id];
                } else {
                    $.ajax({
                        type: "POST",
                        url: "01-crud.php",
                        async: false,
                        data: {
                            type: 'insert',
                            table: 'spk',
                            column: ['id', 'tgl_pembuatan', 'ket_judul', 'id_pelanggan', 'harga'],
                            value: [newSPK.id, newSPK.tglPembuatan, newSPK.ketSPK, newSPK.custID, totalHarga],
                            dateIndex: 1,
                            idToReturn: newSPK.id
                        },
                        success: function(res) {
                            res = JSON.parse(res);
                            console.log(res);
                            result = res;
                        }
                    });
                }
            }
        });

        console.log('result insertNewSPK(): ' + result);
        return result;
    }

    function toggleProductType() {
        $(".productType").toggle(500);
    }

    // window.addEventListener('popstate', (event) => {
    //     // console.log(event.state.page);
    //     // console.log(event)
    //     $('#SPKBaru').hide();
    //     $("#containerBeginSPK").hide();
    //     $('#containerSJVaria').hide();
    //     if (event.state == null) {
    //         history.go(-1);
    //     } else if (event.state.page == 'SJVaria') {
    //         $("#containerSJVaria").show();
    //     } else if (event.state.page == 'newSPK') {
    //         $('#SPKBaru').show();
    //     } else if (event.state.page == 'SPKBegin') {
    //         $('#containerBeginSPK').show();
    //     }
    // });

    async function proceedSPK() {
        // cek apakah produk sudah ada atau blm
        let result = new Array();
        let status;
        let resInsertProduct = await insertNewProduct();
        console.log('resInsertProduct:');
        console.log(resInsertProduct);

        dataSPK = localStorage.getItem('dataSPKToEdit');
        dataSPK = JSON.parse(dataSPK);

        if (resInsertProduct[0] === 'OK') {
            // masukkan data SPK
            console.log('proceedSPK()');
            let resNewSPK = await insertNewSPK();
            console.log('resNewSPK: ' + resNewSPK);
            if (resNewSPK[0] === 'INSERT OK') {
                for (let i = 0; i < resInsertProduct[1].length; i++) {
                    let lastID = getLastID('spk_contains_produk');
                    lastID = JSON.parse(lastID);
                    console.log('lastID from spk_contains_produk: ' + lastID);
                    let setID = lastID[1];
                    $.ajax({
                        type: 'POST',
                        url: '01-crud.php',
                        async: false,
                        data: {
                            type: 'insert',
                            table: 'spk_contains_produk',
                            column: ['id', 'id_spk', 'id_produk', 'ktrg', 'jumlah', 'harga_item'],
                            value: [setID, resNewSPK[2], resInsertProduct[1][i], resInsertProduct[2][i][0], resInsertProduct[2][i][1], resInsertProduct[2][i][2]]
                        },
                        success: function(res) {
                            console.log(res);
                            res = JSON.parse(res);
                            if (res[0] === 'INSERT OK') {
                                result.push('OK');
                            } else {
                                result.push('NOT OK');
                            }
                        }
                    });
                }
            } else {
                console.log('Ada kesalahan pada saat insert!');
            }
        }
        try {
            result.forEach(res => {
                if (res != 'OK') {
                    throw 'Ada Eror INSERT spk_contains_produk';
                }
                status = 'OK';
            });
        } catch (error) {
            console.log(error);
            status = 'NOT OK';
        }

        if (status == 'OK') {
            localStorage.setItem('dataSPKToPrint', JSON.stringify(dataSPK));
            localStorage.removeItem('dataSPKToEdit');
            localStorage.removeItem('dataSPKBefore');

            setTimeout(() => {
                location.href = '03-06-print-out-spk.php';
            }, 300);
        }
    }

    async function insertNewProduct() {
        let result = [];
        let status = '';
        let listOfID = [];
        let parameterToPass = [];
        console.log('newSPK:');
        console.log(newSPK);
        for (const item of newSPK.item) {
            let lastID = JSON.parse(getLastID('produk'));
            let setID = lastID[1];
            console.log(lastID);
            console.log(setID);
            console.log('item:');
            console.log(item);
            let column = new Array();
            let value = new Array();
            if (item.tipe === 'sj-varia') {
                column = ['tipe', 'bahan', 'varia', 'ukuran', 'jahit'];
                value = [item.tipe, item.bahan, item.varia, item.ukuran, item.jahit];
            } else if (item.tipe === 'sj-kombi' || item.tipe === 'sj-std') {
                column = ['tipe', 'jahit', 'nama_lengkap'];
                value = [item.tipe, item.jahit, item.namaLengkap];
            } else {
                column = ['tipe', 'nama_lengkap'];
                value = [item.tipe, item.namaLengkap];
            }

            console.log('column: ');
            console.log(column);
            console.log('value: ');
            console.log(value);

            $.ajax({
                type: 'POST',
                url: '01-crud.php',
                async: false,
                cache: false,
                data: {
                    type: 'cek',
                    table: 'produk',
                    column: column,
                    value: value,
                    parameter: [item.desc, item.jumlah, item.hargaItem]
                },
                success: function(res) {
                    console.log(res);
                    res = JSON.parse(res);
                    console.log(res);
                    if (res[0] === 'blm ada') {
                        if (item.tipe === 'sj-varia') {
                            column = ['id', 'tipe', 'bahan', 'varia', 'ukuran', 'jahit', 'nama_lengkap', 'harga_price_list'];
                            value = [setID, item.tipe, item.bahan, item.varia, item.ukuran, item.jahit, item.namaLengkap, item.hargaPcs];
                        } else if (item.tipe === 'sj-kombi' || item.tipe === 'sj-std') {
                            column = ['id', 'tipe', 'jahit', 'nama_lengkap', 'harga_price_list'];
                            value = [setID, item.tipe, item.jahit, item.namaLengkap, item.hargaPcs];
                        } else {
                            column = ['id', 'tipe', 'nama_lengkap', 'harga_price_list'];
                            value = [setID, item.tipe, item.namaLengkap, item.hargaPcs];
                        }
                        console.log('column:');
                        console.log(column);
                        console.log('value:');
                        console.log(value);
                        $.ajax({
                            type: 'POST',
                            url: '01-crud.php',
                            async: false,
                            cache: false,
                            data: {
                                type: 'insert',
                                table: 'produk',
                                column: column,
                                value: value,
                                parameter: [item.desc, item.jumlah, item.hargaItem]
                            },
                            success: function(res) {
                                console.log(res);
                                res = JSON.parse(res);
                                if (res[0] === 'INSERT OK') {
                                    result.push('OK');
                                    console.log('result: ' + result);
                                    listOfID.push(setID);
                                    console.log('lisfOfID: ' + listOfID);
                                    parameterToPass.push(res[3]);
                                    console.log('parameterToPass: ' + parameterToPass);
                                } else {
                                    result.push('NOT OK');
                                }
                            }
                        });
                    } else {
                        // res = JSON.parse(res);
                        // console.log(res);
                        listOfID.push(parseInt(res[1]));
                        parameterToPass.push(res[2]);
                        result.push('OK');
                    }
                }
            });
        }

        try {
            result.forEach(res => {
                if (res != 'OK') {
                    throw 'Ada Eror INSERT product atau cek product';
                }
                status = 'OK';
            });
        } catch (error) {
            console.log(error);
            status = 'NOT OK';
        }
        console.log(listOfID);
        return [status, listOfID, parameterToPass];
    }

    function showEditOptItemSPK() {
        $('.divItem').removeClass('grid-2-auto').addClass('grid-3-auto_auto_10');
        $('.divItemName').addClass('grid-2-15_auto');
        $('.btnRemoveItem').show();
        $('.btnEditItem').show();
        $('#divBtnShowEditOptItemSPK').hide();
        $('#divBtnHideEditOptItemSPK').show();
    }

    function hideEditOptItemSPK() {
        $('.divItem').removeClass('grid-3-auto_auto_10').addClass('grid-2-auto');
        $('.divItemName').removeClass('grid-2-15_auto');
        $('.btnRemoveItem').hide();
        $('.btnEditItem').hide();
        $('#divBtnShowEditOptItemSPK').show();
        $('#divBtnHideEditOptItemSPK').hide();
    }

    hideEditOptItemSPK();

    function removeSPKItem(i) {
        let dataSPK = localStorage.getItem('dataSPKToEdit');
        dataSPK = JSON.parse(dataSPK);
        console.log(i);
        dataSPK.item.splice(i, 1);
        console.log(dataSPK.item);
        localStorage.setItem('dataSPKToEdit', JSON.stringify(dataSPK));
        location.reload();
    }

    function editSPKItem(i) {
        console.log(i);
        if (newSPK.item[i].tipe === 'sj-varia') {
            console.log(newSPK.item[i].tipe);
            location.href = '03-03-02-sj-varia3.php?i=' + i;
        } else if (newSPK.item[i].tipe === 'sj-kombi') {
            console.log(newSPK.item[i].tipe);
            location.href = '03-03-03-sj-kombi.php?i=' + i;
        } else if (newSPK.item[i].tipe === 'sj-std') {
            console.log(newSPK.item[i].tipe);
            location.href = '03-03-04-sj-std.php?i=' + i;
        }
    }

    function updateSPK() {
        console.log('Running Update SPK!');

        newSPK = localStorage.getItem('dataSPKToEdit');
        newSPK = JSON.parse(newSPK);

        let totalHarga = 0;
        for (const item of newSPK.item) {
            totalHarga = totalHarga + parseFloat(item.hargaItem);
        }

        $('#inputHargaTotalSPK').val(totalHarga);

        $.ajax({
            url: '01-crud.php',
            type: 'POST',
            async: false,
            cache: false,
            data: {
                type: 'DELETE',
                table: 'spk_contains_produk',
                column: 'id_spk',
                value: newSPK.id
            },
            success: function(res) {
                console.log(res);
                res = JSON.parse(res);
                if (res[0] == 'DELETED') {

                    proceedSPK();

                }
            }
        });
    }
</script>

<?php
include_once "01-footer.php";
?>