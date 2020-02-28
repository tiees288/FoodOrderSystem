<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if ((!isset($_SESSION['staff']) || ($_SESSION['staff_level'] != 1))) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
    }

    if ($_SESSION['staff_id'] == $_POST['staffid']) {
        echo "<script>alert('ไม่สามารถลบได้'); window.location.assign('show_staff.php')</script>";
        exit();
    }

    require_once('../conf/connection.php');

    if (mysqli_query($link, "DELETE FROM staff WHERE staffid = '" . $_POST['staffid'] . "' ")) {
        echo "<script> alert('ลบข้อมูล รหัสพนักงาน: ". $_POST['staffid'] ." เรียบร้อยแล้ว'); window.location.assign('show_staff.php')</script>";
    } else {
        echo "<script> alert('ไม่สามารถลบได้'); window.location.assign('show_staff.php')</script>";
    }
}
?>