<?php

if (!isset($_GET['foodid'])) {
	echo "<script>window.location.assign('index.php') </script>";
	exit();
}

if (!isset($_SESSION)) {  // Check if sessio nalready start
	session_start();
}

if (!isset($_SESSION['staff'])) {
	echo  "<script> alert('กรุณาเข้าสู่ระบบ');window.location.assign('index.php') </script>";
	exit();
}

require_once('../conf/connection.php');
/*
	$sql_chk 		=	"SELECT * FROM customers WHERE cusid = ".$_SESSION['user_id'];
	$data_cus		=	mysqli_query($link,$sql_chk);
	$result_cus		=	mysqli_fetch_assoc($data_cus);
    
	 if($result_cus['cus_status'] == "1"){
		echo  "<script> alert('ไม่สามารถทำรายการได้เนื่องจากเป็นลูกค้าบัญชีดำ');window.location.assign('index.php') </script>";
		exit();
	}*/

$sql_food	    =	"SELECT * FROM foods WHERE foodid = '" . $_GET['foodid'] . "' ";
$data_food	    =	mysqli_query($link, $sql_food);
$result_food	=	mysqli_fetch_assoc($data_food);

if (!isset($_SESSION['food_admin']['list'])) {
	$_SESSION['food_admin']['list']['foodid']['0'] = $result_food['foodid'];
	$_SESSION['food_admin']['list']['amount']['0'] = 1; // จำนวนสินค้า
	$_SESSION['food_admin']['list']['food_price']['0'] = $result_food['food_price'];
} else {
	$key = array_search($_GET['foodid'], $_SESSION['food_admin']['list']['foodid']);

	/* for ($i=0; $i < count($_SESSION['food_admin']['list']['foodid']) ; $i++) { 
		    	$sum[] = $_SESSION['food_admin']['list']['food_price'][$i]*$_SESSION['food_admin']['list']['amount'][$i];
		    }
        
         $sum = array_sum($sum);
            if($sum >= "120000"){
                echo  "<script> alert('ไม่สามารถทำรายการได้เนื่องจากยอดชำระมากกว่า 120,000 บาท');window.location.assign('index.php') </script>";
                exit();
            }*/

	if ((string) $key != "") {
		$_SESSION['food_admin']['list']['amount'][$key] =  $_SESSION['food_admin']['list']['amount'][$key] + 1;
	} else {
		$count = count($_SESSION['food_admin']['list']['foodid']);
		$_SESSION['food_admin']['list']['foodid'][$count] = $result_food['foodid'];
		$_SESSION['food_admin']['list']['amount'][$count] = 1;
		$_SESSION['food_admin']['list']['food_price'][$count] = $result_food['food_price'];
	}
}
if (isset($_GET['oid'])) {
	echo  "<script>window.location.assign('order_edit.php?oid=". $_GET['oid'] ."') </script>";
} else {
	echo  "<script>window.location.assign('staff_cart_order.php') </script>";
}
  
    //echo $_SESSION['food']['list']['foodid']['1'];
