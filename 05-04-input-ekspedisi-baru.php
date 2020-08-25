<?php

include_once "01-config.php";

$nama = $_POST["nama"];
$bentuk = $_POST["bentuk"];
$alamat = $_POST["alamat"];
$kontak = $_POST["kontak"];
$keterangan = $_POST["keterangan"];

var_dump($nama, $bentuk, $alamat, $kontak, $keterangan);

$sql = "INSERT INTO ekspedisi (nama, bentuk, alamat, kontak, keterangan) VALUE('$nama', '$bentuk', '$alamat', '$kontak', '$keterangan')";

$res = mysqli_query($con, $sql);

if (!$res) {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
} else {
    echo "New record created successfully";
}

mysqli_close($con);
