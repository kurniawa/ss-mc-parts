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

let daftarTipeProduk = new Array();
let daftarBahan = new Array();
let daftarVaria = new Array();
let daftarUkuran = new Array();
let daftarLogo = new Array();
let daftarTato = new Array();
let daftarJahit = new Array();
let daftarJapstyle = new Array();

function initSPK () {
    $.ajax({
        type: "POST",
        url: "01-crud.php",
        async: false,
        cache: false,
        data: {
            type: 'SELECT',
            table: 'spk',
            order: 'tgl_pembuatan'
        },
        success: function (data) {
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
                    success: function (data) {
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
                    success: function (data) {
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
                        success: function (data) {
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
                    success: function (res) {
                        console.log('res spk_contains_produk: ' + res);
                        console.log(res);
                        if (res === 'NOT FOUND!') {
                            res = [];
                        } else {
                            res = JSON.parse(res);
                        }
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
                let tipeProduk = new Array();
                let bahan = new Array();
                let varia = new Array();
                let ukuran = new Array();
                let logo = new Array();
                let tato = new Array();
                let jahit = new Array();
                let japstyle = new Array();
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
                        success: function (res) {
                            console.log('res produk: ' + res);
                            res = JSON.parse(res);
                            namaProduk.push(res[0].nama_lengkap);
                            console.log('res.nama_lengkap: ' + res[0].nama_lengkap);
                            hrgPerPcsPerSPK.push(res[0].harga_price_list);
                            tipeProduk.push(res[0].tipe);
                            bahan.push(res[0].bahan);
                            varia.push(res[0].varia);
                            ukuran.push(res[0].ukuran);
                            logo.push(res[0].logo);
                            tato.push(res[0].tato);
                            jahit.push(res[0].jahit);
                            japstyle.push(res[0].japstyle);
                        }
                    });

                });
                daftarNamaProdukEachSPK.push(namaProduk);
                daftarHargaPerPcs.push(hrgPerPcsPerSPK);
                daftarBahan.push(bahan);
                daftarVaria.push(varia);
                daftarUkuran.push(ukuran);
                daftarLogo.push(logo);
                daftarTato.push(tato);
                daftarJahit.push(jahit);
                daftarJapstyle.push(japstyle);
                daftarTipeProduk.push(tipeProduk);
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
                        harga: daftarHargaPerPcs[k][l],
                        bahan: daftarBahan[k][l],
                        varia: daftarVaria[k][l],
                        ukuran: daftarUkuran[k][l],
                        logo: daftarLogo[k][l],
                        tato: daftarTato[k][l],
                        jahit: daftarJahit[k][l],
                        japstyle: daftarJapstyle[k][l],
                        tipe: daftarTipeProduk[k][l]
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
        }
    });
}