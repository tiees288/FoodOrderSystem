<head>
    <title>แจ้งหลักฐานการชำระเงิน | Food Order System</title>
    <?php
    if (!isset($_SESSION)) {  // Check if sessio nalready start
        session_start();
    }

    if (!isset($_GET['oid'])) {
        echo "<script>window.location.assign('order_history.php')</script>";
        exit();
    }


    ?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php

    include("conf/header.php");
    include("conf/connection.php");
    include_once("conf/function.php");

    $sql_orderdata  = "SELECT * FROM orders WHERE orderid = '{$_GET['oid']}'";
    $query_order = mysqli_query($link, $sql_orderdata);
    $order_data = mysqli_fetch_assoc($query_order);

    if (!isset($_SESSION['user']) || $_SESSION['user_id'] != $order_data['cusid']) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิ์การเข้าใช้งาน'); window.location.assign('login.php')</script>";
    }


    if ($order_data['order_status'] != 0) {
        echo "<script>alert('ไม่สามารถแจ้งหลักฐานชำระเงินได้'); window.location.assign('order_history.php');</script>";
    }

    $sql_cusdata    = "SELECT * FROM customers WHERE cusid = '{$order_data['cusid']}'";
    $query_customer = mysqli_query($link, $sql_cusdata);
    $cus_data = mysqli_fetch_assoc($query_customer);


    switch ($order_data['order_status']) {
        case 0:
            $order_status = "<span style='color:orange'>ยังไม่แจ้งชำระ</span>";
            break;
        case 1:
            $order_status = "<span style='color:#0072EE'>รอการตรจสอบ</span>";
            break;
        case 2:
            $order_status = "<span style='color:#12BB4F'>ชำระแล้ว</span>";
            break;
        case 3:
            $order_status = "<span style='color:red;'>ยกเลิก</span>";
            break;
        default:
            echo "Error";
    }
    ?>
    <div class="container" style="padding-top: 90px;">
        <div class="col">
            <h1 class="page-header text-center">แจ้งหลักฐานการชำระเงิน</h1>
            <div class="container" style="width:980px">
                <div class="panel panel-default" align="center" style="background-color:#FBFBFB;">
                    <p>
                        <form method="POST" action="save_order_payment.php" enctype="multipart/form-data">
                            <table width="750px" border="0" align="center">
                                <tr>
                                    <td height="13px"></td>
                                </tr>
                                <tr style="padding-top:15px">
                                    <td width="" height="36px"><b>รหัสการสั่งอาหาร :</b></td>
                                    <td width="30%"><?php echo $_GET['oid'] ?></td>
                                    <td width="20%"><b>สถานะ :</b></td>
                                    <td><?= $order_status ?></td>
                                </tr>
                                <tr>
                                    <td width="" height="36px"><b>รหัสลูกค้า :</b></td>
                                    <td width="30%"><?php echo $cus_data['cusid'] ?></td>
                                    <td width="20%" height="36px"><b>ชื่อ-นามสกุล :</b></td>
                                    <td><?php echo $cus_data['cus_name']; ?></td>
                                </tr>
                                <tr>
                                    <td height="40px" width="15%"><b>วันที่สั่ง :</b></td>
                                    <td width="35%">
                                        <?= dt_tothaiyear($order_data['orderdate']); ?>
                                    </td>
                                    <td width="16%" height="40px"><b>เบอร์โทรศัพท์ :</b></td>
                                    <td><?php echo $cus_data['cus_tel'] ?></td>
                                </tr>
                                <tr>
                                    <td width="15%" height="32px"><b>วันที่กำหนดส่ง :</b></td>
                                    <td width="35%">
                                        <?= tothaiyear($order_data['order_date_tobedelivery']) ?>
                                    </td>
                                    <td width="15%" height="32px"><b>เวลากำหนดส่ง :</b></td>
                                    <td>
                                        <?= substr($order_data['order_time_tobedelivery'], 0, 5) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%" height="32px"><b>สถานที่จัดส่ง :</b></td>
                                    <td width="30%" height="75px">
                                        <?= $order_data['order_delivery_place'] ?>
                                    </td>
                                    <td width="20%"><b>วันที่แจ้งหลักฐาน :</b></td>
                                    <td>
                                        <input type="datetime-local" style="width:200px;" class="form-control" name="evidence_time" id="evidence_time" value="<?= dt_tothaiyear2(date('Y-m-d H:i')); ?>" readonly>
                                    </td>
                                </tr>
                            </table>
                </div>
                <h3 class="page-header text-center">รายการอาหาร</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <th style="text-align:right; width:150px;">รหัสรายการอาหาร</th>
                        <th style="width:160px;">ชื่ออาหาร</th>
                        <th style="width:100px;">หน่วยนับ</th>
                        <th style="text-align:right; width:120px;">ราคา (บาท)</th>
                        <th style="text-align:right; width:90px;">จำนวน</th>
                        <th style="width:130px; text-align:right">ราคารวม (บาท)</th>
                        <th>หมายเหตุ</th>
                    </thead>
                    <?php
                    $orderdet_sql = "SELECT * FROM orderdetails WHERE orderid = '" . $_GET['oid'] . "'";
                    $orderdet_query = mysqli_query($link, $orderdet_sql);

                    while ($orderdet_data = mysqli_fetch_array($orderdet_query)) {
                        $food_sql = "SELECT food_name, food_count FROM foods WHERE foodid = '" . $orderdet_data['foodid'] . "'";
                        $food_data = mysqli_fetch_assoc(mysqli_query($link, $food_sql));
                    ?>
                        <td align="right"><?php echo $orderdet_data['foodid'] ?></td>
                        <td><?php echo $food_data['food_name']; ?></td>
                        <td><?= $food_data['food_count'] ?></td>
                        <td align="right"><?= number_format($orderdet_data['orderdet_price'], 2); ?></td>
                        <td class="text-right">
                            <?php echo $orderdet_data['orderdet_amount'] ?>
                        </td>
                        <td class="text-right">
                            <?= number_format($orderdet_data['orderdet_amount'] * $orderdet_data['orderdet_price'], 2); ?>
                        </td>
                        <td class="col-md-2"><?= ($orderdet_data['orderdet_note']) ? $orderdet_data['orderdet_note'] : "-" ?></td>
                        </tr>
                    <?php }   ?>
                    <tr>
                        <td colspan="5" class="text-right"><b>ราคารวมทั้งหมด</b></td>
                        <td class="text-right"><b><?= number_format($order_data['order_totalprice'], 2); ?></b></td>
                    <td></td>
                    </tr>
            </div>
            </table>
            <div class="col-md-offset-2 col-md-7" style="text-align: center;">

                <div class="row">
                    <div class="col-md-4" style="margin-top:7px; text-align:right;">
                        <label class="control-label">หลักฐาน :<span style="color:red;">*</span></label>
                    </div>
                    <div class="col-md-8" style="width:300px;">
                        <input type="text" name="orderid" id="orderid" value="<?= $_GET['oid'] ?>" hidden>
                        <input type="file" class="form-control" id="order_evidence" name="order_evidence" accept="image/gif, image/jpeg, image/png" required>
                    </div>
                </div>
                <div class="row" style="padding-top:25px;">
                    <button type="submit" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;" class="btn btn-success" name="submit">บันทึก</button>
                    <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <?php include("conf/footer.php"); ?>
</body>