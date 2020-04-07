<?php
if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['staff']) && ($_SESSION['staff_level'] != 1)) {
    echo "<script>alert('กรุณาตรรวจสอบสิทธิ์การเข้าใช้งาน'); window.location.assign('login_staff.php');</script>";
    exit();
}

if (!isset($_POST['month']) && !isset($_POST['year'])) {
    echo "<script>window.location.assign('monthly_report_selector.php?report_name=order_month');</script>";
    exit();
}

include("conf/lib.php");
include("../conf/function.php");
include("../conf/connection.php");

$month  = $_POST['month'];
$year    = $_POST['year'];
?>

<head>
    <title>รายงานการสั่งอาหารประจำเดือน <?= fullmonth($month); ?> พ.ศ. <?= $year + 543 ?> | Food Order System</title>
    <style type="text/css" media="print">
        @page {
            size: auto;
        }
    </style>
</head>

<body>
    <div class="container" style="padding-top:20px; width:1350px;">
        <h3 class="text-center">รายงานการสั่งอาหารประจำเดือน</h3>
        <h3 class="text-center">เดือน <?= fullmonth($month) ?> พ.ศ. <?= $year + 543 ?></h3>
        <br>
    </div>
    <table border="0" width="1100px" align="center">
        <tr>
            <td colspan="9" align="right" style="border-bottom:1px solid;">
                วันที่พิมพ์ <?= fulldate_thai(date("d-m-Y")); ?>
            </td>
        </tr>
        <tr style="border-bottom:1px solid; height:30px; ">
            <th style="text-align:center; width:130px;">วันที่สั่งอาหาร</th>
            <th style="text-align:center; width:160px;">รหัสการสั่งอาหาร</th>
            <th style="text-align:left; width:200px;">ชื่อลูกค้า</th>
            <th style="text-align:right; padding-right:10px; width:125px;">หมายเลขโต๊ะ</th>
            <th style="text-align:left; width:130px;">สถานะ</th>
            <th style="text-align:left; width:150px;">ประเภทการสั่ง</th>
            <th colspan="2"></th>
            <th style="text-align:right; padding-right: 15px; width:150px;">ราคารวม(บาท)</th>
        </tr>
        <?php
        $sql_date = "SELECT DISTINCT date(orderdate) FROM orders 
                WHERE month(orderdate) = '$month' AND year(orderdate) = '$year'";
        $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));

        $total_trans_0 = $total_trans_1 = $total_trans_2 = $total_trans_3 = $total_trans = 0;
        $total = $total_0 = $total_1 = $total_2 = $total_3 = 0;

        if (mysqli_num_rows($query_date) == 0) {
            echo "<script>alert('ไม่พบข้อมูลที่ท่านค้นหา'); window.close();</script>";
            exit();
        }
        while ($result_date = mysqli_fetch_array($query_date)) {
            echo "
               <tr height='27px'>
               <td align='center'>
                " . short_datetime_thai($result_date['date(orderdate)']) . "
               </td>
               ";

            $sql_order = "SELECT * FROM orders 
                LEFT JOIN customers ON orders.cusid = customers.cusid
                WHERE date(orderdate) = '" . $result_date['date(orderdate)'] . "'";
            $query_order = mysqli_query($link, $sql_order) or die(mysqli_error($link));

            ///////////////////////////////////////////////////////////////////
            $order_trans = $sum_per_day = 0;
            ///////////////////////////////////////////////////////////////////
            $row_order = 1; // นับแถบ
            while ($result_order = mysqli_fetch_array($query_order)) {
                $order_trans++;

                switch ($result_order['order_type']) {
                    case 0:
                        $order_type = "กลับบ้าน  สั่งโดยพนักงาน";
                        break;
                    case 1:
                        $order_type = "ทานที่ร้าน สั่งโดยพนักงาน";
                        break;
                    case 2:
                        $order_type = "กลับบ้าน  สั่งโดยลูกค้า";
                        break;
                    default:
                        $order_type = "";
                }

                switch ($result_order['order_status']) {
                    case 0:
                        $order_status = "<font color='orange'>ยังไม่แจ้งชำระ</font>";
                        $order_totalprice = "<font color='orange'>" . $result_order['order_totalprice'] . "</font>";
                        $total_trans_0++;
                        $total_0 += $result_order['order_totalprice'];
                        break;
                    case 1:
                        $order_status = "<font color='#0072EE'>รอการตรวจสอบ</font>";
                        $order_totalprice = "<font color='#0072EE'>" . $result_order['order_totalprice'] . "</font>";
                        $total_trans_1++;
                        $total_1 += $result_order['order_totalprice'];
                        break;
                    case 2:
                        $order_status = "<font color='#12BB4F'>ชำระแล้ว</font>";
                        $order_totalprice = "<font color='#12BB4F'>" . $result_order['order_totalprice'] . "</font>";
                        $total_trans_2++;
                        $total_2 += $result_order['order_totalprice'];
                        break;
                    case 3:
                        $order_status = "<font color='red'>ยกเลิก</font>";
                        $order_totalprice = "<font color='red'>" . $result_order['order_totalprice'] . "</font>";
                        $total_trans_3++;
                        $total_3 += $result_order['order_totalprice'];
                        break;
                    default:
                        $order_status = "-";
                }
                $sum_per_day += $result_order['order_totalprice'];
                $total += $result_order['order_totalprice'];

                if ($row_order > 1) {
                    echo "</tr> <tr height='25px'><td height='25px;'>";
                }
        ?>


                <td align="center" height="25x;"><?= $result_order['orderid'] ?></td>
                <td><?= $result_order['cus_name'] ?></td>
                <td style="padding-right:20px;" align="right"><?= !empty($result_order['tables_no']) ? $result_order['tables_no'] : "-" ?></td>
                <td align="left"><?= $order_status ?></td>
                <td colspan="2"><?= $order_type ?></td>
                <td align="right" style="padding-right:15px;" colspan="3"><?= $order_totalprice ?></td>
                </tr>


            <?php
                $row_order++;
            }
            ?>
            <tr style="border-bottom:1px solid; height:25px;">
                <td colspan="5"></td>
                <td align="left" style="padding-left:50px;"><b>รวม</b></td>
                <td style="padding-right:15px; width:50px;" align="right"><b><?= $order_trans ?></b></td>
                <td width="60px;"><b>รายการ</b></td>
                <td colspan="" style="text-align:right; padding-right:15px;"><b><?= number_format($sum_per_day, 2) ?></b></td>
            </tr>
        <?php
        }
        $total_trans = $total_trans_0 + $total_trans_1 + $total_trans_2 + $total_trans_3;
        ?>
        <tr>
            <td colspan="4" style="height:25px;"></td>
            <td colspan="2"><b>รวมทั้งหมด(บาท)</b></td>
            <td align="right" style="padding-right: 15px;"><b><?= $total_trans ?></b></td>
            <td><b>รายการ</b></td>
            <td style="padding-right:15px;" align="right"><b><?= number_format($total, 2) ?></b></td>
        </tr>
        <tr>
            <td colspan="4" style="height:25px;"></td>
            <td colspan="2" align="">
                <font color="orange"><b>รวมยังไม่แจ้งชำระทั้งหมด(บาท)</b></font>
            </td>
            <td align="right" style="padding-right: 15px;">
                <font color="orange"><b><?= $total_trans_0 ?></b></font>
            </td>
            <td>
                <font color="orange"><b>รายการ</b></font>
            </td>
            <td align="right" style="padding-right: 15px;">
                <font color="orange"><b><?= number_format($total_0, 2) ?></b></font>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="height:25px;"></td>
            <td colspan="2" align="">
                <font color="#0072EE"><b>รวมรอการตรวจสอบทั้งหมด(บาท)</b></font>
            </td>
            <td align="right" style="padding-right: 15px;">
                <font color="#0072EE"><b><?= $total_trans_1 ?></b></font>
            </td>
            <td>
                <font color="#0072EE"><b>รายการ</b></font>
            </td>
            <td align="right" style="padding-right: 15px;">
                <font color="#0072EE"><b><?= number_format($total_1, 2) ?></b></font>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="height:25px;"></td>
            <td colspan="2" align="">
                <font color="#12BB4F"><b>รวมชำระแล้วทั้งหมด(บาท)</b></font>
            </td>
            <td align="right" style="padding-right: 15px;">
                <font color="#12BB4F"><b><?= $total_trans_2 ?></b></font>
            </td>
            <td>
                <font color="#12BB4F"><b>รายการ</b></font>
            </td>
            <td align="right" style="padding-right: 15px;">
                <font color="#12BB4F"><b><?= number_format($total_2, 2) ?></b></font>
            </td>
        </tr>
        <tr style="border-bottom:1px solid;">
            <td colspan="4" style="height:25px;"></td>
            <td colspan="2" align="">
                <font color="red"><b>รวมยกเลิกแล้วทั้งหมด(บาท)</b></font>
            </td>
            <td align="right" style="padding-right: 15px;">
                <font color="red"><b><?= $total_trans_3 ?></b></font>
            </td>
            <td>
                <font color="red"><b>รายการ</b></font>
            </td>
            <td align="right" style="padding-right: 15px;">
                <font color="red"><b><?= number_format($total_3, 2) ?></b></font>
            </td>
        </tr>
    </table>
    <br>
</body>