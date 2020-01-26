<?php
define('SITE_ROOT', '/');

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    echo "<script> window.location.assign('login.php');</script>";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('conf/connection.php');
    require_once('conf/function.php');

    $evidence       =  $_POST['orderid'] . "_" . date("Y-m-d") . "_" . $_FILES['order_evidence']['name'];
    $evidence_time  = dt_tochristyear($_POST['evidence_time']);

    //ตรวจสอบถ้ามีการแจ้งหลักฐานไปแล้ว
    $chk_evidence    = mysqli_query($link, "SELECT * FROM orders WHERE orderid = '" . $_POST['orderid'] . "'");
    $chk_evidence_data = mysqli_fetch_assoc($chk_evidence);
    if ($chk_evidence_data['order_evidence'] != "") {
        echo "<script> alert('ไม่สามารถแจ้งหลักฐานซ้ำได้'); window.location.assign('order_history.php');</script>";
        exit();
    }

    $sql = "UPDATE orders SET
            order_evidence_date = '" . $evidence_time . "',
            order_status = '1',
            order_evidence = '" . "images/pay_evidence/" . $evidence . "' WHERE orderid = '" . $_POST['orderid'] . "'";

    if (move_uploaded_file($_FILES['order_evidence']['tmp_name'], "images/pay_evidence/" . $evidence)) {
        if (mysqli_query($link, $sql)) {
            echo  "<script> alert('แจ้งหลักฐาน รหัสการสั่ง " . str_pad($_POST['orderid'], 5, 0, STR_PAD_LEFT) . " เรียบร้อย');window.location.assign('order_history.php');</script>";
        }
    } else {
        // echo  "<script> alert('อัพโหลดไฟล์ผิดพลาด');window.location.assign('show_food.php') </script>";
    }

}
