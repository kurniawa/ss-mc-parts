<?php

include_once "01-config.php";
include_once "01-header.php";
include_once "01-backUpSQLTable.php";
// CEK REQUEST_METHOD GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id_spk"])) {
        $status = "OK";
        $id_spk = $_GET["id_spk"];
        $htmlLogOK = $htmlLogOK . "REQUEST_METHOD: GET<br>id_spk: $id_spk";
    }
} else {
    $status = "ERROR";
}

// GET ID PELANGGAN FROM SPK
if ($status == "OK") {
    $table = "spk";
    $filter = "id";
    $filter_value = $id_spk;
    $spk = dbGetWithFilter($table, $filter, $filter_value);
}

if ($status == "OK" && $spk !== "ERROR") {
    // var_dump($spk);
    // GET pelanggan
    $pelanggan = dbGetWithFilter("pelanggan", "id", $spk[0]["id_pelanggan"]);
}

if ($status == "OK" && $pelanggan !== "ERROR") {
    // var_dump($pelanggan);
    $spk_item = dbGetWithFilter("spk_contains_produk", "id_spk", $spk[0]["id"]);
}

$array_produk = array();
if ($status == "OK" && $spk_item !== "ERROR") {
    // var_dump($spk_item);
    for ($i = 0; $i < count($spk_item); $i++) {
        $produk = dbGetWithFilter("produk", "id", $spk_item[$i]["id_produk"]);
        array_push($array_produk, $produk[0]);
    }
    // var_dump($array_produk);
}

$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogError = $htmlLogError . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";
?>

<div class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="goBack();">

</div>

<div class="threeDotMenu">
    <div class="threeDot">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
    <div class="divThreeDotMenuContent">
        <div id="editKopSPK" class="threeDotMenuItem">
            <img src="img/icons/edit.svg" alt=""><span>Edit Kop SPK</span>
        </div>
        <div id="downloadExcel" class="threeDotMenuItem" onclick="goToPrintOutSPK();">
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

<form action="03-03-01-spk-selesai.php" method="POST" id="containerBeginSPK" class="m-0_5em">

    <div class="b-1px-solid-grey">
        <div class="text-center">
            <h2>Surat Perintah Kerja</h2>
        </div>
        <div class="grid-3-25_10_auto m-0_5em grid-row-gap-1em">
            <div>No.</div>
            <div>:</div>
            <div id="divSPKNumber" class="font-weight-bold"></div>
            <div>Tanggal</div>
            <div>:</div>
            <div id="divTglPembuatan" class="font-weight-bold"></div>
            <div>Untuk</div>
            <div>:</div>
            <div id="divSPKCustomer" class="font-weight-bold"></div>
            <input id="inputIDCustomer" type="hidden" name="inputIDCustomer">
        </div>
        <div class="grid-1-auto justify-items-right m-0_5em">
            <div>
                <img class="w-1em" src="img/icons/edit-grey.svg" alt="">
            </div>
        </div>
    </div>

    <div id="divTitleDesc" class="grid-1-auto justify-items-center mt-0_5em"></div>

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

    <div id="closingGreyArea" class="closingGreyArea" style="display: none;"></div>
    <div class="lightBox" style="display:none;">
        <div class="grid-2-10_auto">
            <div><img src="img/icons/speech-bubble.svg" alt="" style="width: 2em;"></div>
            <div class="font-weight-bold">Tanggal Selesai / Pengiriman</div>
        </div>
        <br><br>
        <div class="text-center">
            <input id="inputTglSelesaiSPK" type="date" class="input-select-option-1 w-12em" name="tgl_selesai" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <br><br>
        <input type="hidden" name="id_spk" value=<?= $id_spk; ?>>
        <div class="text-center">
            <button type="submit" id="btnSPKSelesai" class="btn-tipis bg-color-orange-1 d-inline-block">Lanjutkan >></button>
        </div>
    </div>

</form>

