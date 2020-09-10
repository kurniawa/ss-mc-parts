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
                // DATA UNTUK PAGE DETAIL CUSTOMER
                $("#customerAbbr").html($customer[0].singkatan);
                $("#customerName").html($customer[0].nama);
                $customerAddress = $customer[0].alamat.replace(new RegExp('\r?\n', 'g'), '<br />');
                $("#customerInfo").html($customerAddress).append("<br>" + $customer[0].kontak);

                // DATA UNTUK PAGE EDIT DATA CUSTOMER
                $("#nama").val($customer[0].nama);
                $("#alamat").val($customer[0].alamat);
                $("#pulau").val($customer[0].pulau);
                $("#daerah").val($customer[0].daerah);
                $("#kontak").val($customer[0].kontak);
                $("#singkatan").val($customer[0].singkatan);
                $("#keterangan").val($customer[0].keterangan);

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
                        $idExpeditionAll = JSON.parse(responseText);
                        console.log($idExpeditionAll);

                        $index = 1;
                        for (const $eachExpeditionID of $idExpeditionAll) {

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
                                    $expedition = JSON.parse(responseText);
                                    console.log($expedition);

                                    if ($eachExpeditionID.expedisi_transit == 'y') {
                                        $tipeEkspedisi = "inputEkspedisiTransit";
                                        $placeholder = "Ekspedisi Transit";
                                    } else {
                                        $tipeEkspedisi = "inputEkspedisiNormal";
                                        $placeholder = "Ekspedisi Normal";
                                    }

                                    $address = $expedition[0].alamat.replace(new RegExp('\r?\n', 'g'), '<br>');
                                    $("#customerExpedition").append($address);

                                    // APPEND input-input ekspedisi untuk pelanggan ini
                                    $htmlToAppend = '<div id="divInputID-' + $index + '" class="containerInputEkspedisi grid-2-auto_15 mb-1em">' +
                                        '<div class="bb-1px-solid-grey">' +

                                        '<input id="inputID-' + $index + '" class="inputEkspedisiAll ' + $tipeEkspedisi +
                                        ' input-1 pb-1em bb-none" type="text" placeholder="' + $placeholder +
                                        '" onkeyup="searchEkspedisi(' + $index + ');" value="' + $expedition[0].nama + '">' +

                                        '<div id="searchResults-' + $index + '" class="d-none b-1px-solid-grey bb-none"></div>' +
                                        '</div>' +
                                        '<div class="btnTambahKurangEkspedisi justify-self-right grid-1-auto circle-medium bg-color-soft-red" onclick="btnKurangEkspedisi(' + $index + ');">' +
                                        '<div class="justify-self-center w-1em h-0_3em bg-color-white b-radius-50px"></div>' +
                                        '</div>' +
                                        '</div>';

                                    $("#divInputEkspedisi").append($htmlToAppend);
                                    $index++;

                                }
                            });

                        }

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
        history.pushState(1, null, "./edit-customer");
    }

    function backToCustomer() {
        window.location.replace("04-01-pelanggan.php");
    }

    function btnKurangEkspedisi($id) {
        console.log("btnKurangEkspedisi");
        $("#divInputID-" + $id).remove();
        $("#searchResults-" + $id).removeClass("grid-1-auto").addClass("d-none");
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

<!-- PAGE: EDIT CUSTOMER -->

<div id="pageEditCustomer" class="d-none">
    <div class="header"></div>

    <div class="mt-1em ml-1em grid-2-10_auto">
        <div class="">
            <img class="w-2em" src="img/icons/pencil.svg" alt="Data Pelanggan Baru">
        </div>
        <div class="font-weight-bold">
            Edit Data Pelanggan
        </div>
    </div>

    <div class="ml-1em mr-1em mt-2em">
        <input id="nama" class="input-1 pb-1em" type="text" placeholder="Nama/Perusahaan/Pabrik">
        <textarea class="mt-1em pt-1em pl-1em text-area-mode-1" name="alamat" id="alamat" placeholder="Alamat"></textarea>
        <div class="grid-2-auto grid-column-gap-1em mt-1em">
            <input id="pulau" class="input-1 pb-1em" type="text" placeholder="Pulau">
            <input id="daerah" class="input-1 pb-1em" type="text" placeholder="Daerah">
        </div>
        <div class="grid-2-auto grid-column-gap-1em mt-1em">
            <input id="kontak" class="input-1 pb-1em" type="text" placeholder="No. Kontak">
            <input id="singkatan" class="input-1 pb-1em" type="text" placeholder="Singkatan (opsional)">
        </div>

        <div id="divInputEkspedisi" class="mt-1em">
        </div>

        <!-- MENAMBAHKAN EKSPEDISI UNTUK PELANGGAN INI -->

        <div class="grid-1-auto justify-items-center">
            <div class="bg-color-orange-1 pl-1em pr-1em pt-0_5em pb-0_5em b-radius-50px" onclick="showPertanyaanEkspedisiTransit();">+ Tambah Ekspedisi</div>
        </div>
        <textarea id="keterangan" class="mt-1em pt-1em pl-1em text-area-mode-1" name="alamat" placeholder="Keterangan lain (opsional)"></textarea>
    </div>

    <div class="grid-2-10_auto_auto mt-1em ml-1em mr-1em">
        <div class="">
            <img class="w-2em" src="img/icons/speech-bubble.svg" alt="Reseller?">
        </div>
        <div class="font-weight-bold">
            Apakah ingin menambahkan Reseller?
        </div>
        <div>
            <div id="divToggleReseller" class="position-relative b-radius-50px b-1px-solid-grey bg-color-grey w-4_5em h-1_5em" onclick="showInputReseller();">
                <div id="toggleReseller" class="position-absolute w-3em text-center b-radius-50px b-1px-solid-grey color-grey bg-color-white">tidak</div>
            </div>
        </div>
    </div>

    <div id="divInputNamaReseller" class="d-none ml-2em mr-2em mt-1em b-1px-solid-grey p-1em">
        <input class="input-1 pb-1em" type="text" placeholder="Nama Reseller">

    </div>

    <br><br>

    <!-- Warning apabila ada yang kurang -->

    <div id="warning" class="d-none"></div>

    <div>
        <div class="m-1em h-4em bg-color-orange-2 grid-1-auto" onclick="inputPelangganBaru();">
            <span class="justify-self-center font-weight-bold">Input Pelanggan Baru</span>
        </div>
    </div>

    <div id="closingAreaPertanyaan" class="d-none position-absolute z-index-2 w-100vw h-100vh bg-color-grey top-0 opacity-0_5">
    </div>

    <div class="position-absolute z-index-3 top-50vh grid-1-auto w-100vw">
        <div id="pertanyaanEkspedisiTransit" class="d-none justify-self-center bg-color-white p-1em">
            <div class="grid-2-auto">
                <div><img class="w-2em" src="img/icons/speech-bubble.svg" alt=""></div>
                <div>
                    <h3>
                        Apakah Anda ingin menambahkan Ekspedisi Transit?
                    </h3>
                </div>
            </div>
            <div class="grid-2-auto justify-items-center">
                <div class="color-soft-red" onclick="addInputEkspedisi('tidak')">
                    <h3>Tidak</h3>
                </div>
                <div class="color-bright-green" onclick="addInputEkspedisi('ya')">
                    <h3>Ya</h3>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('popstate', (event) => {
            console.log("location: " + document.location + ", state: " + JSON.stringify(event.state));
            console.log(event.state);
            $("#pageDetailCustomer").toggle(1000);
            $("#pageEditCustomer").toggle(1000);
        });
    </script>
</div>

<script>
    function showInputReseller() {
        if ($("#toggleReseller").html() == "tidak") {
            $("#toggleReseller").animate({
                left: "1.35em"
            }, 200);
            $("#divToggleReseller").css("background-color", "#FFED50");
            $("#toggleReseller").html("ya");

            $("#divInputNamaReseller").toggle(200);
        } else {

            $("#toggleReseller").animate({
                left: '0em'
            }, 200);
            $("#divToggleReseller").css("background-color", "#E4E4E4");
            $("#toggleReseller").html("tidak");

            $("#divInputNamaReseller").toggle(200);
        }
    }
    window.addEventListener('popstate', (event) => {
        console.log("location: " + document.location + ", state: " + JSON.stringify(event.state));
        console.log(event.state);
        $("#pageDetailCustomer").toggle(1000);
        $("#pageEditCustomer").toggle(1000);
        // if (event.state == null) {
        //     $("#pageDetailCustomer").toggle(1000);
        //     $("#pageEditCustomer").toggle(1000);

        // } else if (event.state == 1) {
        //     $("#closingAreaPertanyaan").css("display", "none");
        //     $("#pertanyaanEkspedisiTransit").css("display", "none");
        // }

    });

    function showPertanyaanEkspedisiTransit() {
        history.pushState(2, null, "./pertanyaan-ekspedisi-transit");
        $("#closingAreaPertanyaan").toggle(300);
        $("#pertanyaanEkspedisiTransit").toggle(300);
    }
</script>

<!-- END: PAGE EDIT CUSTOMER -->

<?php
include_once "01-footer.php";
?>