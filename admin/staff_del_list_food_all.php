<?php
session_start();
//require_once('conf/connection.php');
unset($_SESSION['food_admin']['list']);

if (isset($_GET['oid'])) {
    echo  "<script> alert('ล้างตะกร้าสำเร็จ');window.location.assign('order_more.php?oid=". $_GET['oid'] ."') </script>";
} else {
    echo  "<script> alert('ล้างตะกร้าสำเร็จ');window.location.assign('staff_cart_order.php') </script>";
}
