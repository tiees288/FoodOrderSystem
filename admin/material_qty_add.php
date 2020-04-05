<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once("../conf/connection.php");

    $materialid = mysqli_real_escape_string($link,$_POST['materialid']);
    $qty_add = mysqli_real_escape_string($link, $_POST['material_qty_add']);

    if (!isset($_POST['materialid']) || !isset($_POST['material_qty_add'])) {
        exit();
    }

    $sql_add_qty = "UPDATE materials SET material_qty = material_qty + '$qty_add' WHERE materialid = '$materialid'";

    if (mysqli_query($link,$sql_add_qty)) {
        echo "<script> alert('เพิ่มจำนวนวัตถุดิบ รหัสวัตถุดิบ: ". $materialid ." เรียบร้อยแล้ว'); window.location.assign('show_material.php');</script>";
    } else {
        echo "<script> alert('เพิ่มจำนวนวัตถุดิบ รหัสวัตถุดิบ: ". $materialid ." ผิดพลาด'); window.history.back();</script>";
    }

}
?>