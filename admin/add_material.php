<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('../conf/connection.php');
    //	include_once('../conf/function.php');


    $chk_material    = mysqli_query($link, "SELECT * FROM materials WHERE material_name = '" . $_POST['material_name'] . "'");
    //ถ้าในฐานข้อมูลมี ผู้ใช้งานแล้ว
    if (mysqli_num_rows($chk_material) != "0") {
        echo "<script> alert('วัตถุดิบมีอยู่ในระบบแล้ว'); window.history.back();</script>";
        exit();
    }

    $sql        =    "INSERT INTO materials SET 
						material_name		= '" . $_POST['material_name'] . "',
						material_qty		= '" . $_POST['material_qty'] . "',
						material_count		= '" . $_POST['material_count'] . "'";

    if (mysqli_query($link, $sql)) {
        $new_materialid = mysqli_insert_id($link);
        echo "<script> alert('เพิ่มข้อมูลเรียบร้อย รหัสวัตถุดิบ: ". $new_materialid ."'); window.location.assign('show_material.php')</script>";
    } else {
        echo "<script> alert('เพิ่มข้อมูลผิดพลาด'); window.location.assign('show_material.php')</script>";  
    }
}
