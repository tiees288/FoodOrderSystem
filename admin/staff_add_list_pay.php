<?php

if (!isset($_GET['oid'])) {
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

$sql_order        =    "SELECT * FROM orders WHERE orderid = '" . $_GET['oid'] . "' ";
$data_order     =    mysqli_query($link, $sql_order);
$result_order    =    mysqli_fetch_assoc($data_order);

if (!isset($_SESSION['food_admin']['payment'])) {
    $_SESSION['food_admin']['payment']['orderid']['0'] = $result_order['orderid'];
    //$_SESSION['food_admin']['payment']['amount']['0'] = 1; // จำนวนสินค้า
    //$_SESSION['food_admin']['payment']['seats']['0'] = $result_order['order_seats'];
} else {
    $key = array_search($_GET['oid'], $_SESSION['food_admin']['payment']['orderid']);

    if ((string) $key != "") {
        echo "<script> window.location.assign('staff_cart_payment.php'); </script>";
        exit();
    } else {

        if ($result_order['order_type'] == 2) {
            echo "<script>alert('ไม่สามารถเลือกรายการนี้ได้'); window.history.back();</script>";
            exit();
        } else {
            $sql_type = "SELECT order_type FROM orders WHERE orderid = '" . $_SESSION['food_admin']['payment']['orderid'][0] . "'";
            $query_type = mysqli_query($link, $sql_type) or die(mysqli_error($link));
            $result_type = mysqli_fetch_assoc($query_type);

            if ($result_type['order_type'] == 2) { // เช็คเมื่อหยิบ เข้าตะกร้ามากกว่า 1
                echo "<script>alert('ไม่สามารถเลือกรายการนี้ได้'); window.history.back();</script>";
                exit();
            }
        }
        // เพิ่ม การสั่งในตะกร้าชำระ
        $count = count($_SESSION['food_admin']['payment']['orderid']);
        $_SESSION['food_admin']['payment']['orderid'][$count] = $result_order['orderid'];
    }
}
echo  "<script>window.location.assign('staff_cart_payment.php') </script>";
