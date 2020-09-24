<div id="containerSJBasic">

    <div class="ml-0_5em mr-0_5em mt-2em">
        <div>
            <h2>Tipe: Sarung Jok Basic</h2>
        </div>
        <div id="divArraySJBasic">

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
    let sjBasic = [{}];
    let indexSJBasic = 0; // index yang akan memudahkan apabila nantinya ada item sejenis yang sekaligus mau ditambahkan, yang hanya beda gambar atau warna misalnya.
    let pilihanSJBasicSejenis = [] // ini nanti untuk pilihan item sejenis yang mau ditambahkan
    let arrayBahan = new Array();
    let arrayVariasi = new Array();
    let arrayVariasiLG = [],
        arrayGambarLGBludru = [],
        arrayGambarLGPolimas = [],
        arrayGambarLGSablon = [],
        arrayGambarLGBayang = [],
        arrayGambarLGStiker = [];

    // ini nantinya untuk menampung id - id element yang mau di remove ata di reset
    let idElementToRemove;
    let idElementToReset;

    // console.log('Length divSJBasic: ' + $('div.divSJBasic').length);

    // let testArray = ["test1", "test1", "test1", "test1", "test1", "test1", "test1", "test1"];

    // console.log(testArray);
    $(document).ready(function() {

        fetch('json/products.json').then(response => response.json()).then(data => {
            console.log(data);
            for (const bahan of data[0].bahan) {
                console.log(bahan.nama_bahan);
                arrayBahan.push(bahan.nama_bahan);
            }
            for (const variasi of data[0].variasi[0].jenis_variasi) {
                console.log(variasi.nama);
                arrayVariasi.push(variasi.nama);
            }
            for (const variasiLG of data[0].variasi[0].jenis_variasi[1].jenis_logo) {
                console.log(variasiLG.nama);
                arrayVariasiLG.push(variasiLG.nama);
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
        });

        // console.log(arrayBahan);

        addSJBasic(); // fungsi langsung dipanggil untuk langsung menambahkan element2 input SJ Basic pertama pada halaman web.
        $('#divPilihanTambahItemSejenis').hide();

        // $("#variasi2").autocomplete({
        //     source: arrayVariasi
        // });

        // $('#variasi').selectmenu();

    });


    function addSJBasic() {
        let elementsToAppend =
            `<div id="divSJBasic-${indexSJBasic}" class="divSJBasic b-1px-solid-grey pt-1em pb-1em pl-1em pr-1em">
                <input id="inputNamaBahan-${indexSJBasic}" class="input-1 mt-1em pb-1em" type="text" placeholder="Nama/Tipe Bahan" onkeyup="cekBahanAddSelectVariasi(this.value);">
            </div>`;

        $('#divArraySJBasic').append(elementsToAppend);

        $("#inputNamaBahan-" + indexSJBasic).autocomplete({
            source: arrayBahan,
            select: function(event, ui) {
                console.log(ui);
                console.log(ui.item.value);
                cekBahanAddSelectVariasi(ui.item.value, indexSJBasic);
                // sjBasic.push({
                //     'nama_bahan': ui.item.value
                // });
                sjBasic[indexSJBasic]['nama_bahan'] = ui.item.value;
                console.log(sjBasic);
            }
        });

    }

    function showSelectVariasiBludru() {
        $("#selectVariasiBludru").toggle();
    }

    function cekBahanAddSelectVariasi(namaBahan) {
        // console.log(namaBahan);
        try {
            arrayBahan.forEach(namaBahan2 => {
                if (namaBahan === namaBahan2) {
                    console.log('namaBahan1:' + namaBahan);
                    console.log('namaBahan2:' + namaBahan2);
                    // document.getElementById('divSelectVariasi').style.display = 'grid';

                    let htmlSelectVariasi =
                        `<div id="divSelectVariasi-${indexSJBasic}" class="grid-1-auto mt-1em mb-0_5em">
                            <select name="selectVariasi-${indexSJBasic}" id="selectVariasi-${indexSJBasic}" class="pt-0_5em pb-0_5em" onchange="showNextVarian(this.value);">
                                <option value="" disabled selected>Pilih Variasi</option>
                            </select>
                        </div>`;

                    $('#divSJBasic-' + indexSJBasic).append(htmlSelectVariasi);

                    arrayVariasi.forEach(variasi => {
                        $("#selectVariasi-" + indexSJBasic).append('<option value="' + variasi + '">' + variasi + '</option>');
                    });

                    throw Error("Actually this error is to break the loop only. Because break; cannot used for forEach loop.");
                } else {
                    console.log("Nama Bahan not found!")
                    $('#divSelectVariasi-' + indexSJBasic).remove();
                }
            });
        } catch (error) {
            console.log(error);
        }
    }

    function showNextVarian(variasi) {
        console.log(variasi);
        if (variasi === "" || variasi === "Polos") {

            idElementToRemove = [{
                'id': `#divSelectVariasiLG-${indexSJBasic}`
            }, {
                'id': `#divSelectVariasiTato-${indexSJBasic}`
            }, {
                'id': `#divJumlah-${indexSJBasic}`
            }];

            removeElement(JSON.stringify(idElementToRemove));


        } else if (variasi === "LG") {
            idElementToRemove = [{
                'id': `#divSelectVariasiLG-${indexSJBasic}`
            }, {
                'id': `#divJumlah-${indexSJBasic}`
            }];
            console.log(idElementToRemove);
            idElementToReset = [{
                'id': `#selectVariasi-${indexSJBasic}`
            }];

            let htmlVariasiLG =
                `<div id="divSelectVariasiLG-${indexSJBasic}" class="grid-2-auto_10 mt-1em">
                    <select name="selectVariasiLG-${indexSJBasic}" id="selectVariasiLG-${indexSJBasic}" class="pt-0_5em pb-0_5em" onchange="showBoxAvailableOptions(this.value);">
                        <option value="" disabled selected>Pilih Variasi LOGO</option>
                    </select>
                    <span class="ui-icon ui-icon-closethick justify-self-center"` + "onclick='removeElement(" + JSON.stringify(idElementToRemove) + ");resetElement(" + JSON.stringify(idElementToReset) + ");'></span>" +
                '</div>';

            $('#divSJBasic-' + indexSJBasic).append(htmlVariasiLG);

            arrayVariasiLG.forEach(variasiLG => {
                $("#selectVariasiLG-" + indexSJBasic).append('<option value="' + variasiLG + '">' + variasiLG + '</option>');
            });

            pilihanSJBasicSejenis[0] =
                `<input type="radio" name="radioTambahItemSejenis" id=""> Beda gambar LOGO`;
            pilihanSJBasicSejenis[1] = "";

            $("#divSelectVariasiTato-" + indexSJBasic).remove();

        } else if (variasi === "TATO") {

            let htmlVariasiTATO =
                `<div id="divSelectVariasiTato-${indexSJBasic}" class="grid-2-auto_10 mt-1em">
                    <select name="selectVariasiTato-${indexSJBasic}" id="selectVariasiTato-${indexSJBasic}" class="pt-0_5em pb-0_5em">
                        <option value="" disable selected>Pilih Variasi TATO</option>
                    </select>
                    <span class="ui-icon ui-icon-closethick justify-self-center"></span>
                </div>`;

            $('#divSJBasic-' + indexSJBasic).append(htmlVariasiTATO);

            pilihanSJBasicSejenis[0] = "";
            pilihanSJBasicSejenis[1] =
                `<input type="radio" name="radioTambahItemSejenis" id=""> Beda gambar TATO`;

            $("#divSelectVariasiLG-" + indexSJBasic).remove();

        }

        sjBasic[indexSJBasic]['variasi'] = {
            'nama': variasi
        };
        console.log(sjBasic);
    }

    function showBoxAvailableOptions(value) {
        let htmlBox;
        if (value === "Bludru") {
            let htmlBoxGambarLGBludru =
                `<div id="choseVariasiBludru" class="d-inline-block pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red" onclick="showOptionsOfVariasiLG('${value}');">
                    Gambar LG Bludru
                </div>`;
            $('#availableOptions').html(htmlBoxGambarLGBludru);

        } else if (value === "jumlah") {
            htmlBox =
                `<div id="choseJumlah" class="d-inline-block pt-0_5em pb-0_5em pl-1em pr-1em b-radius-5px bg-color-soft-red box-sizing-border-box" onclick="showInputJumlah('#'+this.id);">
                    Jumlah
                </div>`;
            $('#availableOptions').html(htmlBox);
        }
    }

    function showInputJumlah(idToRemove) {
        let htmlInputJumlah =
            `<div id="divJumlah-${indexSJBasic}" class="mt-1em">
                    <input type="number" name="jumlah-${indexSJBasic}" id="inputJumlah-${indexSJBasic}" min="0" step="1" placeholder="Jumlah" class="pt-0_5em pb-0_5em">
                </div>`;
        $('#divSJBasic-' + indexSJBasic).append(htmlInputJumlah);

        $(idToRemove).remove();

    }

    function removeElement(idElements) {
        // idElements = JSON.parse(idElements);
        console.log(idElements);
        console.log(idElements[0].id);
        for (const element of idElements) {
            $(element.id).remove();
        }
    }

    function resetElement(idElements) {
        for (const element of idElements) {
            $(element.id).prop('selectedIndex', 0);
        }
    }

    function showOptionsOfVariasiLG(value) {
        idElementToRemove = [{
            'id': `#divSelectVariasiLGBludru-${indexSJBasic}`
        }, {
            'id': `#divJumlah-${indexSJBasic}`
        }];
        idElementToRemove = JSON.stringify(idElementToRemove);
        idElementToReset = [{
            'id': `#selectVariasiLG-${indexSJBasic}`
        }];
        idElementToReset = JSON.stringify(idElementToReset);

        if (value === "Bludru") {

            let htmlVariasiLGBludru =
                `<div id="divSelectVariasiLGBludru-${indexSJBasic}" class="grid-2-auto_10 mt-1em">
                    <select name="selectVariasiLGBludru-${indexSJBasic}" id="selectVariasiLGBludru-${indexSJBasic}" class="pt-0_5em pb-0_5em" onchange="showBoxAvailableOptions('jumlah')">
                        <option value="" disabled selected>Pilih Gambar Bludru</option>
                    </select>
                    <span class="ui-icon ui-icon-closethick justify-self-center"` + "onclick='removeElement(" + idElementToRemove + "); resetElement(" + idElementToReset + ");'></span>" +
                "</div>";

            $("#divSJBasic-" + indexSJBasic).append(htmlVariasiLGBludru);
            arrayGambarLGBludru.forEach(gambarLGBludru => {
                $("#selectVariasiLGBludru-" + indexSJBasic).append('<option value="' + gambarLGBludru + '">' + gambarLGBludru + '</option>');
            });

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
        let htmlRadioToAppend = pilihanSJBasicSejenis[0] + pilihanSJBasicSejenis[1];
        $('#divRadioPilihan').html(htmlRadioToAppend);
        $('#divPilihanTambahItemSejenis').show();

    });

    function insertNewProduct() {

    }
</script>

<style>

</style>