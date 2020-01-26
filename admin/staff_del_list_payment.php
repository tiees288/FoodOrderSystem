<?php
if (!isset($_SESSION)) {  // Check if sessio nalready start
	session_start();
}
//require_once('conf/connection.php');

if (!isset($_GET['oid'])) {
	echo "<script>window.location.assign('index.php') </script>";
	exit();
}

//$food_id	= $_GET['orderid'];
$key = array_search($_GET['oid'], $_SESSION['food_admin']['payment']['orderid']);
if ((string) $key != "") {
	unset($_SESSION['food_admin']['payment']['orderid'][$key]);
//	unset($_SESSION['food_admin']['payment']['seats'][$key]);
}

$new_orderid = array_values($_SESSION['food_admin']['payment']['orderid']);
unset($_SESSION['food_admin']['payment']['orderid']);
$_SESSION['food_admin']['payment']['orderid'] = $new_orderid;

/*
$new_seats = array_values($_SESSION['food_admin']['payment']['seats']);
unset($_SESSION['food_admin']['payment']['seats']);
$_SESSION['food_admin']['payment']['seats'] = $new_seats;
*/

if (!isset($_SESSION['food_admin']['payment']['orderid']['0'])) {
	unset($_SESSION['food_admin']['payment']);
}

echo  "<script> window.location.assign('staff_cart_payment.php');</script>";
