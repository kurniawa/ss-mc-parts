<?php
include_once "01-header.php";
?>

<div class="m-1em">
    <button class="bg-color-orange-1 p-1em" onclick="goBackToPelanggan();">
        === Kembali ke Pelanggan
    </button>

</div>
<script>
    function goBackToPelanggan() {
        window.history.go(2 - window.history.length);
    }
</script>

<?php

include_once "01-config.php";

// var_dump($_POST);
// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';

highlight_string("<?php\n\$data =\n" . var_export($_POST, true) . ";\n?>");

// var_dump(var_export($_POST, true));

// DELETE dulu data ekspedisi untuk pelanggan ini
$nama = htmlspecialchars($_POST["nama"]);
$idPelanggan = htmlspecialchars($_POST["idPelanggan"]);
$alamat = htmlspecialchars($_POST["alamat"]);
$pulau = htmlspecialchars($_POST["pulau"]);
$daerah = htmlspecialchars($_POST["daerah"]);
$kontak = htmlspecialchars($_POST["kontak"]);
$singkatan = htmlspecialchars($_POST["singkatan"]);

echo count($_POST);
foreach ($_POST as $data => $value) {
    echo ($data);
}
$sql = "DELETE FROM pelanggan_use_ekspedisi WHERE id_pelanggan=$idPelanggan";

$res = mysqli_query($con, $sql);

if (!$res) {
    echo "Error: " . $sql . ". " . mysqli_error($con);
} else {
    echo "<br>" . $sql . ": SUCCEED!";
}

// Update Data Pelanggan yang baru

$sql = "UPDATE pelanggan SET
nama='$nama', alamat='$alamat', pulau='$pulau', daerah='$daerah',
kontak='$kontak', singkatan='$singkatan'
WHERE id=$idPelanggan";

$res = mysqli_query($con, $sql);

if (!$res) {
    echo "<br><br>Error updating: " . mysqli_error($con);
} else {
    echo "<br><br>" . $sql . ": SUCCEED!";
}

// INSERT ekspedisi pelanggan, bentuk relasi baru
echo "<br><br>";
var_dump($_POST["idEkspedisi"]);
if (isset($_POST["idEkspedisi"])) {
    foreach ($_POST["idEkspedisi"] as $id) {
        $id = htmlspecialchars($id);
        $sql = "INSERT INTO pelanggan_use_ekspedisi
            (id_ekspedisi, id_pelanggan, ekspedisi_utama)
            VALUE($id, $idPelanggan,'y')";
        $res = mysqli_query($con, $sql);
        if (!$res) {
            echo "INSERT ekspedisi gagal: " . mysqli_error($con);
        } else {
            echo $sql . ": SUCCEED!";
        }
    }
}

if (isset($_POST["idEkspedisiTransit"])) {
    foreach ($_POST["idEkspedisiTransit"] as $id) {
        $id = htmlspecialchars($id);
        $sql = "INSERT INTO pelanggan_use_ekspedisi
            (id_ekspedisi, id_pelanggan, ekspedisi_transit)
            VALUE($id, $idPelanggan,'y')";
        $res = mysqli_query($con, $sql);
        if (!$res) {
            echo "INSERT ekspedisi gagal: " . mysqli_error($con);
        } else {
            echo $sql . ": SUCCEED!";
        }
    }
}
?>

<?php
include_once "01-footer.php";
?>