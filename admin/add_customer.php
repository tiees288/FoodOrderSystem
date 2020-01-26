<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	require('../conf/connection.php');
	include_once('../conf/function.php');

	$cus_name		=	$_POST['cus_name'];
	$cus_tel	    =	$_POST['cus_tel'];
	$cus_birth	    =  	tochristyear($_POST['cus_birth']);
	$cus_email		=	$_POST['cus_email'];
	$cus_address 	=	$_POST['cus_address'];
	$cus_postnum	=	$_POST['cus_postnum'];

	/*
	//ตรวจสอบ user ซ้ำ
	$chk_username	= mysqli_query($link, "SELECT * FROM customers WHERE cus_user = '" . $user_name . "'");
	//ถ้าในฐานข้อมูลมี ผู้ใช้งานแล้ว
	if (mysqli_num_rows($chk_username) != "") {
		echo "<script> alert('ชื่อผู้ใช้ถูกใช้แล้ว');</script>";
		exit();
	} */
	$chk_user	= mysqli_query($link, "SELECT * FROM customers WHERE cus_user = '" . $cus_tel . "'");
	//ถ้าในฐานข้อมูลมี ผู้ใช้งานแล้ว
	if (mysqli_num_rows($chk_user) != "0") {
		echo "<script> alert('ชื่อผู้ใช้นี้ถูกใข้ไปแล้ว'); window.history.back();</script>";
		exit();
	}

	$chk_email	= mysqli_query($link, "SELECT * FROM customers WHERE cus_email = '" . $cus_email . "'");
	//ถ้าในฐานข้อมูลมี ผู้ใช้งานแล้ว
	if (mysqli_num_rows($chk_email) != "0") {
		echo "<script> alert('อีเมลล์ถูกใช้แล้ว'); window.history.back();</script>";
		exit();
	}

	$sql		=	"INSERT INTO customers SET 
						cus_name		= '" . $cus_name . "',
						cus_birth		= '" . $cus_birth . "',
						cus_tel			= '" . $cus_tel . "',
						cus_email		= '" . $cus_email . "',
						cus_user		= '" . $cus_tel . "',
						cus_password	= '" . sha1($cus_tel) . "',
						cus_status		= '0',
						cus_postnum		= '" . $cus_postnum . "',
						cus_address		= '" . $cus_address . "'";

	if (mysqli_query($link, $sql)) {
		$new_cusid = mysqli_insert_id($link);
		echo "<script> alert('เพิ่มข้อมูลเรียบร้อย รหัสลูกค้า:". $new_cusid ."'); window.location.assign('show_customer.php')</script>";
	}
}
