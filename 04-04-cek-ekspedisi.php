<?php

include_once "01-config.php";

$nama = $_POST["nama"];
$sql = "SELECT * FROM ekspedisi WHERE nama = '$nama'";

$res = mysqli_query($con, $sql);

if (mysqli_num_rows($res) > 0) {
    echo "Found!";
    die;
} else {
    echo "No result!";
    die;
}
