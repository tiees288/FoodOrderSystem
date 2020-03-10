<?php
session_start();
include("conf/connection.php");
include("conf/function.php");

$totalprice = $_POST['totalprice'];
$orderdate = dt_tochristyear($_POST['orderdate']);
$deliverydate = date("Y-m-d", strtotime(tochristyear($_POST['deliverydate'])));
$deliveryplace = $_POST["deliveryplace"] . " " . $_POST['postnum'];

$sqlorder = "
	INSERT INTO orders (orderdate, order_date_tobedelivery, order_time_tobedelivery, order_delivery_place, order_type, order_totalprice, cusid)
	VALUES
	('" . $orderdate . "','" . $deliverydate . "', '" . $_POST['deliverytime'] . "' ,'" . $deliveryplace . "','2','" . $totalprice . "', '" . $_SESSION['user_id'] . "') 
  ";
mysqli_query($link, $sqlorder) or die(mysqli_error($link));

$last_orderid = mysqli_insert_id($link);

for ($i = 0; $i < count($_SESSION['food']['list']['foodid']); $i++) {

	$sql_addfoodlist =	"INSERT INTO orderdetails ( `orderdet_amount`, `orderdet_status`,`orderdet_price`,`orderid`, foodid, orderdet_note) 
	VALUES ('" . $_SESSION['food']['list']['amount'][$i] . "', '0','" . $_SESSION['food']['list']['food_price'][$i] . "','" . $last_orderid . "', '" . $_SESSION['food']['list']['foodid'][$i] . "', '" . $_POST['order_note_' . $_SESSION['food']['list']['foodid'][$i]] . "')";

	mysqli_query($link, $sql_addfoodlist) or die(mysqli_error($link));

	$sql_recommend =  "UPDATE foods SET
      food_recomend = (food_recomend + '" . $_SESSION['food']['list']['amount'][$i] . "') WHERE foodid = '" . $_SESSION['food']['list']['foodid'][$i] . "'";
	mysqli_query($link, $sql_recommend) or die(mysqli_error($link));
}

unset($_SESSION['food']['list']);

echo '<script>alert("บันทึกการสั่งอาหารเรียบร้อยแล้ว\nรหัสการสั่งคือ ' . str_pad($last_orderid, 5, 0, STR_PAD_LEFT) . '"); window.location.assign("order_history.php")</script>';
mysqli_close($link);
