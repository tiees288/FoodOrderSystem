<?php

if (!isset($_GET['oid'])) {
    echo "<script>window.location.assign('order_history.php')</script>";
    exit();
}
?>

<head>
    <title>รายละเอียดการสั่งอาหาร | Food Order System</title>
    <?php
    if (!isset($_SESSION)) {  // Check if sessio nalready start
        session_start();
    }
    ?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php
    require_once("conf/header_admin.php");
    require_once("../conf/connection.php");
    include_once("../conf/function.php");

    $sql_orderdata  = "SELECT * FROM orders WHERE orderid = '{$_GET['oid']}'";
    $query_order = mysqli_query($link, $sql_orderdata);
    $order_data = mysqli_fetch_assoc($query_order);

    $sql_cusdata    = "SELECT * FROM customers WHERE cusid = '{$order_data['cusid']}'";
    $query_customer = mysqli_query($link, $sql_cusdata);
    $cus_data = mysqli_fetch_assoc($query_customer);

    $sql_reserve = "SELECT * FROM reservations WHERE reserv_id = '{$order_data['reserv_id']}'";
    $reserve_data = mysqli_fetch_assoc(mysqli_query($link, $sql_reserve));

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
    <div class="container" style="padding-top: 135px;">
        <div class="col">
            <h1 class="page-header text-center">รายละเอียดการสั่งอาหาร</h1>
            <div class="container" style="width:850px">
                <div class="panel panel-default" align="center" style="background-color:#FBFBFB;">

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
                        <?php
                        if ($order_data['order_date_tobedelivery'] != "0000-00-00" && substr($order_data['order_time_tobedelivery'], 0, 5) != "00:00") {
                        ?>
                            <tr>
                                <td width="15%" height="32px"><b>วันที่กำหนดส่ง :</b></td>
                                <td width="35%">
                                    <?php
                                    if ($order_data['order_date_tobedelivery'] != "0000-00-00")
                                        echo tothaiyear($order_data['order_date_tobedelivery']);
                                    else
                                        echo "-";
                                    ?>
                                </td>
                                <td width="15%" height="32px"><b>เวลากำหนดส่ง :</b></td>
                                <td>
                                    <?php
                                    if (substr($order_data['order_time_tobedelivery'], 0, 5) != "00:00")
                                        echo substr($order_data['order_time_tobedelivery'], 0, 5);
                                    else
                                        echo "-";
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td width="15%" height="40px"><b>ประเภทการสั่ง :</b></td>
                            <td>
                                <?= ($order_data['order_type'] == 0) ? "สั่งกลับบ้าน" : "สั่งทานที่ร้าน"; ?>
                            </td>
                            <td width="15%" height="40px"><b>หมายเลขโต๊ะ :</b></td>
                            <td>
                                <?php
                                if ($order_data['tables_no'] != NULL)
                                    echo $order_data['tables_no'];
                                else echo "-";
                                ?>
                            </td>
                        </tr>
                        <?php if ($order_data['reserv_id'] != NULL) { ?>
                            <tr>
                                <td width="15%" height="32px"><b>รหัสการจอง :</b></td>
                                <td>
                                    <?php
                                    if ($order_data['reserv_id'] != NULL)
                                        echo $order_data['reserv_id'];
                                    else echo "-";
                                    ?>
                                </td>
                                <td width="15%" height="32px"><b>วัน/เวลาจอง :</b></td>
                                <td>
                                    <?php
                                    if ($order_data['reserv_id'] != NULL)
                                        echo dt_tothaiyear($reserve_data['reserv_date_reservation']);
                                    else echo "-";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="15%" height="40px"><b>วันที่นัด :</b></td>
                                <td>
                                    <?php
                                    if ($order_data['reserv_id'] != NULL)
                                        echo tothaiyear($reserve_data['reserv_date_appointment']);
                                    else echo "-";
                                    ?>
                                </td>
                                <td width="15%" height="32px"><b>เวลานัด :</b></td>
                                <td>
                                    <?php
                                    if ($order_data['reserv_id'] != NULL)
                                        echo substr($reserve_data['reserv_time_appointment'], 0, 5);
                                    else echo "-";
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td width="20%" height="32px"><b>สถานที่จัดส่ง :</b></td>
                            <td width="30%" height="75px">
                                <?= $order_data['order_type'] == 0 ? $order_data['order_delivery_place'] : "-" ?>
                            </td>
                            <td width="20%" height="32px"><b>หลักฐานการชำระ :</b></td>
                            <td>
                                <?php
                                if ($order_data['order_status'] != 0 && $order_data['order_status'] != 3 && $order_data['order_evidence'] != "") { ?>
                                    <a style="padding-left:10%;" href="#img_<?= $order_data['orderid'] ?>" data-toggle="modal"><img height="70px" style="border: 1px solid;" width="50px" src="../<?= $order_data['order_evidence'] ?>"></a>
                                    <div class="modal fade" id="img_<?php echo $order_data['orderid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="col-md-4 col-md-offset-4">
                                                        <h4 class="modal-title" id="myModalLabel">หลักฐานการชำระ</h4>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid text-center">
                                                        <img height="400px" width="300px" src="../<?= $order_data['order_evidence'] ?>">
                                                        <hr>
                                                        <div class="col-md-7 col-md-offset-2">
                                                            <label>วันที่แจ้งหลักฐาน : &nbsp; </label><?= dt_tothaiyear($order_data['order_evidence_date']) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                <?php    } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <h3 class="page-header text-center">รายการอาหาร</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <th style="text-align:right; width:150px">รหัสรายการอาหาร</th>
                        <th width="160px">ชื่ออาหาร</th>
                        <th>หน่วยนับ</th>
                        <th style="text-align:right; width:120px;">ราคา (บาท)</th>
                        <th style="text-align:right; width:90px;">จำนวน</th>
                        <th style="width:130px; text-align:right">ราคารวม (บาท)</th>
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
                        </tr>
                    <?php }   ?>
                    <tr>
                        <td colspan="5" class="text-right"><b>ราคารวมทั้งหมด</b></td>
                        <td class="text-right"><b><?= number_format($order_data['order_totalprice'], 2); ?></b></td>
                    </tr>
            </div>
            </table>
            <div class="col-md-offset-3 col-md-6" style="text-align: center;">
                <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
            </div>
        </div>
    </div>
    <br>
    </div>
    <?php //include("conf/footer.php"); 
    ?>
</body>