<?php
if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['staff'])) {
    header("location: login_staff.php");
    exit();
}

require_once("../conf/connection.php");
require_once("../conf/function.php");

if (isset($_GET['pno'])) { // กรณียกเลิกเฉพาะรายการ
    $pno = mysqli_real_escape_string($link, $_GET['pno']);

    $sql_payment = "UPDATE payment SET
        pay_status = 2 WHERE payno = '$pno'";
    $sql_order = "UPDATE orders SET
        payno_cancel = payno,
        order_status = 0 WHERE payno = '$pno'";

    if (mysqli_query($link, $sql_payment) && mysqli_query($link, $sql_order)) {
        echo "<script>
            alert('ยกเลิกใบเสร็จรับเงิน หมายเลข " . $pno . " เรียบร้อยแล้ว');
            window.location.assign('staff_payment_history.php');
        </script>";
    } else {
        echo "ยกเลิกใบเสร็จผิดพลาด";
    }
} else {
    echo "<script>window.location.assign('staff_payment_history.php');</script>";
}
