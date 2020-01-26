<?php
if (!isset($_SESSION))
    session_start();
if (!isset($_SESSION['staff'])) {
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once("../conf/connection.php");
    require_once("conf/lib.php");
    include_once("../conf/function.php");

    $sql_deliver = "UPDATE orders SET
        order_date_delivered = '" . tochristyear($_POST['order_date_delivered']) . "',
        order_time_delivered = '" . $_POST['order_time_delivered'] . "'
    WHERE payno = '" . $_POST['payno'] . "'";

    if (mysqli_query($link, $sql_deliver))
        echo "<script>alert('บันทึกการส่งเรียบร้อยแล้ว'); window.location.assign('staff_payment_history.php');</script>";
} else {
    echo "<sript>window.location.assign('staff_payment_history.php');</script>";
}
