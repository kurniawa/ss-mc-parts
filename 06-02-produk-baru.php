<?php
include_once "01-header.php";
?>

<div class="header"></div>

<div id="containerNewProduct" class="mt-0_5em ml-0_5em mr-0_5em">

    <div class="grid-2-10_auto">
        <div class="">
            <img class="w-2em" src="img/icons/speech-bubble.svg" alt="">
        </div>
        <div class="font-weight-bold">
            Ada produk baru ya?
            <br>
            Pilih tipe produk terlebih dahulu ya!
        </div>
    </div>

    <div class="grid-3-auto justify-items-center mt-4em grid-row-gap-3em">
        <div>
            <img class="w-4em" src="img/icons/products.svg" alt="">
            <div class="text-center">SJ<br>Basic</div>
        </div>
        <div>
            <img class="w-4em" src="img/icons/products.svg" alt="">
            <div class="text-center">SJ<br>Kombi</div>
        </div>
        <div>
            <img class="w-4em" src="img/icons/products.svg" alt="">
            <div class="text-center">SJ<br>Standard</div>
        </div>
        <div>
            <img class="w-4em" src="img/icons/products.svg" alt="">
            <div class="text-center">Busa<br>Stang</div>
        </div>
        <div>
            <img class="w-4em" src="img/icons/products.svg" alt="">
            <div class="text-center">Tank<br>Pad</div>
        </div>
    </div>

</div>

<div id="closingAreaPertanyaan" class="d-none position-absolute z-index-2 w-100vw h-100vh bg-color-grey top-0 opacity-0_5">
</div>

<script>
    $(document).ready(function() {
        $("#containerBeginSPK").css("display", "none");
        let lastID = getLastID("spk");
        console.log(lastID);
        lastID = JSON.parse(lastID);
        console.log(lastID[1]);

        let SPKNo = parseFloat(lastID[1]) + 1;

        $("#SPKNo").val(SPKNo);
        // Set juga untuk halaman berikutnya ketika mau mulai masukkan produk
        $(".divSPKNumber").html(SPKNo);
    });

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
                    result.nama + "</div>";
                $idResult++;
            }

            $("#searchResults").html($htmlToAppend);
            $("#searchResults").removeClass("d-none").addClass("grid-1-auto");

        }

    }

    function pickChoice($idResult) {
        $inputCustomerName = $("#inputCustomerName");
        $chosenValue = $("#chosenValue-" + $idResult);
        $searchResults = $("#searchResults");
        $inputCustomerName.val($chosenValue.html());
        // $searchResults.remove();
        $searchResults.removeClass("grid-1-auto").addClass("d-none");

        // Set juga untuk halaman berikutnya ketika mau mulai masukkan produk
        $(".divSPKCustomer").html($chosenValue.html());
    }

    function beginInsertingProducts() {
        if ($("#SPKBaru").css("display") === "block") {
            $("#SPKBaru").toggle();
            $("#containerBeginSPK").toggle();
            let SPKDate = formatDate($("#date").val());

            $(".divSPKDate").html(SPKDate);
            $(".divTitleDesc").html($("#description").val());
        }
    }
</script>

<style>
    .icon-small-circle {
        border-radius: 100%;
        width: 2.5em;
        height: 2.5em;
        position: relative;
    }

    .circle-medium {
        border-radius: 100%;
        width: 2.5em;
        height: 2.5em;
    }
</style>

<?php

include_once "01-footer.php";
?>