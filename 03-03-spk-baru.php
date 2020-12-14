<?php
include_once "01-header.php";
include_once "01-config.php";
?>

<header class="header grid-2-auto">
    <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="goBack();">
    <div class="justify-self-right pr-0_5em">
        <!-- <a href="06-02-produk-baru.php" id="btnNewProduct" class="btn-atas-kanan2">
            + Tambah Produk Baru
        </a> -->
    </div>
</header>
<form action="03-03-01-begin-inserting-products.php" method="GET" id="SPKBaru">

    <div class="mt-1em ml-1em grid-2-10_auto">
        <div class="">
            <img class="w-2em" src="img/icons/pencil.svg" alt="">
        </div>
        <div class="font-weight-bold">
            Untuk siapa SPK ini?
        </div>
    </div>

    <div class="ml-0_5em mr-0_5em mt-2em">

        <div class="grid-2-auto grid-column-gap-1em mt-1em">
            <input id="SPKNo" class="input-1 pb-1em" type="text" placeholder="No." disabled>
            <input type="date" class="input-select-option-1 pb-1em" name="tanggal" id="date" value="<?php echo date('Y-m-d'); ?>">
        </div>

        <div id="divInputCustomerName" class="containerInputEkspedisi mt-1em mb-1em">
            <div class="bb-1px-solid-grey">
                <input id="inputCustomerName" class="input-1 pb-1em bb-none" name="nama_pelanggan" type="text" placeholder="Pelanggan" onkeyup="findCustomer(this.value);">
                <div id="searchResults" class="d-none b-1px-solid-grey bb-none"></div>
                <input id="daerahCust" type="hidden" name="daerah">
                <input id="inputIDCust" type="hidden" name="id_pelanggan">
            </div>
        </div>

        <input name="ket_judul" id="titleDesc" class="input-1 mt-1em pb-1em" type="text" placeholder="Keterangan Judul (opsional)">


    </div>


    <br><br>

    <div id="warning" class="d-none"></div>

    <div class="m-1em">
        <!-- <button type="submit" class="w-100 h-4em bg-color-orange-2 grid-1-auto" onclick="beginInsertingProducts();"> -->
        <button type="submit" class="w-100 h-4em bg-color-orange-2 grid-1-auto">
            <span class="justify-self-center font-weight-bold">Mulai Proses SPK >></span>
        </button>
    </div>

    <div id="closingAreaPertanyaan" class="d-none position-absolute z-index-2 w-100vw h-100vh bg-color-grey top-0 opacity-0_5">
    </div>

</form>


<script>
    // // history.pushState({
    // //     page: 'newSPK'
    // // }, null);

    // // $(document).ready(function() {
    // let lastID = getLastID("spk");
    // console.log(lastID);
    // lastID = JSON.parse(lastID);
    // console.log('lastID for SPK Number: ' + lastID[1]);

    // let SPKNo = lastID[1];

    // $("#SPKNo").val(SPKNo);
    // // Set juga untuk halaman berikutnya ketika mau mulai masukkan produk
    // $(".divSPKNumber").html(SPKNo);
    // // });

    // $i = 0;

    function cekEkspedisi(params) {
        console.log(params);
        $idToReturn = "";
        if (params != "") {
            $.ajax({
                type: "POST",
                url: "04-04-cek-ekspedisi.php",
                async: false,
                data: {
                    nama: params
                },
                success: function(responseText) {
                    console.log(responseText);
                    $idToReturn = responseText;
                }
            });
        }
        console.log($idToReturn);
        return $idToReturn;

    }

    function findCustomer(customerName) {
        console.log(customerName);

        if (customerName === "") {
            $("#searchResults").html("").removeClass("grid-1-auto").addClass("d-none");
        }

        let results = liveSearch(customerName, "pelanggan", "nama");
        console.log(results);

        $htmlToAppend = "";

        if (results === "not found!") {
            $htmlToAppend = $htmlToAppend +
                "<div class='bb-1px-solid-grey hover-bg-color-grey pt-0_5em pb-0_5em pl-0_5em color-grey'>Pelanggan tidak ditemukan!</div>";
            $("#searchResults").html($htmlToAppend);

        } else {

            results = JSON.parse(results);
            console.log(results);

            if (results.length > 5) {
                results.splice(5);
            }
            $idResult = 0;
            for (const result of results) {
                $htmlToAppend = $htmlToAppend +
                    "<div id='chosenValue-" + $idResult + "' class='bb-1px-solid-grey hover-bg-color-grey pt-0_5em pb-0_5em pl-0_5em' onclick='pickChoice(" + $idResult + ")'>" +
                    result.nama + "</div>" +
                    `<input id='inputChosenValue-${$idResult}' type='hidden' value='${result.id}'>
                    <input id='inputChosenValueDaerah-${$idResult}' type='hidden' value='${result.daerah}'>`;
                $idResult++;
            }

            $("#searchResults").html($htmlToAppend);
            $("#searchResults").removeClass("d-none").addClass("grid-1-auto");

        }

    }

    function pickChoice($idResult) {
        $inputCustomerName = $("#inputCustomerName");
        $chosenValue = $("#chosenValue-" + $idResult);
        $idChosenValue = $(`#inputChosenValue-${$idResult}`).val();
        $custDaerah = $(`#inputChosenValueDaerah-${$idResult}`).val();
        $searchResults = $("#searchResults");
        $inputCustomerName.val($chosenValue.html());
        // $searchResults.remove();
        $searchResults.removeClass("grid-1-auto").addClass("d-none");

        // Set juga untuk halaman berikutnya ketika mau mulai masukkan produk
        $(".divSPKCustomer").html($chosenValue.html());
        $('#inputIDCust').val($idChosenValue);
        $('#daerahCust').val($custDaerah);
    }

    // function beginInsertingProducts() {
    //     if ($("#SPKBaru").css("display") === "block") {
    //         $("#SPKBaru").toggle();
    //         $("#containerBeginSPK").toggle();
    //         let SPKDate = formatDate($("#date").val());

    //         $(".divSPKDate").html(SPKDate);
    //         $(".divTitleDesc").html($("#titleDesc").val());
    //     }
    // }

    function beginInsertingProducts() {
        let dataSPK = {
            id: $('#SPKNo').val(),
            tglPembuatan: formatDate($('#date').val()),
            custName: $('#inputCustomerName').val(),
            custID: $('#inputIDCust').val(),
            daerah: $('#daerahCust').val(),
            ketSPK: $('#titleDesc').val(),
            keteranganTambahan: '',
            item: new Array()
        }
        localStorage.setItem('dataSPKToEdit', JSON.stringify(dataSPK));

        location.href = '03-03-01-inserting-items.php';
    }
</script>

<style>

</style>

<?php
// include_once "03-03-01-begin-inserting-products.php";
include_once "01-footer.php";
?>