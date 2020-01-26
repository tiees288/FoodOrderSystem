<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('../conf/connection.php');
    include_once('../conf/function.php');

    $cusid          =   $_POST['cusid'];
    $cus_name       =   $_POST['cus_name'];
    $cus_birth      =   tochristyear($_POST['cus_birth']);
    $cus_tel        =   $_POST['cus_tel'];
    $cus_email      =   $_POST['cus_email'];
    $cus_address    =   $_POST['cus_address'];
    $cus_postnum  =   $_POST['cus_postnum'];
    $cus_status   =   $_POST['cus_status'];
    $data_cus1      = mysqli_query($link, "SELECT * FROM customers WHERE cusid = '" . $cusid . "'") or die(mysqli_error($link));
    $data1          = mysqli_fetch_assoc($data_cus1);



    $sql_update     = "UPDATE customers SET 
			cus_name		= '" . $cus_name . "',
			cus_birth		= '" . $cus_birth . "',
			cus_tel		    = '" . $cus_tel . "',
			cus_email		= '" . $cus_email . "',
			cus_address	= '" . $cus_address . "',
            cus_postnum	= '" . $cus_postnum . "',
            cus_status	= '" . $cus_status . "' WHERE cusid = '" . $cusid . "' ";
}

if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
    // $data_user     = mysqli_query($link, "SELECT * FROM staff WHERE staffid = '" . $staffid . "'");
    //$data         = mysqli_fetch_assoc($data_user);
    //	$_SESSION['user'] 	= $data['cus_user'];	
    echo "<script> alert('แก้ไขข้อมูล รหัสสมาชิก: ". $cusid ." เรียบร้อยแล้ว'); window.location.assign('show_customer.php')</script>";
}
