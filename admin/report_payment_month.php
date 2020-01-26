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
    <title>รายงานการรับชำระประจำเดือน <?= fullmonth($month); ?> พ.ศ. <?= $year + 543 ?> | Food Order System</title>
</head>

<body>
    <div class="container" style="padding-top:20px; width:1350px;">
        <h3 class="text-center">รายงานการรับชำระประจำเดือน</h3>
        <h3 class="text-center">เดือน <?= fullmonth($month) ?> พ.ศ. <?= $year + 543 ?></h3>
        <br>
    </div>
    <table border="0" width="1050px" align="center">
        <tr>
            <td colspan="8" align="right" style="border-bottom:1px solid;">
                วันที่พิมพ์ <?= fulldate_thai(date("d-m-Y")); ?>
            </td>
        </tr>
        <tr style="border-bottom:1px solid; height:30px; ">
            <th style="text-align:center; width:125px;">วันที่รับชำระ</th>
            <th style="text-align:center; width:160px;">เลขที่ใบเสร็จ</th>
            <th style="text-align:left; width:160px;">ประเภทการชำระ</th>
            <th style="text-align:left; width:180px;">ชื่อลูกค้า</th>
            <th style="text-align:center; width:150px;">วันที่สั่งอาหาร</th>
            <th style="text-align:right; padding-right:10px; width:150px;">ยอดชำระ(บาท)</th>
            <th style="text-align:left; width:170px;">ชื่อพนักงาน</th>
            <th style="text-align:left; width:120px;">สถานะ</th>
        </tr>

        <?php
        $sql_date = "SELECT DISTINCT date(pay_date) FROM payment 
                WHERE month(pay_date) = '$month' AND year(pay_date) = '$year'";
        $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));
        $status_all = $status_0 = $status_1 = $status_2 = 0; // รวมสถานะด้านล่าง


        if (mysqli_num_rows($query_date) == 0) {
            echo "<script>alert('ไม่พบข้อมูลที่ท่านค้นหา'); window.close();</script>";
            exit();
        }
        while ($result_date = mysqli_fetch_array($query_date)) {
            $per_day = 0;
            echo "
               <tr height='25px'>
               <td align='center'>
                " . short_datetime_thai($result_date['date(pay_date)']) . "
               </td>
               </tr>";

            $sql_payment = "SELECT * FROM payment
                LEFT JOIN staff ON payment.staffid = staff.staffid
            WHERE date(pay_date) = '" . $result_date['date(pay_date)'] . "'";
            $query_payment = mysqli_query($link, $sql_payment) or die(mysqli_error($link));

            while ($result_payment = mysqli_fetch_array($query_payment)) {
                $per_day += $result_payment['payamount'];
                $status_all += $result_payment['payamount'];

                switch ($result_payment['pay_type']) {
                    case 0:
                        $pay_type = "<font color='#1E87C9'>เงินสด</font>";
                        break;
                    case 1:
                        $pay_type = "<font color='#EB6BD8'>เงินโอน</font>";
                        break;
                    default:
                        $pay_type = "";
                }

                switch ($result_payment['pay_status']) {
                    case 0:
                        $pay_status = "<font color='orange'>ยังไม่ชำระ</font>";
                        $pay_amount = "<font color='orange'>" . number_format($result_payment['payamount'], 2) . "</font>";
                        $status_0 += $result_payment['payamount'];
                        break;
                    case 1:
                        $pay_status = "<font color='#12BB4F'>ยังไม่ชำระ</font>";
                        $pay_amount = "<font color='#12BB4F'>" . number_format($result_payment['payamount'], 2) . "</font>";
                        $status_1 += $result_payment['payamount'];
                        break;
                    case 2:
                        $pay_status = "<font color='red'>ยกเลิก</font>";
                        $pay_amount = "<font color='red'>" . number_format($result_payment['payamount'], 2) . "</font>";
                        $status_2 += $result_payment['payamount'];
                        break;
                }

                $sql_cus = "SELECT cus.cus_name, date(orders.orderdate) FROM orders
                    LEFT JOIN customers AS cus ON orders.cusid = cus.cusid
                WHERE orders.payno = '" . $result_payment['payno'] . "'";
                $result_cus = mysqli_fetch_assoc(mysqli_query($link, $sql_cus));
        ?>
                <tr>
                    <td colspan=""></td>
                    <td align="center"><?= $result_payment['payno'] ?></td>
                    <td><?= $pay_type ?></td>
                    <td><?= $result_cus['cus_name'] ?></td>
                    <td align="center"><?= short_datetime_thai($result_cus['date(orders.orderdate)']) ?></td>
                    <td align="right" style="padding-right:10px;"><?= $pay_amount ?></td>
                    <td><?= $result_payment['staff_name']  ?></td>
                    <td><?= $pay_status ?></td>
                </tr>

            <?php
            }
            ?>
            <tr style="border-bottom: 1px solid;">
                <td colspan="4"></td>
                <td align="right" style="padding-right:8px;"><b>รวม</b></td>
                <td align="right" style="height:25px; padding-right:10px;"><b><?= number_format($per_day, 2) ?></b></td>
                <td colspan="2"><b>บาท</b></td>
            </tr>
        <?php
        }
        ?>
        <tr style="">
            <td colspan="3"></td>
            <td colspan="2" style="padding-left:70px;"><b>รวมทั้งหมด(บาท)</b></td>
            <td align="right" style="padding-right:10px;"><b><?= number_format($status_all, 2) ?></b></td>
            <td><b>บาท</b></td>
        </tr>
        <tr style="color:orange;">
            <td colspan="3"></td>
            <td colspan="2" style="padding-left:70px;"><b>รวมยังไม่ชำระทั้งหมด(บาท)</b></td>
            <td align="right" style="padding-right:10px;"><b><?= number_format($status_0, 2) ?></b></td>
            <td><b>บาท</b></td>
        </tr>
        <tr style="color:#12BB4F;">
            <td colspan="3"></td>
            <td colspan="2" style="padding-left:70px;"><b>รวมชำระทั้งหมด(บาท)</b></td>
            <td align="right" style="padding-right:10px;"><b><?= number_format($status_1, 2) ?></b></td>
            <td><b>บาท</b></td>
        </tr>
        <tr style="border-bottom:1px solid;">
            <td colspan="3"></td>
            <td colspan="2" style="padding-left:70px;"><b>
                    <font color="red">รวมยกเลิกทั้งหมด(บาท)
                </b></td>
            <td align="right" style="padding-right:10px;"><b>
                    <font color="red"><?= number_format($status_2, 2) ?></font>
                </b></td>
            <td colspan="2"><b>
                    <font color="red">บาท</font>
                </b></td>
        </tr>
    </table>
    <br>
</body>