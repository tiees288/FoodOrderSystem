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
    <title>ใบแจ้งรับชำระเงิน รหัสการสั่ง <?= str_pad($_GET['oid'], 5, 0, STR_PAD_LEFT) ?> | ระบบขายอาหารตามสั่ง</title>
    <style type="text/css" media="print">
        @page {
            size: auto;
        }
    </style>
</head>

<body>
    <?php
    $sql_payment = "SELECT * FROM orders
    LEFT JOIN customers ON orders.cusid = customers.cusid WHERE orders.orderid = '" . $_GET['oid'] . "'";
    $result_payment = mysqli_fetch_assoc(mysqli_query($link, $sql_payment));

    ?>
    <div class="container" style="padding-top:20px; width:1100px; margin-top:15px; border:1px solid;">
        <h3 class="text-center">ใบแจ้งรับชำระเงิน</h3>
        <h5 class="text-center">หน้าหอพัก Grand modern condo ตรงข้ามมหาวิทยาลัยกรุงเทพ วิทยาเขตรังสิต</h5>
        <h5 class="text-center" style="padding-bottom:30px;">หมู่ 5 ตำบลคลองหนึ่ง อำเภอคลองหลวง จังหวัดปทุมธานี 12120</h5>

        <table width="90%" border="0" align="center">
            <tr>
                <td width="150px" style="text-align: right; height:25px; padding-right:10px;"><b>รหัสการสั่งอาหาร : </b></td>
                <td width="200px"><?= $result_payment['orderid'] ?></td>
                <td width="150px" style="text-align: right; padding-right:10px;"><b>วันที่ออก : </b></td>
                <td width="200px"><?= fulldatetime_thai(dt_tothaiyear(date("d-m-Y"))) ?></td>
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
                <td width="200px"><?= ($result_payment['order_date_tobedelivery'] != "0000-00-00") ? fulldatetime_thai(tothaiyear($result_payment['order_date_tobedelivery'])) : "-"  ?></td>
            </tr>
            <tr>
                <td width="150px" style="text-align: right; height:25px; padding-right:10px;"><b>สถานที่จัดส่ง : </b></td>
                <td width="200px"><?= $result_payment['order_delivery_place']  ?></td>
                <td width="150px" style="text-align: right; padding-right:10px;"><b>วันที่ส่ง : </b></td>
                <td width="200px"><?= ($result_payment['order_date_delivered'] != "0000-00-00") ?  fulldatetime_thai(dt_tothaiyear($result_payment['order_date_delivered'])) : "-" ?></td>
            </tr>
            <tr>
                <td height="20px"></td>
            </tr>
        </table>

        <table width="95%" border="0">
            <tr>
                <th style="text-align:right; padding-right:20px; width:13%; height:40px; border-top :1px solid;"></th>
                <th style="height:40px; border-top :1px solid;">รายการอาหาร</th>
                <th style="height:40px; border-top :1px solid; text-align: right; padding-right:10px;">จำนวน</th>
                <th style="height:40px; border-top :1px solid; ">หน่วยนับ</th>
                <th style="height:40px; border-top :1px solid; text-align: right; width:15%;">ราคาต่อหน่วย (บาท)</th>
                <th style=" height:40px; border-top :1px solid; text-align: right; padding-right:10px;">ราคา (บาท)</th>
                <th style="border-top:1px solid;"></th>
            </tr>
            <?php
            $sum_final = 0;
            ?>
            <tr>
                <td>
                    <?php
                    $sql_orderdet = "SELECT * FROM orderdetails LEFT JOIN foods ON orderdetails.foodid = foods.foodid WHERE orderdetails.orderid = '" . $result_payment['orderid'] . "'";
                    $q_orderdet = mysqli_query($link, $sql_orderdet);
                    $i = 1;
                    $sumdet = 0;

                    while ($ressult_orderdet = mysqli_fetch_array($q_orderdet)) {
                        if ($i >= 2)
                            echo "</tr><tr><td colspan='1'></td>";
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
                <td colspan="4"></td>
                <td colspan="" style="height:25px; padding-top:5px; padding-bottom:10px; border-top:1px solid;" align="right">
                    <b> รวม </b>
                </td>
                <td align="right" style="padding-top: 5px; border-top:1px solid; padding-bottom:10px; padding-right:10px;">
                    <b><?= number_format($sumdet, 2) ?></b>
                </td>
                <td style=" border-top:1px solid; padding-bottom:5px;"><b>บาท</b></td>
            </tr>
            <?php $sum_final += $sumdet;

            ?>
            <td colspan="5" style="height:25px; text-align:right; border-top:1px solid;">
                <b>รวมทั้งหมด</b>
            </td>
            <td align="right" style="padding-right:10px; border-top:1px solid;"><b><?= number_format($sum_final, 2) ?></b></td>
            <td style=" border-top:1px solid;"><b>บาท</b></td>
        </table>
        <table width="50%" border="0">
            <tr>
                <td width="12%" align="right" style="padding-right:5px;"><b>ประเภทการสั่ง : </b></td>
                <td width="15%">
                    <?php
                    if ($result_payment['order_type'] == 0) {
                        echo "กลับบ้าน สั่งโดยพนักงาน";
                    } elseif ($result_payment['order_type'] == 1) {
                        echo "ทานที่ร้าน สั่งโดยพนักงาน";
                    } elseif ($result_payment['order_type'] == 2) {
                        echo "กลับบ้าน สั่งโดยลูกค้า";
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td width="20%" align="right" style="padding-right:5px;"><b>ลายเซ็นลูกค้า : </b></td>
                <td>...............................</td>
            </tr>

        </table>
        <div class="row">
            <div class="col-md-3 col-md-offset-9 text-right" style="padding-bottom:25px;">
                <b>วันที่พิมพ์ <?= fulldate_thai(date("d-m-Y")) ?></b>
            </div>
        </div>
    </div>
</body>