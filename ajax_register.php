<?php

if (isset($_POST['user_name'])) {

    require_once("conf/connection.php");
    require_once("conf/function.php");

    if (!empty($_POST["user_name"])) {
        if (utf8_strlen($_POST['user_name']) >= 5 && utf8_strlen($_POST['user_name']) <= 15 && (!preg_replace('/[^ก-ฮ]/u','',$_POST['user_name']))) { // ตรวจจำนวน
            $sql_cus = "SELECT * FROM customers WHERE cus_user ='" . $_POST["user_name"] . "'";
            $query_cus = mysqli_query($link, $sql_cus) or die(mysqli_error($link));
            $user_count = mysqli_num_rows($query_cus);
            if ($user_count > 0) {
                echo "false"; // ซ้ำ
            } else {
                echo "true"; // ไม่ซ้ำ
            }
        } else {
            echo "false";
        }
    }
}
