<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('../conf/connection.php');
    //	include_once('../conf/function.php');


     $chk_bankdetails    = mysqli_query($link, "SELECT * FROM banks WHERE bank_details = '" . $_POST['bank_details'] . "'");
    //ถ้าในฐานข้อมูลมี ผู้ใช้งานแล้ว
    if (mysqli_num_rows($chk_bankdetails) != "0") {
        echo "<script> alert('เลขที่บัญชีนี้ มีในระบบแล้ว'); window.history.back();</script>";
        exit();
    }

    $sql        =    "INSERT INTO banks SET 
						bank_name		= '" . $_POST['bank_name'] . "',
						bank_branch		= '" . $_POST['bank_branch'] . "',
						bank_details	= '" . $_POST['bank_details'] . "'";

    if (mysqli_query($link, $sql)) {
        $new_bank = mysqli_insert_id($link);
        echo "<script> alert('เพิ่มข้อมูลเรียบร้อย รหัสธนาคาร: " . $new_bank . "'); window.location.assign('show_bank.php')</script>";
    } else {
        echo "<script> alert('เพิ่มข้อมูลผิดพลาด'); window.location.assign('show_bank.php')</script>";
    }
}
