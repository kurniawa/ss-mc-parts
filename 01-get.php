<?php

include_once "01-config.php";

$table = $_POST["table"];
$column = $_POST["column"];

if (!empty($_POST["id"])) {
    $id = $_POST["id"];
    $sql = "SELECT * FROM $table WHERE $column=$id";
} else {
    $sql = "SELECT * FROM $table";
}

$res = mysqli_query($con, $sql);

if (mysqli_num_rows($res) > 0) {
    $rows = array();

    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    // echo "Query: " . $sql . " has 0 result.";
    echo "No result.";
    die;
}
