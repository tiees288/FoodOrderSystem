<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once("../conf/connection.php");

    $foodid = mysqli_real_escape_string($link,$_POST['foodid']);
    $qty_add = mysqli_real_escape_string($link, $_POST['food_qty_add']);

    if (!isset($_POST['foodid']) || !isset($_POST['food_qty_add'])) {
        exit();
    }

    $sql_add_qty = "UPDATE foods SET food_qty = food_qty + '$qty_add' WHERE foodid = '$foodid'";

    if (mysqli_query($link,$sql_add_qty)) {
        echo "<script> alert('เพิ่มจำนวนรายการอาหาร รหัสรายการอาหาร: ". $foodid ." เรียบร้อยแล้ว'); window.location.assign('show_food.php');</script>";
    } else {
        echo "<script> alert('เพิ่มจำนวนรายการอาหาร รหัสรายการอาหาร: ". $foodid ." ผิดพลาด'); window.history.back();</script>";
    }

}
?>