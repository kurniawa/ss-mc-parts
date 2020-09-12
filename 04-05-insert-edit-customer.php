<?php

include_once "01-config.php";

$nama = htmlspecialchars($_POST["nama"]);
$alamat = htmlspecialchars($_POST["alamat"]);
$pulau = htmlspecialchars($_POST["pulau"]);
$daerah = htmlspecialchars($_POST["daerah"]);
$kontak = htmlspecialchars($_POST["kontak"]);
$singkatan = htmlspecialchars($_POST["singkatan"]);
$keterangan = htmlspecialchars($_POST["keterangan"]);

if (isset($_POST["id"])) {
    $id = htmlspecialchars($_POST["id"]);
    $sql = "UPDATE pelanggan SET nama='$nama', alamat='$alamat', pulau='$pulau', daerah='$daerah', " .
        "kontak='$kontak', singkatan='$singkatan', keterangan='$keterangan' WHERE id=$id";
    $msg = "Customer Info successfully updated.";
} else {
    $sql = "INSERT INTO pelanggan(nama, alamat, pulau, daerah, kontak, singkatan, keterangan) VALUE('$nama', '$alamat', '$pulau', '$daerah', '$kontak', '$singkatan', '$keterangan')";
    $msg = "New Customer added successfully.";
}

var_dump("sql: " . $sql);

$res = mysqli_query($con, $sql);

if (!$res) {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
} else {
    echo $msg;
    if ($msg === "New Customer added successfully.") {
        $id = mysqli_insert_id($con);
    }
}

// Delete terlebih dahulu semua ekspedisi yang berkaitan, hal ini juga untuk membuat table tersusun lebih baik.

$sql = "DELETE FROM pelanggan_use_ekspedisi WHERE id_pelanggan=$id";

$res = mysqli_query($con, $sql);

if (!$res) {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
} else {
    echo "All expedition deleted successfully.";
}

// Mulai insert relasi baru di pelanggan_use_ekspedisi

if (isset($_POST["arrayEkspedisiNormalID"]) && !isset($_POST["arrayEkspedisiTransitID"])) {
    $arrayEkspedisiNormalID = $_POST["arrayEkspedisiNormalID"];
    var_dump($arrayEkspedisiNormalID);
    foreach ($arrayEkspedisiNormalID as $ekspedisiNormalID) {
        $sql = "INSERT INTO pelanggan_use_ekspedisi(id_ekspedisi, id_pelanggan) VALUE($ekspedisiNormalID, $id)";
        insertEkspedisi($sql);
    }
} else if (!isset($_POST["arrayEkspedisiNormalID"]) && isset($_POST["arrayEkspedisiTransitID"])) {
    $arrayEkspedisiTransitID = $_POST["arrayEkspedisiTransitID"];
    var_dump($arrayEkspedisiTransitID);
    foreach ($arrayEkspedisiTransitID as $ekspedisiTransitID) {
        $sql = "INSERT INTO pelanggan_use_ekspedisi(id_ekspedisi, id_pelanggan, ekspedisi_transit) VALUE($ekspedisiTransitID, $id, 'y')";
        insertEkspedisi($sql);
    }
} else if (isset($_POST["arrayEkspedisiNormalID"]) && isset($_POST["arrayEkspedisiTransitID"])) {
    $arrayEkspedisiNormalID = $_POST["arrayEkspedisiNormalID"];
    var_dump($arrayEkspedisiNormalID);
    foreach ($arrayEkspedisiNormalID as $ekspedisiNormalID) {
        $sql = "INSERT INTO pelanggan_use_ekspedisi(id_ekspedisi, id_pelanggan) VALUE($ekspedisiNormalID, $id)";
        insertEkspedisi($sql);
    }
    $arrayEkspedisiTransitID = $_POST["arrayEkspedisiTransitID"];
    var_dump($arrayEkspedisiTransitID);
    foreach ($arrayEkspedisiTransitID as $ekspedisiTransitID) {
        $sql = "INSERT INTO pelanggan_use_ekspedisi(id_ekspedisi, id_pelanggan, ekspedisi_transit) VALUE($ekspedisiTransitID, $id, 'y')";
        insertEkspedisi($sql);
    }
}


function insertEkspedisi($sql)
{
    global $con;
    var_dump($sql);
    $res = mysqli_query($con, $sql);

    if (!$res) {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    } else {
        echo "Relasi Ekspedisi Pelanggan terbentuk.";
    }
}


mysqli_close($con);
