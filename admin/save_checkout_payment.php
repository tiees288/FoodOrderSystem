<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION))
        session_start();
    include("../conf/connection.php");
    include("../conf/function.php");
    require_once("conf/lib.php");

    $sum_price = $_POST['sum_price'];
    $pay_date = dt_tochristyear($_POST['pay_date']);
    $bankid = ($_POST['bankid'] != 0) ? $_POST['bankid'] : NULL;
    $paytype = ($_POST['bankid'] != 0) ? "1" : "0";


    $sql_payment = "INSERT INTO payment SET
        pay_date    = '" . $pay_date . "',
        payamount   = $sum_price,
        pay_type    = '$paytype',
        pay_status  = '1',
        pay_note    = '" . $_POST['pay_note'] . "',
        staffid     = '" . $_SESSION['staff_id'] . "',
        bankid      = NULLIF('$bankid','')";
    mysqli_query($link, $sql_payment) or die(mysqli_error($link));

    $payno = mysqli_insert_id($link);

    for ($i = 0; $i < count($_SESSION['food_admin']['payment']['orderid']); $i++) {
        $sql_update_order = "UPDATE orders SET
            order_status = 2,
            payno = '$payno' WHERE orderid = '" . $_SESSION['food_admin']['payment']['orderid'][$i] . "'";
        $sql_update_orderdet = "UPDATE orderdetails SET
            orderdet_status = '1' WHERE orderid = '" . $_SESSION['food_admin']['payment']['orderid'][$i] . "'";
        $sql_update_tables = "UPDATE tables LEFT JOIN orders ON orders.tables_no = tables.tables_no
            SET tables.tables_status_use = 0
            WHERE orderid = '". $_SESSION['food_admin']['payment']['orderid'][$i] ."';";

        mysqli_query($link, $sql_update_order) or die(mysqli_error($link));
        mysqli_query($link, $sql_update_orderdet) or die(mysqli_error($link));
        mysqli_query($link, $sql_update_tables) or die(mysqli_error($link));
    }
    unset($_SESSION['food_admin']['payment']);

    echo '<script> 
    $(document).ready(function(){
        alert("บันทึกรับชำระเรียบร้อยแล้ว\nเลขที่ใบเสร็จคือ ' . str_pad($payno, 5, 0, STR_PAD_LEFT) . '");
        window.open("bill_payment.php?bill=' . str_pad($payno, 5, 0, STR_PAD_LEFT) . '","_blank");
        window.location.assign("staff_payment_history.php");
    });
    </script>';
}
