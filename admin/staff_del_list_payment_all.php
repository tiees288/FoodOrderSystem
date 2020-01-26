<?php 
session_start();
//require_once('conf/connection.php');
unset($_SESSION['food_admin']['payment']);

echo  "<script> alert('ล้างตะกร้าสำเร็จ');window.location.assign('staff_cart_payment.php') </script>";
?>