<?php
include_once "01-header.php";
?>

<header class="header"></header>

<div id="containerDetailNota">
    <div class="grid-3-30_30_40">
        <div><img width="160em" src="img/images/logo-mc.jpg" alt=""></div>
        <div>CV. MC-Parts<br>Jl. Raya Kranggan No. 96<br>Kec. Gn. Putri/Kab. Bogor<br>0812 9335 218<br>0812 8655 6500</div>
        <div class='grid-3-30_5_65'>
            <div>No. Nota</div>
            <div>:</div>
            <div id="noNota"></div>
            <div>Tanggal</div>
            <div>:</div>
            <div id="tglNota"></div>
            <div>Nama</div>
            <div>:</div>
            <div id="custName"></div>
            <div>Alamat</div>
            <div>:</div>
            <div id="alamatCust"></div>
        </div>
    </div>

    <br>

    <!-- <div id="divItemNota" class="grid-4-12_50_18_20">
        <div class="bg-color-orange-1">Jumlah</div>
        <div>Nama Barang</div>
        <div>Hrg./pcs</div>
        <div>Harga</div>
    </div> -->
    <hr style="height: 2px; background-color: black; margin-bottom: 0.2em; margin-top: 0;">
    <table id="tableItemNota" style="width: 100%;">
        <tr class="tr-border-bottom tr-border-left-right">
            <th>Jumlah</th>
            <th>Nama Barang</th>
            <th>Hrg./pcs</th>
            <th>Harga</th>
        </tr>
    </table>
</div>

<style>
    #containerDetailNota {
        font-family: 'Roboto';
        font-weight: normal;
        font-style: normal;
        /* font-size: 0.8em; */
    }

    #tableItemNota {
        border-collapse: collapse;
        border-top: 1px solid black;
    }

    .tr-border-bottom th {
        border-bottom: 1px solid black;
        padding-top: 1em;
        padding-bottom: 1em;
    }

    .tr-border-bottom td {
        border-bottom: 1px solid black;
    }

    .tr-border-left-right th,
    .tr-border-left-right td {
        border-left: 1px solid black;
        border-right: 1px solid black;
    }

    .height-1_5em td {
        height: 1.5em;
    }

    .blrb-total {
        border-left: 1px solid black;
        border-right: 1px solid black;
    }

    @media print {
        .bg-color-orange-1 {
            background-color: #FFED50;
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<script>
    let notaToPrint = localStorage.getItem('notaToPrint');
    notaToPrint = JSON.parse(notaToPrint);
    $('#noNota').html(notaToPrint.noNota);
    $('#tglNota').html(notaToPrint.tglNota);
    $('#custName').html(notaToPrint.namaCust);
    $('#alamatCust').html(notaToPrint.alamatCust);

    for (const item of notaToPrint.itemSPK) {
        // let htmlItem =
        //     `
        // <div>${item.jumlah}</div><div>${item.nama}</div><div>${item.hargaPcs}</div><div>${item.harga}</div>
        // `;
        // $('#divItemNota').append(htmlItem);

        let htmlItem =
            `
        <tr class='tr-border-left-right height-1_5em'><td>${item.jumlah}</td><td>${item.nama}</td><td>${item.hargaPcs}</td><td>${item.harga}</td></tr>
        `;
        $('#tableItemNota').append(htmlItem);
    }

    let restRow = 16 - notaToPrint.itemSPK.length;
    console.log(restRow);

    for (let i = 0; i < restRow; i++) {
        let htmlRestRow =
            `
        <tr class='tr-border-left-right height-1_5em'><td></td><td></td><td></td><td></td></tr>
        `;
        $('#tableItemNota').append(htmlRestRow);
    }

    let htmlLastRow =
        `
    <tr class='tr-border-left-right tr-border-bottom'><td></td><td></td><td></td><td></td></tr>
    `;

    $('#tableItemNota').append(htmlLastRow);

    let htmlTotalHarga =
        `
        <tr><td></td><td></td>
        <td class='blrb-total'>Total Harga</td>
        <td class='blrb-total'>${notaToPrint.hargaTotalSPK}</td>
        </tr>
        `;

    $('#tableItemNota').append(htmlTotalHarga);
</script>
<?php
include_once "01-footer.php";
?>