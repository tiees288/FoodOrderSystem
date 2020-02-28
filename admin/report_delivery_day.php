<?php
if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['staff']) && ($_SESSION['staff_level'] != 1)) {
    echo "<script>alert('กรุณาตรรวจสอบสิทธิ์การเข้าใช้งาน'); window.location.assign('login_staff.php');</script>";
    exit();
}

if (!isset($_POST['startdate']) && !isset($_POST['enddate'])) {
    echo "<script>window.location.assign('daily_report_selector.php?report_name=delivery_day');</script>";
    exit();
}

include("conf/lib.php");
include("../conf/function.php");
include("../conf/connection.php");
?>

<head>
    <title>รายงานการส่งอาหารประจำวัน ตั้งแต่วันที่ <?= $_POST['startdate']; ?> ถึงวันที่ <?= $_POST['enddate'];  ?> | Food Order System</title>
    <style type="text/css" media="print">
        @page {
            size: auto;
        }
    </style>
</head>

<body>
    <?php
    $startdate  = $_POST['startdate'];
    $enddate    = $_POST['enddate'];
    ?>
    <div class="container" style="padding-top:20px; width:1350px;">
        <h3 class="text-center">รายงานการส่งอาหารประจำวัน</h3>
        <h3 class="text-center">ตั้งแต่วันที่ <?= fulldatetime_thai($startdate) ?> ถึงวันที่ <?= fulldatetime_thai($enddate) ?></h3>
        <br>
    </div>
    <table border="0" width="1660px" align="center">
        <tr>
            <td colspan="14" align="right" style="border-bottom:1px solid;">
                วันที่พิมพ์ <?= fulldate_thai(date("d-m-Y")); ?>
            </td>
        </tr>
        <tr style="border-bottom:1px solid; height:30px; ">
            <th style="text-align:center; width:115px;">วันที่ส่ง</th>
            <th style="text-align:center; width:100px;">เวลาส่ง</th>
            <th style="text-align:center; width:170px;">วัน/เวลากำหนดส่ง</th>
            <th style="text-align:center; width:130px;">วันที่สั่งอาหาร</th>
            <th style="text-align:center; width:130px;">เลขที่ใบเสร็จ</th>
            <th style="text-align:center; width:120px;">รหัสการสั่ง</th>
            <th style="text-align:left; width:190px;">ประเภทการสั่ง</th>
            <th style="text-align:left; width:150px;">สถานะการสั่ง</th>
            <th style="text-align:left; width:180px;">ชื่อลูกค้า</th>
            <th style="text-align:right; width:130px; padding-right:10px;">ราคารวม(บาท)</th>
            <th style="text-align:left; width:140px;">ชื่ออาหาร</th>
            <th style="text-align:right; width:90px;">จำนวน</th>
            <th style="text-align:right; width:125px;">ราคาต่อหน่วย(บาท)</th>
            <th style="text-align:right; padding-right:15px; width:110px;">ราคา(บาท)</th>
        </tr>
        <?php
        $sql_date = "SELECT DISTINCT date(order_date_delivered) FROM orders 
            WHERE (date(orders.order_date_delivered) >= date('" . tochristyear($_POST['startdate']) . "') 
            AND date(orders.order_date_delivered) <= date('" . tochristyear($_POST['enddate']) . "'))
            ORDER BY date(order_date_delivered) ASC";
        $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));


        if (mysqli_num_rows($query_date) == 0) {
            echo "<script>alert('ไม่พบข้อมูลที่ท่านค้นหา'); window.close();</script>";
            exit();
        }
        // รวมข้อมูลทั้งหมดของหน้า ////////////////////////
        $total_all = $total_0 = $total_1 = $total_2 = 0;
        ///////////////////////////////////////////////

        while ($result_date = mysqli_fetch_array($query_date)) {
            $sum_day_delivery = 0; // รวมต่อวัน
            echo "
               <tr height='25px'>
               <td align='center'>
                " . short_datetime_thai($result_date['date(order_date_delivered)']) . "
               </td>
               ";

            $sql_delivery = "SELECT * FROM orders 
                LEFT JOIN customers ON orders.cusid = customers.cusid
                LEFT JOIN payment ON orders.payno = payment.payno
                WHERE date(order_date_delivered) = '" . $result_date['date(order_date_delivered)'] . "'";
            $query_delivery = mysqli_query($link, $sql_delivery) or die(mysqli_error($link));
            $row_date = 1; // นับแถว
            while ($result_delivery = mysqli_fetch_array($query_delivery)) {
                $sum_day_delivery += $result_delivery['order_totalprice'];
                $total_all += $result_delivery['order_totalprice'];
              /*
                switch ($result_delivery['pay_status']) {
                    case 0:
                        $payment_status = "<font color='orange'>ยังไม่ชำระ</font>";
                        $pay_amount = "<font color='orange'>" . $result_delivery['order_totalprice'] . "</font>";
                        $total_0 += $result_delivery['order_totalprice'];
                        break;
                    case 1:
                        $payment_status = "<font color='#12BB4F'>ชำระแล้ว</font>";
                        $pay_amount = "<font color='#12BB4F'>" . $result_delivery['order_totalprice'] . "</font>";
                        $total_1 += $result_delivery['order_totalprice'];
                        break;
                    case 2:
                        $payment_status = "<font color='red'>ยกเลิก</font>";
                        $pay_amount = "<font color='red'>" . $result_delivery['order_totalprice'] . "</font>";
                        $total_2 += $result_delivery['order_totalprice'];
                        break;
                    default:
                        $payment_status = "-";
                }
*/
                switch ($result_delivery['order_type']) {
                    case 0:
                        $order_type = "กลับบ้าน  โดยพนักงาน";
                        break;
                    case 1:
                        $order_type = "ทานที่ร้าน โดยพนักงาน";
                        break;
                    case 2:
                        $order_type = "กลับบ้าน  โดยลูกค้า";
                        break;
                    default:
                        echo "Error";
                }

                switch ($result_delivery['order_status']) {
                    case 0:
                        $order_status = "<font color='orange'>ยังไม่แจ้งชำระ</font>";
                        $pay_amount = "<font color='orange'>" . $result_delivery['order_totalprice'] . "</font>";
                        $total_0 += $result_delivery['order_totalprice'];
                        break;
                    case 1:
                        $order_status = "<font color='#0072EE'>รอการตรวจสอบ</font>";
                        $pay_amount = "<font color='#0072EE'>" . $result_delivery['order_totalprice'] . "</font>";
                        $total_3 += $result_delivery['order_totalprice'];
                        break;
                    case 2:
                        $order_status = "<font color='#12BB4F'>ชำระแล้ว</font>";
                        $pay_amount = "<font color='#12BB4F'>" . $result_delivery['order_totalprice'] . "</font>";
                        $total_1 += $result_delivery['order_totalprice'];
                        break;
                    case 3:
                        $order_status = "<font color='red'>ยกเลิก</font>";
                        $pay_amount = "<font color='red'>" . $result_delivery['order_totalprice'] . "</font>";
                        $total_2 += $result_delivery['order_totalprice'];
                        break;
                    default:
                        $order_status = "-";
                }

                if ($row_date > 1) {
                    echo "</tr><tr><td></td>";
                }
        ?>
                <td align="center" height="30px"><?= substr($result_delivery['order_time_delivered'], 0, 5) ?></td>
                <td align="center"><?= short_datetime_thai($result_delivery['order_date_tobedelivery']) . " " . substr($result_delivery['order_time_tobedelivery'], 0, 5); ?></td>
                <td align="center"><?= short_datetime_thai($result_delivery['orderdate']) ?></td>
                <td align="center"><?= $result_delivery['payno'] ? $result_delivery['payno'] : "-" ?></td>
                <td align="center"><?= $result_delivery['orderid'] ?></td>
                <td align="left"><?= $order_type ?></td>
                <td align="left"><?= $order_status ?></td>
                <td align="left"><?= $result_delivery['cus_name'] ?></td>
                <td align="right" style="padding-right:10px;"><?= $pay_amount ?></td>
                <?php
                $sql_orderdet = "SELECT * FROM orderdetails AS orderdet
                    LEFT JOIN foods ON orderdet.foodid = foods.foodid
                    WHERE orderid = '" . $result_delivery['orderid'] . "'";
                $query_orderdet = mysqli_query($link, $sql_orderdet) or die(mysqli_error($link));
                $row_orderdet = 1;
                while ($result_orderdet = mysqli_fetch_array($query_orderdet)) {
                    if ($row_orderdet > 1) {
                        echo "</tr><td colspan='10'</td>";
                    }
                ?>
                    <td align="left" height="30px"><?= $result_orderdet['food_name'] ?></td>
                    <td align="right" height="30px"><?= $result_orderdet['orderdet_amount'] ?></td>
                    <td align="right" height="30px"><?= number_format($result_orderdet['orderdet_price'], 2) ?></td>
                    <td style="padding-right:15px;" align="right" height="30px"><?= number_format($result_orderdet['orderdet_price'] * $result_orderdet['orderdet_amount'], 2) ?></td>
            <?php
                    $row_orderdet++;
                }
                $row_date++;
            }
            ?>
            <tr style="border-bottom:1px solid; height:30px;">
                <td colspan="8"></td>
                <td><b>รวม</b></td>
                <td align="right" style="padding-right:10px;"><b><?= number_format($sum_day_delivery, 2) ?></b></td>
                <td colspan="4"><b>บาท</b></td>
            </tr>
        <?php
        }
        ?>
        <tr style="height:30px;">
            <td colspan="7"></td>
            <td style="padding-left:70px;" colspan="2"><b>รวมทั้งหมด</b></td>
            <td style="padding-right:10px;" align="right"><b><?= number_format($total_all, 2) ?></b></td>
            <td colspan="4"><b>บาท</b></td>
        </tr>
        <tr style="height:30px; color:orange;">
            <td colspan="7"></td>
            <td style="padding-left:70px;" colspan="2"><b>รวมยังไม่ได้แจ้งชำระทั้งหมด</b></td>
            <td style="padding-right:10px;" align="right"><b><?= number_format($total_0, 2) ?></b></td>
            <td colspan="4"><b>บาท</b></td>
        </tr>
        <tr style="height:30px; color:#12BB4F;">
            <td colspan="7"></td>
            <td style="padding-left:70px;" colspan="2"><b>รวมชำระแล้วทั้งหมด</b></td>
            <td style="padding-right:10px;" align="right"><b><?= number_format($total_1, 2) ?></b></td>
            <td colspan="4"><b>บาท</b></td>
        </tr>
        <tr style="height:30px; border-bottom:1px solid;">
            <td colspan="7"></td>
            <td style="color:red; padding-left:70px;" colspan="2"><b>รวมยกเลิกการสั่งทั้งหมด</b></td>
            <td style="color:red; padding-right:10px;" align="right"><b><?= number_format($total_2, 2) ?></b></td>
            <td style="color:red;" colspan="4"><b>บาท</b></td>
        </tr>
    </table>
    <br>
</body>