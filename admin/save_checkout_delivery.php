<?php
if (!isset($_SESSION))
    session_start();
if (!isset($_SESSION['staff'])) {
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['oid'])) {

    require_once("../conf/connection.php");
    require_once("conf/lib.php");
    include_once("../conf/function.php");

    $oid = mysqli_real_escape_string($link, $_POST['oid']);
    
    $sql_deliver = "UPDATE orders SET
        order_date_delivered = '" . tochristyear($_POST['order_date_delivered']) . "',
        order_time_delivered = '" . $_POST['order_time_delivered'] . "'
    WHERE orderid = '" . $oid . "'";

    if (mysqli_query($link, $sql_deliver))
        echo "<script>alert('บันทึกการส่ง รหัสการสั่งอาหาร ". $oid ." เรียบร้อยแล้ว'); window.location.assign('staff_order_history.php');</script>";
} else {
    echo "<script>window.location.assign('staff_order_history.php');</script>";
}
