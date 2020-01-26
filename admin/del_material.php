<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if ((!isset($_SESSION['staff']) )) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
    }

    require_once('../conf/connection.php');
    if (mysqli_query($link, "DELETE FROM materials WHERE materialid = '" . $_POST['materialid'] . "' ")) {
        echo "<script> alert('ลบข้อมูล รหัสวัตถุดิบ: ". $_POST['materialid'] ." เรียบร้อยแล้ว'); window.location.assign('show_material.php')</script>";
    } else {
        echo "<script> alert('ไม่สามารถลบได้'); window.location.assign('show_material.php')</script>";
    }
} 
?>
