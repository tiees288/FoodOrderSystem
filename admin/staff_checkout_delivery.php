<head>
    <title>บันทึกการส่ง | Food Order System</title>
    <?php
    if (!isset($_SESSION)) {  // Check if sessio nalready start
        session_start();
    }
    include("conf/header_admin.php");
    ?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php

    if (!isset($_GET['pno'])) {
        echo "<script>window.location.assign('staff_payment_history.php');</script>";
        exit();
    }

    require_once("../conf/connection.php");
    include_once("../conf/function.php");

    $sql_payment    = "SELECT * FROM payment 
        LEFT JOIN orders ON payment.payno = orders.payno
        LEFT JOIN customers ON orders.cusid = customers.cusid
    WHERE payment.payno = '{$_GET['pno']}'";
    $q_payment = mysqli_query($link, $sql_payment);
    $payment_data = mysqli_fetch_assoc($q_payment);

    $sql_order = "SELECT * FROM orders 
        LEFT JOIN orderdetails ON orders.orderid = ordersdetails.orderid 
        WHERE payno = '" . $_GET['pno'] . "'";
    $q_orders = mysqli_query($link, $sql_order);
    ?>

    <div class="container" style="padding-top: 135px;">
        <div class="col">
            <h1 class="page-header text-center">บันทึกการส่ง</h1>
            <div class="container" style="width:860px">
                <div class="panel panel-default" align="center" style="background-color:#FBFBFB;">
                    <p>
                        <form id="checkout_order" class="form" name="checkout_order" method="POST" action="save_checkout_delivery.php">
                            <table width="750px" border="0" align="center">
                                <tr>
                                    <td width="34px" height="36px"><b>เลขที่ใบเสร็จ :</b></td>
                                    <td width="30%">
                                        <?= $payment_data['payno'] ?>
                                        <input name="payno" id="payno" hidden value="<?= $payment_data['payno'] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="34px" height="36px"><b>รหัสลูกค้า :</b></td>
                                    <td width="30%">
                                        <?= $payment_data['cusid'] ?>
                                    </td>
                                    <td width="20%" height="36px"><b>ชื่อ-นามสกุล :</b></td>
                                    <td><?php echo $payment_data['cus_name']; ?></td>
                                </tr>
                                <tr>
                                    <td height="40px" width="15%"><b>วันที่สั่ง :</b></td>
                                    <td width="35%">
                                        <?= dt_tothaiyear($payment_data['orderdate']) ?>
                                    </td>
                                    <td width="16%" height="40px"><b>เบอร์โทรศัพท์ :</b></td>
                                    <td><?php echo $payment_data['cus_tel'] ?></td>
                                </tr>
                                <tr>
                                    <td width="15%" height="32px"><b>วันที่กำหนดส่ง :<span style="color:red;"></span></b></td>
                                    <td width="35%">
                                        <?= tothaiyear($payment_data['order_date_tobedelivery']) ?>
                                    </td>
                                    <td width="15%" height="32px"><b>เวลากำหนดส่ง :<span style="color:red;"></span></b></td>
                                    <td>
                                        <?= substr($payment_data['order_time_tobedelivery'], 0, 5) ?></td>
                                </tr>
                                <tr>
                                    <td width="15%" height="40px"><b>วันที่ส่ง :<span style="color:red;">*</span></b></td>
                                    <td width="35%">
                                        <input class="form-control datepicker-deliver" onkeypress="return false; event.preventDefault();" onfocus="$(this).blur();" autocomplete="off" type="text" style="height:32px; width:180px" id="order_date_delivered" name="order_date_delivered" required></td>
                                    </td>
                                    <td width="15%" height="32px"><b>เวลาส่ง :<span style="color:red;">*</span></b></td>
                                    <td><input class="form-control" autocomplete="off" type="time" min="09:00" max="18:00" style="height:32px; width:180px" id="order_time_delivered" name="order_time_delivered" required></td>
                                </tr>
                                <tr>
                                    <td width="20%" height="32px"><b>สถานที่จัดส่ง :<span style="color:red;"></span></b></td>
                                    <td height="75px"><?= $payment_data['cus_address'] . " รหัสไปรษณีย์ " . $payment_data['cus_postnum'] ?></td>
                                    </td>
                                    </td>
                                </tr>
                            </table>
                </div>
                <h3 class="page-header text-center">รายการอาหาร</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <th style="width: 150px; text-align:center;">รหัสการสั่งอาหาร</th>
                        <th style="width:150px; text-align:right;">รหัสรายการอาหาร</th>
                        <th style="width:120px;">ชื่ออาหาร</th>
                        <th style="width:80px;">หน่วยนับ</th>
                        <th style="text-align:right; width:100px;">ราคา (บาท)</th>
                        <th style="text-align:right; width:55px;">จำนวน</th>
                        <th style="width:130px; text-align:right">ราคารวม (บาท)</th>
                    </thead>
                    <?php
                    $sql_orderdet = "SELECT orderid FROM orders WHERE payno = '" . $_GET['pno'] . "'";
                    $q_orderdet = mysqli_query($link, $sql_orderdet) or die(mysqli_error($link));
                    $sum_total = 0;

                    while ($result_orderdet = mysqli_fetch_array($q_orderdet)) {
                        $i = 1; ?>
                        <tr>
                            <td align="center"><?= $result_orderdet['orderid'] ?></td>
                            <?php
                            $sql_orderdet2 = "SELECT orders.orderid ,orderdetails.foodid, orderdetails.orderdet_amount, orderdetails.orderdet_price, foods.food_name, foods.food_count FROM orders
                                 LEFT JOIN orderdetails ON orders.orderid = orderdetails.orderid
                                 LEFT JOIN foods ON orderdetails.foodid = foods.foodid
                             WHERE orders.orderid = '" . $result_orderdet['orderid'] . "'";
                            $q_orderdet2 = mysqli_query($link, $sql_orderdet2) or die(mysqli_error($link));

                            while ($result_orderdet2 = mysqli_fetch_array($q_orderdet2)) {
                            ?>
                                <?= $i >= 2 ? "</tr><tr><td></td>" : "" ?>
                                <td align="right"><?= $result_orderdet2['foodid'] ?></td>
                                <td><?= $result_orderdet2['food_name'] ?></td>
                                <td><?= $result_orderdet2['food_count'] ?></td>
                                <td align="right"><?= $result_orderdet2['orderdet_price'] ?></td>
                                <td align="right"><?= $result_orderdet2['orderdet_amount'] ?></td>
                                <td align="right"><?= number_format(($result_orderdet2['orderdet_amount'] * $result_orderdet2['orderdet_price']), 2) ?></td>
                        </tr>
                <?php $i++;
                                $sum_total += ($result_orderdet2['orderdet_amount'] * $result_orderdet2['orderdet_price']);
                            }
                        }
                ?>
                <tr>
                    <td colspan="6" align="right"><b>ราคารวมทั้งหมด</b></td>
                    <td align="right"><b><?= number_format($sum_total, 2) ?></b></td>
                </tr>

                </table>
                <div class="col-md-offset-3 col-md-6" style="text-align: center; padding-bottom:20px;">
                    <input type="submit" name="submit" id="submit" onclick="if(confirm('ยืนยันบันทึกการส่ง?')) return true; else return false;" class="btn btn-success" value="บันทึก" />
                    <button type="reset" class="btn btn-danger">ล้างค่า</button></form>
                    <button type="back" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
                </div>

            </div>