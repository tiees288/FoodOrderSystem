<?php 
session_start();
require_once('conf/connection.php');
unset($_SESSION['food']['reserve']);

echo  "<script> alert('ล้างตะกร้าสำเร็จ');window.location.assign('cart_reserve.php') </script>";
?>