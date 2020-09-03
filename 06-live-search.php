<?php

include_once "01-config.php";

$key = $_POST["nama"];
$table = $_POST["table"];

// var_dump($key, $table);

$sql = "SELECT * FROM $table WHERE nama LIKE '$key'";

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
