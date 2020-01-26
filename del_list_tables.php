<?php
if (!isset($_SESSION)) {  // Check if sessio nalready start
	session_start();
}
require_once('conf/connection.php');

if (!isset($_GET['tables_no'])) {
	echo "<script>window.location.assign('index.php') </script>";
	exit();
}

//$food_id	= $_GET['tables_no'];
$key = array_search($_GET['tables_no'], $_SESSION['food']['reserve']['tables_no']);
if ((string) $key != "") {
	unset($_SESSION['food']['reserve']['tables_no'][$key]);
	unset($_SESSION['food']['reserve']['seats'][$key]);
}

$new_tables_no = array_values($_SESSION['food']['reserve']['tables_no']);
unset($_SESSION['food']['reserve']['tables_no']);
$_SESSION['food']['reserve']['tables_no'] = $new_tables_no;

$new_seats = array_values($_SESSION['food']['reserve']['seats']);
unset($_SESSION['food']['reserve']['seats']);
$_SESSION['food']['reserve']['seats'] = $new_seats;


if (!isset($_SESSION['food']['reserve']['tables_no']['0'])) {
	unset($_SESSION['food']['reserve']);
}

echo  "<script> window.location.assign('cart_reserve.php');</script>";
