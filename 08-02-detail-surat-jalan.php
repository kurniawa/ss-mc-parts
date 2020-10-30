<?php
include_once "01-header.php";
?>

<header class="header"></header>

<div id="containerDetailSrjalan">
    <div class="grid-3-25_25_50">
        <img width="200em" src="img/images/logo-mc.jpg" alt="">
        <div><span class="font-weight-bold">CV. MC-Parts</span><br>Jl. Raya Kranggan No. 96<br>Kec. Gn. Putri/Kab. Bogor<br>0812 9335 218<br>0812 8655 6500</div>

        <div class="grid-1-auto justify-items-center font-weight-bold font-size-2em">
            <span>SURAT JALAN -</span><span>TANDA TERIMA BARANG</span>
        </div>
    </div>

    <br>

    <hr style="height: 2px; background-color: black; margin-bottom: 0.2em; margin-top: 0;">
    <br>
    <div class="grid-2-65_35 grid-column-gap-1em">
        <table style="width: 100%;">
            <tr>
                <td class="font-weight-bold" style="width: 35%;">Untuk:</td>
                <td class="font-weight-bold">Alamat:</td>
            </tr>
            <tr>
                <td style="height: 1.5em;"></td>
            </tr>
            <tr>
                <td id="custName" style="vertical-align: top;" class="font-weight-bold font-size-1_5em"></td>
                <td id="alamatCust" class="font-size-1_5em"></td>
            </tr>
        </table>
        <!-- <div class="grid-1-auto2">
            <span class="font-weight-bold">Untuk:</span>
            <div></div>
            <span id='custName' class="font-weight-bold font-size-1_5em"></span>
        </div>

        <div class="grid-1-auto2">
            <span class="font-weight-bold">Alamat:</span>
            <div></div>
            <span id="alamatCust" class=" font-size-1_5em"></span>
        </div> -->

        <div class="grid-3-35_5_60 grid-row-gap-0_5em">
            <div>No.</div>
            <div>:</div>
            <div id="noSrjalan"></div>
            <div>Tanggal</div>
            <div>:</div>
            <div id="tglSrjalan"></div>
            <div>Ekspedisi</div>
            <div>:</div>
            <div id="ekspedisi"></div>
        </div>
    </div>
    <br>
    <table id="tableItemSrjalan">
        <tr>
            <th class="thTableItemSrjalan" style="width: 50%;">Nama / Jenis Barang</th>
            <th class="thTableItemSrjalan">Jumlah</th>
        </tr>
        <tr>
            <td class="tdTableItemSrjalan font-size-2em font-weight-bold">Sarung Jok Motor</td>
            <td class="tdTableItemSrjalan font-weight-bold" style="font-size: xx-large;">
                <div class="grid-2-auto grid-column-gap-0_5em">
                    <div id="divJmlKoli" class="justify-self-right">
                        <div id="closingArea" onclick="closeInputEditKoli();"></div>
                        <span id="jmlKoli" ondblclick="editKoliValue();"></span>
                        <input id="inputEditKoli" type="number" step="1" min="1">
                    </div>
                    <img style="width: 2em;" class="d-inline-block" src="img/icons/koli.svg" alt="">
                </div>
            </td>
        </tr>
    </table>
    <span style="font-style: italic;">*Barang sudah diterima dengan baik dan sesuai, oleh:</span>

    <br><br><br>

    <div class="grid-2-auto">
        <div class="grid-1-auto justify-items-center">
            <div class="">Penerima,</div>
            <br><br><br><br>
            <div>(....................)</div>
        </div>
        <div class="grid-1-auto justify-items-center">
            <div class="">Hormat Kami,</div>
            <br><br><br><br>
            <div>(....................)</div>
        </div>
    </div>
</div>

<style>
    #closingArea {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1;
    }

    #inputEditKoli {
        width: 2em;
        font-size: xx-large;
        position: relative;
        z-index: 3;
    }

    #containerDetailSrjalan {
        font-family: 'Roboto';
        font-weight: normal;
        font-style: normal;
    }

    #tableItemSrjalan {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid black;
    }

    .thTableItemSrjalan,
    .tdTableItemSrjalan {
        border-left: 1px solid black;
        border-right: 1px solid black;
        border-bottom: 1px solid black;
    }

    .thTableItemSrjalan {
        height: 3em;
    }

    .tdTableItemSrjalan {
        height: 8em;
        text-align: center;
    }

    @media print {
        .bg-color-orange-1 {
            background-color: #FFED50;
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<script>
    $('#inputEditKoli').hide();
    $('#closingArea').hide();
    let srjlnToPrint = localStorage.getItem('notaToPrint');
    srjlnToPrint = JSON.parse(srjlnToPrint);

    let htmlEkspedisi =
        `
    ${srjlnToPrint.ekspedisiUtama.nama}<br>
    ${srjlnToPrint.ekspedisiUtama.alamat.replace(new RegExp('\r?\n', 'g'),'<br>')}<br>
    ${srjlnToPrint.ekspedisiUtama.kontak}
    `;

    let jmlKoli;
    if (srjlnToPrint.koli === null) {
        jmlKoli = 'null';
    } else {
        jmlKoli = srjlnToPrint.koli;
    }
    $('#noSrjalan').html(srjlnToPrint.noSrjalan);
    $('#tglSrjalan').html(srjlnToPrint.tglNota);
    $('#custName').html(srjlnToPrint.namaCust);
    $('#alamatCust').html(srjlnToPrint.alamatCust.replace(new RegExp('\r?\n', 'g'), '<br>'));
    $('#ekspedisi').html(htmlEkspedisi);
    $('#jmlKoli').html(jmlKoli);

    function editKoliValue() {
        console.log('running edit koli value');
        $('#jmlKoli').hide();
        $('#inputEditKoli').show();
        $('#closingArea').show();
    }

    function closeInputEditKoli() {
        console.log('closing Input Edit Koli');
        console.log($('#inputEditKoli').val());
        // console.log(typeof($('#inputEditKoli').val()));
        if ($('#inputEditKoli').val() !== '') {
            srjlnToPrint.koli = $('#inputEditKoli').val();
            $.ajax({
                url: '01-crud.php',
                type: 'POST',
                async: false,
                cache: false,
                data: {
                    type: 'UPDATE',
                    table: 'spk',
                    column: ['koli'],
                    value: [$('#inputEditKoli').val()],
                    key: 'id',
                    keyValue: srjlnToPrint.id
                },
                success: function(res) {
                    console.log(res);
                    res = JSON.parse(res);
                    if (res[0] == 'UPDATE SUCCEED') {
                        localStorage.setItem('notaToPrint', JSON.stringify(srjlnToPrint));
                        location.reload();
                    }
                }
            });
        }
        console.log(srjlnToPrint.koli);
        $('#inputEditKoli').hide();
        $('#closingArea').hide();
        $('#jmlKoli').show();

    }
</script>
<?php
include_once "01-footer.php";
?>