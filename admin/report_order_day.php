<?php
if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['staff']) && ($_SESSION['staff_level'] != 1)) {
    echo "<script>alert('กรุณาตรรวจสอบสิทธิ์การเข้าใช้งาน'); window.location.assign('login_staff.php');</script>";
    exit();
}

if (!isset($_POST['startdate']) && !isset($_POST['enddate'])) {
    echo "<script>window.location.assign('daily_report_selector.php?report_name=order_day');</script>";
    exit();
}

include("conf/lib.php");
include("../conf/function.php");
include("../conf/connection.php");
?>

<head>
    <title>รายงานการสั่งอาหารประจำวัน ตั้งแต่วันที่ <?= $_POST['startdate']; ?> ถึงวันที่ <?= $_POST['enddate'];  ?> | Food Order System</title>
</head>

<body>
    <?php
    $startdate  = $_POST['startdate'];
    $enddate    = $_POST['enddate'];
    ?>
    <div class="container" style="padding-top:20px; width:1350px;">
        <h3 class="text-center">รายงานการสั่งอาหารประจำวัน</h3>
        <h3 class="text-center">ตั้งแต่วันที่ <?= fulldatetime_thai($startdate) ?> ถึงวันที่ <?= fulldatetime_thai($enddate) ?></h3>
        <br>
    </div>
    <table border="0" width="1150px" align="center">
        <tr>
            <td colspan="9" align="right" style="border-bottom:1px solid;">
                วันที่พิมพ์ <?= fulldate_thai(date("d-m-Y")); ?>
            </td>
        </tr>
        <tr style="border-bottom:1px solid; height:30px; ">
            <th style="text-align:center; width:140px;">วันที่สั่ง</th>
            <th style="text-align:center; width:110px;">รหัสการสั่ง</th>
            <th style="text-align:left; width:120px;">สถานะการสั่ง</th>
            <th style="text-align:left; width:160px;">ชื่อลูกค้า</th>
            <th style="text-align:right; width:125px;">ราคารวม(บาท)</th>
            <th style="text-align:left; padding-left:20px;">รายการอาหาร</th>
            <th style="text-align:right;">จำนวน</th>
            <th style="text-align:right; width:150px;">ราคาต่อหน่วย(บาท)</th>
            <th style="text-align:right; width:115px; padding-right:15px;">ราคา(บาท)</th>
        </tr>
        <?php
        $sql_date = "SELECT DISTINCT date(orderdate) FROM orders WHERE (date(orders.orderdate) >= date('" . tochristyear($_POST['startdate']) . "') AND date(orders.orderdate) <= date('" . tochristyear($_POST['enddate']) . "'))";
        $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));

        // ตัวแปรสำหรับรวมค่า
        $total_trans_0 = $total_trans_1 = $total_trans_2 = $total_trans_3 = $total_trans = 0;
        $total_0 = $total_1 = $total_2 = $total_3 = $total = 0; // ราคารวมทั้งหมด

        if (mysqli_num_rows($query_date) == 0) {
            echo "<script>alert('ไม่พบข้อมูลที่ท่านค้นหา'); window.close();</script>";
            exit();
        }

        while ($result_date = mysqli_fetch_array($query_date)) {
            echo "
               <tr height='25px'>
               <td align='center'>
                " . short_datetime_thai($result_date['date(orderdate)']) . "
               </td>
               </tr>";
            $sql_order = "SELECT * FROM orders 
                LEFT JOIN customers ON orders.cusid = customers.cusid
                WHERE date(orderdate) = '" . $result_date['date(orderdate)'] . "'";
            $query_order = mysqli_query($link, $sql_order) or die(mysqli_error($link));

            $sum_per_date = 0; // ราคารวมในแต่ละวัน

            while ($result_order = mysqli_fetch_array($query_order)) {
                switch ($result_order['order_status']) {
                    case 0:
                        $order_status = "<font color='orange'>ยังไม่แจ้งชำระ</font>";
                        $order_totalprice = "<font color='orange'>" . $result_order['order_totalprice'] . "</font>";
                        $total_trans_0++;
                        break;
                    case 1:
                        $order_status = "<font color='#0072EE'>รอการตรวจสอบ</font>";
                        $order_totalprice = "<font color='#0072EE'>" . $result_order['order_totalprice'] . "</font>";
                        $total_trans_1++;
                        break;
                    case 2:
                        $order_status = "<font color='#12BB4F'>ชำระแล้ว</font>";
                        $order_totalprice = "<font color='#12BB4F'>" . $result_order['order_totalprice'] . "</font>";
                        $total_trans_2++;
                        break;
                    case 3:
                        $order_status = "<font color='red'>ยกเลิก</font>";
                        $order_totalprice = "<font color='red'>" . $result_order['order_totalprice'] . "</font>";
                        $total_trans_3++;
                        break;
                    default:
                        $order_status = "-";
                }
        ?>
                <tr height="20px">
                    <td></td>
                    <td align="center"><?= $result_order['orderid'] ?></td>
                    <td><?= $order_status ?></td>
                    <td><?= $result_order['cus_name'] ?></td>
                    <td align="right"><?= $order_totalprice ?></td>
                </tr>
                <?php
                $sum_per_date += $result_order['order_totalprice'];

                if ($result_order['order_status'] == 0) {
                    $total_0 += $result_order['order_totalprice'];
                } elseif ($result_order['order_status'] == 1) {
                    $total_1 += $result_order['order_totalprice'];
                } elseif ($result_order['order_status'] == 2) {
                    $total_2 += $result_order['order_totalprice'];
                } elseif ($result_order['order_status'] == 3) {
                    $total_3 += $result_order['order_totalprice'];
                }
                $total_trans++;

                $sql_orderdet = "SELECT * FROM orderdetails 
                    LEFT JOIN foods ON orderdetails.foodid = foods.foodid
                    WHERE orderdetails.orderid = '" . $result_order['orderid'] . "' AND orderdetails.orderdet_status != '2'";
                $query_orderdet = mysqli_query($link, $sql_orderdet) or die(mysqli_error($link));

                while ($result_orderdet = mysqli_fetch_array($query_orderdet)) { ?>
                    <tr style="height: 25px;">
                        <td colspan="5"></td>
                        <td style="padding-left:20px;"><?= $result_orderdet['food_name'] ?></td>
                        <td align="right"><?= $result_orderdet['orderdet_amount'] ?></td>
                        <td align="right"><?= $result_orderdet['orderdet_price'] ?></td>
                        <td align="right" style="padding-right:15px;"><?= number_format($result_orderdet['orderdet_price'] * $result_orderdet['orderdet_amount'], 2) ?></td>
                    </tr>
            <?php
                }
            }
            $total += $sum_per_date;

            ?>
            <tr style="border-bottom:1px solid; height:25px;">
                <td colspan="4" align="right"><b>รวม(บาท)</b></td>
                <td align="right"><b><?= number_format($sum_per_date, 2) ?></b></td>
                <td colspan="4" style="padding-left:10px;"></td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan="2" style="height:30px;"></td>
            <td colspan="2"><b>ราคารวมทั้งหมด(บาท)</b></td>
            <td align="right"><b><?= number_format($total, 2) ?></b></td>
            <td></td>
            <td align="right"><b><?= $total_trans ?></b></td>
            <td style="padding-left:15px;"><b>รายการ</b></td>
        </tr>
        <tr>
            <td colspan="2" style="height:30px;"></td>
            <td colspan="2" align="">
                <font color="orange"><b>รวมยังไม่แจ้งชำระทั้งหมด(บาท)</b></font>
            </td>
            <td align="right">
                <font color="orange"><b><?= number_format($total_0, 2) ?></b></font>
            </td>
            <td></td>
            <td align="right">
                <font color="orange"><b><?= $total_trans_0 ?></b></font>
            </td>
            <td style="padding-left:15px;">
                <font color="orange"><b>รายการ</b></font>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="height:30px;"></td>
            <td colspan="2" align="">
                <font color="#0072EE"><b>รวมรอการตรวจสอบทั้งหมด(บาท)</b></font>
            </td>
            <td align="right">
                <font color="#0072EE"><b><?= number_format($total_1, 2) ?></b></font>
            </td>
            <td></td>
            <td align="right">
                <font color="#0072EE"><b><?= $total_trans_1 ?></b></font>
            </td>
            <td style="padding-left:15px;">
                <font color="#0072EE"><b>รายการ</b></font>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="height:30px;"></td>
            <td colspan="2" align="">
                <font color="#12BB4F"><b>รวมยังไม่แจ้งชำระทั้งหมด(บาท)</b></font>
            </td>
            <td align="right">
                <font color="#12BB4F"><b><?= number_format($total_2, 2) ?></b></font>
            </td>
            <td></td>
            <td align="right">
                <font color="#12BB4F"><b><?= $total_trans_2 ?></b></font>
            </td>
            <td style="padding-left:15px;"> <font color="#12BB4F"><b>รายการ</b></font></td>
        </tr>
        <tr style="border-bottom:1px solid;">
            <td colspan="2" style="height:30px;"></td>
            <td colspan="2" align="">
                <font color="red"><b>รวมยกเลิกแล้วทั้งหมด(บาท)</b></font>
            </td>
            <td align="right">
                <font color="red"><b><?= number_format($total_3, 2) ?></b></font>
            </td>
            <td></td>
            <td align="right">
                <font color="red"><b><?= $total_trans_3 ?></b></font>
            </td>
            <td colspan="2" style="padding-left:15px;"> <font color="red"><b>รายการ</b></font></td>
        </tr>
    </table>
</body>
<br>