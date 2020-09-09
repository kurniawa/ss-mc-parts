<?php
include_once "01-header.php";
// var_dump($_GET["id"]);

$id = $_GET["id"];
?>
<div id="pageDetailCustomer">
    <div class="header grid-2-auto">
        <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="backToCustomer();">

        <div class="grid-1-auto justify-self-right grid-row-gap-0_2em mr-1_5em z-index-3" onclick="showMenu();">
            <div class="w-0_4em h-0_4em b-radius-100 bg-color-white"></div>
            <div class="w-0_4em h-0_4em b-radius-100 bg-color-white"></div>
            <div class="w-0_4em h-0_4em b-radius-100 bg-color-white"></div>
        </div>
    </div>

    <div id="showDotMenuContent" class="position-absolute bg-color-white z-index-3">
        <div class="dotMenuItem grid-2-auto grid-column-gap-0_5em pl-1em pr-1em pt-0_5em pb-0_5em" onclick="moveToPageEditCustomer();">
            <img class="w-1em" src="img/icons/edit.svg" alt="">
            <div class="">Edit</div>
        </div>
    </div>

    <div id="areaClosingDotMenu" onclick="closingDotMenuContent();"></div>

    <div class="ml-1em mr-0_5em mt-0_5em">
        <div class="grid-1-auto justify-items-center">
            <div id="customerAbbr" class="circle-medium bg-color-soft-red grid-1-auto font-weight-bold justify-items-center">SS</div>
            <h2 id="customerName" class="">Nama Customer</h2>
        </div>
    </div>

    <!-- INFO PELANGGAN DAN EKSPEDISI -->
    <div class="grid-2-50_50 ml-0_5em mr-0_5em">

        <div class="b-1px-solid-grey mr-0_25em p-0_5em">

            <div class="h-10em">
                <div class="grid-1-auto justify-items-center">
                    <img class="w-2_5em" src="img/icons/real-estate.svg" alt="">
                </div>
                <div id="customerInfo" class="mt-0_5em font-size-0_9em font-weight-bold">Alamat Customer</div>
            </div>

            <div class="grid-1-auto justify-items-right">
                <img class="w-1em" src="img/icons/edit-grey.svg" alt="">
            </div>

        </div>

        <div class="b-1px-solid-grey ml-0_25em p-0_5em">

            <div class="h-10em">
                <div class="grid-1-auto justify-items-center">
                    <img class="w-2_5em" src="img/icons/shipment.svg" alt="">
                </div>
                <div id="customerExpedition" class="mt-0_5em font-size-0_9em font-weight-bold">Info Ekspedisi</div>
            </div>

            <div class="grid-1-auto justify-items-right">
                <img class="w-1em" src="img/icons/edit-grey.svg" alt="">
            </div>

        </div>

    </div>
    <!-- END - INFO PELANGGAN DAN EKSPEDISI -->

    <!-- DAFTAR PRODUK CUSTOMER INI -->
    <div class="ml-0_5em mr-0_5em mt-1em">

        <div class="grid-2-10-auto grid-row-gap-0_5em">
            <img class="w-2_5em" src="img/icons/shopping-cart.svg" alt="">
            <div id="">Daftar Produk Orderan Pelanggan ini:</div>
        </div>
    </div>
    <!-- END - DAFTAR PRODUK CUSTOMER INI -->
</div>
<script>
    $id = <?php echo $id ?>;
    $(document).ready(function() {
        $.ajax({
            url: "01-get.php",
            type: "POST",
            async: false,
            data: {
                id: $id,
                table: "pelanggan",
                column: "id"
            },
            success: function(responseText) {
                console.log(responseText);
                $customer = JSON.parse(responseText);
                console.log($customer);
                $("#customerAbbr").html($customer[0].singkatan);
                $("#customerName").html($customer[0].nama);
                $customerAddress = $customer[0].alamat.replace(new RegExp('\r?\n', 'g'), '<br />');
                $("#customerInfo").html($customerAddress).append("<br>" + $customer[0].kontak);
                $.ajax({
                    url: "01-get.php",
                    type: "POST",
                    async: false,
                    data: {
                        id: $customer[0].id,
                        table: "pelanggan_use_ekspedisi",
                        column: "id_pelanggan"
                    },
                    success: function(responseText) {
                        console.log(responseText);
                        $idExpeditionForThisCustomer = JSON.parse(responseText);
                        console.log($idExpeditionForThisCustomer);

                        $.ajax({
                            url: "01-get.php",
                            type: "POST",
                            async: false,
                            data: {
                                id: $customer[0].id,
                                table: "ekspedisi",
                                column: "id"
                            },
                            success: function(responseText) {
                                console.log(responseText);
                                $expeditionForThisCustomer = JSON.parse(responseText);
                                console.log($expeditionForThisCustomer);
                                $expeditionAddress = $expeditionForThisCustomer[0].alamat.replace(new RegExp('\r?\n', 'g'), '<br>');
                                $("#customerExpedition").html($expeditionAddress);
                            }
                        });
                    }
                });
            }
        });
    });

    function showMenu() {
        $("#showDotMenuContent").toggle(200);
        $("#areaClosingDotMenu").css("display", "block");

    }

    function closingDotMenuContent() {
        $("#showDotMenuContent").toggle();
        $("#areaClosingDotMenu").css("display", "none");

    }

    function moveToPageEditCustomer() {
        $("#pageDetailCustomer").toggle(1000);
        $("#pageEditCustomer").toggle(1000);
        $("#showDotMenuContent").toggle();
        $("#areaClosingDotMenu").toggle();
        history.pushState(null, null, "./edit-customer");
    }

    function backToCustomer() {
        window.location.replace("04-01-pelanggan.php");
    }
</script>
<style>
    #showDotMenuContent {
        display: none;
        top: 3em;
        right: 1.5em;
        border: 1px solid #E4E4E4;
    }

    .dotMenuItem:hover {
        background-color: grey;
    }

    #areaClosingDotMenu {
        display: none;
        position: absolute;
        top: 0;
        width: 100vw;
        height: 100vh;
        z-index: 2;
        /* border: 1px solid red; */
    }
</style>

<div id="pageEditCustomer">

</div>

<script>
    window.addEventListener('popstate', (event) => {
        console.log("location: " + document.location + ", state: " + JSON.stringify(event.state));
        $("#pageDetailCustomer").toggle(1000);
        $("#pageEditCustomer").toggle(1000);
    });
</script>

<?php
include_once "01-footer.php";
?>