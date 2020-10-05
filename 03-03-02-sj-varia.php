<div id="containerSJVaria">

    <div class="ml-0_5em mr-0_5em mt-2em">
        <div>
            <h2>Tipe: Sarung Jok Variasi</h2>
        </div>
        <div id="divArraySJVaria">

        </div>


        <br><br>

        <div id="warning" class="d-none"></div>

        <div id="divBtnKunciItem" class="grid-1-auto justify-items-center">
            <div id="btnKunciItem" class="b-radius-50px bg-color-orange-1 pt-0_5em pb-0_5em pl-1em pr-1em">
                <span class="ui-icon ui-icon-locked"></span>
                <span class="font-weight-bold">kunci item</span>
            </div>
        </div>

        <div id="divPilihanTambahItemSejenis" class="grid-1-auto m-1em">
            <div id="divRadioPilihan" class="justify-self-center b-1px-solid-grey p-1em">
            </div>
        </div>

        <div id="divAvailableOptions" class="position-absolute bottom-5em w-calc-100-1em">
            Available options:
            <div id="availableOptions">

            </div>

        </div>
        <div id="bottomDiv" class="position-absolute bottom-0_5em w-calc-100-1em">
            <div class="h-4em bg-color-orange-2 grid-1-auto" onclick="insertNewProduct();">
                <span class="justify-self-center font-weight-bold">TAMBAH ITEM KE SPK</span>
            </div>
        </div>

    </div>
</div>

