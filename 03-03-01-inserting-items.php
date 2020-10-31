<?php
include_once "01-header.php";
?>

<div class="header"></div>

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
            <div id="divSPKDate" class="font-weight-bold">15-10-2020</div>
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

    <div id="divAddItems" class="h-9em position-relative mt-1em">
        <a href="03-03-02-sj-varia3.php" class="productType position-absolute top-0 left-50 transform-translate--50_0 circle-L bg-color-orange-1 grid-1-auto justify-items-center">
            <span class="font-size-0_8em text-center font-weight-bold">SJ<br>Varia</span>
        </a>
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
        <div class="d-inline-block btn-1 bg-color-purple-blue font-weight-bold color-white" onclick="hideEditOptItemSPK();">Finish Editing</div>
    </div>

    <div id="btnProsesSPK" class="position-absolute bottom-0_5em w-calc-100-1em h-4em bg-color-orange-2 grid-1-auto" onclick="proceedSPK();">
        <span class="justify-self-center font-weight-900">PROSES SPK</span>
    </div>

</div>

<script>
    $('.productType').hide();
    $('#btnProsesSPK').hide();
    let newSPK = localStorage.getItem('newSPK');
    getSPKItems();

    function getSPKItems() {
        newSPK = localStorage.getItem('newSPK');
        newSPK = JSON.parse(newSPK);
        $('#divSPKNumber').html(newSPK.id);
        $('#divSPKDate').html(newSPK.date);
        $('#divSPKCustomer').html(newSPK.custName + '-' + newSPK.daerah);
        $('#divTitleDesc').html(newSPK.desc);

        if (newSPK.item === new Array()) {
            console.log('return');
            $('#divBtnEditItem').hide();
            return;
        }
        console.log(newSPK);
        let htmlItemList = '';
        let totalHarga = 0;
        let i = 0;
        for (const item of newSPK.item) {
            var textItemJht = item.jht;
            if (textItemJht != '') {
                textItemJht = '+ jht ' + textItemJht;
            }
            htmlItemList = htmlItemList +
                `<div class='divItem grid-3-auto_auto_10 pt-0_5em pb-0_5em bb-1px-solid-grey'>
                <div class='divItemName grid-2-15_auto'>
                    <div id='btnRemoveItem-${i}' class='btnRemoveItem grid-1-auto justify-items-center circle-medium bg-color-soft-red' onclick='removeSPKItem(${i});'><img style='width: 1.3em;' src='img/icons/minus-white.svg'></div>
                    ${item.bahan} ${item.varia} ${textItemJht}
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

        $.ajax({
            type: "POST",
            url: "01-crud.php",
            async: false,
            data: {
                type: 'insert',
                table: 'spk',
                column: ['id', 'tgl_pembuatan', 'ket_judul', 'id_pelanggan', 'harga'],
                value: [newSPK.id, newSPK.date, newSPK.desc, newSPK.custID, totalHarga],
                dateIndex: 1,
                idToReturn: newSPK.id
            },
            success: function(res) {
                res = JSON.parse(res);
                console.log(res);
                result = res;
            }
        });
        console.log('result insertNewSPK(): ' + result);
        return result;
    }

    function toggleProductType() {
        $(".productType").toggle(500);
    }

    window.addEventListener('popstate', (event) => {
        // console.log(event.state.page);
        // console.log(event)
        $('#SPKBaru').hide();
        $("#containerBeginSPK").hide();
        $('#containerSJVaria').hide();
        if (event.state == null) {
            history.go(-1);
        } else if (event.state.page == 'SJVaria') {
            $("#containerSJVaria").show();
        } else if (event.state.page == 'newSPK') {
            $('#SPKBaru').show();
        } else if (event.state.page == 'SPKBegin') {
            $('#containerBeginSPK').show();
        }
    });

    async function proceedSPK() {
        // cek apakah produk sudah ada atau blm
        let result = new Array();
        let status = '';
        let resInsertProduct = await insertNewProduct();
        console.log('resInsertProduct:');
        console.log(resInsertProduct);

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
        location.href = '03-06-print-out-spk.php';
    }

    async function insertNewProduct() {
        let result = [];
        let status = '';
        let listOfID = [];
        let parameterToPass = [];
        for (const item of newSPK.item) {
            let lastID = JSON.parse(getLastID('produk'));
            let setID = lastID[1];
            console.log(lastID);
            console.log(setID);
            console.log('item:');
            console.log(item);
            $.ajax({
                type: 'POST',
                url: '01-crud.php',
                async: false,
                data: {
                    type: 'cek',
                    table: 'produk',
                    column: ['tipe', 'bahan', 'varia', 'ukuran', 'jahit'],
                    value: [item.tipe, item.bahan, item.varia, item.ukuran, item.jht],
                    parameter: [item.desc, item.jumlah, item.hargaItem]
                },
                success: function(res) {
                    console.log(res);
                    if (res === 'blm ada') {

                        $.ajax({
                            type: 'POST',
                            url: '01-crud.php',
                            async: false,
                            data: {
                                type: 'insert',
                                table: 'produk',
                                column: ['id', 'tipe', 'bahan', 'varia', 'ukuran', 'jahit', 'nama_lengkap', 'harga_price_list'],
                                value: [setID, item.tipe, item.bahan, item.varia, item.ukuran, item.jht, item.namaLengkap, item.hargaPriceList],
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
                        res = JSON.parse(res);
                        console.log(res);
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
        console.log(i);
    }

    function editSPKItem(i) {
        console.log(i);
        if (newSPK.item[i].tipe === 'sj-varia') {
            console.log(newSPK.item[i].tipe);
            location.href = '03-03-02-sj-varia3.php?i=' + i;
        }
    }
</script>

<?php
include_once "01-footer.php";
?>