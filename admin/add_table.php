<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('../conf/connection.php');

    $sql        =    "INSERT INTO tables SET 
				
				tables_seats	= '" . $_POST['tables_seats'] . "',
                tables_status_reserve = '0',
                tables_status_use = '0'";

    if (mysqli_query($link, $sql)) {
        $new_tables_no = mysqli_insert_id($link);
        echo "<script> alert('เพิ่มข้อมูลโต๊ะเรียบร้อย หมายเลขโต๊ะ: ". $new_tables_no ."'); window.location.assign('show_table.php')</script>";
    }
}
