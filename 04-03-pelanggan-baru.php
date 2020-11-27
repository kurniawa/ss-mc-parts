<?php
include_once "01-header.php";
?>

<div class="header"></div>

<div class="mt-1em ml-1em">
    <div class="d-inline">
        <img class="w-2em" src="img/icons/pencil.svg" alt="Data Pelanggan Baru">
    </div>
    <div class="d-inline font-weight-bold">
        Input Data Pelanggan Baru
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

    <!-- DROPDOWN MENU -->

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
        Apakah Pelanggan ini memiliki Reseller?
    </div>
    <div>
        <div id="divToggleReseller" class="position-relative b-radius-50px b-1px-solid-grey bg-color-grey w-4_5em" onclick="showInputReseller();">
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

    function showPertanyaanEkspedisiTransit() {
        history.pushState(null, null, "./pertanyaan-ekspedisi-transit");
        $("#closingAreaPertanyaan").toggle(300);
        $("#pertanyaanEkspedisiTransit").toggle(300);
    }
    window.onpopstate = function() {
        $("#closingAreaPertanyaan").css("display", "none");
        $("#pertanyaanEkspedisiTransit").css("display", "none");
    }

    $i = 0;

    function addInputEkspedisi($jawaban) {
        $("#closingAreaPertanyaan").css("display", "none");
        $("#pertanyaanEkspedisiTransit").css("display", "none");
        if ($jawaban == 'tidak') {
            $placeholder = "Ekspedisi";
            $tipeEkspedisi = "inputEkspedisiNormal";
        } else {
            $placeholder = "Ekspedisi Transit";
            $tipeEkspedisi = "inputEkspedisiTransit";
        }

        $newDiv = '<div id="divInputID-' + $i + '" class="containerInputEkspedisi grid-2-auto_15 mb-1em">' +
            '<div class="bb-1px-solid-grey">' +
            '<input id="inputID-' + $i + '" class="inputEkspedisiAll ' + $tipeEkspedisi + ' input-1 pb-1em bb-none" type="text" placeholder="' + $placeholder + '" onkeyup="searchEkspedisi(' + $i + ');">' +
            '<div id="searchResults-' + $i + '" class="d-none b-1px-solid-grey bb-none"></div>' +
            '</div>' +
            '<div class="btnTambahKurangEkspedisi justify-self-right grid-1-auto circle-medium bg-color-soft-red" onclick="btnKurangEkspedisi(' + $i + ');">' +
            '<div class="justify-self-center w-1em h-0_3em bg-color-white b-radius-50px"></div>' +
            '</div>' +
            '</div>';

        $("#divInputEkspedisi").append($newDiv);
        $i++;
        history.back();
    }

    function btnKurangEkspedisi($id) {
        console.log("btnKurangEkspedisi");
        $("#divInputID-" + $id).remove();
        $("#searchResults-" + $id).removeClass("grid-1-auto").addClass("d-none");
    }

    function inputPelangganBaru() {
        $nama = $("#nama").val();
        $alamat = $("#alamat").val();
        $pulau = $("#pulau").val();
        $daerah = $("#daerah").val();
        $kontak = $("#kontak").val();
        $singkatan = $("#singkatan").val();
        $keterangan = $("#keterangan").val();
        $warning = "";

        $lastID = getLastID('pelanggan');
        $lastID = JSON.parse($lastID);

        $arrayGaPenting = [$nama, $alamat, $pulau, $daerah, $kontak, $singkatan, $keterangan];
        console.log($arrayGaPenting);
        // Cek apakah nama, pulau, daerah nya belum terisi

        // Sebelum Insert, cek terlebih dahulu apakah ekspedisi yang diinput terdaftar di database
        // Sebelumnya cek dulu apakah input ekspedisi kosong

        console.log("$('.inputEkspedisiNormal').length : " + $(".inputEkspedisiNormal").length);
        console.log("$('.inputEkspedisiTransit').length : " + $(".inputEkspedisiTransit").length);
        var arrayEkspedisiNormalID = new Array();
        var arrayEkspedisiTransitID = new Array();
        console.log("arrayEkspedisiNormalID: " + arrayEkspedisiNormalID);
        console.log("arrayEkspedisiTransitID: " + arrayEkspedisiTransitID);

        if ($(".inputEkspedisiAll").length != 0) {

            $inputEkspedisiNormalIndex = 0;
            $inputEkspedisiTransitIndex = 0;

            $(".inputEkspedisiAll").each(function(index) {
                // cek ekspedisi sekaligus kalo emang ada, return id
                $resultCekEkspedisi = cekEkspedisi($(this).val());
                if ($resultCekEkspedisi === "No result!") {
                    $warning = $warning + "<div>Ekspedisi tidak sesuai. Silahkan input ulang ekspedisi atau tambahkan ekspedisi baru terlebih dahulu.</div>";
                    $("#warning").html($warning).removeClass("d-none");
                    return false;
                } else {

                    if ($(".inputEkspedisiNormal:eq(" + $inputEkspedisiNormalIndex + ")").val() == null) {
                        arrayEkspedisiTransitID.push($resultCekEkspedisi);
                        $inputEkspedisiTransitIndex++;
                    } else {
                        arrayEkspedisiNormalID.push($resultCekEkspedisi);
                        $inputEkspedisiNormalIndex++;
                    }
                }

            });

            console.log("arrayEkspedisiNormalID: " + JSON.stringify(arrayEkspedisiNormalID));
            console.log("arrayEkspedisiTransitID: " + JSON.stringify(arrayEkspedisiTransitID));

        }

        $.ajax({
            type: "POST",
            url: "04-05-input-pelanggan-baru.php",
            async: false,
            data: {
                id: $lastID[1],
                nama: $nama.trim(),
                alamat: $alamat.trim(),
                pulau: $pulau.trim(),
                daerah: $daerah.trim(),
                kontak: $kontak.trim(),
                singkatan: $singkatan.trim(),
                keterangan: $keterangan.trim(),
                arrayEkspedisiNormalID: arrayEkspedisiNormalID,
                arrayEkspedisiTransitID: arrayEkspedisiTransitID
            },
            success: function(responseText) {
                console.log(responseText);
                responseText = JSON.parse(responseText);
                if (responseText[0] === 'New customer created successfully.') {
                    alert('Pelanggan Baru berhasil diinput!');
                    setTimeout(() => {
                        history.back();
                    }, 500);
                }
            }
        });

    }

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

    function searchEkspedisi($id) {
        $namaEkspedisi = $("#inputID-" + $id).val();

        if ($namaEkspedisi == "") {
            $("#searchResults-" + $id).html("").removeClass("grid-1-auto").addClass("d-none");

        } else {
            $.ajax({
                type: "POST",
                url: "06-live-search.php",
                async: false,
                data: {
                    nama: "%" + $namaEkspedisi + "%",
                    table: "ekspedisi"
                },
                success: function(responseText) {
                    console.log(responseText);

                    $htmlToAppend = "";

                    $("#searchResults-" + $id).removeClass("d-none").addClass("grid-1-auto");

                    if (responseText === "not found!") {
                        $htmlToAppend = $htmlToAppend +
                            "<div class='bb-1px-solid-grey hover-bg-color-grey pt-0_5em pb-0_5em pl-0_5em color-grey'>Ekspedisi tidak ditemukan!</div>";
                        $("#searchResults-" + $id).html($htmlToAppend);

                    } else {

                        $results = JSON.parse(responseText);
                        console.log($results);

                        if ($results.length > 5) {
                            $results.splice(5);
                        }
                        $idResult = 0;
                        for (const ekspedisi of $results) {
                            $htmlToAppend = $htmlToAppend +
                                "<div id='chosenValue-" + $idResult + "' class='bb-1px-solid-grey hover-bg-color-grey pt-0_5em pb-0_5em pl-0_5em' onclick='pickChoice(" + $id + "," + $idResult + ")'>" +
                                ekspedisi.nama + "</div>";
                            $idResult++;
                        }

                        $("#searchResults-" + $id).html($htmlToAppend);

                    }


                }
            });

        }
    }

    function pickChoice($id, $idResult) {
        $inputID = $("#inputID-" + $id);
        $chosenValue = $("#chosenValue-" + $idResult);
        $searchResults = $("#searchResults-" + $id);
        $inputID.val($chosenValue.html());
        $searchResults.remove();
        // $searchResults.removeClass("grid-1-auto").addClass("d-none");
    }
</script>

<style>
    #divToggleReseller {
        height: 1.5em;
    }

    .btn-atas-kanan {
        display: inline;
        border-radius: 25px;
        background-color: #FFED50;
        padding: 0.5em 1em 0.5em 1em;
        position: absolute;
        top: 1em;
        right: 0.5em;
    }

    .div-filter-icon {
        justify-self: end;
    }

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

    .icon-img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .div-cari-filter {
        border-bottom: 0.5px solid #E4E4E4;
    }
</style>

<?php
include_once "01-footer.php";
?>