<div id="divItemList" class="bt-1px-solid-grey font-weight-bold"></div>
<input id="inputHargaTotalSPK" type="hidden">

<div id="divKeteranganTambahan" class="mt-1em">
    <div class='text-right'><span class='ui-icon ui-icon-closethick' onclick='removeKeteranganTambahan();'></span></div>
    <textarea class="pt-1em pl-1em text-area-mode-1" name="taDesc" id="taKeteranganTambahan" placeholder="Keterangan"></textarea>
</div>

<div id="divJmlTotal" class="text-right">
    <div id="divJmlTotal2" class="font-weight-bold font-size-2em color-green"></div>
    <div class="font-weight-bold color-red font-size-1_5em">Total</div>
</div>

<div id="divAddItems" class="h-9em position-relative mt-1em">
    <a href="03-03-02-sj-varia-add_item.php?id_spk=<?= $id_spk ?>" class="productType position-absolute top-0 left-50 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
        <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Varia</span>
    </a>
    <a href="03-03-03-sjKombiFromDetailSPK?id_spk=<?= $id_spk ?>.php" class="productType position-absolute top-1em left-35 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
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

<div id="boxKeteranganTambahan" class="position-fixed bottom-5em d-inline-block mr-0_5em pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red" onclick='showKeteranganTambahan();'>
    + Ktrgn Tambahan
</div>

<div id="divMarginBottom" style="height: 20vh;"></div>

<div class="divLogError"></div>
<div class="divLogWarning"></div>
<div class="divLogOK"></div>

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

