<?php

include_once "01-config.php";

$sql = "SELECT * FROM pelanggan";

$res = mysqli_query($con, $sql);

if (mysqli_num_rows($res) > 0) {
    $rows = array();

    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo "Query: " . $sql . " has 0 result.";
    die;
}
