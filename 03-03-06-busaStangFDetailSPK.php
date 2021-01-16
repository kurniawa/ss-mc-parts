<?php
include_once "01-header.php";
include_once "01-config.php";

$id_spk = 0;
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $status = "OK";
    $htmlLogOK .= "REQUEST_METHOD: GET<br><br>";
} else {
    $status = "ERROR";
    $htmlLogError .= "REQUEST_METHOD: ENTAHLAH<br><br>";
}

if ($status == "OK") {
    if (isset($_GET["id_spk"])) {
        $id_spk = $_GET["id_spk"];
    } else {
        $status = "ERROR";
    }
}

$htmlLogError .= "</div>";
$htmlLogOK .= "</div>";
$htmlLogWarning .= "</div>";
?>

<form action="03-03-06-busaStangFDetailSPK-db.php" method="POST" id="containerBusaStang">

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
        <button type="submit" id="bottomDiv" class="position-absolute bottom-0_5em w-calc-100-1em h-4em bg-color-orange-2 grid-1-auto" onclick="insertItemToLocal();">

            <span class="justify-self-center font-weight-bold">TAMBAH ITEM KE SPK</span>

        </button>

    </div>
    <input type="hidden" name="id_spk" value="<?= $id_spk; ?>">
</form>

<div class="divLogError"></div>
<div class="divLogOK"></div>
<div class="divLogWarning"></div>

<script>
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

    function backToSPK() {
        window.history.go(-2);
    }

    var status = "<?= $status; ?>";
    var id_spk = 0;
    if (status == "OK") {
        id_spk = <?= $id_spk; ?>;
    }
</script>

<script src="js/variableForNewSPK.js"></script>

<script>
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
            <select name="jahit" id="selectJht" class="pt-0_5em pb-0_5em">
                <option value="" disabled selected>Pilih Jenis Jahit</option>
            </select>
            <span class="ui-icon ui-icon-closethick justify-self-center" onclick='closeAndAddBox("${elementSystem[2][1][1]}","${elementSystem[1][1][0]}","${elementSystem[1][1][1]}", 1, 1);'></span>
        </div>`;

    let htmlDivTADesc =
        `<div id="divTADesc" class="mt-1em">
            <div class='text-right'><span class='ui-icon ui-icon-closethick' onclick='closeAndAddBox("${elementSystem[2][1][1]}", "${elementSystem[1][1][0]}","${elementSystem[1][1][1]}", 1, 1);'></span></div>
            <textarea class="pt-1em pl-1em text-area-mode-1" name="ktrg" id="taDesc" placeholder="Keterangan"></textarea>
        </div>`;


    // onkeyup="cekTankpadAddBoxes(this.value)";

    let elementHTML = [
        `<input id="inputBusaStang" name="busa_stang" class="input-1 mt-1em pb-1em" type="text" value="Busa Stang" readonly>
        <input id='inputHargaBusaStang' name="harga_busa_stang" type='hidden'>
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

        } catch (error) {
            console.log(error);
        }

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

    function cekTankpadAddBoxes2() {
        indexElementSystem = 1;
        for (let i = 0; i < elementSystem[indexElementSystem].length; i++) {
            console.log('i: ' + i);
            if ($(elementSystem[indexElementSystem][i][1]).length === 0) {
                createElement(elementSystem[indexElementSystem][i][0], elementSystem[indexElementSystem][i][1], elementHTML[indexElementSystem][i]);
            }
        }
    }
</script>

<?php
include_once "01-footer.php";
?>