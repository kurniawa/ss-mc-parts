<?php
include_once "01-header.php";
?>

<div class="header"></div>

<div id="SPKBaru">

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
            <input type="date" class="input-select-option-1 pb-1em" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">
        </div>

        <div id="divInputCustomerName" class="containerInputEkspedisi mt-1em mb-1em">
            <div class="bb-1px-solid-grey">
                <input id="inputCustomerName" class="input-1 pb-1em bb-none" type="text" placeholder="Pelanggan" onkeyup="findCustomer(this.value);">
                <div id="searchResults" class="d-none b-1px-solid-grey bb-none"></div>
            </div>
        </div>

        <input id="titleDesc" class="input-1 mt-1em pb-1em" type="text" placeholder="Keterangan Judul (opsional)">


    </div>


    <br><br>

    <div id="warning" class="d-none"></div>

    <div>
        <div class="m-1em h-4em bg-color-orange-2 grid-1-auto" onclick="beginInsertingProducts();">
            <span class="justify-self-center font-weight-bold">Mulai Proses SPK >></span>
        </div>
    </div>

    <div id="closingAreaPertanyaan" class="d-none position-absolute z-index-2 w-100vw h-100vh bg-color-grey top-0 opacity-0_5">
    </div>

</div>

<script>
    // deklarasi data-data dari localStorage dataSPKToEdit
    dataSPK = JSON.parse(localStorage.getItem('dataSPKToEdit'));
    console.log(dataSPK);

    // assign data-data yang ada ke html

    // history.pushState({
    //     page: 'newSPK'
    // }, null);

    // $(document).ready(function() {
    // let lastID = getLastID("spk");
    // console.log(lastID);
    // lastID = JSON.parse(lastID);
    // console.log('lastID for SPK Number: ' + lastID[1]);

    // let SPKNo = lastID[1];

    // $("#SPKNo").val(SPKNo);
    // Set juga untuk halaman berikutnya ketika mau mulai masukkan produk
    // $(".divSPKNumber").html(SPKNo);
    // });

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
                    `<input id='inputChosenValue-${$idResult}' type='hidden' value='${result.id}'>`;
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
        $searchResults = $("#searchResults");
        $inputCustomerName.val($chosenValue.html());
        // $searchResults.remove();
        $searchResults.removeClass("grid-1-auto").addClass("d-none");

        // Set juga untuk halaman berikutnya ketika mau mulai masukkan produk
        $(".divSPKCustomer").html($chosenValue.html());
        $('#inputIDCustomer').val($idChosenValue);
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

    async function insertNewSPK() {
        console.log('SPKNo: ' + SPKNo);
        let result = [];
        let SPKDate = formatDate($('#date').val());
        let customerName = $('#inputCustomerName').val();
        let customerID = $('#inputIDCustomer').val();
        let titleDesc = $('#titleDesc').val();

        console.log('SPKDate: ' + SPKDate);
        console.log('customerName: ' + customerName);
        console.log('customerID: ' + customerID);
        console.log('titleDesc: ' + titleDesc);

        $.ajax({
            type: "POST",
            url: "01-crud.php",
            async: false,
            data: {
                type: 'insert',
                table: 'spk',
                column: ['id', 'tgl_pembuatan', 'ket_judul', 'id_pelanggan'],
                value: [SPKNo, SPKDate, titleDesc, customerID],
                dateIndex: 1,
                idToReturn: SPKNo
            },
            success: function(res) {
                res = JSON.parse(res);
                console.log(res);
                result = res;
            }
        });
        console.log('result insertNewSPK(): ' + result);
        return result;
    }
</script>

<style>

</style>

<?php
include_once "01-footer.php";
?>