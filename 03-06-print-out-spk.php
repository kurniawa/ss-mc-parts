<?php
include_once '01-header.php';
include_once '01-config.php';

// PASTIKAN REQUEST METHOD nya: GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $status = "OK";
    $htmlLogOK = $htmlLogOK . "REQUEST METHOD: GET<br><br>";
} else {
    $status = "NOT OK";
    $htmlLogError = $htmlLogError . "REQUEST METHOD: ENTAHLAH!<br><br>";
}

// DECLARE semua variable yang di get
if ($status == "OK") {
    $id_spk = $_GET["id_spk"];

    $htmlLogOK = $htmlLogOK .
        "id_spk: $id_spk<br><br>";

    // MULAI GET data SPK
    $table_spk = "spk";
    $filter_spk = "id";

    $spk = dbGetWithFilter($table_spk, $filter_spk, $id_spk);
}

// MULAI GET pelanggan
if ($spk !== "ERROR") {
    $table_pelanggan = "pelanggan";
    $filter_table_pelanggan = "id";
    $filter_value_table_pelanggan = $spk[0]["id_pelanggan"];

    $pelanggan = dbGetWithFilter($table_pelanggan, $filter_table_pelanggan, $filter_value_table_pelanggan);
}

// MULAI GET spk_contains_produk dan produk
if ($spk !== "ERROR" && $pelanggan !== "ERROR") {
    $table_spk_contains_produk = "spk_contains_produk";
    $filter_spk_contains_produk = "id_spk";
    $filter_value_spk_contains_produk = $id_spk;
    $spk_contains_produk = dbGetWithFilter($table_spk_contains_produk, $filter_spk_contains_produk, $filter_value_spk_contains_produk);

    $array_produk = array();
    if ($spk_contains_produk !== "ERROR") {
        for ($i = 0; $i < count($spk_contains_produk); $i++) {
            $table_produk = "produk";
            $filter_produk = "id";
            $filter_value_produk = $spk_contains_produk[$i]["id_produk"];

            $produk = dbGetWithFilter($table_produk, $filter_produk, $filter_value_produk);
            if ($produk !== "ERROR") {
                array_push($array_produk, $produk[0]);
            } else {
                break;
            }
        }
    }
}

$htmlLogError = $htmlLogError . "</div>";
$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogWarning = $htmlLogWarning . "</div>";
?>

<header class="header"></header>

<div id="containerPrintOutSPK" class="p-0_5em">

    <div id="divTableToPrint"></div>

    <br><br>

    <form action="03-07-hapus-spk-item.php" method="POST">
        <div class="text-center">
            <button type="submit" id='goToMainMenu' class="btn-1 d-inline-block bg-color-orange-1">Kembali ke SPK</button>
        </div>

    </form>

</div>

<div class="divLogError"></div>
<div class="divLogWarning"></div>
<div class="divLogOK"></div>
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

    var status = '<?= $status; ?>';
    console.log('status: ' + status);

    var spk, pelanggan, spk_contains_produk, produk;

    if (status == "OK") {
        spk = <?= json_encode($spk); ?>;
        pelanggan = <?= json_encode($pelanggan); ?>;
        spk_contains_produk = <?= json_encode($spk_contains_produk); ?>;
        produk = <?= json_encode($array_produk); ?>;

        console.log("spk:");
        console.log(spk);

        console.log("pelanggan:");
        console.log(pelanggan);

        console.log("spk_contains_produk:");
        console.log(spk_contains_produk);

        console.log("produk:");
        console.log(produk);
    }

    // Perbaikan mulai dari sini
    // let spkToPrint;
    // if (localStorage.getItem('dataSPKToPrint') != null) {
    //     spkToPrint = localStorage.getItem('dataSPKToPrint');
    //     spkToPrint = JSON.parse(spkToPrint);
    //     console.log(spkToPrint);
    // } else {
    //     spkToPrint = localStorage.getItem('dataSPKToPrint');
    //     spkToPrint = JSON.parse(spkToPrint);
    //     console.log(spkToPrint);
    // }

    var htmlTable =
        `
    <table style="width: 100%;">
    <tr>
        <td colspan="3" style="text-align: center;">SURAT PERINTAH KERJA<br>PENGAMBILAN STOK</td>
    </tr>
    <tr>
        <td>NO</td>
        <td>: ${spk[0].id}</td>
        <td style='text-align: right;'>ASLI</td>
    </tr>
    <tr>
        <td>TGL</td>
        <td>: ${spk[0].tgl_pembuatan}</td>
        <td></td>
    </tr>
    <tr>
        <td>UNTUK</td>
        <td>: ${pelanggan[0].nama}-${pelanggan[0].daerah}</td>
        <td></td>
    </tr>
    <tr>
        <th colspan='2'>ITEM PRODUKSI</th>
        <th>JUMLAH</th>
    </tr>

    `;

    var jumlahTotalItem = 0;

    for (var i = 0; i < spk_contains_produk.length; i++) {
        console.log(produk[i]);
        if (spk_contains_produk[i].ktrg !== '') {
            htmlTable = htmlTable +
                `
            <tr>
                <td colspan='2'>${produk[i].nama_lengkap} :</td>
                <td>${spk_contains_produk[i].jumlah}</td>
            </tr>
            <tr>
                <td colspan='2' style='font-style: italic;'>${spk_contains_produk[i].ktrg.replace(new RegExp('\r?\n', 'g'), '<br />')}</td>
                <td></td>
            </tr>
            `;
        } else {
            htmlTable = htmlTable +
                `
            <tr>
                <td colspan='2'>${produk[i].nama_lengkap}</td>
                <td>${spk_contains_produk[i].jumlah}</td>
            </tr>
            `;
        }

        jumlahTotalItem = jumlahTotalItem + parseFloat(spk_contains_produk[i].jumlah);
    }

    // for (const spkItem of spk_contains_produk) {
    //     if (spkItem.desc !== '') {
    //         htmlTable = htmlTable +
    //             `
    //         <tr>
    //             <td colspan='2'>${spkItem.nama_lengkap} :</td>
    //             <td>${spkItem.jumlah}</td>
    //         </tr>
    //         <tr>
    //             <td colspan='2' style='font-style: italic;'>${spkItem.ktrg.replace(new RegExp('\r?\n', 'g'), '<br />')}</td>
    //             <td></td>
    //         </tr>
    //         `;
    //     } else {
    //         htmlTable = htmlTable +
    //             `
    //         <tr>
    //             <td colspan='2'>${spkItem.nama_lengkap}</td>
    //             <td>${spkItem.jumlah}</td>
    //         </tr>
    //         `;
    //     }

    //     jumlahTotalItem = jumlahTotalItem + parseFloat(spkItem.jumlah);
    // }

    htmlTable = htmlTable +
        `
        <tr>
            <td colspan='2' style='font-weight: bold; text-align: right;'>
                Total
                <div style='display: inline-block;width: 0.5em;'></div>
            </td>
            <td style='font-weight: bold;'>${jumlahTotalItem}</td>
        </tr>
        </table>
        `;


    $('#divTableToPrint').html(htmlTable);
    // document.getElementById('goToMainMenu').addEventListener('click', event => {
    //     localStorage.removeItem('dataSPKToPrint');
    //     window.history.go(1 - (history.length));
    // });
</script>

<style>
    table {
        border-collapse: collapse;
        border: 1px solid black;
    }

    table td {
        border: 1px solid black;
    }
</style>

<?php
include_once '01-footer.php';
?>