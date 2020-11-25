<?php

include_once "01-config.php";

// var_dump($_POST);
if (isset($_POST["type"])) {
    $type = $_POST["type"];
    if ($type === "delete") {
        funcDelete();
    } elseif ($type === "last") {
        funcLast();
    } elseif ($type === "live-search") {
        funcLiveSearch();
    } elseif ($type === "cek") {
        funcCek();
    } elseif ($type === "insert") {
        funcInsert();
    } elseif ($type === "SELECT") {
        $table = $_POST["table"];
        if (isset($_POST["column"])) {
            $column = $_POST["column"];
            $value = $_POST["value"];
        } else {
            $column = null;
            $value = null;
        }

        if (isset($_POST["order"])) {
            $order = $_POST["order"];
        } else {
            $order = null;
        }
        funcSelect($table, $column, $value, $order);
    } elseif ($type === "SELECT ONE") {
        funcSelectOne();
    } elseif ($type === "UPDATE") {
        funcUpdate();
    } elseif ($type === "DELETE") {
        funcDelete2();
    }
}

function funcDelete()
{
    global $con;
    $id = $_POST["id"];
    $column = $_POST["column"];
    $table = $_POST["table"];
    $sql = "DELETE FROM $table WHERE $column=$id";
    $msg = "Query: " . $sql . " SUCCESSFULLY EXECUTED.";
    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo json_encode(array("error", "Error: " . $sql . "<br>" . mysqli_error($con)));
        die;
    } else {
        echo json_encode(array("deleted", $msg));
        die;
    }
    return;
}

function funcDelete3($table, $column, $value)
{
    global $con;

    $sql = "DELETE FROM $table WHERE ";
    for ($i = 0; $i < count($column); $i++) {
        if ($i === count($column)) {
            $sql = $sql . $column[$i] = $value[$i];
        } else {
            $sql = $sql . $column[$i] = $value[$i] . " AND ";
        }
    }
    $msg = "Query: " . $sql . " SUCCESSFULLY EXECUTED.";
    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo json_encode(array("error", "Error: " . $sql . "<br>" . mysqli_error($con)));
        die;
    } else {
        echo json_encode(array("deleted", $msg));
        die;
    }
    return;
}

function funcLast()
{
    global $con;
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
}

function funcLiveSearch()
{
    global $con;
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

function funcCek()
{
    global $con;
    $table = $_POST['table'];
    $column = $_POST['column'];
    $value = $_POST['value'];
    $data_length = count($column);
    // var_dump($column[count($column) - 1]);
    // var_dump($column);
    // var_dump($value);

    if (isset($_POST['parameter'])) {
        $parameter = $_POST['parameter'];
    } else {
        $parameter = 'none';
    }

    $sql = "SELECT * FROM $table WHERE ";
    for ($i = 0; $i < $data_length; $i++) {
        // $value[$i] = mysqli_real_escape_string($con, $value[$i]);
        if ($i === ($data_length - 1)) {
            $sql = $sql . "$column[$i]='$value[$i]'";
        } else {
            $sql = $sql . "$column[$i]='$value[$i]' AND ";
        }
    }

    // var_dump($sql);
    // echo $sql;
    $res = mysqli_query($con, $sql);

    // if (mysqli_num_rows($res) > 0) {
    //     // echo 'udah ada';
    //     $row = mysqli_fetch_assoc($res);
    //     echo json_encode(array('udah ada', $row['id'], $parameter));
    // } else {
    //     echo 'blm ada';
    //     // insertToDB($table, $column, $value, $data_length);
    // }
    // var_dump(mysqli_num_rows($res));
    if (mysqli_num_rows($res) == 0) {
        # code...
        echo json_encode(array('blm ada'));
    } else {
        $row = mysqli_fetch_assoc($res);
        echo json_encode(array('udah ada', $row['id'], $parameter));
    }
}

function funcInsert()
{
    global $con;
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

function funcSelect($table, $column, $value, $order)
{
    global $con;
    if ($column !== null) {
        $data_length = count($column);

        $sql = "SELECT * FROM $table WHERE ";

        for ($i = 0; $i < $data_length; $i++) {
            $sql = $sql . "$column[$i] = '$value[$i]'";
            if ($data_length > 1) {
                $sql = $sql . " AND ";
            }
        }
    } else {
        $sql = "SELECT * FROM $table";
    }

    if ($order !== null) {
        $sql = $sql . " ORDER BY $order DESC";
    }

    $res = mysqli_query($con, $sql);

    if (mysqli_num_rows($res) > 0) {
        $rows = array();
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
        if (isset($_POST["table"])) {
            echo json_encode($rows);
        } else {
            return json_encode($rows);
        }
    } else {
        if (isset($_POST["table"])) {
            echo json_encode(array("NOT FOUND!"));
        } else {
            return json_encode(array("NOT FOUND!"));
        }
    }
}

function funcSelectOne()
{
    global $con;
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

function funcUpdate()
{
    global $con;
    $table = $_POST["table"];
    $column = $_POST["column"];
    $value = $_POST["value"];
    $key = $_POST["key"];
    $keyValue = $_POST["keyValue"];
    $data_length = count($column);

    if (isset($_POST['dateIndex'])) {
        $dateIndex = $_POST['dateIndex'];
        for ($i = 0; $i < count($dateIndex); $i++) {
            $value[$dateIndex[$i]] = date("Y-m-d", strtotime($value[$dateIndex[$i]]));
            // var_dump($value[$dateIndex[$i]]);
        }
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

function funcDelete2()
{
    global $con;
    $table = $_POST["table"];
    $column = $_POST["column"];
    $value = $_POST["value"];
    $sql = "DELETE FROM $table WHERE $column=$value";
    $msg = "Query: " . $sql . " SUCCESSFULLY EXECUTED.";
    $res = mysqli_query($con, $sql);
    if (!$res) {
        echo json_encode(array("error", "Error: " . $sql . "<br>" . mysqli_error($con)));
        die;
    } else {
        echo json_encode(array("DELETED", $msg));
        die;
    }
    return;
}

// die;
