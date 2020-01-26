<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require('../conf/connection.php');

    $sql_update  = "UPDATE materials SET 
		        material_name	      = '" . $_POST['material_name'] . "',
                material_qty          = '" . $_POST['material_qty'] . "',
                material_count        = '" . $_POST['material_count'] . "',
                material_status       = '" . $_POST['material_status'] . "'  WHERE materialid = '" . $_POST['materialid'] . "' ";

    if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
        echo "<script> alert('แก้ไขข้อมูล รหัสวัคถุดิบ: ". $_POST['materialid'] ." เรียบร้อยแล้ว'); window.location.assign('show_material.php')</script>";
    } else {
        echo "<script> alert('แก้ไขข้อมูลผิดพลาด'); window.location.assign('show_material.php')</script>";
    }
}
