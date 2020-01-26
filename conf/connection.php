<?php

$host = "localhost"; // mysql host
$mysql_user = "root"; // mysql username
$mysql_pass = "krittawat"; // mysql password
$db = "foodordersystem"; // mysql schema

$link = @mysqli_connect("$host", "$mysql_user", "$mysql_pass", "$db");

date_default_timezone_set("Asia/Bangkok");

if (!$link) {
    echo "<h3>Error: Unable to connect to database.<h3>" . PHP_EOL;
    //  echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    // echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
} else {
    mysqli_set_charset($link, "utf8");
}


