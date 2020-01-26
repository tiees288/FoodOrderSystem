<?php
define('SITE_ROOT', '/');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('../conf/connection.php');


    $prd_image        =    $_FILES['food_image']['name'];
    $extension        = array("jpeg", "jpg", "png", "gif");
    $file_extension   = pathinfo($prd_image, PATHINFO_EXTENSION);


    $chk_food    = mysqli_query($link, "SELECT * FROM foods WHERE food_name = '" . $_POST['food_name'] . "'");
    //ถ้าในฐานข้อมูลมี ผู้ใช้งานแล้ว
    if (mysqli_num_rows($chk_food) != "0") {
        echo "<script> alert('รายการอาหารนี้มีอยู่ในระบบแล้ว'); window.history.back();</script>";
        exit();
    }

    if ($_FILES['food_image']['name'] == "") { // กรณีไม่ใส่รูปภาพ

        $sql        =    "INSERT INTO foods SET 
				
        food_name	= '" . $_POST['food_name'] . "',
        food_type	= '" . $_POST['food_type'] . "',
        food_price	= '" . $_POST['food_price'] . "',
        food_qty	= '" . $_POST['food_qty'] . "',
        food_count	= '" . $_POST['food_count'] . "',
        food_status = '0'";

        if (mysqli_query($link, $sql)) {
            $new_foodid = mysqli_insert_id($link);
            echo  "<script> alert('เพิ่มข้อมูลเรียบร้อย รหัสรายการอาหาร: " . $new_foodid . "');window.location.assign('show_food.php');</script>";
            exit();
        }
    }

    $sql        =    "INSERT INTO foods SET 
				
				food_name	= '" . $_POST['food_name'] . "',
                food_type	= '" . $_POST['food_type'] . "',
                food_price	= '" . $_POST['food_price'] . "',
                food_qty	= '" . $_POST['food_qty'] . "',
                food_count	= '" . $_POST['food_count'] . "',
                food_image  = '" . "images/food/" . $prd_image . "',
                food_status = '0'";

    if (in_array($file_extension, $extension)) {
        if (move_uploaded_file($_FILES['food_image']['tmp_name'], "../images/food/" . $prd_image)) {
            if (mysqli_query($link, $sql)) {
                $new_foodid = mysqli_insert_id($link);
                echo  "<script> alert('เพิ่มข้อมูลเรียบร้อย รหัสรายการอาหาร: " . $new_foodid . "');window.location.assign('show_food.php');</script>";
                exit();
            }
        }
    } else {
        echo "<script>alert('ไฟล์ที่จะอัพโหลด จะต้องเป็นรูปภาพเท่านั้น'); window.history.back();</script>";
    }
}
