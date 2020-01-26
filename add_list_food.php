<?php

    if (!isset($_GET['foodid'])) {
		echo "<script>window.location.assign('index.php') </script>";
		exit();
    }
    
    if(!isset($_SESSION)){  // Check if sessio nalready start
		session_start();
    }
    
	if(!isset($_SESSION['user'])){ // ตรวจสอบว่า Login แล้วหรือไม่
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

	$sql_food	    =	"SELECT * FROM foods WHERE foodid = '".$_GET['foodid']."' ";
	$data_food	    =	mysqli_query($link,$sql_food);
	$result_food	=	mysqli_fetch_assoc($data_food);

	if(!isset($_SESSION['food']['list'])){
		$_SESSION['food']['list']['foodid']['0'] = $result_food['foodid'];
		$_SESSION['food']['list']['amount']['0'] = 1; // จำนวนสินค้า
		$_SESSION['food']['list']['food_price']['0'] = $result_food['food_price'];
	}
	else {
		$key = array_search($_GET['foodid'], $_SESSION['food']['list']['foodid']);

		    for ($i=0; $i < count($_SESSION['food']['list']['foodid']) ; $i++) { 
		    	$sum[] = $_SESSION['food']['list']['food_price'][$i]*$_SESSION['food']['list']['amount'][$i];
		    }
        
        /* $sum = array_sum($sum);
            if($sum >= "120000"){
                echo  "<script> alert('ไม่สามารถทำรายการได้เนื่องจากยอดชำระมากกว่า 120,000 บาท');window.location.assign('index.php') </script>";
                exit();
            }*/

		if((string)$key != ""){
			$_SESSION['food']['list']['amount'][$key] =  $_SESSION['food']['list']['amount'][$key]+1;
		} else {  $count = count($_SESSION['food']['list']['foodid']);
			      $_SESSION['food']['list']['foodid'][$count] = $result_food['foodid'];
			      $_SESSION['food']['list']['amount'][$count] = 1;
			      $_SESSION['food']['list']['food_price'][$count] = $result_food['food_price'];
		    }
	}
   	echo  "<script>window.location.assign('cart_order.php') </script>";
    //echo $_SESSION['food']['list']['foodid']['1'];
