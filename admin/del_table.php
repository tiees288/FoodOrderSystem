<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if ((!isset($_SESSION['staff']))) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
    }

    require_once('../conf/connection.php');

    if (mysqli_query($link, "DELETE FROM tables WHERE tables_no = '" . $_POST['tables_no'] . "' ")) {
        echo "<script> alert('ลบข้อมูล หมายเลขโต๊ะ: " . $_POST['tables_no'] . " เรียบร้อยแล้ว'); window.location.assign('show_table.php')</script>";
    } else {
        echo "<script> alert('ไม่สามารถลบ หมายเลขโต๊ะ: " . $_POST['tables_no'] . " ได้'); window.location.assign('show_table.php')</script>";
    }
}
