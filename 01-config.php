<?php

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
