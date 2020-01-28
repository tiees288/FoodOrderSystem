<?php 
	if(!isset($_SESSION)){  // Check if sessio nalready start
		session_start();
    }
    //require_once('conf/connection.php');
    
    if (!isset($_GET['foodid'])) {
	    echo "<script>window.location.assign('index.php') </script>";
		exit();
    }

    //$food_id	= $_GET['foodid'];
	$key = array_search($_GET['foodid'], $_SESSION['food_admin']['list']['foodid']);
	if((string)$key != ""){
		unset($_SESSION['food_admin']['list']['foodid'][$key]);
		unset($_SESSION['food_admin']['list']['amount'][$key]);
		unset($_SESSION['food_admin']['list']['food_price'][$key]);
	}

	$new_foodid = array_values($_SESSION['food_admin']['list']['foodid']);
	unset($_SESSION['food_admin']['list']['foodid']);
	$_SESSION['food_admin']['list']['foodid'] = $new_foodid;
	
	$new_foodamount = array_values($_SESSION['food_admin']['list']['amount']);
	unset($_SESSION['food_admin']['list']['amount']);
	$_SESSION['food_admin']['list']['amount'] = $new_foodamount;

	$new_price = array_values($_SESSION['food_admin']['list']['food_price']);
	unset($_SESSION['food_admin']['list']['food_price']);
	$_SESSION['food_admin']['list']['food_price'] = $new_price;
	

		if (!isset($_SESSION['food_admin']['list']['foodid']['0'])) {
			unset($_SESSION['food_admin']);
		}
if (isset($_GET['oid'])) {
	echo "<script> window.location.assign('order_edit.php?oid=". $_GET['oid'] ."'); </script>";
} else {
	echo "<script> window.location.assign('staff_cart_order.php'); </script>";
}
