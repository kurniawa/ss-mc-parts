<?php

include_once "01-config.php";

$id = htmlspecialchars($_POST["id"]);
$nama = htmlspecialchars($_POST["nama"]);
$bentuk = htmlspecialchars($_POST["bentuk"]);
$alamat = htmlspecialchars($_POST["alamat"]);
$kontak = htmlspecialchars($_POST["kontak"]);
$keterangan = htmlspecialchars($_POST["keterangan"]);

if (isset($_POST['type'])) {
    $type = $_POST['type'];
    if ($type === 'new_ekspedisi') {
        $sql = "INSERT INTO ekspedisi (nama, bentuk, alamat, kontak, keterangan) VALUE('$nama', '$bentuk', '$alamat', '$kontak', '$keterangan')";
        $msg = "New record created successfully.";
    } else if ($type === 'update_ekspedisi') {
        $sql = "UPDATE ekspedisi SET nama='$nama', bentuk='$bentuk', alamat='$alamat', kontak='$kontak', keterangan='$keterangan' WHERE id=$id";
        $msg = "Data updated successfully.";
    }
}

$paramsToReturn = array();
// var_dump($id, $nama, $bentuk, $alamat, $kontak, $keterangan);

$res = mysqli_query($con, $sql);

if (!$res) {
    array_push($paramsToReturn, "Error: " . $sql . "<br>" . mysqli_error($con));
} else {
    array_push($paramsToReturn, $msg);
}

echo json_encode($paramsToReturn);

mysqli_close($con);
