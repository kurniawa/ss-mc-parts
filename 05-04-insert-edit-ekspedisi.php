<?php

include_once "01-config.php";

$id = $_POST["id"];
$nama = $_POST["nama"];
$bentuk = $_POST["bentuk"];
$alamat = $_POST["alamat"];
$kontak = $_POST["kontak"];
$keterangan = $_POST["keterangan"];

// var_dump($id, $nama, $bentuk, $alamat, $kontak, $keterangan);

if ($id == "") {
    $sql = "INSERT INTO ekspedisi (nama, bentuk, alamat, kontak, keterangan) VALUE('$nama', '$bentuk', '$alamat', '$kontak', '$keterangan')";
    $msg = "New record created successfully.";
} else {
    $sql = "UPDATE ekspedisi SET nama='$nama', bentuk='$bentuk', alamat='$alamat', kontak='$kontak', keterangan='$keterangan' WHERE id=$id";
    $msg = "Data updated successfully.";
}

$res = mysqli_query($con, $sql);

if (!$res) {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
} else {
    echo ($msg);
}

mysqli_close($con);
