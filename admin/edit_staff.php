<?php

session_start();
if ((!isset($_SESSION['staff']))) {
    echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('../conf/connection.php');
    include_once('../conf/function.php');

    $staffid        =   $_POST['staffid'];
    $name           =   $_POST['staff_name'];
    $staff_birth    =   date("Y-m-d", strtotime(tochristyear($_POST['staff_birth'])));
    $number_phone   =   $_POST['staff_tel'];
    $email          =   $_POST['staff_email'];
    $address        =   $_POST['staff_address'];
    $staff_postnum  =   $_POST['staff_postnum'];
    $staff_nationid =   $_POST['staff_nationid'];
    $staff_level    =   $_POST['staff_level'];
    $staff_status   =   $_POST['staff_status'];
    $data_staff1    = mysqli_query($link, "SELECT * FROM staff WHERE staffid = '" . $staffid . "'") or die(mysqli_error($link));
    $data1          = mysqli_fetch_assoc($data_staff1);


    $chk_nationid    = mysqli_query($link, "SELECT * FROM staff WHERE staff_nationid = '" . $staff_nationid . "'");
    //ถ้าในฐานข้อมูลมี ผู้ใช้งานแล้ว

    $sql_update     = "UPDATE staff SET 
			staff_name		= '" . $name . "',
			staff_birth		= '" . $staff_birth . "',
			staff_tel		= '" . $number_phone . "',
			staff_email		= '" . $email . "',
			staff_address	= '" . $address . "',
            staff_postnum	= '" . $staff_postnum . "',
            staff_nationid	= '" . $staff_nationid . "',
            staff_level 	= '" . $staff_level . "',
            staff_status	= '" . $staff_status . "' WHERE staffid = '" . $staffid . "' ";
}

//อัพแดท ข้อมูล ผู้ใช้งาน
if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
    echo "<script> alert('แก้ไขข้อมูล รหัสพนักงาน: ". $staffid ." เรียบร้อยแล้ว'); window.location.assign('show_staff.php')</script>";
} else {
    echo "<script> alert('แก้ไขข้อมูลผิดพลาด'); window.location.assign('show_staff.php')</script>";
}
