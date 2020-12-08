<?php

include_once "01-config.php";
include_once "01-header.php";

$htmlLogOK = "<div class='logOK'>";
$htmlLogError = "<div class='logError'>";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $htmlLogOK = $htmlLogOK . "Server Request Method = GET<br><br>";
    $id = $_GET["id"];
    $query_get_ekspedisi = "SELECT * FROM ekspedisi WHERE id=$id";
    $res_q_get_ekspedisi = mysqli_query($con, $query_get_ekspedisi);

    if (!$res_q_get_ekspedisi) {
        $htmlLogError = $htmlLogError . $query_get_ekspedisi . " - FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $htmlLogOK = $htmlLogOK . $query_get_ekspedisi . " - SUCCEED!<br><br>";
        $row = mysqli_fetch_assoc($res_q_get_ekspedisi);
    }
} else {
    $htmlLogError = $htmlLogError . "Server Request Method = ??<br><br>";
}


$htmlLogOK = $htmlLogOK . "</div>";
$htmlLogError = $htmlLogError . "</div>";

?>


<div id="pageEditEkspedisi">
    <div class="header grid-1-auto">
        <img class="w-0_8em ml-1_5em" src="img/icons/back-button-white.svg" alt="" onclick="backButton();">
    </div>

    <div class="grid-2-10_auto mt-1em ml-1em">
        <div>
            <img class="w-2em" src="img/icons/pencil.svg" alt="Data Pelanggan Baru">
        </div>
        <div class="font-weight-bold">
            Edit Data Ekspedisi
        </div>
    </div>

    <form action="05-06-edit-ekspedisi-2.php" method="POST" class="ml-1em mr-1em mt-2em">
        <input type="hidden" name="id_ekspedisi" value="<?= $id; ?>">
        <div class="grid-2-auto grid-column-gap-1em">
            <div class="bb-0_5px-grey pb-1em">
                <label for="selectBentukPerusahaan">Bentuk:</label><br>
                <select class="b-none" name="bentuk_perusahaan" id="selectBentukPerusahaan">
                    <option value="" disabled>Bentuk</option>
                    <option value="" <?php if ($row["bentuk"] == "") {
                                            echo "selected";
                                        } ?>>-</option>
                    <option value="PT" <?php if ($row["bentuk"] == "PT") {
                                            echo "selected";
                                        } ?>>PT</option>
                    <option value="CV" <?php if ($row["bentuk"] == "CV") {
                                            echo "selected";
                                        } ?>>CV</option>
                </select>
            </div>
            <div>
                <label for="namaEdited">Nama Ekspedisi:</label>
                <input id="namaEdited" class="input-1 pb-1em" name="nama_ekspedisi" type="text" placeholder="Nama Ekspedisi" value="<?= $row['nama']; ?>">
            </div>
        </div>

        <br>
        <label for="alamatEdited">Alamat:</label>
        <textarea id="alamatEdited" class="text-area-mode-1 mt-1em pt-1em pl-1em" name="alamat_ekspedisi" placeholder="Alamat"><?= $row['alamat']; ?></textarea>

        <div class="mt-1em">
            <label for="kontakEdited">Kontak:</label>
            <input id="kontakEdited" name="kontak_ekspedisi" class="input-1 pb-1em" type="text" placeholder="No. Kontak" value="<?= $row['kontak']; ?>">
        </div>

        <br>
        <label for="divTujuanEkspedisi">Tujuan Ekspedisi:</label>
        <div id="divTujuanEkspedisi" class="mt-1em grid-2-auto grid-column-gap-1em">
            <input id="pulauTujuan" class="input-1 pb-1em" type="text" placeholder="Pulau Tujuan Ekspedisi" name="pulau_tujuan">
            <input id="daerahTujuan" class="input-1 pb-1em" type="text" placeholder="Daerah Tujuan Ekspedisi" name="daerah_tujuan">
        </div>

        <br>
        <label for="keteranganEdited">Keterangan:</label>
        <textarea id="keteranganEdited" class="text-area-mode-1 mt-1em pt-1em pl-1em" name="keterangan" placeholder="Keterangan lain (opsional)" value="<?= $row['keterangan']; ?>"></textarea>

        <div id="peringatan" class="d-none color-red p-1em">

        </div>

        <div class="m-1em">
            <button type="submit" class="h-4em bg-color-orange-2 grid-1-auto w-100">
                <span class="justify-self-center font-weight-bold">Simpan Perubahan</span>
            </button>
        </div>
    </form>

</div>

<div class="divLogError"></div>
<div class="divLogOK"></div>
<script>
    // $(document).ready(function() {
    //     // console.log($("#selectBentukPerusahaan"));
    //     $("#selectBentukPerusahaan option[value='" + $bentukEkspedisi + "']").prop("selected", true);
    //     $("#namaEdited").val($namaEkspedisi);
    //     $("#alamatEdited").val($alamatEkspedisi);
    //     $("#kontakEdited").val($kontakEkspedisi);
    //     $("#keteranganEdited").val($keterangan);
    // });

    var htmlLogError = `<?= $htmlLogError; ?>`;
    var htmlLogOK = `<?= $htmlLogOK; ?>`;

    $('.divLogError').html(htmlLogError);
    $('.divLogOK').html(htmlLogOK);

    if ($('.logError').html() === '') {
        $('.divLogError').hide();
    } else {
        $('.divLogError').show();
    }

    if ($('.logOK').html() === '') {
        $('.divLogOK').hide();
    } else {
        $('.divLogOK').show();
    }

    // function simpanPerubahan() {
    //     $bentuk = $("#selectBentukPerusahaan").val();
    //     $nama = $("#namaEdited").val();
    //     $alamat = $("#alamatEdited").val();
    //     $kontak = $("#kontakEdited").val();
    //     $keterangan = $("#keteranganEdited").val();
    //     $peringatan = $("#peringatan");

    //     console.log($alamat);
    //     if ($nama == "") {
    //         $peringatan.html("Nama Ekspedisi harus diisi!");
    //         if ($peringatan.css("display") == "none") {
    //             $peringatan.toggle(100);
    //         }
    //     } else if ($nama != "" && $peringatan.css("display") != "none") {
    //         $peringatan.toggle(100);
    //     }

    //     $.ajax({
    //         url: "05-04-insert-edit-ekspedisi.php",
    //         type: "POST",
    //         async: false,
    //         data: {
    //             id: $id,
    //             nama: $nama,
    //             bentuk: $bentuk,
    //             alamat: $alamat,
    //             kontak: $kontak,
    //             keterangan: $keterangan,
    //             type: 'update_ekspedisi'
    //         },
    //         success: function(responseText) {
    //             console.log(responseText);
    //             responseText = JSON.parse(responseText);
    //             if (responseText[0] === "Data updated successfully.") {
    //                 alert('Data ekspedisi berhasil di-update!');
    //                 setTimeout(() => {
    //                     window.history.back();
    //                 }, 500);
    //             }
    //         }
    //     });
    // }

    function backButton() {
        history.back();
    }
</script>

<?php

include_once "01-footer.php";

?>