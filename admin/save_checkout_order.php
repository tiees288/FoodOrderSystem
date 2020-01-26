<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION))
        session_start();

    include("../conf/connection.php");
    include("../conf/function.php");

    $totalprice = $_POST['totalprice'];
    $orderdate = dt_tochristyear($_POST['orderdate']);
    $deliverydate = tochristyear($_POST['deliverydate']);
    $reservid = NULL;
    if (!empty($_POST['reserv_id'])) {
        $reservid = $_POST['reserv_id'];
    }
    $tables_no = NULL;
    if (!empty($_POST['tables_no'])) {
        $tables_no = $_POST['tables_no'];

        // เปลี่ยนสถานะโต๊ะ
        $sql_update_tables = "UPDATE tables SET
            tables_status_use = '1' WHERE tables_no = '$tables_no'";
        mysqli_query($link, $sql_update_tables) or die(mysqli_error($link));
    }

    $sqlorder = "INSERT INTO orders SET 
        orderdate               = '" . $orderdate . "', 
        order_date_tobedelivery = '" . $deliverydate . "',
        order_time_tobedelivery = '" . $_POST['deliverytime'] . "',
        order_delivery_place    = '" . $_POST["deliveryplace"] . "',
        order_type              = '" . $_POST['order_type'] . "',
        order_totalprice        = '" . $totalprice . "',
        cusid                   = '" . $_POST['cusid'] . "',
        reserv_id               = NULLIF('" . $reservid . "',''),
        tables_no               = NULLIF('" . $tables_no . "','')";

    mysqli_query($link, $sqlorder) or die(mysqli_error($link));

    $last_orderid = mysqli_insert_id($link);

    for ($i = 0; $i < count($_SESSION['food_admin']['list']['foodid']); $i++) {

        $sql_addfoodlist =    "INSERT INTO orderdetails ( `orderdet_amount`, `orderdet_status`,`orderdet_price`,`orderid`, foodid) 
	VALUES ('" . $_SESSION['food_admin']['list']['amount'][$i] . "', '0','" . $_SESSION['food_admin']['list']['food_price'][$i] . "','" . $last_orderid . "', '" . $_SESSION['food_admin']['list']['foodid'][$i] . "')";

        mysqli_query($link, $sql_addfoodlist) or die(mysqli_error($link));

        $sql_recommend =  "UPDATE foods SET
      food_recomend = (food_recomend + '" . $_SESSION['food_admin']['list']['amount'][$i] . "') WHERE foodid = '" . $_SESSION['food_admin']['list']['foodid'][$i] . "'";
        mysqli_query($link, $sql_recommend) or die(mysqli_error($link));
    }

    unset($_SESSION['food_admin']['list']);

    echo '<script>alert("บันทึกการสั่งอาหารเรียบร้อยแล้ว\nรหัสการสั่งคือ ' . str_pad($last_orderid, 5, 0, STR_PAD_LEFT) . '"); window.location.assign("staff_order_history.php")</script>';
    mysqli_close($link);
}
