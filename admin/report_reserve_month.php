<?php
if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['staff']) && ($_SESSION['staff_level'] != 1)) {
    echo "<script>alert('กรุณาตรรวจสอบสิทธิ์การเข้าใช้งาน'); window.location.assign('login_staff.php');</script>";
    exit();
}

if (!isset($_POST['month']) && !isset($_POST['year'])) {
    echo "<script>window.location.assign('monthly_report_selector.php?report_name=order_month');</script>";
    exit();
}

include("conf/lib.php");
include("../conf/function.php");
include("../conf/connection.php");

$month  = $_POST['month'];
$year    = $_POST['year'];
?>

<head>
    <title>รายงานการจองรประจำเดือน <?= fullmonth($month); ?> พ.ศ. <?= $year + 543 ?> | Food Order System</title>
</head>

<body>
    <div class="container" style="padding-top:20px; width:1350px;">
        <h3 class="text-center">รายงานการจองประจำเดือน</h3>
        <h3 class="text-center">เดือน <?= fullmonth($month) ?> พ.ศ. <?= $year + 543 ?></h3>
        <br>
    </div>