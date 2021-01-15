<?php
function backUpSQLTable($table)
{
    global $status, $htmlLogError, $htmlLogOK, $htmlLogWarning, $con;
    // BACK-UP SYSTEM
    if ($status == "OK") {
        $file = fopen("back-up/$table.sql", 'w');
        if (!$file) {
            $status = "NOT OK";
            $htmlLogError = $htmlLogError . "Open file $table.sql - FAILED!<br><br>";
        } else {
            $status = "OK";
            $htmlLogOK = $htmlLogOK . "Open file $table.sql - SUCCEED!<br><br>";

            $query = "SELECT * FROM $table";
            $res_query = mysqli_query($con, $query);

            if (!$res_query) {
                $status = "NOT OK";
                $htmlLogError = $htmlLogError . $query . " - FAILED! " . mysqli_error($con) . "<br><br>";
            } else {
                $status = "OK";
                $htmlLogOK = $htmlLogOK . $query . " - SUCCEED!<br><br>";
            }

            // TOTAL DATA YANG ADA DI DB, GET NAMA COLUMN DAN VALUE NYA
            $column = array();
            $value = array();
            if ($status == "OK") {
                $query_select = "SELECT * FROM $table";
                $res_query_select = mysqli_query($con, $query_select);

                if (!$res_query_select) {
                    $status = "NOT OK";
                    $htmlLogError = $htmlLogError . $query_select . " - FAILED! " . mysqli_error($con) . "<br><br>";
                } else {
                    $status = "OK";
                    $htmlLogOK = $htmlLogOK . $query_select . " - SUCCEED!<br><br>";
                    $rows_count = mysqli_num_rows($res_query_select);

                    // var_dump($rows_count);
                    // br_2x();

                    // br_2x();

                    while ($row = mysqli_fetch_assoc($res_query_select)) {
                        // var_dump($row);
                        // br_2x();
                        $column = array_keys($row);
                        $temp_value = array();
                        for ($i = 0; $i < count($column); $i++) {
                            array_push($temp_value, $row[$column[$i]]);
                        }
                        array_push($value, $temp_value);
                    }
                    // var_dump($column);
                    // br_2x();
                    // var_dump($value);
                    // br_2x();
                }
            }

            // SUSUN COMMAND INSERT KE DB UNTUK RECOVERY NANTI NYA
            $sql_insert = "";
            if ($status == "OK") {
                $htmlLogOK = $htmlLogOK . "Jumlah data $table: " . $rows_count . "<br><br>";

                // LOOPING COLUMN
                $sql_insert = "INSERT INTO $table (";
                for ($i = 0; $i < count($column); $i++) {
                    if ($i == count($column) - 1) {
                        $sql_insert .= "$column[$i])";
                    } else {
                        $sql_insert .= "$column[$i], ";
                    }
                }

                // LOOPING VALUE
                // var_dump($value[0][0]);
                // br_2x();

                $sql_insert .= " VALUES (";
                for ($i = 0; $i < count($value); $i++) {
                    for ($j = 0; $j < count($value[$i]); $j++) {
                        $temp_value = $value[$i][$j];
                        // echo "$i, $j ";
                        if (is_int($temp_value)) {
                            if ($j == count($value[$i]) - 1) {
                                $sql_insert .= "$temp_value)";
                            } else {
                                $sql_insert .= "$temp_value, ";
                            }
                        } elseif (empty($temp_value) || $temp_value == "") {
                            if ($j == count($value[$i]) - 1) {
                                $sql_insert .= "NULL)";
                            } else {
                                $sql_insert .= "NULL, ";
                            }
                        } else {
                            if ($j == count($value[$i]) - 1) {
                                $sql_insert .= "'$temp_value')";
                            } else {
                                $sql_insert .= "'$temp_value', ";
                            }
                        }
                    }

                    if ($i !== count($value) - 1) {
                        $sql_insert .= ", (";
                    }
                }

                // var_dump($sql_insert);

                $htmlLogOK = $htmlLogOK . $sql_insert . "<br><br>";
                fwrite($file, $sql_insert);
                fclose($file);
            }
        }
    }
}
