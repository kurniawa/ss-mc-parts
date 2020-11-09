<?php

// var_dump($_POST);
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
$hargaPcs = $_POST["hargaPcs"];
$bahan = $_POST["bahan"];
$varia = $_POST["varia"];
$ukuran = $_POST["ukuran"];
$logo = $_POST["logo"];
$tato = $_POST["tato"];
$jahit = $_POST["jahit"];
$japstyle = $_POST["japstyle"];
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
<div id="containerDetailSPK" class="m-0_5em">

    <div class="b-1px-solid-grey">
        <div class="text-center">
            <h2>Surat Perintah Kerja</h2>
        </div>
        <div class="grid-3-25_10_auto m-0_5em grid-row-gap-1em">
            <div>No.</div>
            <div>:</div>
            <div class="divSPKNumber font-weight-bold"><?= $SPKID ?></div>
            <div>Tanggal</div>
            <div>:</div>
            <div id="divTglPembuatan" class="font-weight-bold"><?= $tglPembuatan ?></div>
            <div>Untuk</div>
            <div>:</div>
            <div id="divSPKCustomer" class="font-weight-bold"><?= $custName ?> - <?= $daerah ?></div>
            <input id="inputIDCustomer" type="hidden" name="inputIDCustomer">
        </div>
    </div>

    <div id="divTitleDesc" class="grid-1-auto justify-items-center mt-0_5em"><?= $ketSPK ?></div>

    <div id="divItemList" class="bt-1px-solid-grey font-weight-bold"></div>

    <div class="text-right">
        <div class="font-weight-bold font-size-2em color-green"><?= $jmlTotal ?></div>
        <div class="font-weight-bold color-red font-size-1_5em">Total</div>
    </div>

    <div id="divAddItems" class="h-9em position-relative mt-1em">
        <div class="productType position-absolute top-0 left-50 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center" onclick="toggleSJVaria();">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Varia</span>
        </div>
        <div class="productType position-absolute top-1em left-35 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Kombi</span>
        </div>
        <div class="productType position-absolute top-1em left-65 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Std</span>
        </div>
        <div class="productType position-absolute top-5em left-30 transform-translate--50_0 circle-L bg-color-soft-red grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">Tank<br>Pad</span>
        </div>
        <div class="productType position-absolute top-5em left-70 transform-translate--50_0 circle-L bg-color-grey grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">Busa<br>Stang</span>
        </div>
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

    <div class="position-absolute bottom-0_5em w-calc-100-1em">
        <div id="btnProsesSPK" class="h-4em bg-color-orange-2 grid-1-auto" onclick="finishSPK();">
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
    $('.productType').hide();
    $('#btnProsesSPK').hide();
    // -- END --

    // deklarasi awal variabel-variable yang di send melalui post
    let SPKID = <?= $SPKID ?>;
    let custName = <?= json_encode($custName) ?>;
    let custID = <?= json_encode($custID) ?>;
    let daerah = <?= json_encode($daerah) ?>;
    let tglPembuatan = <?= json_encode($tglPembuatan2) ?>;
    let tglSelesai = <?= json_encode($tglSelesai) ?>;
    let ketSPK = <?= json_encode($ketSPK) ?>;
    let SPKItem = <?= json_encode($SPKItem); ?>;
    let jmlItem = <?= json_encode($jmlItem); ?>;
    let descEachItem = <?= json_encode($descEachItem); ?>;

    let jmlTotal = <?= json_encode($jmlTotal) ?>;

    console.log(SPKItem);
    console.log(jmlItem);
    console.log(descEachItem);

    // localStorage.setItem untuk mempermudah, apabila diperlukan pengeditan
    // let dataSPK = {
    //     id: SPKID,
    //     custName: custName,
    //     custID: custID,
    //     daerah: daerah,
    //     tglPembuatan: tglPembuatan,
    //     ketSPK: ketSPK
    // };
    // console.log(dataSPK);
    // localStorage.setItem('dataSPKToEdit', JSON.stringify(dataSPK));
    // console.log(localStorage.getItem('dataSPKToEdit'));

    let dataSPK = localStorage.getItem('dataSPKToEdit');
    if (dataSPK != null) {
        dataSPK = JSON.parse(dataSPK);
        custName = dataSPK.custName;
        custID = dataSPK.custID;
        tglPembuatan = dataSPK.tglPembuatan
        daerah = dataSPK.daerah;
        ketSPK = dataSPK.ketSPK;

        $('#divTglPembuatan').html(formatDate(tglPembuatan));
        $('#divSPKCustomer').html(custName + ' - ' + daerah);
        $('#divTitleDesc').html(ketSPK);

    } else {
        let dataSPK = {
            id: SPKID,
            custName: custName,
            custID: custID,
            daerah: daerah,
            tglPembuatan: tglPembuatan,
            ketSPK: ketSPK
        };
        console.log(dataSPK);
        localStorage.setItem('dataSPKToEdit', JSON.stringify(dataSPK));
        console.log(localStorage.getItem('dataSPKToEdit'));

    }

    let htmlSPKItem = '';
    for (let i = 0; i < SPKItem.length; i++) {
        htmlSPKItem = htmlSPKItem +
            `
            <div class='grid-2-auto p-0_5em bb-1px-solid-grey'>
                <div class=''>${SPKItem[i]}</div>
                <div class='grid-1-auto'>
                <div class='color-green justify-self-right font-size-1_2em'>${jmlItem[i]}</div>
                <div class='color-grey justify-self-right'>Jumlah</div>
                </div>
                <div class='pl-0_5em color-blue-purple'>${descEachItem[i]}</div>
                </div>
            `;
    }
    $('#divItemList').html(htmlSPKItem);

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
                jumlah: jmlItem[i],
                jmlTotal: jmlTotal[i]
            });
        }

        let spkToPrint = {
            custID: custID,
            custName: custName,
            daerah: daerah,
            date: tglPembuatan,
            desc: ketSPK,
            id: SPKID,
            item: itemToPrint
        }

        localStorage.setItem('spkToPrint', JSON.stringify(spkToPrint));

        location.href = '03-06-print-out-spk.php';
    });

    document.querySelector('.threeDot').addEventListener('click', function() {
        let element = [{
            id: '.divThreeDotMenuContent',
            time: 300
        }];
        elementToToggle(element);
    });
    // $("#containerBeginSPK").css("display", "none");
    // $('#btnProsesSPK').hide();
    // let SPKItems = localStorage.getItem('SPKItems');
    // getSPKItems();

    // function getSPKItems() {
    //     SPKItems = localStorage.getItem('SPKItems');
    //     if (SPKItems === '') {
    //         return false;
    //     }
    //     SPKItems = JSON.parse(SPKItems);
    //     console.log(SPKItems);
    //     let htmlItemList = '';
    //     for (const item of SPKItems) {
    //         var textItemJht = item.jht;
    //         if (textItemJht != '') {
    //             textItemJht = '+ jht ' + textItemJht;
    //         }
    //         htmlItemList = htmlItemList +
    //             `<div class='grid-2-auto p-0_5em bb-1px-solid-grey'>
    //             <div class=''>${item.bahan} ${item.varia} ${textItemJht}</div>
    //             <div class='grid-1-auto'>
    //             <div class='color-green justify-self-right font-size-1_2em'>${item.jumlah}</div>
    //             <div class='color-grey justify-self-right'>Jumlah</div>
    //             </div>
    //             <div class='pl-0_5em color-blue-purple'>${item.desc}</div>
    //             </div>`;
    //     }
    //     $('#divItemList').html(htmlItemList);
    //     $('#btnProsesSPK').show();
    // }
    // history.pushState({
    //     page: 'SPKBegin'
    // }, null);
    // $(document).ready(function() {
    //     $(".productType").css("display", "none");
    //     $("#containerSJVaria").css("display", "none");
    // });

    // function toggleProductType() {
    //     $(".productType").toggle(500);
    // }

    // function toggleSJVaria() {
    //     history.pushState({
    //         page: 'SJVaria'
    //     }, 'test title');
    //     $(".productType").hide();
    //     $("#containerSJVaria").toggle();
    //     $("#containerBeginSPK").toggle();
    // }

    // window.addEventListener('popstate', (event) => {
    //    // console.log(event.state.page);
    //    // console.log(event)
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

    // async function proceedSPK() {
    //     // cek apakah produk sudah ada atau blm
    //     let result = new Array();
    //     let status = '';
    //     let resInsertProduct = await insertNewProduct();
    //     console.log('resInsertProduct: ' + resInsertProduct);

    //     if (resInsertProduct[0] === 'OK') {
    //         // masukkan data SPK
    //         console.log('proceedSPK()');
    //         let resNewSPK = await insertNewSPK();
    //         console.log('resNewSPK: ' + resNewSPK);
    //         if (resNewSPK[0] === 'INSERT OK') {
    //             for (let i = 0; i < resInsertProduct[1].length; i++) {
    //                 let lastID = getLastID('spk_contains_produk');
    //                 lastID = JSON.parse(lastID);
    //                 console.log('lastID from spk_contains_produk: ' + lastID);
    //                 let setID = lastID[1];
    //                 $.ajax({
    //                     type: 'POST',
    //                     url: '01-crud.php',
    //                     async: false,
    //                     data: {
    //                         type: 'insert',
    //                         table: 'spk_contains_produk',
    //                         column: ['id', 'id_spk', 'id_produk', 'ktrg', 'jumlah'],
    //                         value: [setID, resNewSPK[2], resInsertProduct[1][i], resInsertProduct[2][i][0], resInsertProduct[2][i][1]]
    //                     },
    //                     success: function(res) {
    //                         console.log(res);
    //                         res = JSON.parse(res);
    //                         if (res[0] === 'INSERT OK') {
    //                             result.push('OK');
    //                         } else {
    //                             result.push('NOT OK');
    //                         }
    //                     }
    //                 });
    //             }
    //         } else {
    //             console.log('Ada kesalahan pada saat insert!');
    //         }
    //     }
    //     try {
    //         result.forEach(res => {
    //             if (res != 'OK') {
    //                 throw 'Ada Eror INSERT spk_contains_produk';
    //             }
    //             status = 'OK';
    //         });
    //     } catch (error) {
    //         console.log(error);
    //         status = 'NOT OK';
    //     }
    // }

    // async function insertNewProduct() {
    //     let result = [];
    //     let status = '';
    //     let listOfID = [];
    //     let parameterToPass = [];
    //     for (const item of SPKItems) {
    //         let lastID = JSON.parse(getLastID('produk'));
    //         let setID = lastID[1];
    //         console.log(lastID);
    //         console.log(setID);
    //         $.ajax({
    //             type: 'POST',
    //             url: '01-crud.php',
    //             async: false,
    //             data: {
    //                 type: 'cek',
    //                 table: 'produk',
    //                 column: ['tipe', 'bahan', 'varia', 'ukuran', 'jahit'],
    //                 value: [item.tipe, item.bahan, item.varia, item.ukuran, item.jht],
    //                 parameter: [item.desc, item.jumlah]
    //             },
    //             success: function(res) {
    //                 console.log(res);
    //                 if (res === 'blm ada') {

    //                     $.ajax({
    //                         type: 'POST',
    //                         url: '01-crud.php',
    //                         async: false,
    //                         data: {
    //                             type: 'insert',
    //                             table: 'produk',
    //                             column: ['id', 'tipe', 'bahan', 'varia', 'ukuran', 'jahit', 'nama_lengkap'],
    //                             value: [setID, item.tipe, item.bahan, item.varia, item.ukuran, item.jht, item.namaLengkap],
    //                             parameter: [item.desc, item.jumlah]
    //                         },
    //                         success: function(res) {
    //                             console.log(res);
    //                             res = JSON.parse(res);
    //                             if (res[0] === 'INSERT OK') {
    //                                 result.push('OK');
    //                                 console.log('result: ' + result);
    //                                 listOfID.push(setID);
    //                                 console.log('lisfOfID: ' + listOfID);
    //                                 parameterToPass.push(res[3]);
    //                                 console.log('parameterToPass: ' + parameterToPass);
    //                             } else {
    //                                 result.push('NOT OK');
    //                             }
    //                         }
    //                     });
    //                 } else {
    //                     res = JSON.parse(res);
    //                     console.log(res);
    //                     listOfID.push(parseInt(res[1]));
    //                     parameterToPass.push(res[2]);
    //                     result.push('OK');
    //                 }
    //             }
    //         });
    //     }

    //     try {
    //         result.forEach(res => {
    //             if (res != 'OK') {
    //                 throw 'Ada Eror INSERT product atau cek product';
    //             }
    //             status = 'OK';
    //         });
    //     } catch (error) {
    //         console.log(error);
    //         status = 'NOT OK';
    //     }
    //     console.log(listOfID);
    //     return [status, listOfID, parameterToPass];
    // }
</script>

<?php
include_once "01-footer.php";

// include_once "03-03-02-sj-varia.php";
?>