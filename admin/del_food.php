<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if ((!isset($_SESSION['staff']) )) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
    }

    require_once('../conf/connection.php');
    $sql_food    = mysqli_query($link, "SELECT * FROM foods WHERE foodid = '" . $_POST['foodid'] . "'");
    while ($result = mysqli_fetch_array($sql_food)) {
        $old_file = "../" . $result['food_image'];
          }
    if (mysqli_query($link, "DELETE FROM foods WHERE foodid = '" . $_POST['foodid'] . "' ")) {
        if (file_exists($old_file)) {
            unlink($old_file);
        }
        echo "<script> alert('ลบข้อมูล รหัสรายการอาหาร: " .$_POST['foodid']. " เรียบร้อยแล้ว'); window.location.assign('show_food.php')</script>";
    } else {
        echo "<script> alert('ไม่สามารถลบข้อมูล รหัสรายการอาหาร: " .$_POST['foodid']. " ได้'); window.location.assign('show_food.php')</script>";
    }
}
