<?php
if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['staff']) && ($_SESSION['staff_level'] != 1)) {
    echo "<script>alert('กรุณาตรรวจสอบสิทธิ์การเข้าใช้งาน'); window.location.assign('login_staff.php');</script>";
    exit();
}

if (!isset($_POST['month']) && !isset($_POST['year'])) {
    echo "<script>window.location.assign('monthly_report_selector.php?report_name=delivery_month');</script>";
    exit();
}

include("conf/lib.php");
include("../conf/function.php");
include("../conf/connection.php");

$month  = $_POST['month'];
$year    = $_POST['year'];
?>

<head>
    <title>รายงานการส่งอาหารประจำเดือน <?= fullmonth($month); ?> พ.ศ. <?= $year + 543 ?> | Food Order System</title>
    <style type="text/css" media="print">
        @page {
            size: auto;
        }
    </style>
</head>

<body>
    <div class="container" style="padding-top:20px; width:1350px;">
        <h3 class="text-center">รายงานการส่งอาหารประจำเดือน</h3>
        <h3 class="text-center">เดือน <?= fullmonth($month) ?> พ.ศ. <?= $year + 543 ?></h3>
        <br>
    </div>
    <table border="0" width="1300px" align="center">
        <tr>
            <td colspan="9" align="right" style="border-bottom:1px solid;">
                วันที่พิมพ์ <?= fulldate_thai(date("d-m-Y")); ?>
            </td>
        </tr>
        <tr style="border-bottom:1px solid; height:30px; ">
            <th style="text-align:left; padding-left:15px; width:100px;">สถานะ</th>
            <th style="text-align:center; width:130px;">วันที่สั่งอาหาร</th>
            <th style="text-align:center; width:120px;">รหัสการสั่ง</th>
            <th style="text-align:center; width:130px;">เลขที่ใบเสร็จ</th>
            <th style="text-align:center; width:160px;">วัน/เวลากำหนดส่ง</th>
            <th style="text-align:left; width:190px;">ชื่อลูกค้า</th>
            <th style="text-align:left; width:130px;">เบอร์โทรศัพท์</th>
            <th style="text-align:left; width:200px;">สถานที่ส่ง</th>
            <th style="text-align:right; width:130px; padding-right:15px;">ราคา(บาท)</th>
        </tr>
        <?php
        $sql_delivery = "SELECT DISTINCT date(orderdate) FROM orders
            LEFT JOIN payment ON orders.payno = payment.payno
            WHERE (month(orderdate) = '$month' AND year(orderdate) = '$year'
            AND order_type = '0' AND orders.order_date_delivered != '0000-00-00')";
        $query_delivery = mysqli_query($link, $sql_delivery) or die(mysqli_error($link));
        $sql_delivery_1 = $sql_delivery_0 = $sql_delivery_2 = $sql_delivery;
        $sum_a = $sum_b = $sum_c = 0;

        if (mysqli_num_rows($query_delivery) == 0) {
            echo "<script>alert('ไม่พบข้อมูลที่ท่านค้นหา'); window.close();</script>";
            exit();
        }
        ?>
        <tr>
            <td style="padding-left:15px; height:30px; color:#12BB4F">ชำระแล้ว</td>

            <?php
            $status = 1; // เลขสถานะ
            $sql_delivery_1 .= "AND pay_status = '$status'";
            $query_delivery_1 = mysqli_query($link, $sql_delivery_1) or die(mysqli_error($link));

            $row_delivery_date = 1; // นับแถว
            $total_1 = 0;
            while ($result_delivery_1 = mysqli_fetch_array($query_delivery_1)) {
                if ($row_delivery_date > 1) {
                    echo "</tr><tr><td height='30px'></td>";
                }
                echo "
                <td align='center'>
                 " . short_datetime_thai($result_delivery_1['date(orderdate)']) . "
                </td>";
                $sql_deliverys = "SELECT * FROM orders
                    LEFT JOIN payment ON orders.payno = payment.payno
                    LEFT JOIN customers ON orders.cusid = customers.cusid
                WHERE date(orderdate) = '" . $result_delivery_1['date(orderdate)'] . "' 
                AND order_type = '0' AND pay_status = '$status' ORDER BY orders.orderid ASC";
                $query_deliveys = mysqli_query($link, $sql_deliverys);
                $row_order = 1; //นับแถว
                while ($result_order = mysqli_fetch_array($query_deliveys)) {
                    $total_1 += $result_order['order_totalprice'];
                    if ($row_order > 1) {
                        echo "</tr><tr><td colspan='2' height='30px'></td>";
                    }
            ?>
                    <td align="center"><?= $result_order['orderid'] ?></td>
                    <td align="center"><?= $result_order['payno'] ?></td>
                    <td align="center"><?= short_datetime_thai($result_order['order_date_tobedelivery']) . " " . substr($result_order['order_time_tobedelivery'], 0, 5) ?></td>
                    <td align="left"><?= $result_order['cus_name'] ?></td>
                    <td align="left"><?= $result_order['cus_tel'] ?></td>
                    <td align="left"><?= $result_order['order_delivery_place'] ?></td>
                    <td align="right" style="padding-right:15px; color:#12BB4F;"><?= number_format($result_order['order_totalprice'], 2) ?></td>
            <?php
                    $row_order++;
                }
                $row_delivery_date++;
            }
            $sum_a = $total_1;
            ?>
            <!-- รวมต่อสถานะ -->
        <tr height="30px" style="border-bottom:1px solid;">
            <td colspan="7"></td>
            <td><b>รวม</b></td>
            <td align="right" style="padding-right:15px"><b><?= number_format($total_1, 2) ?></b></td>
        </tr>
        <!-- ----- -->

        <tr>
            <td style="padding-left:15px; height:30px; color:orange">ยังไม่ชำระ</td>

            <?php
            $status = ""; // เลขสถานะ
            $sql_delivery_0 .= " AND orders.payno IS NULL";
            $query_delivery_0 = mysqli_query($link, $sql_delivery_0) or die(mysqli_error($link));

            $row_delivery_date = 1; // นับแถว
            $total_1 = 0;
            if (mysqli_num_rows($query_delivery_0) == 0) {
                echo "
                    <td colspan='9'></td>
                </tr>";
            }

            while ($result_delivery_0 = mysqli_fetch_array($query_delivery_0)) {
                if ($row_delivery_date > 1) {
                    echo "</tr><tr><td height='30px'></td>";
                }
                echo "
                <td align='center'>
                 " . short_datetime_thai($result_delivery_0['date(orderdate)']) . "
                </td>";
                $sql_deliverys = "SELECT * FROM orders
                    LEFT JOIN payment ON orders.payno = payment.payno
                    LEFT JOIN customers ON orders.cusid = customers.cusid
                WHERE date(orderdate) = '" . $result_delivery_0['date(orderdate)'] . "' 
                AND order_type = '0' AND orders.order_date_delivered != '0000-00-00' AND orders.payno IS NULL 
                ORDER BY orders.orderid ASC";

                $query_deliveys = mysqli_query($link, $sql_deliverys);
                $row_order = 1; //นับแถว
                while ($result_order = mysqli_fetch_array($query_deliveys)) {
                    $total_1 += $result_order['order_totalprice'];
                    if ($row_order > 1) {
                        echo "</tr><tr><td colspan='2' height='30px'></td>";
                    }
            ?>
                    <td align="center"><?= $result_order['orderid'] ?></td>
                    <td align="center"><?= $result_order['payno'] ? $result_order['payno'] : "-" ?></td>
                    <td align="center"><?= short_datetime_thai($result_order['order_date_tobedelivery']) . " " . substr($result_order['order_time_tobedelivery'], 0, 5) ?></td>
                    <td align="left"><?= $result_order['cus_name'] ?></td>
                    <td align="left"><?= $result_order['cus_tel'] ?></td>
                    <td align="left"><?= $result_order['order_delivery_place'] ?></td>
                    <td align="right" style="padding-right:15px; color:orange;"><?= number_format($result_order['order_totalprice'], 2) ?></td>
            <?php
                    $row_order++;
                }
                $row_delivery_date++;
            }
            $sum_b = $total_1;
            ?>
            <!-- รวมต่อสถานะ -->
        <tr height="30px" style="border-bottom:1px solid;">
            <td colspan="7"></td>
            <td><b>รวม</b></td>
            <td align="right" style="padding-right:15px"><b><?= number_format($total_1, 2) ?></b></td>
        </tr>
        <!-- ----- -->

        <tr>
            <td style="padding-left:15px; height:30px; color:red">ยกเลิก</td>

            <?php
            $status = 2; // เลขสถานะ
            $sql_delivery_2 .= " AND pay_status = '$status'";
            $query_delivery_2 = mysqli_query($link, $sql_delivery_2) or die(mysqli_error($link));

            $row_delivery_date = 1; // นับแถว
            $total_1 = 0;
            if (mysqli_num_rows($query_delivery_2) == 0) {
                echo "
                    <td colspan='9'></td>
                </tr>";
            } else {

                while ($result_delivery_2 = mysqli_fetch_array($query_delivery_2)) {
                    if ($row_delivery_date > 1) {
                        echo "</tr><tr><td height='30px'></td>";
                    }
                    echo "
                <td align='center'>
                 " . short_datetime_thai($result_delivery_2['date(orderdate)']) . "
                </td>";
                    $sql_deliverys = "SELECT * FROM orders
                    LEFT JOIN payment ON orders.payno = payment.payno
                    LEFT JOIN customers ON orders.cusid = customers.cusid
                WHERE date(orderdate) = '" . $result_delivery_2['date(orderdate)'] . "'
                AND order_type = '0' AND pay_status = '$status' ORDER BY orders.orderid ASC";
                    $query_deliveys = mysqli_query($link, $sql_deliverys);
                    $row_order = 1; //นับแถว
                    while ($result_order = mysqli_fetch_array($query_deliveys)) {
                        $total_1 += $result_order['order_totalprice'];
                        if ($row_order > 1) {
                            echo "</tr><tr><td colspan='2' height='30px'></td>";
                        }
            ?>
                        <td align="center"><?= $result_order['orderid'] ?></td>
                        <td align="center"><?= $result_order['payno'] ?></td>
                        <td align="center"><?= short_datetime_thai($result_order['order_date_tobedelivery']) . " " . substr($result_order['order_time_tobedelivery'], 0, 5) ?></td>
                        <td align="left"><?= $result_order['cus_name'] ?></td>
                        <td align="left"><?= $result_order['cus_tel'] ?></td>
                        <td align="left"><?= $result_order['order_delivery_place'] ?></td>
                        <td align="right" style="padding-right:15px; color:red;"><?= number_format($result_order['order_totalprice'], 2) ?></td>
            <?php
                        $row_order++;
                    }
                    $row_delivery_date++;
                }
            }
            $sum_c = $total_1;
            ?>
            <!-- รวมต่อสถานะ -->
        <tr height="30px" style="border-bottom:1px solid;">
            <td colspan="7"></td>
            <td><b>รวม</b></td>
            <td align="right" style="padding-right:15px"><b><?= number_format($total_1, 2) ?></b></td>
        </tr>
        <tr height="30px">
            <td colspan="7"></td>
            <td colspan=""><b>รวมทั้งหมด(บาท)</b></td>
            <td align="right" style="padding-right:15px;"><b><?= number_format($sum_a + $sum_b + $sum_c, 2) ?></b></td>
        </tr>
        <tr height="30px" style="color:#12BB4F;">
            <td colspan="7"></td>
            <td colspan="1"><b>รวมชำระแล้วทั้งหมด(บาท)</b></td>
            <td align="right" style="padding-right:15px;"><b><?= number_format($sum_a, 2) ?></b></td>
        </tr>
        <tr height="30px" style="color:orange;">
            <td colspan="7"></td>
            <td colspan="1"><b>รวมยังไม่ชำระทั้งหมด(บาท)</b></td>
            <td align="right" style="padding-right:15px;"><b><?= number_format($sum_b, 2) ?></b></td>
        </tr>
        <tr height="30px" style="border-bottom:1px solid;">
            <td colspan="7"></td>
            <td style="color:red;" colspan="1"><b>รวมยกเลิกทั้งหมด(บาท)</b></td>
            <td align="right" style="color:red; padding-right:15px;"><b><?= number_format($sum_c, 2) ?></b></td>
        </tr>
    </table>
    <br>
</body>