<script>
    // LOG ERROR DAN OK
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
    // ----- END -----

    var spk = <?= json_encode($spk); ?>;
    console.log(spk);

    var pelanggan = <?= json_encode($pelanggan); ?>;
    console.log(pelanggan);

    var spk_contains_item = <?= json_encode($spk_item); ?>;
    console.log(spk_contains_item);

    var produk = <?= json_encode($array_produk); ?>;
    console.log(produk);

    $jmlTotalSPK = 0;
    var htmlSPKItem = '';
    for (var i = 0; i < spk_contains_item.length; i++) {
        var action = "";

        if (produk[i].tipe == "sj-varia") {
            action = "03-03-02-sj-varia3.php";
        } else if (produk[i].tipe == "sj-kombi") {
            action = "03-03-03-sj-kombi.php";
        } else if (produk[i].tipe == "sj-std") {
            action = "03-03-04-sj-std.php";
        } else if (produk[i].tipe == "tankpad") {
            action = "03-03-05-tankpad.php";
        } else if (produk[i].tipe == "busa-stang") {
            action = '03-03-06-busa-stang.php';
        }

        var ktrg = spk_contains_item[i].ktrg;
        if (ktrg == null) {
            ktrg = "";
        } else {
            ktrg = ktrg.replace(new RegExp('\n?\r', 'g'), '<br />');
        }

        htmlSPKItem = htmlSPKItem +
            `<form action='${action}' method="GET">
            <div class='divItem grid-3-auto_auto_10 pt-0_5em pb-0_5em bb-1px-solid-grey'>
                <div class='divItemName grid-2-15_auto'>
                    <div id='btnRemoveItem-${i}' class='btnRemoveItem grid-1-auto justify-items-center circle-medium bg-color-soft-red' onclick='removeSPKItem(${spk_contains_item[i].id});'><img style='width: 1.3em;' src='img/icons/minus-white.svg'></div>
                    ${produk[i].nama_lengkap}
                </div>
                <div class='grid-1-auto'>
                    <div class='color-green justify-self-right font-size-1_2em'>
                        ${spk_contains_item[i].jumlah}
                    </div>
                    <div class='color-grey justify-self-right'>Jumlah</div>
                </div>
                <button type='submit' id='btnEditItem-${spk_contains_item[i].id}' class='btnEditItem grid-1-auto justify-items-center circle-medium bg-color-purple-blue'><img style='width: 1.3em;' src='img/icons/pencil2-white.svg'></button>
                <div class='pl-0_5em color-blue-purple'>${ktrg}</div>
            </div>
            <input type="hidden" name="id_spk" value="${spk[0].id}">
            <input type="hidden" name="id_spk_contains_item" value="${spk_contains_item[i].id}">
            <input type="hidden" name="id_produk" value="${produk[i].id}">
            </form>
            `;

        $jmlTotalSPK = $jmlTotalSPK + parseFloat(spk_contains_item[i].jumlah);
    }

    $('#divSPKNumber').html(spk[0].id);
    $('#divTitleDesc').html(spk[0].ktrg);
    $('#divItemList').html(htmlSPKItem);
    console.log($jmlTotalSPK);

    setTimeout(function() {
        if ($jmlTotalSPK !== 0) {
            $('#divJmlTotal2').html($jmlTotalSPK);
            $('#divJmlTotal').show();
        }

    }, 100);

    $('#divTglPembuatan').html(spk[0].tgl_pembuatan);
    $('#divSPKCustomer').html(`${pelanggan[0].nama} - ${pelanggan[0].daerah}`);
    $('#divTitleDesc').html(spk[0].ket_judul);
    $('#taKeteranganTambahan').html(spk[0].ktrg);

    // keadaan awal apa aja yang di hide
    $('.divThreeDotMenuContent').hide();
    // $('.threeDotMenu').css('display', 'none'); // -> untuk new SPK
    $('.productType').hide();
    $('#boxKeteranganTambahan').hide();
    $('#divKeteranganTambahan').hide();
    $('#btnProsesSPK').hide();
    $('#divJmlTotal').hide();
    // $('#divBtnSPKSelesai').hide();
    $('#btnEditSPKItem').hide();

    function goToPrintOutSPK() {
        location.href = `03-06-print-out-spk.php?id_spk=${spk[0].id}`;
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

        if ($('#divKeteranganTambahan').css('display') === 'none') {
            $('#boxKeteranganTambahan').show();
        } else {
            $('#boxKeteranganTambahan').hide();
        }

        $('.threeDotMenu').css('display', 'grid');

        console.log('SPKitem:');
        console.log(SPKItem);
        console.log(jmlItem);
        console.log(descEachItem);

        $('#divSPKNumber').html(SPKID);
        $('#divTglPembuatan').html(formatDate(tglPembuatan));
        $('#divSPKCustomer').html(`${custName} - ${daerah}`);
        $('#divTitleDesc').html(ketSPK);
        $('#taKeteranganTambahan').html(keteranganTambahan);

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
            keteranganTambahan = dataSPK.keteranganTambahan;

            $('#divTglPembuatan').html(formatDate(tglPembuatan));
            $('#divSPKCustomer').html(custName + ' - ' + daerah);
            $('#divTitleDesc').html(ketSPK);
            $('#taKeteranganTambahan').html(keteranganTambahan);

            let beda = 'tidak';
            let namaKeyItem = ['bahan', 'desc', 'hargaItem', 'hargaPcs', 'jahit', 'japstyle', 'jumlah', 'logo', 'namaLengkap', 'tato', 'tipe', 'ukuran', 'varia'];
            if (dataSPK.item.length === SPKBefore.item.length || dataSPK.keteranganTambahan !== $('#taKeteranganTambahan').val()) {

                for (let i = 0; i < dataSPK.item.length; i++) {
                    for (let k = 0; k < namaKeyItem.length; k++) {
                        console.log(dataSPK.item[i][namaKeyItem[k]]);
                        if (dataSPK.item[i][namaKeyItem[k]] !== SPKBefore.item[i][namaKeyItem[k]]) {
                            beda = 'ya';
                        }
                    }
                }

                if (dataSPK.keteranganTambahan !== $('#taKeteranganTambahan').val()) {
                    beda = 'ya';
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
                mode: 'edit',
                keteranganTambahan: keteranganTambahan
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
        $jmlTotalSPK = 0;
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
                    <div class='pl-0_5em color-blue-purple'>${dataSPK.item[i].desc.replace(new RegExp('\r?\n', 'g'), '<br />')}</div>
                    </div>`;

                $jmlTotalSPK = $jmlTotalSPK + parseFloat(dataSPK.item[i].jumlah);
                console.log('$jmlTotalSPK-1: ' + $jmlTotalSPK);
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
                    <div class='pl-0_5em color-blue-purple'>${descEachItem[i].replace(new RegExp('\r?\n', 'g'), '<br />')}</div>
                    </div>`;

                $jmlTotalSPK = $jmlTotalSPK + parseFloat(jmlItem[i]);
                console.log('$jmlTotalSPK-2: ' + $jmlTotalSPK);
            }
        }
        $('#divItemList').html(htmlSPKItem);
        if ($jmlTotalSPK !== 0) {
            $('#divJmlTotal2').html($jmlTotalSPK);
            $('#divJmlTotal').show();
        }
        console.log('$jmlTotalSPK: ' + $jmlTotalSPK);

    }



    document.getElementById('editKopSPK').addEventListener('click', function() {
        console.log('clicked');
        window.location.href = `03-05-edit-kop-spk.php?id_spk=${spk[0].id}`;
    });

    function finishSPK() {
        $('.closingGreyArea').show();
        $('.lightBox').show();
    }

    document.querySelector('.closingGreyArea').addEventListener('click', (event) => {
        $('.closingGreyArea').hide();
        $('.lightBox').hide();
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
        $('#taKeteranganTambahan').val(newSPK.keteranganTambahan);

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
                <div class='pl-0_5em color-blue-purple'>${item.desc.replace(new RegExp('\r?\n', 'g'), '<br />' )}</div>
                </div>`;

            // kita jumlah harga semua item untuk satu SPK
            totalHarga = totalHarga + parseFloat(item.hargaItem);
            totalJumlahItem = totalJumlahItem + parseFloat(item.jumlah);
            i++;
        }
        $('#inputHargaTotalSPK').val(totalHarga);
        $('#divItemList').html(htmlItemList);
        $('#btnProsesSPK').show();

        if ($('#divKeteranganTambahan').css('display') === 'none') {
            $('#boxKeteranganTambahan').show();
        } else {
            $('#boxKeteranganTambahan').hide();
        }

        if (totalJumlahItem !== 0) {
            $('#divJmlTotal2').html(totalJumlahItem);
            $('#divJmlTotal').show();

            console.log('$jmlTotalSPK: ' + totalJumlahItem);

        }
    }

    async function insertNewSPK() {
        console.log('SPKNo: ' + newSPK.id);
        let result = [];
        let totalHarga = $('#inputHargaTotalSPK').val();

        // cek apakah ada keterangan tambahan
        if ($('#taKeteranganTambahan') !== null || $('#taKeteranganTambahan') !== '') {
            newSPK.keteranganTambahan = $('#taKeteranganTambahan').val();
        }

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
                            column: ['id', 'tgl_pembuatan', 'ket_judul', 'id_pelanggan', 'harga', 'keterangan'],
                            value: [newSPK.id, newSPK.tglPembuatan, newSPK.ketSPK, newSPK.custID, totalHarga, newSPK.keteranganTambahan],
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

            alert('SPK berhasil dibuat');

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

    function removeSPKItem(id_spk_contains_item) {
        window.location.href = `03-03-01-removeItemFromDetailSPK.php?id_spk_contains_item=${id_spk_contains_item}`;
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

    function showKeteranganTambahan() {
        $('#boxKeteranganTambahan').hide();
        $('#divKeteranganTambahan').show();
    }

    function removeKeteranganTambahan() {
        $('#boxKeteranganTambahan').show();
        $('#divKeteranganTambahan').hide();
    }
</script>

<?php
include_once "01-footer.php";
?>