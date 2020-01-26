<?php

if (!isset($_GET['tables_no'])) {
	echo "<script>window.location.assign('index.php') </script>";
	exit();
}

if (!isset($_SESSION)) {  // Check if sessio nalready start
	session_start();
}

if (!isset($_SESSION['user'])) { // ตรวจสอบว่า Login แล้วหรือไม่
	echo  "<script> alert('กรุณาเข้าสู่ระบบก่อนสั่งอาหาร');window.location.assign('login.php') </script>";
	exit();
}

require_once('conf/connection.php');
/*
	$sql_chk 		=	"SELECT * FROM customers WHERE cusid = ".$_SESSION['user_id'];
	$data_cus		=	mysqli_query($link,$sql_chk);
	$result_cus		=	mysqli_fetch_assoc($data_cus);
    
	 if($result_cus['cus_status'] == "1"){
		echo  "<script> alert('ไม่สามารถทำรายการได้เนื่องจากเป็นลูกค้าบัญชีดำ');window.location.assign('index.php') </script>";
		exit();
	}*/

$sql_tables	    =	"SELECT * FROM tables WHERE tables_no = '" . $_GET['tables_no'] . "' ";
$data_tables    =	mysqli_query($link, $sql_tables);
$result_tables	=	mysqli_fetch_assoc($data_tables);

if (!isset($_SESSION['food']['reserve'])) {
	$_SESSION['food']['reserve']['tables_no']['0'] = $result_tables['tables_no'];
	//$_SESSION['food']['reserve']['amount']['0'] = 1; // จำนวนสินค้า
	$_SESSION['food']['reserve']['seats']['0'] = $result_tables['tables_seats'];
} else {
	$key = array_search($_GET['tables_no'], $_SESSION['food']['reserve']['tables_no']);

	/* for ($i=0; $i < count($_SESSION['food']['reserve']['foodid']) ; $i++) { 
		    	$sum[] = $_SESSION['food']['reserve']['food_price'][$i]*$_SESSION['food']['reserve']['amount'][$i];
		    } */

	if ((string) $key != "") {
		//	$_SESSION['food']['reserve']['amount'][$key] =  $_SESSION['food']['reserve']['amount'][$key]+1;
		echo "<script> alert('โต๊ะนี้ถูกเลือกอยู่ในตะกร้าแล้ว'); window.history.back(); </script>";
		exit();
	} else {
		$count = count($_SESSION['food']['reserve']['tables_no']);
		$_SESSION['food']['reserve']['tables_no'][$count] = $result_tables['tables_no'];
		//    $_SESSION['food']['reserve']['amount'][$count] = 1;
		$_SESSION['food']['reserve']['seats'][$count] = $result_tables['tables_seats'];
	}
}
echo  "<script>window.location.assign('cart_reserve.php') </script>";
