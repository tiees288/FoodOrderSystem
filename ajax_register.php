<?php

if (isset($_POST['user_name'])) {

    require_once("conf/connection.php");

    if (!empty($_POST["user_name"])) {
        $sql_cus = "SELECT * FROM customers WHERE cus_user ='" . $_POST["user_name"] . "'";
        $query_cus = mysqli_query($link, $sql_cus) or die(mysqli_error($link));
        $user_count = mysqli_num_rows($query_cus);
        if ($user_count > 0) {
            echo "false"; // ซ้ำ
        } else {
            echo "true"; // ไม่ซ้ำ
        }
    }

}
