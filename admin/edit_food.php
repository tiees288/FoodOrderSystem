<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('../conf/connection.php');
    $food_image        =    $_FILES['food_image']['name'];
    $extension        = array("jpeg", "jpg", "png", "gif");
    $file_extension   = pathinfo($food_image, PATHINFO_EXTENSION);

    if ($food_image == "") {

        $sql_update  = "UPDATE foods SET 
		        food_name       = '" . $_POST['food_name'] . "',
                food_type	    = '" . $_POST['food_type'] . "',
                food_price	    = '" . $_POST['food_price'] . "',
                food_qty	    = '" . $_POST['food_qty'] . "',
                food_count	    = '" . $_POST['food_count'] . "',
                food_status     = '" . $_POST['food_status'] . "'  WHERE foodid = '" . $_POST['foodid'] . "' ";

        if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
            echo "<script> alert('แก้ไขข้อมูล หัสรายการอาหาร: " . $_POST['foodid'] . " เรียบร้อยแล้ว'); window.location.assign('show_food.php')</script>";
        }
    } else {
        $sql_update  = "UPDATE foods SET 
		        food_name       = '" . $_POST['food_name'] . "',
                food_type	    = '" . $_POST['food_type'] . "',
                food_price	    = '" . $_POST['food_price'] . "',
                food_qty	    = '" . $_POST['food_qty'] . "',
                food_count	    = '" . $_POST['food_count'] . "',
                food_image      = '" . "images/food/" . $food_image . "',
                food_status     = '" . $_POST['food_status'] . "' WHERE foodid = '" . $_POST['foodid'] . "' ";
        if (in_array($file_extension, $extension)) {
            if (move_uploaded_file($_FILES['food_image']['tmp_name'], "../images/food/" . $food_image)) {

                $sql_food    = mysqli_query($link, "SELECT * FROM foods WHERE foodid = '" . $_POST['foodid'] . "'");
                while ($result = mysqli_fetch_array($sql_food)) {
                    $old_file = "../" . $result['food_image'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
                if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
                    echo "<script> alert('แก้ไขข้อมูล รหัสรายการอาหาร: " . $_POST['foodid'] . " เรียบร้อยแล้ว'); window.location.assign('show_food.php')</script>";
                }
            }
        } else {
            echo "<script>alert('ไฟล์ที่จะอัพโหลด จะต้องเป็นรูปภาพเท่านั้น'); window.history.back();</script>";
        }
    }
}
