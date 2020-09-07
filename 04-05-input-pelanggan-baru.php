<?php

include_once "01-config.php";

$nama = htmlspecialchars($_POST["nama"]);
$alamat = htmlspecialchars($_POST["alamat"]);
$pulau = htmlspecialchars($_POST["pulau"]);
$daerah = htmlspecialchars($_POST["daerah"]);
$kontak = htmlspecialchars($_POST["kontak"]);
$singkatan = htmlspecialchars($_POST["singkatan"]);
$keterangan = htmlspecialchars($_POST["keterangan"]);

// $sql = "INSERT INTO pelanggan(nama, alamat, pulau, daerah, kontak, singkatan, keterangan) VALUE('$nama', '$alamat', '$pulau', '$daerah', '$kontak', '$singkatan', '$keterangan')";

// $res = mysqli_query($con, $sql);

// if (!$res) {
//     echo "Error: " . $sql . "<br>" . mysqli_error($con);
// } else {
//     echo "New record created successfully.";
//     $lastID = mysqli_insert_id($con);
// }


$arrayEkspedisiNormalID = $_POST["arrayEkspedisiNormalID"];
$arrayEkspedisiTransitID = $_POST["arrayEkspedisiTransitID"];

var_dump($arrayEkspedisiNormalID);
var_dump($arrayEkspedisiTransitID);

// foreach ($ekspedisiNormalAll as $ekspedisiNormal) {
//     $sql_2 = "INSERT INTO pelanggan_use_ekspedisi(id_ekspedisi, id_pelanggan) VALUE()";
// }

mysqli_close($con);
