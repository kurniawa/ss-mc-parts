<?php

include_once "01-config.php";

$nama = htmlspecialchars($_POST["nama"]);
$alamat = htmlspecialchars($_POST["alamat"]);
$pulau = htmlspecialchars($_POST["pulau"]);
$daerah = htmlspecialchars($_POST["daerah"]);
$kontak = htmlspecialchars($_POST["kontak"]);
$singkatan = htmlspecialchars($_POST["singkatan"]);
$keterangan = htmlspecialchars($_POST["keterangan"]);

$sql = "INSERT INTO pelanggan(nama, alamat, pulau, daerah, kontak, singkatan, keterangan) VALUE('$nama', '$alamat', '$pulau', '$daerah', '$kontak', '$singkatan', '$keterangan')";

$res = mysqli_query($con, $sql);

$paramsToReturn = array();

if (!$res) {
    array_push($paramsToReturn, "Error: " . $sql . "<br>" . mysqli_error($con));
} else {
    array_push($paramsToReturn, "New customer created successfully.");
    $customerID = mysqli_insert_id($con);
}

// $test = 0;

if (isset($_POST["arrayEkspedisiNormalID"]) && !isset($_POST["arrayEkspedisiTransitID"])) {
    $arrayEkspedisiNormalID = $_POST["arrayEkspedisiNormalID"];
    // var_dump($arrayEkspedisiNormalID);
    foreach ($arrayEkspedisiNormalID as $ekspedisiNormalID) {
        $sql = "INSERT INTO pelanggan_use_ekspedisi(id_ekspedisi, id_pelanggan) VALUE($ekspedisiNormalID, $customerID)";
        insertEkspedisi($sql);
    }
} else if (!isset($_POST["arrayEkspedisiNormalID"]) && isset($_POST["arrayEkspedisiTransitID"])) {
    $arrayEkspedisiTransitID = $_POST["arrayEkspedisiTransitID"];
    // var_dump($arrayEkspedisiTransitID);
    foreach ($arrayEkspedisiTransitID as $ekspedisiTransitID) {
        $sql = "INSERT INTO pelanggan_use_ekspedisi(id_ekspedisi, id_pelanggan, ekspedisi_transit) VALUE($ekspedisiTransitID, $customerID, 'y')";
        insertEkspedisi($sql);
    }
} else if (isset($_POST["arrayEkspedisiNormalID"]) && isset($_POST["arrayEkspedisiTransitID"])) {
    $arrayEkspedisiNormalID = $_POST["arrayEkspedisiNormalID"];
    // var_dump($arrayEkspedisiNormalID);
    foreach ($arrayEkspedisiNormalID as $ekspedisiNormalID) {
        $sql = "INSERT INTO pelanggan_use_ekspedisi(id_ekspedisi, id_pelanggan) VALUE($ekspedisiNormalID, $customerID)";
        insertEkspedisi($sql);
    }
    $arrayEkspedisiTransitID = $_POST["arrayEkspedisiTransitID"];
    // var_dump($arrayEkspedisiTransitID);
    foreach ($arrayEkspedisiTransitID as $ekspedisiTransitID) {
        $sql = "INSERT INTO pelanggan_use_ekspedisi(id_ekspedisi, id_pelanggan, ekspedisi_transit) VALUE($ekspedisiTransitID, $customerID, 'y')";
        insertEkspedisi($sql);
    }
}


function insertEkspedisi($sql)
{
    global $con;
    global $paramsToReturn;
    // var_dump($sql);
    $res = mysqli_query($con, $sql);

    if (!$res) {
        array_push($paramsToReturn, "Error: " . $sql . "<br>" . mysqli_error($con));
    } else {
        array_push($paramsToReturn, "Relasi Ekspedisi Pelanggan terbentuk.");
    }
}

echo json_encode($paramsToReturn);

mysqli_close($con);
