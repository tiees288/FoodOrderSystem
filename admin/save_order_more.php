<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION))
        session_start();

    include("../conf/connection.php");
    include("../conf/function.php");
    $oid = $_POST['oid']; // Orderid
    $total_price = 0;

    for ($i = 0; $i < count($_SESSION['food_admin']['list']['foodid']); $i++) {
        $sql_check = "SELECT orderdetid, foodid, orderdet_status FROM orderdetails 
            WHERE orderid = '$oid' AND foodid = '" . $_SESSION['food_admin']['list']['foodid'][$i] . "'";
        $query_check = mysqli_query($link, $sql_check);

        $total_price += $_SESSION['food_admin']['list']['amount'][$i] * $_SESSION['food_admin']['list']['food_price'][$i];
        $result_check = mysqli_fetch_array($query_check);
        
        if (mysqli_num_rows($query_check) > 0) { // กรณีตรวจสอบว่ามีในรายการสั่งอยู่แล้ว

            if ($result_check['orderdet_status'] == 2) { // กรณีอาหารถูกยกเลิกไปก่อนหน้า
                $sql_update_oderdet_status = "UPDATE orderdetails SET
                    orderdet_status = '0',
                    orderdet_amount = '" . $_SESSION['food_admin']['list']['amount'][$i] . "'
                WHERE orderdetid = '" . $result_check['orderdetid'] . "'";
                mysqli_query($link, $sql_update_oderdet_status) or die(mysqli_error($link));
            } else {
                $sql_update_oderdet_status = "UPDATE orderdetails SET
                    orderdet_amount = orderdet_amount + '" . $_SESSION['food_admin']['list']['amount'][$i] . "'
                WHERE orderdetid = '" . $result_check['orderdetid'] . "'";
                mysqli_query($link, $sql_update_oderdet_status) or die(mysqli_error($link));
            }

            $sql_recommend =  "UPDATE foods SET
            food_recomend = (food_recomend + '" . $_SESSION['food_admin']['list']['amount'][$i] . "') WHERE foodid = '" . $_SESSION['food_admin']['list']['foodid'][$i] . "'";
            mysqli_query($link, $sql_recommend) or die(mysqli_error($link));
        } else { // กรณีไม่มีรายการเดิมอยู่ ให้เพิ่มเข้าไปใหม่

            $sql_addfoodlist =    "INSERT INTO orderdetails ( `orderdet_amount`, `orderdet_status`,`orderdet_price`,`orderid`, foodid) 
	VALUES ('" . $_SESSION['food_admin']['list']['amount'][$i] . "', '0','" . $_SESSION['food_admin']['list']['food_price'][$i] . "','" . $oid . "', '" . $_SESSION['food_admin']['list']['foodid'][$i] . "')";
            mysqli_query($link, $sql_addfoodlist) or die(mysqli_error($link));

            $sql_recommend =  "UPDATE foods SET
                food_recomend = (food_recomend + '" . $_SESSION['food_admin']['list']['amount'][$i] . "') 
                WHERE foodid = '" . $_SESSION['food_admin']['list']['foodid'][$i] . "'";
            mysqli_query($link, $sql_recommend) or die(mysqli_error($link));
        }
    }

    $sql_update_totalprice = "UPDATE orders SET order_totalprice = order_totalprice + '$total_price'
        WHERE orderid = '$oid'";
    mysqli_query($link, $sql_update_totalprice) or die(mysqli_error($link));

    unset($_SESSION['food_admin']['list']);

    echo '<script>alert("บันทึกการสั่งอาหารเพิ่ม รหัสการสั่ง : ' . str_pad($oid, 5, 0, STR_PAD_LEFT) . ' เรียบร้อยแล้ว"); window.location.assign("staff_order_history.php")</script>';
    mysqli_close($link);
}
