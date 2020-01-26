<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('../conf/connection.php');


    $sql_update  = "UPDATE tables SET 
		        tables_seats	        = '" . $_POST['tables_seats'] . "',
                tables_status_reserve   = '" . $_POST['tables_status_reserve'] . "',
                tables_status_use       = '" . $_POST['tables_status_use'] . "'  WHERE tables_no = '" . $_POST['tables_no'] . "' ";
}

if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
    echo "<script> alert('แก้ไขข้อมูล หมายเลขโต๊ะ: ". $_POST['tables_no'] ." เรียบร้อยแล้ว'); window.location.assign('show_table.php')</script>";
}
