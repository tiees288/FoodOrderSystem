<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	require('../conf/connection.php');
	include('../conf/function.php');

	$name			=	$_POST['staff_name'];
	$number_phone	=	$_POST['staff_tel'];
	$staff_birth	= 	date("Y-m-d", strtotime(tochristyear($_POST['staff_birth'])));
	$email			=	$_POST['staff_email'];
	$address 		=	$_POST['staff_address'];
	//$user_name	=	trim($_POST['user_name']);
	//$password		=	trim($_POST['password']);
	$staff_postnum	=	$_POST['staff_postnum'];
	$staff_nationid =	$_POST['staff_nationid'];
	$staff_level 	= 	$_POST['staff_level'];

	$chk_nationid	= mysqli_query($link, "SELECT * FROM staff WHERE staff_nationid = '" . $staff_nationid . "'");
	//ถ้าในฐานข้อมูลมี ผู้ใช้งานแล้ว
	if (mysqli_num_rows($chk_nationid) != "0") {
		echo "<script> alert('หมาบเลขบัตรประชาชนนี้ถูกใช้แล้ว'); window.history.back();</script>";
		exit();
	}
	//ถ้าไม่มีให้เพิ่มข้อมูล
	//	echo "$name $number_phone $cus_birth $email $address $user_name $password $cus_postnum";
	$sql		=	"INSERT INTO staff SET 
						staff_name		= '" . $name . "',
						staff_birth		= '" . $staff_birth . "',
						staff_tel		= '" . $number_phone . "',
						staff_email		= '" . $email . "',
						staff_status	= '0',
						staff_postnum	= '" . $staff_postnum . "',
						staff_username	= '" . $staff_nationid . "',
						staff_password	= '" . sha1($staff_nationid) . "',
						staff_address	= '" . $address . "',
						staff_nationid	= '" . $staff_nationid . "',
						staff_level		= '" . $staff_level . "'";

	if (mysqli_query($link, $sql)) {
		$new_staffid = mysqli_insert_id($link);
		echo "<script> alert('เพิ่มข้อมูลเรียบร้อย รหัสพนักงาน: " . $new_staffid . "'); window.location.assign('show_staff.php')</script>";
	}
}
