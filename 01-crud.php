<?php

include_once "01-config.php";

$type = $_POST["type"];

if ($type === "delete") {
    $id = $_POST["id"];
    $column = $_POST["column"];
    $sql = "DELETE FROM $table WHERE $column=$id";
    $msg = "Query: " . $sql . " SUCCESSFULLY EXECUTED.";
    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo json_encode(array("error", "Error: " . $sql . "<br>" . mysqli_error($con)));
    } else {
        echo json_encode(array("deleted", $msg));
    }
} elseif ($type === "last") {
    $table = $_POST["table"];
    $sql = "SELECT max(id) FROM $table";
    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo json_encode(array("error", "Error: " . $sql . "<br>" . mysqli_error($con)));
    } else {
        $lastID = mysqli_fetch_row($res);
        // var_dump($lastID);
        // var_dump($lastID[0]);
        echo json_encode(array("lastID", $lastID[0]));
    }
} elseif ($type === "live-search") {
    $key = $_POST["key"];
    $table = $_POST["table"];
    $column = $_POST["column"];
    // var_dump($key, $table, $column);
    $sql = "SELECT * FROM $table WHERE $column LIKE '%$key%'";

    $res = mysqli_query($con, $sql);

    if (mysqli_num_rows($res) > 0) {
        $rows = array();
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        // echo "Query: " . $sql . " has 0 result.";
        echo "not found!";
        die;
    }
}

die;
