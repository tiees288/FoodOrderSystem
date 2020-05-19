<?php
if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['staff'])) {
    echo "<script>alert('กรุณาตรรวจสอบสิทธิ์การเข้าใช้งาน'); window.location.assign('login_staff.php');</script>";
    exit();
}

include("conf/lib.php");
include("../conf/function.php");
include("../conf/connection.php");
?>

<head>
    <title>ใบเสร็จรับเงิน เลขที่ <?= $_GET['bill'] ?> | ระบบขายอาหารตามสั่ง</title>
    <style type="text/css" media="print">
        @page {
            size: auto;
        }
    </style>
</head>

<body>
    <?php
    $sql_p = "SELECT pay_status FROM payment WHERE payno = '" . $_GET['bill'] . "'";
    $result_p = mysqli_fetch_assoc(mysqli_query($link, $sql_p));
    //echo $result_p['pay_status'];
    if ($result_p['pay_status'] == 2) {
        $sql_payment = "SELECT * FROM payment LEFT JOIN orders ON payment.payno = orders.payno_cancel
            LEFT JOIN customers ON orders.cusid = customers.cusid WHERE payment.payno = '" . $_GET['bill'] . "'";
    } elseif ($result_p['pay_status'] == 1) {
        $sql_payment = "SELECT * FROM payment LEFT JOIN orders ON payment.payno = orders.payno
            LEFT JOIN customers ON orders.cusid = customers.cusid WHERE payment.payno = '" . $_GET['bill'] . "'";
    }
    $result_payment = mysqli_fetch_assoc(mysqli_query($link, $sql_payment));

    $sql_staff = "SELECT staff_name FROM staff WHERE staffid = '" . $result_payment['staffid'] . "'";
    $result_staff = mysqli_fetch_assoc(mysqli_query($link, $sql_staff));

    if ($result_payment['pay_billdate'] == "0000-00-00 00:00:00") {
        mysqli_query($link, "UPDATE payment SET pay_billdate = '" . date("Y-m-d H:i:s") . "'
            WHERE payno = '" . $_GET['bill'] . "'");
        echo "<script>window.location.reload();</script>";
    }
    ?>
    <div class="container" style="padding-top:20px; width:1100px; margin-top:15px; border:1px solid;">
        <h3 class="text-center">ใบเสร็จรับเงิน</h3>
        <h5 class="text-center">หน้าหอพัก Grand modern condo ตรงข้ามมหาวิทยาลัยกรุงเทพ วิทยาเขตรังสิต</h5>
        <h5 class="text-center" style="padding-bottom:30px;">หมู่ 5 ตำบลคลองหนึ่ง อำเภอคลองหลวง จังหวัดปทุมธานี 12120</h5>

        <table width="90%" border="0" align="center">
            <tr>
                <td width="150px" style="text-align: right; height:25px; padding-right:10px;"><b>เลขที่ : </b></td>
                <td width="200px"><?= $_GET['bill'] ?></td>
                <td width="150px" style="text-align: right; padding-right:10px;"><b>วันที่ออก : </b></td>
                <td width="200px"><?= fulldatetime_thai(dt_tothaiyear($result_payment['pay_billdate'])) ?></td>
            </tr>
            <tr>
                <td width="150px" style="text-align: right; height:25px; padding-right:10px;"><b>ชื่อลูกค้า : </b></td>
                <td width="200px"> <?= $result_payment['cus_name'] ?></td>
                <td width="150px" style="text-align: right; padding-right:10px;"><b>วันที่สั่งอาหาร : </b></td>
                <td width="200px"><?= fulldatetime_thai(dt_tothaiyear($result_payment['orderdate'])) ?></td>
            </tr>
            <tr>
                <td width="150px" style="text-align: right; height:25px; padding-right:10px;"><b>เบอร์โทรศัพท์ : </b></td>
                <td width="200px"><?= $result_payment['cus_tel'] ?></td>
                <td width="150px" style="text-align: right; padding-right:10px;"><b>วันกำหนดส่ง : </b></td>
                <td width="200px"><?= ($result_payment['order_date_tobedelivery'] != "0000-00-00") ? fulldatetime_thai(tothaiyear($result_payment['order_date_tobedelivery']))." ". substr($result_payment['order_time_tobedelivery'],0,5) : "-"  ?></td>
            </tr>
            <tr>
                <td width="150px" style="text-align: right; height:25px; padding-right:10px;"><b>สถานที่จัดส่ง : </b></td>
                <td width="200px"><?= $result_payment['order_delivery_place']  ?></td>
                <td width="150px" style="text-align: right; padding-right:10px;"><b>วันที่ส่ง : </b></td>
                <td width="200px"><?= ($result_payment['order_date_delivered'] != "0000-00-00") ?  fulldatetime_thai(dt_tothaiyear($result_payment['order_date_delivered'])) ." ". substr($result_payment['order_time_delivered'],0,5) : "-" ?></td>
            </tr>
            <tr>
                <td height="20px"></td>
            </tr>
        </table>

        <table width="95%" border="0">
            <tr>
                <th style="width:15%; text-align:center; height:40px; border-top :1px solid;">รหัสการสั่งอาหาร</th>
                <th style="text-align:right; padding-right:20px; width:13%; height:40px; border-top :1px solid;">หมายเลขโต๊ะ</th>
                <th style="height:40px; border-top :1px solid;">รายการอาหาร</th>
                <th style="height:40px; border-top :1px solid; text-align: right; padding-right:10px;">จำนวน</th>
                <th style="height:40px; border-top :1px solid; ">หน่วยนับ</th>
                <th style="height:40px; border-top :1px solid; text-align: right; width:15%;">ราคาต่อหน่วย (บาท)</th>
                <th style=" height:40px; border-top :1px solid; text-align: right; padding-right:10px;">ราคา (บาท)</th>
                <th style="border-top:1px solid;"></th>
            </tr>
            <?php
            if ($result_p['pay_status'] == "2") {
                $sql_order = "SELECT * FROM orders WHERE payno_cancel = '" . $_GET['bill'] . "'";
            } elseif ($result_p['pay_status'] == "1") {
                $sql_order = "SELECT * FROM orders WHERE payno = '" . $_GET['bill'] . "'";
            }
            $q_order = mysqli_query($link, $sql_order);
            $sum_final = 0;

            // echo mysqli_num_rows($q_order);
            while ($result_order = mysqli_fetch_array($q_order)) { ?>
                <tr>
                    <td align="center"><?= $result_order['orderid'] ?></td>
                    <td align="right" style="padding-right:20px;"><?= ($result_order['tables_no'] == NULL) ? "-" : $result_order['tables_no'] ?></td>
                    <?php
                    $sql_orderdet = "SELECT * FROM orderdetails LEFT JOIN foods ON orderdetails.foodid = foods.foodid WHERE orderdetails.orderid = '" . $result_order['orderid'] . "'";
                    $q_orderdet = mysqli_query($link, $sql_orderdet);
                    $i = 1;
                    $sumdet = 0;

                    while ($ressult_orderdet = mysqli_fetch_array($q_orderdet)) {
                        if ($i >= 2)
                            echo "</tr><tr><td colspan='2'></td>";
                    ?>
                        <td><?= $ressult_orderdet['food_name'] ?></td>
                        <td align="right" style="padding-right:10px; height:25px;"><?= $ressult_orderdet['orderdet_amount'] ?></td>
                        <td><?= $ressult_orderdet['food_count'] ?></td>
                        <td align="right"><?= $ressult_orderdet['food_price'] ?></td>
                        <td align="right" style="padding-right:10px;"><?= number_format($ressult_orderdet['food_price'] * $ressult_orderdet['orderdet_amount'], 2) ?></td>
                    <?php $i++;
                        $sumdet += ($ressult_orderdet['food_price'] * $ressult_orderdet['orderdet_amount']);
                        if ($i >= 2)
                            echo "</tr>";
                    } ?>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="" style="height:25px; padding-top:5px; padding-bottom:10px; border-top:1px solid;" align="right">
                        <b> รวม </b>
                    </td>
                    <td align="right" style="padding-top: 5px; border-top:1px solid; padding-bottom:10px; padding-right:10px;">
                        <b><?= number_format($sumdet, 2) ?></b>
                    </td>
                    <td style=" border-top:1px solid; padding-bottom:5px;"><b>บาท</b></td>
                </tr>
            <?php $sum_final += $sumdet;
            }
            ?>
            <td colspan="6" style="height:25px; text-align:right; border-top:1px solid;">
                <b>รวมทั้งหมด</b>
            </td>
            <td align="right" style="padding-right:10px; border-top:1px solid;"><b><?= number_format($sum_final, 2) ?></b></td>
            <td style=" border-top:1px solid;"><b>บาท</b></td>
        </table>
        <table width="100%" border="0">
            <tr>
                <td width="12%" align="right" style="padding-right:5px;"><b>ประเภทการชำระ : </b></td>
                <td width="15%"><?= $result_payment['pay_type'] == 0 ? "เงินสด" : "เงินโอน" ?></td>
                <td width="10%" align="right" style="padding-right:5px;"><b>หมายเหตุ : </b></td>
                <td width="20%"><?= $result_payment['pay_note'] == "" ? "-" : $result_payment['pay_note'] ?></td>
                <td rowspan="3" align="center">
                    <?php
                    if ($result_payment['pay_status'] == 2) {
                        echo '<font size="5px" color="red"><b>*** ใบเสร็จนี้ได้ถูกยกเลิกแล้ว ***</b></font>';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td width="20%" align="right" style="padding-right:5px;"><b>ลายเซ็นลูกค้า : </b></td>
                <td>...............................</td>
                <td align="right" style="padding-right:5px;"><b>วันที่ชำระ : </b></td>
                <td><?= fulldatetime_thai(dt_tothaiyear($result_payment['pay_date'])) ?></td>
            </tr>
            <tr>
                <td width="20%" align="right" style="padding-right:5px;"><b>ชื่อพนักงาน : </b></td>
                <td><?= $result_staff['staff_name'] ?></td>
        </table>
        <div class="row">
            <div class="col-md-3 col-md-offset-9 text-right" style="padding-bottom:25px;">
                <b>วันที่พิมพ์ <?= fulldate_thai(date("d-m-Y")) ?></b>
            </div>
        </div>
    </div>
</body>