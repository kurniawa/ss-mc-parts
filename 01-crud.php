<?php

include_once "01-config.php";

$type = $_POST["type"];

if ($type === "delete") {
    $id = $_POST["id"];
    $column = $_POST["column"];
    $msg = "Query: " . $sql . " SUCCESSFULLY EXECUTED.";
    $sql = "DELETE FROM $table WHERE $column=$id";
    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo json_encode(array("error", "Error: " . $sql . "<br>" . mysqli_error($con)));
        die;
    } else {
        echo json_encode(array("deleted", $msg));
        die;
    }
    return;
} elseif ($type === "last") {
    $table = $_POST["table"];
    $sql = "SELECT max(id) FROM $table";
    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo json_encode(array("error", "Error: " . $sql . "<br>" . mysqli_error($con)));
        die;
    } else {
        $lastID = mysqli_fetch_row($res);
        // var_dump($lastID);
        // var_dump($lastID[0]);
        if ($lastID[0] == null) {
            $setID = 1;
        } else {
            $setID = $lastID[0] + 1;
        }

        echo json_encode(array("lastID", $setID));
    }
    return;
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
    return;
}

if ($type === 'cek') {
    $table = $_POST['table'];
    $column = $_POST['column'];
    $value = $_POST['value'];
    $data_length = count($column);
    // var_dump($column[count($column) - 1]);

    if (isset($_POST['parameter'])) {
        $parameter = $_POST['parameter'];
    } else {
        $parameter = 'none';
    }

    $sql = "SELECT * FROM $table WHERE ";
    for ($i = 0; $i < $data_length; $i++) {
        if ($i === ($data_length - 1)) {
            $sql = $sql . "$column[$i]='$value[$i]'";
        } else {
            $sql = $sql . "$column[$i]='$value[$i]' AND ";
        }
    }

    // var_dump($sql);

    $res = mysqli_query($con, $sql);

    if (mysqli_num_rows($res) > 0) {
        // echo 'udah ada';
        $row = mysqli_fetch_assoc($res);
        echo json_encode(array('udah ada', $row['id'], $parameter));
    } else {
        echo 'blm ada';
        // insertToDB($table, $column, $value, $data_length);
    }
}

if ($type === 'insert') {
    $table = $_POST['table'];
    $column = $_POST['column'];
    $value = $_POST['value'];
    $data_length = count($column);
    // Parameter to pass
    if (isset($_POST['parameter'])) {
        $parameter = $_POST['parameter'];
    } else {
        $parameter = 'none';
    }
    if (isset($_POST['idToReturn'])) {
        $idToReturn = $_POST['idToReturn'];
    } else {
        $idToReturn = 'none';
    }
    // var_dump($value);

    if (isset($_POST['dateIndex'])) {
        $dateIndex = $_POST['dateIndex'];
        $value[$dateIndex] = date("Y-m-d", strtotime($value[$dateIndex]));
        // var_dump($value[$dateIndex]);
    }
    // var_dump($value);

    $sql_part_1 = "INSERT INTO $table(";
    $sql_part_2 = " VALUE(";

    for ($i = 0; $i < $data_length; $i++) {
        if ($i === ($data_length - 1)) {
            $sql_part_1 = $sql_part_1 . "$column[$i])";
            $sql_part_2 = $sql_part_2 . "'$value[$i]')";
        } else {
            $sql_part_1 = $sql_part_1 . "$column[$i], ";
            $sql_part_2 = $sql_part_2 . "'$value[$i]', ";
        }
    }
    $sql = $sql_part_1 . $sql_part_2;
    // echo $sql;

    $msg = "Query: " . $sql . " SUCCESSFULLY EXECUTED.";
    $res = mysqli_query($con, $sql);

    if (!$res) {
        echo json_encode(array("error", "Error: " . $sql . "<br>" . mysqli_error($con)));
        die;
    } else {
        echo json_encode(array("INSERT OK", $msg, $idToReturn, $parameter));
        // echo "INSERT OK";
    }
}

if ($type === "SELECT") {
    $table = $_POST["table"];
    $sql = "SELECT * FROM $table";

    $res = mysqli_query($con, $sql);

    if (mysqli_num_rows($res) > 0) {
        $rows = array();
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo "NOT FOUND!";
        die;
    }
}

if ($type === "SELECT ONE") {
    $table = $_POST["table"];
    $column = $_POST["column"];
    $value = $_POST["value"];
    $data_length = count($column);
    $sql = "SELECT * FROM $table";

    $sql = "SELECT * FROM $table WHERE ";

    for ($i = 0; $i < $data_length; $i++) {
        $sql = $sql . "$column[$i] = '$value[$i]'";
        if ($data_length > 1) {
            $sql = $sql . " AND ";
        }
    }
    // echo $sql;

    $res = mysqli_query($con, $sql);

    if (mysqli_num_rows($res) > 0) {
        $rows = array();
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo "NOT FOUND!";
        die;
    }
}

if ($type === "UPDATE") {
    $table = $_POST["table"];
    $column = $_POST["column"];
    $value = $_POST["value"];
    $key = $_POST["key"];
    $keyValue = $_POST["keyValue"];
    $data_length = count($column);

    if (isset($_POST['dateIndex'])) {
        $dateIndex = $_POST['dateIndex'];
        $value[$dateIndex] = date("Y-m-d", strtotime($value[$dateIndex]));
        // var_dump($value[$dateIndex]);
    }

    $sql = "UPDATE $table SET ";
    for ($i = 0; $i < $data_length; $i++) {
        if ($i === ($data_length - 1)) {
            $sql = $sql . "$column[$i] = '$value[$i]' WHERE $key=$keyValue";
        } else {
            $sql = $sql . "$column[$i] = '$value[$i]', ";
        }
    }

    // echo ($sql);
    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo json_encode(array('Error updating: ' . mysqli_error($con)));
    } else {
        echo json_encode(array('UPDATE SUCCEED', $sql));
    }
}

die;
