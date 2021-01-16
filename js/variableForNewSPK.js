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

// VARIABLE UNTUK KOMBINASI
var arrayKombi = new Array();
var arrayTipeKombi = new Array();

// KHUSUS UNTUK STANDAR
var arrayStd = new Array();
var arrayTipeStd = new Array();

// KHUSUS UNTUK TANKPAD
var arrayTankpad = new Array();
var arrayTipeTankpad = new Array();

// KHUSUS BUSA_STANG
var arrayBusaStang = new Array();
var arrayTipeBusaStang = new Array();

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

    // KHUSUS UNTUK KOMBINASI
    for (const kombi of data[1].varia) {
        arrayKombi.push({
            nama: kombi.nama_varia,
            harga: kombi.harga
        });
        arrayTipeKombi.push(kombi.nama_varia);
    }

    console.log(arrayKombi);

    //KHUSUS UNTUK STANDAR
    for (const std of data[2].variasi_1) {
        arrayStd.push({
            nama: std.nama_variasi,
            harga: std.harga
        });
        arrayTipeStd.push(std.nama_variasi);
    }
    console.log(arrayStd);

    // KHUSUS UNTUK TANKPAD
    for (const tankpad of data[3].lini_produk) {
        arrayTankpad.push({
            nama: tankpad.nama,
            harga: tankpad.harga
        });
        arrayTipeTankpad.push(tankpad.nama);
    }

    // KHUSUS BUSA_STANG
    arrayBusaStang.push({
        nama: data[4].nama,
        harga: data[4].harga
    });
    arrayTipeBusaStang.push(data[4].nama);

    console.log(arrayBusaStang);

    console.log(arrayTankpad);
});