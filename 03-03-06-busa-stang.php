<?php
include_once "01-header.php";
if (isset($_GET['i'])) {
    $m = $_GET['i'];
} else {
    $m = 'undefined';
}
?>

<div id="containerBusaStang">

    <div class="ml-0_5em mr-0_5em mt-2em">
        <div>
            <h2>Tipe: Busa Stang</h2>
        </div>

        <div id="divArrayBusaStang">

        </div>

        <br><br>

        <div id="divWarning" class="d-none"></div>

        <div id="divAvailableOptions" class="position-absolute bottom-5em w-calc-100-1em">
            Available options:
            <div id="availableOptions">

            </div>

        </div>
        <div id="bottomDiv" class="position-absolute bottom-0_5em w-calc-100-1em h-4em bg-color-orange-2 grid-1-auto" onclick="insertItemToLocal();">

            <span class="justify-self-center font-weight-bold">TAMBAH ITEM KE SPK</span>

        </div>
        <div id="bottomDiv2" class="position-absolute bottom-0_5em w-calc-100-1em h-4em bg-color-orange-2 grid-1-auto" onclick="confirmEditItemSPK();">

            <span class="justify-self-center font-weight-bold">EDIT ITEM SPK</span>

        </div>

    </div>
</div>

<script>
    // codingan untuk antisipasi editing item

    let indexSJVaria = 0; // index yang akan memudahkan apabila nantinya ada item sejenis yang sekaligus mau ditambahkan, yang hanya beda gambar atau warna misalnya.
    let sjVaria = [{}];
    let pilihanSJVariaSejenis = [] // ini nanti untuk pilihan item sejenis yang mau ditambahkan
    let arrayBusaStang = new Array();
    let arrayTipeBusaStang = new Array();
    // let arrayJht = new Array();

    // ini nantinya untuk menampung id - id element yang mau di remove atau di reset
    let idElementToRemove;
    let idElementToReset;

    $(document).ready(function() {

        fetch('json/products.json').then(response => response.json()).then(data => {
            console.log(data);

            // for (const busaStang of data[4]) {
            //     arrayBusaStang.push({
            //         nama: busaStang.nama,
            //         harga: busaStang.harga
            //     });
            //     arrayTipeBusaStang.push(busaStang.nama);
            // }

            arrayBusaStang.push({
                nama: data[4].nama,
                harga: data[4].harga
            });
            arrayTipeBusaStang.push(data[4].nama);

            console.log(arrayBusaStang);

            // for (const jht of data[0].jahit[0].tipe_jht) {
            //     arrayJht.push(jht);
            // }
            // console.log(arrayJht);
        });


    });

    function addBusaStang() {
        let elementsToAppend =
            `<div id="divBusaStang" class="b-1px-solid-grey pt-1em pb-1em pl-1em pr-1em">
                <div id='divBusaStang2'></div>
                <div id='divDesc'></div>
                <div id='divJumlah'></div>
            </div>`;

        $('#divArrayBusaStang').append(elementsToAppend);
    }

    let indexElementSystem = 0;
    let elementSystem = [
        [`#divBusaStang2`, `#inputBusaStang`],
        [
            [`#availableOptions`, `#boxJumlah`],
            [`#availableOptions`, `#boxDesc`]
        ],
        [
            [`#divJumlah`, `#divInputJumlah`],
            [`#divDesc`, `#divTADesc`]
        ]
    ];

    // console.log(elementSystem);

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
            <select name="selectJht" id="selectJht" class="pt-0_5em pb-0_5em">
                <option value="" disabled selected>Pilih Jenis Jahit</option>
            </select>
            <span class="ui-icon ui-icon-closethick justify-self-center" onclick='closeAndAddBox("${elementSystem[2][1][1]}","${elementSystem[1][1][0]}","${elementSystem[1][1][1]}", 1, 1);'></span>
        </div>`;

    let htmlDivTADesc =
        `<div id="divTADesc" class="mt-1em">
            <div class='text-right'><span class='ui-icon ui-icon-closethick' onclick='closeAndAddBox("${elementSystem[2][1][1]}", "${elementSystem[1][1][0]}","${elementSystem[1][1][1]}", 1, 1);'></span></div>
            <textarea class="pt-1em pl-1em text-area-mode-1" name="taDesc" id="taDesc" placeholder="Keterangan"></textarea>
        </div>`;


    // onkeyup="cekTankpadAddBoxes(this.value)";

    let elementHTML = [
        `<input id="inputBusaStang" class="input-1 mt-1em pb-1em" type="text" value="Busa Stang" disabled>
        <input id='inputHargaBusaStang' type='hidden'>
        `,

        [htmlBoxJumlah, htmlBoxDesc],

        [htmlDivInputJumlah, htmlDivTADesc]

    ];

    async function createElement(divID, elementID, elementHTML) {
        console.log('running create Element');
        console.log(divID + ' ' + elementHTML);
        console.log('elementID: ' + elementID);

        if (divID === '#availableOptions') {
            $(divID).append(elementHTML);
            return;
        }
        $(divID).html(elementHTML);

        if (elementID === `#inputBusaStang`) {
            // $("#inputBusaStang").autocomplete({
            //     source: arrayTipeBusaStang,
            //     select: function(event, ui) {
            //         console.log(ui);
            //         console.log(ui.item.value);
            //         cekTankpadAddBoxes(ui.item.value);
            //         // sjVaria.push({
            //         //     'nama_bahan': ui.item.value
            //         // });
            //         // sjVaria['nama_bahan'] = ui.item.value;
            //         // console.log('sjVaria: ' + sjVaria);
            //     }
            // });
            $(divID).html(elementHTML);

        } else if (elementID === elementSystem[1][1]) {
            arrayVariasi.forEach(variasi => {
                $("#selectVaria").append('<option value="' + variasi + '">' + variasi + '</option>');
            });
        } else if (elementID === `#divSelectJht`) {
            arrayJht.forEach(tipeJht => {
                $("#selectJht").append('<option value="' + tipeJht + '">' + tipeJht + '</option>');
            });
        }
    }

    addBusaStang();
    createElement(elementSystem[indexElementSystem][0], elementSystem[indexElementSystem][1], elementHTML[indexElementSystem]);

    // fungsi langsung dipanggil untuk langsung menambahkan element2 input SJ Varia pertama pada halaman web.

    function cekBusaStangAddBoxes(tipeBusaStang) {
        try {
            console.log('masuk ke try');
            console.log(arrayBusaStang);
            console.log(arrayBusaStang.length);

            for (let i = 0; i < arrayBusaStang.length; i++) {
                console.log('masuk ke for');
                if (tipeBusaStang === arrayBusaStang[i].nama) {
                    console.log('masuk ke if');
                    console.log('namaTankpad1:' + tipeBusaStang);
                    console.log('namaTankpad2:' + arrayBusaStang[i].nama);
                    console.log('hargaTankpad:' + arrayBusaStang[i].harga);

                    indexElementSystem = 1;
                    removeElement(indexElementSystem);
                    for (let i = 0; i < elementSystem[indexElementSystem].length; i++) {
                        console.log('i: ' + i);
                        if ($(elementSystem[indexElementSystem][i][1]).length === 0) {
                            createElement(elementSystem[indexElementSystem][i][0], elementSystem[indexElementSystem][i][1], elementHTML[indexElementSystem][i]);
                        }
                    }
                    $(`#inputHargaBusaStang`).val(arrayBusaStang[i].harga);
                    console.log('Harga Busa Stang:');
                    console.log($(`#inputHargaBusaStang`).val());
                    throw Error("Actually this error is to break the loop only. Because break; cannot used for forEach loop.");
                } else {
                    console.log("Nama Busa Stang not found!")
                    indexElementSystem = 1;
                    removeElement(indexElementSystem);
                }
            }

            // for (const busaStang of arrayBusaStang) {
            //     console.log('masuk ke for');
            //     if (tipeBusaStang === busaStang.nama) {
            //         console.log('masuk ke if');
            //         console.log('namaTankpad1:' + tipeBusaStang);
            //         console.log('namaTankpad2:' + busaStang.nama);
            //         console.log('hargaTankpad:' + busaStang.harga);

            //         indexElementSystem = 1;
            //         removeElement(indexElementSystem);
            //         for (let i = 0; i < elementSystem[indexElementSystem].length; i++) {
            //             console.log('i: ' + i);
            //             if ($(elementSystem[indexElementSystem][i][1]).length === 0) {
            //                 createElement(elementSystem[indexElementSystem][i][0], elementSystem[indexElementSystem][i][1], elementHTML[indexElementSystem][i]);
            //             }
            //         }
            //         $(`#inputHargaBusaStang`).val(busaStang.harga);
            //         console.log('Harga Busa Stang:');
            //         console.log($(`#inputHargaBusaStang`).val());
            //         throw Error("Actually this error is to break the loop only. Because break; cannot used for forEach loop.");
            //     } else {
            //         console.log("Nama Busa Stang not found!")
            //         indexElementSystem = 1;
            //         removeElement(indexElementSystem);
            //     }

            // }
        } catch (error) {
            console.log(error);
        }

        // indexElementSystem = 1;
        // removeElement(indexElementSystem);
        // for (let i = 0; i < elementSystem[indexElementSystem].length; i++) {
        //     console.log('i: ' + i);
        //     if ($(elementSystem[indexElementSystem][i][1]).length === 0) {
        //         createElement(elementSystem[indexElementSystem][i][0], elementSystem[indexElementSystem][i][1], elementHTML[indexElementSystem][i]);
        //     }
        // }
        // $(`#inputHargaBusaStang`).val(tankpad.harga);
        // console.log('Harga Tankpad:');
        // console.log($(`#inputHargaBusaStang`).val());

    }
    console.log('cekBusaStangAddBoxes');

    setTimeout(() => {
        cekBusaStangAddBoxes("Busa Stang");
    }, 300);


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
            createElement(elementSystem[indexElementSystem][1][0], elementSystem[indexElementSystem][1][1], elementHTML[indexElementSystem][1]);
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
        $tipe = 'busa-stang'
        $busaStang = $(`#inputBusaStang`).val();
        // $jht = '';
        // $plusJahit = '';
        $desc = '';
        $namaLengkap = '';
        $jumlah = 0;

        $hargaBusaStang = $(`#inputHargaBusaStang`).val();
        let hargaJht = 0;
        let hargaItem = 0;

        console.log('$tankpad: ' + $busaStang);
        // console.log('$jht: ' + $jht);
        console.log('$desc: ' + $desc);
        console.log('$jumlah: ' + $jumlah);

        // if ($(`#divSelectJht`).length !== 0) {
        //     $jht = $(`#selectJht`).val();
        //     hargaJht = 1000;
        // }

        if ($(`#divTADesc`).length !== 0) {
            $desc = $(`#taDesc`).val();
        }
        if ($(`#divInputJumlah`).length !== 0) {
            $jumlah = $(`#inputJumlah`).val();
        }

        if ($busaStang === '') {
            $textWarning = '<span class="color-red">Kombinasi masih belum ditentukan!</span>';
            $('#divWarning').html($textWarning).removeClass('d-none');
            return;
        }

        if ($jumlah <= 0) {
            console.log('warning untuk jumlah');
            $textWarning = '<span class="color-red">Jumlah barang masih belum diinput dengan benar!</span>';
            $('#divWarning').html($textWarning).removeClass('d-none');
            return;
        }

        // if ($jht !== '') {
        //     $plusJahit = '+ jht ' + $jht;
        // }
        $namaLengkap = $busaStang;
        $namaLengkap = $namaLengkap.trim();
        let hargaPcs = parseFloat($hargaBusaStang)
        hargaItem = hargaPcs * $jumlah;

        let itemObj = {
            tipe: $tipe,
            busaStang: $busaStang,
            desc: $desc,
            jumlah: $jumlah,
            namaLengkap: $namaLengkap,
            hargaBusaStang: $hargaBusaStang,
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

    let m = <?php echo $m ?>;
    console.log(m);
    $('#bottomDiv2').hide()
    setTimeout(() => {

        if (m !== undefined) {
            editMode();
            $('#bottomDiv2').show();
            $('#bottomDiv').hide();
        }

    }, 300);

    function editMode() {
        console.log('edit mode');
        let newSPK = localStorage.getItem('dataSPKToEdit');
        newSPK = JSON.parse(newSPK);

        if (newSPK.item[m].busaStang !== '') {
            console.log(newSPK.item[m].busaStang);
            $(`#inputBusaStang`).val(newSPK.item[m].busaStang);
        }

        // if (newSPK.item[m].varia !== '') {
        //     console.log(elementSystem[1][1]);
        //     cekTankpadAddBoxes(newSPK.item[m].kombi);
        //     $(`#selectVaria`).val(newSPK.item[m].varia);
        // }

        // console.log(newSPK.item[m].jht);
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

        // if (newSPK.item[m].jht !== '') {
        //     addLvl2ElementFromBox('Jht');
        //     $(`#selectJht`).val(newSPK.item[m].jht);
        // }
        if (newSPK.item[m].desc !== '') {
            addLvl2ElementFromBox('Desc');
            $(`#taDesc`).val(newSPK.item[m].desc);
        }

        if (newSPK.item[m].jumlah !== '') {
            addLvl2ElementFromBox('Jumlah');
            $(`#inputJumlah`).val(newSPK.item[m].jumlah);
        }

        cekTankpadAddBoxes2();
    }

    function cekTankpadAddBoxes2() {
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
        $tipe = 'tankpad'
        $busaStang = $(`#inputBusaStang`).val();
        // $jht = '';
        // $plusJahit = '';
        $desc = '';
        $namaLengkap = '';
        $jumlah = 0;

        $hargaBusaStang = $(`#inputHargaBusaStang`).val();
        let hargaJht = 0;
        let hargaItem = 0;

        console.log('$busaStang: ' + $busaStang);
        // console.log('$jht: ' + $jht);
        console.log('$desc: ' + $desc);
        console.log('$jumlah: ' + $jumlah);

        // if ($(`#divSelectJht`).length !== 0) {
        //     $jht = $(`#selectJht`).val();
        //     hargaJht = 1000;
        // }
        if ($(`#divTADesc`).length !== 0) {
            $desc = $(`#taDesc`).val();
        }
        if ($(`#divInputJumlah`).length !== 0) {
            $jumlah = $(`#inputJumlah`).val();
        }

        if ($busaStang === '') {
            $textWarning = '<span class="color-red">Kombinasi masih belum ditentukan!</span>';
            $('#divWarning').html($textWarning).removeClass('d-none');
            return;
        }

        // if ($varia == undefined) {
        //     console.log('warning untuk Select Variasi');
        //     $textWarning = '<span class="color-red">Variasi Sarung Jok masih belum ditentukan!</span>';
        //     $('#divWarning').html($textWarning).removeClass('d-none');
        //     return;
        // }

        if ($jumlah <= 0) {
            console.log('warning untuk jumlah');
            $textWarning = '<span class="color-red">Jumlah barang masih belum diinput dengan benar!</span>';
            $('#divWarning').html($textWarning).removeClass('d-none');
            return;
        }

        // if ($jht !== '') {
        //     $plusJahit = '+ jht ' + $jht;
        // }
        $namaLengkap = $busaStang;
        $namaLengkap = $namaLengkap.trim();
        let hargaPcs = parseFloat($hargaBusaStang);
        hargaItem = hargaPcs * $jumlah;

        let itemObj = {
            tipe: $tipe,
            busaStang: $busaStang,
            jht: $jht,
            desc: $desc,
            jumlah: $jumlah,
            namaLengkap: $namaLengkap,
            hargaBusaStang: $hargaBusaStang,
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