<script>
    let sjVaria = [{}];
    let indexSJVaria = 0; // index yang akan memudahkan apabila nantinya ada item sejenis yang sekaligus mau ditambahkan, yang hanya beda gambar atau warna misalnya.
    let pilihanSJVariaSejenis = [] // ini nanti untuk pilihan item sejenis yang mau ditambahkan
    let arrayBahan = new Array();
    let arrayVariasi = new Array();
    let arrayJenisLG = [],
        arrayGambarLGBludru = [],
        arrayGambarLGPolimas = [],
        arrayGambarLGSablon = [],
        arrayGambarLGBayang = [],
        arrayGambarLGStiker = [],
        arrayJht = [],
        arrayJenisTato = [];

    // ini nantinya untuk menampung id - id element yang mau di remove atau di reset
    let idElementToRemove;
    let idElementToReset;


    // console.log('Length divSJVaria: ' + $('div.divSJVaria').length);

    // let testArray = ["test1", "test1", "test1", "test1", "test1", "test1", "test1", "test1"];

    // console.log(testArray);
    $(document).ready(function() {

        fetch('json/products.json').then(response => response.json()).then(data => {
            console.log(data);
            for (const bahan of data[0].bahan) {
                // console.log(bahan.nama_bahan);
                arrayBahan.push(bahan.nama_bahan);
            }
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
            for (const jht of data[0].jahit[0].tipe_jht) {
                arrayJht.push(jht);
            }
        });

        // console.log(arrayBahan);

        $('#divPilihanTambahItemSejenis').hide();

        // $("#variasi2").autocomplete({
        //     source: arrayVariasi
        // });

        // $('#variasi').selectmenu();

    });

    function addSJVaria() {
        let elementsToAppend =
            `<div id="divSJVaria-${indexSJVaria}" class="divSJVaria b-1px-solid-grey pt-1em pb-1em pl-1em pr-1em">
                <div id='divInputBahan-${indexSJVaria}'></div>
                <div id='divVaria-${indexSJVaria}'></div>
                <div id='divJenisLGTato-${indexSJVaria}'></div>
                <div id='divGambar-${indexSJVaria}'></div>
                <div id='divJht-${indexSJVaria}'></div>
                <div id='divJumlah-${indexSJVaria}'></div>
            </div>`;

        $('#divArraySJVaria').append(elementsToAppend);
    }

    let indexElementSystem = 0;
    let elementSystem = [
        [`#divInputBahan-${indexSJVaria}`, `#inputBahan-${indexSJVaria}`],
        [`#divVaria-${indexSJVaria}`, `#divSelectVaria-${indexSJVaria}`],
        [
            [
                [`#availableOptions`, `#boxJumlah`],
                [`#availableOptions`, `#boxJht`]
            ],
            [
                [`#availableOptions`, `#boxJumlah`],
                [`#availableOptions`, `#boxJht`],
                [`#availableOptions`, `#boxDesc`]
            ],
        ],
        [
            [
                [`#divJumlah-${indexSJVaria}`, `#divInputJumlah-${indexSJVaria}`],
                [`#divJht-${indexSJVaria}`, `#divSelectJht-${indexSJVaria}`]
            ],
            [``, ``],
            [``, ``]
        ],
        ['', ['boxJumlah', 'boxJhtKepala'],
            ['selectTipeLG'],
            ['selectTipeTato']
        ],
        ['', [
            ['inputJumlah', 'removeBoxJumlah'],
            ['selectTipeJahit', 'removeBoxJht']
        ]]
    ];

    // console.log(elementSystem);
    let removeElementSystem = [`#selectPolosLGTato-${indexSJVaria}`, 'removeSelectTipeLG', 'removeSelectTipeTato', 'removeSelectTipeJahit', 'removeInputJumlah', 'removeBoxJumlah', 'removeBoxJhtKepala'];

    let htmlBoxJumlah =
        `<div id="boxJumlah" class="d-inline-block mr-0_5em pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red" onclick='addLvl3ElementFromBox("Jumlah");'>
        Jumlah
    </div>`;

    let htmlBoxJht =
        `<div id="boxJht" class="d-inline-block mr-0_5em pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red" onclick='addLvl3ElementFromBox("Jht");'>
        + Jahit
    </div>`;

    let htmlBoxDesc =
        `<div id="boxDesc" class="d-inline-block mr-0_5em pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red" onclick='addLvl3ElementFromBox("Desc");'>
        + Ktrgn
    </div>`;

    let htmlDivInputJumlah =
        `<div id="divInputJumlah-${indexSJVaria}" class="mt-1em">
            <input type="number" name="jumlah-${indexSJVaria}" id="inputJumlah-${indexSJVaria}" min="0" step="1" placeholder="Jumlah" class="pt-0_5em pb-0_5em">
        </div>`;

    let htmlDivSelectJht =
        `<div id='divSelectJht-${indexSJVaria}' class="grid-2-auto_10 mt-1em">
            <select name="selectJht-${indexSJVaria}" id="selectJht-${indexSJVaria}" class="pt-0_5em pb-0_5em" onchange="cekLGAddJenisLG(this.value);">
                <option value="" disabled selected>Pilih Jenis Jahit</option>
            </select>
            <span class="ui-icon ui-icon-closethick justify-self-center" onclick=></span>
        </div>`;

    let htmlDivTADesc =
        `<div id="divTADesc-${indexSJVaria}" class="mt-1em">
            <textarea class="pt-1em pl-1em text-area-mode-1" name="desc-${indexSJVaria}" id="desc-${indexSJVaria}" placeholder="Keterangan"></textarea>
        </div>`;


    let elementHTML = [
        `<input id="inputBahan-${indexSJVaria}" class="input-1 mt-1em pb-1em" type="text" placeholder="Nama/Tipe Bahan" onkeyup="cekBahanAddSelectVariasi(this.value);">`,

        `<div id='divSelectVaria-${indexSJVaria}' class="grid-1-auto mt-1em mb-0_5em">
            <select name="selectVaria-${indexSJVaria}" id="selectVaria-${indexSJVaria}" class="pt-0_5em pb-0_5em" onchange="cekVariaAddBoxes(this.value);">
                <option value="" disabled selected>Pilih Variasi</option>
            </select>
        </div>`,

        [
            [htmlBoxJumlah, htmlBoxJht],
            [htmlBoxJumlah, htmlBoxJht, htmlBoxDesc]

        ],
        [
            [htmlDivInputJumlah, htmlDivSelectJht],
            [htmlDivInputJumlah, htmlDivSelectJht, htmlDivTADesc]

        ]

    ];

    async function pilihFungsi(namaFungsi, divID, elementID, elementHTML) {
        window[namaFungsi](divID, elementID, elementHTML);
        console.log('pilih fungsi dijalankan: ' + namaFungsi + '\n' + divID + '\n' + elementHTML);
    }

    async function createElement(divID, elementID, elementHTML) {
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
                source: arrayBahan,
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
            arrayJht.forEach(tipeJht => {
                $("#selectJht-" + indexSJVaria).append('<option value="' + tipeJht + '">' + tipeJht + '</option>');
            });
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

    function resetElement(params) {

    }

    addSJVaria();
    createElement(elementSystem[indexElementSystem][0], elementSystem[indexElementSystem][1], elementHTML[indexElementSystem]);

    // fungsi langsung dipanggil untuk langsung menambahkan element2 input SJ Varia pertama pada halaman web.

    function cekBahanAddSelectVariasi(namaBahan) {
        // console.log(namaBahan);
        try {
            arrayBahan.forEach(namaBahan2 => {
                if (namaBahan === namaBahan2) {
                    console.log('namaBahan1:' + namaBahan);
                    console.log('namaBahan2:' + namaBahan2);

                    if ($(`#divSelectVaria-${indexSJVaria}`).length === 0) {
                        indexElementSystem = 1;
                        createElement(elementSystem[indexElementSystem][0], elementSystem[indexElementSystem][1], elementHTML[indexElementSystem]);
                    }
                    throw Error("Actually this error is to break the loop only. Because break; cannot used for forEach loop.");
                } else {
                    console.log("Nama Bahan not found!")
                    indexElementSystem = 1;
                    removeElement(indexElementSystem);
                }
            });
        } catch (error) {
            console.log(error);
        }
    }

    function cekVariaAddBoxes(variasi) {
        console.log(variasi);
        indexElementSystem = 2;
        if (variasi === 'Polos') {
            removeElement(indexElementSystem);
            for (let i = 0; i < elementSystem[indexElementSystem][0].length; i++) {
                console.log('i: ' + i);
                createElement(elementSystem[indexElementSystem][0][i][0], elementSystem[indexElementSystem][0][i][1], elementHTML[indexElementSystem][0][i]);
            }
        } else {
            removeElement(indexElementSystem);
            createElement(elementSystem[indexElementSystem][0][0][0], elementSystem[indexElementSystem][0][0][1], elementHTML[indexElementSystem][1][0]);
            createElement(elementSystem[indexElementSystem][0][1][0], elementSystem[indexElementSystem][0][1][1], elementHTML[indexElementSystem][1][1]);
            createElement(elementSystem[indexElementSystem][1][2][0], elementSystem[indexElementSystem][1][2][1], elementHTML[indexElementSystem][1][2]);
        }

        // sjVaria[indexSJVaria]['variasi'] = {
        //     'nama': variasi
        // };
        // console.log(sjVaria);
    }

    function showBoxAvailableOptions(value, text) {
        let divID = `box${value}`;
        let htmlBox =
            `<div id="${divID}" class="d-inline-block pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red"` +
            `onclick='addLvl3ElementFromBox("${value}");'>` +
            `${text}` +
            '</div>';

        $('#availableOptions').append(htmlBox);
    }

    function showInputJumlah(idToRemove) {
        let htmlInputJumlah =
            `<div id="divInputJumlah-${indexSJVaria}" class="mt-1em">
                    <input type="number" name="jumlah-${indexSJVaria}" id="inputJumlah-${indexSJVaria}" min="0" step="1" placeholder="Jumlah" class="pt-0_5em pb-0_5em">
                </div>`;
        $('#divJumlah-' + indexSJVaria).html(htmlInputJumlah);

        $(idToRemove).remove();

    }

    function addLvl3ElementFromBox(value) {
        indexElementSystem = 3;
        if (value === 'Jumlah') {
            // removeElement(indexElementSystem);
            $('#boxJumlah').remove();
            createElement(elementSystem[indexElementSystem][0][0][0], elementSystem[indexElementSystem][0][0][1], elementHTML[indexElementSystem][0][0]);
        } else if (value === 'Jht') {
            // removeElement(indexElementSystem);
            $('#boxJht').remove();
            createElement(elementSystem[indexElementSystem][0][1][0], elementSystem[indexElementSystem][0][1][1], elementHTML[indexElementSystem][0][1]);
        } else if (value === 'Desc') {
            // removeElement(indexElementSystem);
            $('#boxDesc').remove();
            createElement(elementSystem[indexElementSystem][0][2][0], elementSystem[indexElementSystem][0][2][1], elementHTML[indexElementSystem][1][3]);
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
                    for (let k = 0; k < elementSystem[i][j].length; k++) {
                        console.log(i + ' ' + j + ' ' + k + ' ' + 1);
                        removeElement2(elementSystem[i][j][k][1]);
                    }

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

    function toggleShowElement(idAll, time) {
        idAll.forEach(id => {
            if ($(id).css("display") === "none") {
                $(id).toggle(time);
            }
        });
    }

    document.getElementById('btnKunciItem').addEventListener('click', () => {
        let htmlRadioToAppend = pilihanSJVariaSejenis[0] + pilihanSJVariaSejenis[1];
        $('#divRadioPilihan').html(htmlRadioToAppend);
        $('#divPilihanTambahItemSejenis').show();

    });

    function insertNewProduct() {

    }
</script>

<style>

</style>