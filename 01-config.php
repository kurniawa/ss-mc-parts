<?php
// test ah
define('host', 'localhost');
define('user', 'root');
define('pw', '');
define('db', 'mcparts');

// Create connection
$con = mysqli_connect(host, user, pw, db);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";

$htmlLogError = "<div class='logError'>";
$htmlLogOK = "<div class='logOK'>";
$htmlLogWarning = "<div class='logWarning'>";
$status = "";

function nextID($table, $column)
{
    // header("Content-Type: application/json");
    global $con;
    global $htmlLogOK;
    global $htmlLogError;
    global $status;
    $next_id = 0;

    $query_max_id = "SELECT max($column) FROM $table";
    $res_query_max_id = mysqli_query($con, $query_max_id);

    if (!$res_query_max_id) {
        $status = "ERROR";
        $htmlLogError = $htmlLogError . $query_max_id . " - FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $status = "OK";
        $htmlLogOK = $htmlLogOK . $query_max_id . " - SUCCEED!<br><br>";
    }

    if ($status == "OK") {
        $max_id = mysqli_fetch_row($res_query_max_id);
        if ($max_id[0] == null) {
            $next_id = 1;
        } else {
            $next_id = $max_id[0] + 1;
        }

        $htmlLogOK = $htmlLogOK . "next_id $table ==> $column: $next_id<br><br>";
        return $next_id;
    }

    // $obj_next_id = array(
    //     "status" => $status,
    //     "id" => $next_id,
    //     "log_ok" => $htmlLogOK,
    //     "log_error" => $htmlLogError
    // );

}

function dbInsert($table, $column, $value)
{
    global $con;
    global $htmlLogOK;
    global $htmlLogError;
    global $status;

    $data_length = count($column);
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

    $res = mysqli_query($con, $sql);

    if (!$res) {
        $status = "ERROR";
        $htmlLogError = $htmlLogError . $sql . " - FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $status = "OK";
        $htmlLogOK = $htmlLogOK . $sql . " - SUCCEED!<br><br>";
    }
}

function dbGet($table)
{
    global $con;
    global $htmlLogOK;
    global $htmlLogWarning;
    global $status;

    $query = "SELECT * FROM $table";
    $res = mysqli_query($con, $query);

    if (!$res) {
        $status = "ERROR";
        $htmlLogWarning = $htmlLogWarning . $query . " - FAILED! " . mysqli_error($con) . "<br><br>";
        return array("ERROR");
    } else {
        $status = "OK";
        $htmlLogOK = $htmlLogOK . $query . " - SUCCEED!<br><br>";
        $rows = array();
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($rows, $row);
        }
        return $rows;
    }
}

function dbUpdate($table, $column, $value, $key, $key_value)
{
    global $con;
    global $htmlLogOK;
    global $htmlLogWarning;
    global $htmlLogError;
    global $status;

    $data_length = count($column);
    $sql = "UPDATE $table SET ";
    for ($i = 0; $i < $data_length; $i++) {
        if ($i === ($data_length - 1)) {
            $sql = $sql . "$column[$i] = '$value[$i]' WHERE $key=$key_value";
        } else {
            $sql = $sql . "$column[$i] = '$value[$i]', ";
        }
    }

    // echo $sql;

    $res = mysqli_query($con, $sql);

    if (!$res) {
        $status = "ERROR";
        $htmlLogError = $htmlLogError . $sql . " - FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $status = "OK";
        $htmlLogWarning = $htmlLogWarning . $sql . " - SUCCEED!<br><br>";
    }
}

function dbDelete($table, $column, $value)
{
    global $con;
    global $htmlLogOK;
    global $htmlLogWarning;
    global $htmlLogError;
    global $status;

    $sql = "DELETE FROM $table WHERE $column=$value";
    $res = mysqli_query($con, $sql);
    if (!$res) {
        $status = "ERROR";
        $htmlLogError = $htmlLogError . $sql . " - FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $status = "OK";
        $htmlLogOK = $htmlLogOK . $sql . " - SUCCEED!<br><br>";
    }
}

function dbCheck($table, $column, $value)
{
    global $con;
    global $htmlLogOK;
    global $htmlLogWarning;
    global $htmlLogError;
    global $status;

    $data_length = count($column);

    $sql = "SELECT * FROM $table WHERE ";
    for ($i = 0; $i < $data_length; $i++) {
        // $value[$i] = mysqli_real_escape_string($con, $value[$i]);
        if ($i === ($data_length - 1)) {
            $sql = $sql . "$column[$i]='$value[$i]'";
        } else {
            $sql = $sql . "$column[$i]='$value[$i]' AND ";
        }
    }

    $res = mysqli_query($con, $sql);

    if (!$res) {
        $status = "ERROR";
        $htmlLogError = $htmlLogError . $sql . " - FAILED! " . mysqli_error($con) . "<br><br>";
    } else {
        $status = "OK";
        $htmlLogOK = $htmlLogOK . $sql . " - SUCCEED!<br><br>";
        if (mysqli_num_rows($res) == 0) {
            $htmlLogOK = $htmlLogOK . "BELUM ADA DI DATABASE<br><br>";
            return "BELUM ADA";
        } else {
            $htmlLogWarning = $htmlLogWarning . "UDAH ADA DI DATABASE<br><br>";
            $row = mysqli_fetch_assoc($res);
            return array("UDAH ADA", $row["id"]);
        }
    }
}
