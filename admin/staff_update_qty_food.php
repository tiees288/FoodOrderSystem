<?php
session_start();
if (isset($_POST)) {
	$i = 0;

	foreach ($_SESSION['food_admin']['list']['foodid'] as $key) {
		//    echo $i;
		$_SESSION['food_admin']['list']['amount'][$i] = $_POST['qty_' . $i];
		$i++;
	}
	//$_SESSION['message'] = 'Cart updated successfully';
	echo "<script> window.location.assign('cart_order.php');</script>";
}
