<?php
include_once '01-header.php';
?>

<header class="header"></header>

<div id="containerPrintOutSPK" class="p-0_5em">

    <div id="divTableToPrint"></div>

    <br><br>

    <div class="text-center">
        <div id='goToMainMenu' class="btn-1 d-inline-block bg-color-orange-1">Kembali ke Menu Utama</div>
    </div>

</div>

<script>
    let spkToPrint;
    if (localStorage.getItem('newSPK') != null) {
        spkToPrint = localStorage.getItem('newSPK');
        spkToPrint = JSON.parse(spkToPrint);
        console.log(spkToPrint);
    } else {
        spkToPrint = localStorage.getItem('spkToPrint');
        spkToPrint = JSON.parse(spkToPrint);
        console.log(spkToPrint);
    }

    let htmlTable =
        `
    <table style="width: 100%;">
    <tr>
        <td colspan="3" style="text-align: center;">SURAT PERINTAH KERJA<br>PENGAMBILAN STOK</td>
    </tr>
    <tr>
        <td>NO</td>
        <td>: ${spkToPrint.id}</td>
        <td style='text-align: right;'>ASLI</td>
    </tr>
    <tr>
        <td>TGL</td>
        <td>: ${spkToPrint.date}</td>
        <td></td>
    </tr>
    <tr>
        <td>UNTUK</td>
        <td>: ${spkToPrint.custName}-${spkToPrint.daerah}</td>
        <td></td>
    </tr>
    <tr>
        <th colspan='2'>ITEM PRODUKSI</th>
        <th>JUMLAH</th>
    </tr>

    `;

    for (const spkItem of spkToPrint.item) {
        if (spkItem.desc !== '') {
            htmlTable = htmlTable +
                `
            <tr>
                <td colspan='2'>${spkItem.namaLengkap} :</td>
                <td>${spkItem.jumlah}</td>
            </tr>
            <tr>
                <td colspan='2'>${spkItem.desc}</td>
                <td></td>
            </tr>
            `;
        } else {
            htmlTable = htmlTable +
                `
            <tr>
                <td colspan='2'>${spkItem.namaLengkap}</td>
                <td>${spkItem.jumlah}</td>
            </tr>
            `;
        }
    }

    htmlTable = htmlTable + '</table>';

    $('#divTableToPrint').html(htmlTable);
    document.getElementById('goToMainMenu').addEventListener('click', event => {
        window.history.go(1 - (history.length));
    });
</script>

<?php
include_once '01-footer.php';
?>