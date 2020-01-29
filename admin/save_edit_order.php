<?php
if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['staff'])) {
    header("location: login_staff.php");
    exit();
}

require_once("../conf/connection.php");
require_once("../conf/function.php");

if (isset($_GET['del_oid'])) { // กรณียกเลิกเฉพาะรายการ
    $del_id = mysqli_real_escape_string($link, $_GET['del_oid']);

    // ตรวจสอบราคากับจำนวน ก่อนการยกเลิก
    $cal_price = "SELECT * FROM orderdetails AS orderdet
                    LEFT JOIN orders AS ord 
                    ON orderdet.orderid = ord.orderid 
                    WHERE orderdetid = '$del_id'";
    $orderdet_detail = mysqli_fetch_assoc(mysqli_query($link, $cal_price));
    $price_to_drecrease = $orderdet_detail['order_totalprice'] - ($orderdet_detail['orderdet_price'] * $orderdet_detail['orderdet_amount']);
    // แก้ไขราคารวมของการสั่งอาหาร
    $update_order_totalprice = mysqli_query($link, "UPDATE orders SET order_totalprice = '$price_to_drecrease' WHERE orderid = '" . $orderdet_detail['orderid'] . "'");

    $sql_cancel_list = "UPDATE orderdetails SET
        orderdet_status = 2 WHERE orderdetid = '" . $del_id . "'";
    if (mysqli_query($link, $sql_cancel_list)) {
        echo "<script>alert('ยกเลิกรายการอาหาร รหัส " . $del_id . " เรียบร้อย'); window.history.back();</script>";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) { // กรณีบันทึกการปรับปรุง
        $sql_orderdet = "SELECT * FROM orderdetails WHERE orderid = '" . $_POST['orderid'] . "'";
        $q_orderdet = mysqli_query($link, $sql_orderdet);
        $totalprice_update = 0;

        for ($i = 0; $i < mysqli_num_rows($q_orderdet); $i++) {
            $result_orderdet = mysqli_fetch_array($q_orderdet);

            $target = ($result_orderdet['orderdet_status'] != 2) ? $_POST['qty_' . $i] : NULL;

            if (!empty($target)) {
                $sql_update1 = "UPDATE orderdetails SET 
                orderdet_amount = '$target' WHERE orderdetid = '" . $result_orderdet['orderdetid'] . "'";
                mysqli_query($link, $sql_update1);
                $totalprice_update += ($result_orderdet['orderdet_price'] * $target);
            }
        }

        mysqli_query($link, "UPDATE orders SET order_totalprice = $totalprice_update WHERE orderid = '" . $result_orderdet['orderid'] . "'");

        if (isset($_SESSION['food_admin']['list']['foodid'])) {
            $oid = $_POST['orderid']; // Orderid
            $total_price = 0;
            //echo count($_SESSION['food_admin']['list']['foodid']);

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
        }
    
        echo "<script>alert('ปรับปรุงการสั่งอาหาร รหัสการสั่ง " . $_POST['orderid'] . " เรียบร้อย'); window.location.assign('staff_order_history.php');</script>";
    
    } elseif (isset($_POST['cancel'])) { // กรณียกเลิกการสั่ง
        $sql_cancel = "UPDATE orders SET
            order_status = 3 WHERE orderid = '" . $_POST['orderid'] . "'";
        $sql_cancel2 = "UPDATE orderdetails SET
            orderdet_status = 2 WHERE orderid = '" . $_POST['orderid'] . "'";
        //  && mysqli_query($link, $sql_cancel2)

        $sql_cancel_table = "UPDATE tables 
            RIGHT JOIN orders ON orders.tables_no = tables.tables_no SET
            tables_status_use = '0' WHERE orders.orderid = '". $_POST['orderid'] ."'";

        if (mysqli_query($link, $sql_cancel) && mysqli_query($link, $sql_cancel_table)) {
            echo "<script>alert('ยกเลิกการสั่งอาหาร รหัสการสั่ง " . $_POST['orderid'] . " เรียบร้อย'); window.location.assign('staff_order_history.php');</script>";
        }
    }
}
