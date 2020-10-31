<?php
include_once "01-header.php";
?>

<div class="header"></div>
<div id="btn-spk-baru" class="btn-atas-kanan" onclick="addNewSPK();">
    + Buat SPK Baru
</div>

<div class="grid-2-auto mt-1em ml-1em mr-1em pb-1em bb-0_5px-solid-grey">
    <div class="justify-self-left grid-2-auto b-1px-solid-grey b-radius-50px mr-1em pl-1em pr-0_4em w-11em">
        <input class="input-2 mt-0_4em mb-0_4em" type="text" placeholder="Cari...">
        <div class="justify-self-right grid-1-auto justify-items-center circle-small bg-color-orange-1">
            <img class="w-0_8em" src="img/icons/loupe.svg" alt="">
        </div>
    </div>
    <div class="div-filter-icon">

        <div class="icon-small-circle grid-1-auto justify-items-center bg-color-orange-1">
            <img class="w-0_9em" src="img/icons/sort-by-attributes.svg" alt="sort-icon">
        </div>
    </div>
</div>

<div id="div-daftar-spk" class='ml-0_5em mr-0_5em'>
</div>

<script>
    let daftarIDSPK = [];
    let daftarIDPelangganSPK = [];
    let daftarTglPembuatan = [];
    let daftarTglSelesai = [];
    let daftarKetSPK = new Array();
    let daftarNamaPelangganSPK = [];
    let daftarDaerahPelangganSPK = [];
    let daftarSingkatanPelangganSPK = [];
    let daftarJumlahItemSPK = [];
    let daftarJumlahTotalSPK = new Array();
    let daftarDescEachItem = [];
    let daftarNamaProdukEachSPK = new Array();

    let daftarNoNota = new Array();
    let daftarTglNota = new Array();
    let daftarNoSrjalan = new Array();
    let daftarTglSrjalan = new Array();
    let daftarEkspedisi = new Array();

    let daftarHargaTotal = new Array();
    let daftarHargaItemSPK = new Array();
    let daftarHargaPerPcs = new Array();

    let daftarKoliSPK = new Array();
    let daftarAlamatCust = new Array();

    $.ajax({
        type: "POST",
        url: "01-crud.php",
        async: false,
        cache: false,
        data: {
            type: 'SELECT',
            table: 'spk'
        },
        success: function(data) {
            console.log(data);
            data = JSON.parse(data);
            console.log('Parsed Data: ' + data);
            // console.log(data[0].id);
            let i = 0;
            for (const dataItem of data) {
                daftarIDSPK.push(dataItem.id);
                daftarIDPelangganSPK.push(dataItem.id_pelanggan);
                daftarTglPembuatan.push(dataItem.tgl_pembuatan);
                daftarKetSPK.push(dataItem.ket_judul);
                if (dataItem.tgl_selesai == null) {
                    daftarTglSelesai.push('');
                } else if (dataItem.tgl_selesai != null) {
                    daftarTglSelesai.push(dataItem.tgl_selesai);
                }
                daftarNoNota.push(dataItem.no_nota);
                daftarTglNota.push(dataItem.tgl_nota);
                daftarNoSrjalan.push(dataItem.no_surat_jalan);
                daftarTglSrjalan.push(dataItem.tgl_surat_jalan);
                daftarHargaTotal.push(dataItem.harga);
                daftarKoliSPK.push(dataItem.koli);

            }
            console.log('daftarIDSPK: ' + daftarIDSPK);
            console.log('daftarIDPelangganSPK: ' + daftarIDPelangganSPK);
            console.log('daftarTglPembuatan: ' + daftarTglPembuatan);
            console.log('daftarTglSelesai: ' + daftarTglSelesai);
            console.log('daftarKetSPK:');
            console.log(daftarKetSPK);
            console.log('daftarHargaTotal:');
            console.log(daftarHargaTotal);

            daftarIDPelangganSPK.forEach(pelanggan => {
                $.ajax({
                    url: '01-crud.php',
                    type: 'POST',
                    async: false,
                    cache: false,
                    data: {
                        type: 'SELECT ONE',
                        table: 'pelanggan',
                        column: ['id'],
                        value: [pelanggan]
                    },
                    success: function(data) {
                        console.log(data);
                        data = JSON.parse(data);
                        console.log(data);
                        for (const dataItem of data) {
                            daftarNamaPelangganSPK.push(dataItem.nama);
                            daftarDaerahPelangganSPK.push(dataItem.daerah);
                            daftarSingkatanPelangganSPK.push(dataItem.singkatan);
                            daftarAlamatCust.push(dataItem.alamat);
                        }
                        console.log('daftarNamaPelangganSPK: ' + daftarNamaPelangganSPK);
                        console.log('daftarDaerahPelangganSPK: ' + daftarDaerahPelangganSPK);
                        console.log('daftarSingkatanPelangganSPK: ' + daftarSingkatanPelangganSPK);
                    }
                });

                let daftarIDEkspedisi = new Array();
                let daftarEkspedisiTransit = new Array();
                let daftarEkspedisiUtama = new Array();
                $.ajax({
                    url: '01-crud.php',
                    type: 'POST',
                    async: false,
                    cache: false,
                    data: {
                        type: 'SELECT ONE',
                        table: 'pelanggan_use_ekspedisi',
                        column: ['id_pelanggan'],
                        value: [pelanggan]
                    },
                    success: function(data) {
                        console.log(data);
                        data = JSON.parse(data);
                        console.log(data);
                        for (const dataItem of data) {
                            daftarIDEkspedisi.push(dataItem.id_ekspedisi);
                            daftarEkspedisiTransit.push(dataItem.ekspedisi_transit);
                            daftarEkspedisiUtama.push(dataItem.ekspedisi_utama);
                        }
                        console.log()
                    }
                });

                let daftarNamaEkspedisi = new Array();
                let daftarAlamatEkspedisi = new Array();
                let daftarKontakEkspedisi = new Array();

                daftarIDEkspedisi.forEach((idEkspedisi) => {
                    $.ajax({
                        url: '01-crud.php',
                        type: 'POST',
                        async: false,
                        cache: false,
                        data: {
                            type: 'SELECT ONE',
                            table: 'ekspedisi',
                            column: ['id'],
                            value: [idEkspedisi]
                        },
                        success: function(data) {
                            console.log(data);
                            data = JSON.parse(data);
                            console.log(data);
                            for (const dataItem of data) {
                                daftarNamaEkspedisi.push(dataItem.nama);
                                daftarAlamatEkspedisi.push(dataItem.alamat);
                                daftarKontakEkspedisi.push(dataItem.kontak);
                            }
                        }
                    });
                });

                daftarEkspedisi.push({
                    id: daftarIDEkspedisi,
                    ketTransit: daftarEkspedisiTransit,
                    ketUtama: daftarEkspedisiUtama,
                    nama: daftarNamaEkspedisi,
                    kontak: daftarKontakEkspedisi,
                    alamat: daftarAlamatEkspedisi
                });

            });
            let daftarIDProdukEachSPK = [];
            daftarIDSPK.forEach(idSPK => {
                let descEachItem = new Array();
                let jumlahTotalSPK = 0;
                let idProdukEachSPK = new Array();
                let jmlEachItem = new Array();
                let hargaItemSPK = new Array();
                $.ajax({
                    url: '01-crud.php',
                    type: 'POST',
                    async: false,
                    cache: false,
                    data: {
                        type: 'SELECT ONE',
                        table: 'spk_contains_produk',
                        column: ['id_spk'],
                        value: [idSPK]
                    },
                    success: function(res) {
                        console.log('res spk_contains_produk: ' + res);
                        res = JSON.parse(res);
                        for (const SPKItem of res) {
                            jumlahTotalSPK = jumlahTotalSPK + parseFloat(SPKItem.jumlah);
                            jmlEachItem.push(SPKItem.jumlah);
                            descEachItem.push(SPKItem.ktrg);
                            console.log('SPKItem.ktrg: ' + SPKItem.ktrg);
                            idProdukEachSPK.push(SPKItem.id_produk);
                            hargaItemSPK.push(SPKItem.harga_item);
                        }
                        daftarIDProdukEachSPK.push(idProdukEachSPK);
                        console.log('jumlahTotalSPK: ' + jumlahTotalSPK);
                        console.log('jmlEachItem: ' + jmlEachItem);
                        console.log('descEachItem: ' + descEachItem);

                        daftarJumlahItemSPK.push(jmlEachItem);
                        daftarJumlahTotalSPK.push(jumlahTotalSPK);
                        daftarDescEachItem.push(descEachItem);
                        daftarHargaItemSPK.push(hargaItemSPK);
                        console.log('daftarHargaItemSPK:');
                        console.log(daftarHargaItemSPK);
                    }
                });
            });

            console.log('daftarJumlahItemSPK');
            console.log(daftarJumlahItemSPK);
            console.log('daftarJumlahTotalSPK: ' + daftarJumlahTotalSPK);
            console.log('daftarDescEachItem:');
            console.log(daftarDescEachItem);
            console.log('daftarIDProdukEachSPK: ' + daftarIDProdukEachSPK);
            console.log(daftarIDProdukEachSPK);
            daftarIDProdukEachSPK.forEach(idProduk => {
                let hrgPerPcsPerSPK = new Array();
                let namaProduk = new Array();
                idProduk.forEach(id => {
                    $.ajax({
                        url: '01-crud.php',
                        type: 'POST',
                        async: false,
                        cache: false,
                        data: {
                            type: 'SELECT ONE',
                            table: 'produk',
                            column: ['id'],
                            value: [id]
                        },
                        success: function(res) {
                            console.log('res produk: ' + res);
                            res = JSON.parse(res);
                            namaProduk.push(res[0].nama_lengkap);
                            console.log('res.nama_lengkap: ' + res[0].nama_lengkap);
                            hrgPerPcsPerSPK.push(res[0].harga_price_list);
                        }
                    });

                });
                daftarNamaProdukEachSPK.push(namaProduk);
                daftarHargaPerPcs.push(hrgPerPcsPerSPK);
            });

            console.log('daftarNamaProdukEachSPK:');
            console.log(daftarNamaProdukEachSPK);
            console.log(daftarEkspedisi);
            let jsonSPK = new Array();
            for (let k = 0; k < daftarIDSPK.length; k++) {
                let itemSPK = new Array();
                for (let l = 0; l < daftarNamaProdukEachSPK[k].length; l++) {
                    itemSPK.push({
                        nama: daftarNamaProdukEachSPK[k][l],
                        desc: daftarDescEachItem[k][l],
                        jumlah: daftarJumlahItemSPK[k][l],
                        harga: daftarHargaPerPcs[k][l]
                    });
                }

                let jsonSPKItem = {
                    id: daftarIDSPK[k],
                    idCust: daftarIDPelangganSPK[k],
                    namaCust: daftarNamaPelangganSPK[k],
                    alamatCust: daftarAlamatCust[k],
                    singkatanCust: daftarSingkatanPelangganSPK[k],
                    daerah: daftarDaerahPelangganSPK[k],
                    tglPembuatan: daftarTglPembuatan[k],
                    tglSelesai: daftarTglSelesai[k],
                    ketSPK: daftarKetSPK[k],
                    jumlahTotal: daftarJumlahTotalSPK[k],
                    noNota: daftarNoNota[k],
                    tglNota: daftarTglNota[k],
                    noSrjalan: daftarNoSrjalan[k],
                    tglSrjalan: daftarTglSrjalan[k],
                    itemSPK: itemSPK,
                    ekspedisi: daftarEkspedisi[k],
                    hargaTotalSPK: daftarHargaTotal[k],
                    hargaItemSPK: daftarHargaItemSPK[k],
                    koli: daftarKoliSPK[k]
                }
                jsonSPK.push(jsonSPKItem);
            }
            localStorage.setItem('daftarSPK', JSON.stringify(jsonSPK));
            daftarSPK();
        }
    });

    async function daftarSPK() {
        let i = 0;
        console.log('function dafarSPK dijalankan.');
        console.log('daftarIDSPK: ' + daftarIDSPK);
        daftarIDSPK.forEach(idSPK => {
            let arrayDate = daftarTglPembuatan[i].split('-');
            let getYear = arrayDate[0];
            let getMonth = arrayDate[1];
            let getDay = arrayDate[2];
            console.log('getYear: ' + getYear);
            console.log('getMonth: ' + getMonth);
            console.log('getDay: ' + getDay);
            let subGetYear = getYear.substr(2);
            console.log('subGetYear: ' + subGetYear);
            let warnaTglPembuatan = 'bg-color-soft-red';

            // apabila tanggal selesai telah ada
            let arrayDateSls = '';
            let getYearSls = '';
            let getMonthSls = '';
            let getDaySls = '';
            let warnaTglSls = '';
            let subGetYearSls = '';

            if (daftarTglSelesai[i] != '') {
                arrayDateSls = daftarTglSelesai[i].split('-');
                getYearSls = arrayDateSls[0];
                getMonthSls = arrayDateSls[1];
                getDaySls = arrayDateSls[2];

                console.log('getYearSls: ' + getYearSls);
                console.log('getMonthSls: ' + getMonthSls);
                console.log('getDaySls: ' + getDaySls);
                subGetYearSls = getYearSls.substr(2);
                console.log('subGetYearSls: ' + subGetYearSls);
                warnaTglSls = 'bg-color-orange-2';
                warnaTglPembuatan = 'bg-color-purple-blue';
            }

            console.log(`daftarNamaPelangganSPK[${i}]: ${daftarNamaPelangganSPK[i]}`);
            console.log(`daftarJumlahTotalSPK[${i}]: ${daftarJumlahTotalSPK[i]}`);
            console.log(`daftarNamaProdukEachSPK[${i}]: ${JSON.stringify(daftarNamaProdukEachSPK[i])}`);
            let elementToToggle = [{
                id: `#divSPKItems-${i}`,
                time: 300
            }];
            console.log('elementToToggle:');
            console.log(elementToToggle);
            elementToToggle = JSON.stringify(elementToToggle);
            console.log(elementToToggle);
            let htmlItemsEachSPK = '';
            let htmlHiddenInput =
                `
                <input type='hidden' name='SPKID' value='${daftarIDSPK[i]}'>
                <input type='hidden' name='custID' value='${daftarIDPelangganSPK[i]}'>
                <input type='hidden' name='custName' value='${daftarNamaPelangganSPK[i]}'>
                <input type='hidden' name='daerah' value='${daftarDaerahPelangganSPK[i]}'>
                <input type='hidden' name='tglPembuatan' value='${daftarTglPembuatan[i]}'>
                <input type='hidden' name='tglSelesai' value='${daftarTglSelesai[i]}'>
                <input type='hidden' name='ketSPK' value='${daftarKetSPK[i]}'>
                <input type='hidden' name='jmlTotal' value='${daftarJumlahTotalSPK[i]}'>
            `;
            for (let j = 0; j < daftarNamaProdukEachSPK[i].length; j++) {
                htmlItemsEachSPK = htmlItemsEachSPK +
                    `<div>${daftarNamaProdukEachSPK[i][j]}</div><div>${daftarJumlahItemSPK[i][j]}</div>`;
                htmlHiddenInput = htmlHiddenInput +
                    `
                    <input type='hidden' name='SPKItem[]' value='${daftarNamaProdukEachSPK[i][j]}'>
                    <input type='hidden' name='jmlItem[]' value='${daftarJumlahItemSPK[i][j]}'>
                    <input type='hidden' name='descEachItem[]' value='${daftarDescEachItem[i][j]}'>
                    `;
            }
            let htmlDaftarSPK =
                `<form method='POST' action='03-04-detail-spk.php' class='pb-0_5em pt-0_5em bb-1px-solid-grey'>
                    <div class='grid-5-9_45_25_18_5'>
                    <div class='circle-medium grid-1-auto justify-items-center font-weight-bold bg-color-orange-1'>${daftarSingkatanPelangganSPK[i]}</div>
                    <div>${daftarNamaPelangganSPK[i]} - ${daftarDaerahPelangganSPK[i]}</div>
                    <div class='grid-3-auto'>
                    <div class='grid-1-auto justify-items-center ${warnaTglPembuatan} color-white b-radius-5px w-3_5em'>
                    <div class='font-size-2_5em'>${getDay}</div><div>${getMonth}-${subGetYear}</div>
                    </div>
                    -
                    <div class='grid-1-auto justify-items-center ${warnaTglSls} color-white b-radius-5px w-3_5em'>
                    <div class='font-size-2_5em'>${getDaySls}</div><div>${getMonthSls}-${subGetYearSls}</div>
                    </div>
                    </div>
                    <div class='grid-1-auto'>
                    <div class='color-green justify-self-right font-size-1_2em font-weight-bold'>${daftarJumlahTotalSPK[i]}</div>
                    <div class='color-grey justify-self-right'>Jumlah</div>
                    </div>
                    <div class='justify-self-center'><img class='w-0_7em' src='img/icons/dropdown.svg' onclick='elementToToggle(${elementToToggle});'></div>
                    </div>` + htmlHiddenInput +
                // DROPDOWN
                `<div id='divSPKItems-${i}' class='p-0_5em b-1px-solid-grey' style='display: none'>
                <div class='font-weight-bold color-grey'>No. ${daftarIDSPK[i]}</div>
                <div class='grid-2-auto'>` + htmlItemsEachSPK + `</div>
                <div class='text-right'>
                <button type='submit' class="d-inline-block bg-color-orange-1 pl-1em pr-1em b-radius-50px" style='border: none'>
                Lebih Detail >>
                </button>
                </div>
                </div>
                </form>`;

            $('#div-daftar-spk').append(htmlDaftarSPK);
            i++;
            console.log('i: ' + i);
        });
    }

    function addNewSPK() {
        localStorage.setItem('SPKItems', '');
        window.location.href = '03-03-spk-baru.php';
    }

    // set keadaan awal dimana JSON SPKToEdit dihilangkan
    if (localStorage.getItem('dataSPKToEdit') != null) {
        localStorage.removeItem('dataSPKToEdit');
    }
</script>

<style>
    .input-cari {
        border: none;
        width: 10em;
        border-radius: 25px;
        padding: 0.5em 1em 0.5em 1em;
        box-shadow: 0 0 2px gray;
    }

    .input-cari:focus {
        box-shadow: 0 0 6px #23FFAD;
    }

    .field {
        margin: 1em;
    }

    .div-filter-icon {
        justify-self: end;
    }

    .icon-small-circle {
        border-radius: 100%;
        width: 2em;
        height: 2em;
    }

    .icon-img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>

<?php
include_once "01-footer.php";
?>