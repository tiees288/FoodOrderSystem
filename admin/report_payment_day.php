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
    <title>รายงานการรับชำระประจำวัน ตั้งแต่วันที่ <?= $_POST['startdate']; ?> ถึงวันที่ <?= $_POST['enddate'];  ?> | Food Order System</title>
</head>

<body>
    <?php
    $startdate  = $_POST['startdate'];
    $enddate    = $_POST['enddate'];
    ?>
    <div class="container" style="padding-top:20px; width:1350px;">
        <h3 class="text-center">รายงานการรับชำระประจำวัน</h3>
        <h3 class="text-center">ตั้งแต่วันที่ <?= fulldatetime_thai($startdate) ?> ถึงวันที่ <?= fulldatetime_thai($enddate) ?></h3>
        <br>
    </div>
    <table border="0" width="1300px" align="center">
        <tr>
            <td colspan="10" align="right" style="border-bottom:1px solid;">
                วันที่พิมพ์ <?= fulldate_thai(date("d-m-Y")); ?>
            </td>
        </tr>
        <tr style="border-bottom:1px solid; height:30px; ">
            <th style="text-align:center; width:125px;">วันที่รับชำระ</th>
            <th style="text-align:center; width:110px;">เลขที่ใบเสร็จ</th>
            <th style="text-align:left; width:170px;">ชื่อลูกค้า</th>
            <th style="text-align:left; width:130px;">ประเภทการชำระ</th>
            <th style="text-align:left; width:120px;">สถานะ</th>
            <th style="text-align:right; padding-right:5px; width:130px;">ยอดชำระ(บาท)</th>
            <th style="text-align:center;">วันที่สั่งอาหาร</th>
            <th style="text-align:center; width:150px;">รหัสการสั่งอาหาร</th>
            <th style="text-align:right; width:115px;">หมายเลขโต๊ะ</th>
            <th style="text-align:right; width:125px; padding-right:10px;">ราคารวม(บาท)</th>
        </tr>

        <?php
        $sql_date = "SELECT DISTINCT date(pay_date) FROM payment WHERE (date(pay_date) >= date('" . tochristyear($_POST['startdate']) . "') AND date(pay_date) <= date('" . tochristyear($_POST['enddate']) . "'))";
        $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));
        $total_pay = $total_bank_trans = $total_cash = 0;

        if (mysqli_num_rows($query_date) == 0) {
            echo "<script>alert('ไม่พบข้อมูลที่ท่านค้นหา'); window.close();</script>";
            exit();
        }

        while ($result_date = mysqli_fetch_array($query_date)) {
            echo "
               <tr height='25px'>
               <td align='center'>
                " . short_datetime_thai($result_date['date(pay_date)']) . "
               </td>
               </tr>";
            $sql_payment = "SELECT * FROM payment
               WHERE date(pay_date) = '" . $result_date['date(pay_date)'] . "'";
            $query_payment = mysqli_query($link, $sql_payment) or die(mysqli_error($link));
            $per_day = 0; //รวมจำนวนเงินต่อวัน

            while ($result_payment = mysqli_fetch_array($query_payment)) {
                $per_day += $result_payment['payamount'];
                $total_pay += $result_payment['payamount'];

                switch ($result_payment['pay_status']) {
                    case 0:
                        $payment_status = "<font color='orange'>ยังไม่ชำระ</font>";
                        break;
                    case 1:
                        $payment_status = "<font color='#12BB4F'>ชำระแล้ว</font>";
                        break;
                    case 2:
                        $payment_status = "<font color='red'>ยกเลิก</font>";
                        break;
                    default:
                        $payment_status = "-";
                }

                switch ($result_payment['pay_type']) {
                    case 0:
                        $payment_type = "<font color='#1E87C9'>เงินสด</font>";
                        $pay_amount = "<font color='#1E87C9'>" . $result_payment['payamount'] . "</font>";
                        $total_cash += $result_payment['payamount'];

                        break;
                    case 1:
                        $payment_type = "<font color='#EB6BD8'>เงินโอน</font>";
                        $pay_amount = "<font color='#EB6BD8'>" . $result_payment['payamount'] . "</font>";
                        $total_bank_trans += $result_payment['payamount'];
                        break;
                    default:
                        $payment_type = "-";
                }



                $sql_cus = "SELECT cus.cus_name FROM payment
                    LEFT JOIN orders ON payment.payno = orders.payno
                    LEFT JOIN customers as cus ON orders.cusid = cus.cusid 
                WHERE payment.payno = '" . $result_payment['payno'] . "'";
                $query_cus = mysqli_query($link, $sql_cus);
                $result_cus = mysqli_fetch_assoc($query_cus);

        ?>
                <tr>
                    <td></td>
                    <td align="center"><?= $result_payment['payno'] ?></td>
                    <td><?= $result_cus['cus_name'] ?></td>
                    <td><?= $payment_type ?></td>
                    <td><?= $payment_status ?></td>
                    <td align="right" style="padding-right:5px;"><?= $pay_amount ?></td>
                    <?php
                    $sql_date2 = "SELECT DISTINCT date(orderdate) FROM orders
                        WHERE payno = '" . $result_payment['payno'] . "'";
                    $query_date2 = mysqli_query($link, $sql_date2);

                    $row_order_day = 1; // จำนวนแถว วันที่
                    while ($result_date2 = mysqli_fetch_array($query_date2)) {
                        if ($row_order_day > 1) {
                            echo "</tr><tr><td colspan='6'></td>";
                        }
                        
                        echo "<td align='center'>" . short_datetime_thai($result_date2['date(orderdate)']) . "</td>";
                        $sql_order = "SELECT orderid, order_totalprice, tables_no
                        FROM orders WHERE date(orderdate) = '" . $result_date2['date(orderdate)'] . "' AND payno = '" . $result_payment['payno'] . "'";
                        $query_order = mysqli_query($link, $sql_order);

                        $row_order = 1; // จำนวนแถว การสั่ง
                        while ($result_order = mysqli_fetch_array($query_order)) {

                            if ($row_order > 1) {
                                echo "</tr><tr><td colspan='7'></td>";
                            }
                    ?>
                    <td align="center"><?= $result_order['orderid'] ?></td>
                    <td align="right"><?= ($result_order['tables_no'] != "") ? $result_order['tables_no'] : "-" ?></td>
                    <td align="right" style="padding-right:10px;"><?= $result_order['order_totalprice'] ?></td>
                </tr>

    <?php
                        $row_order++;
                        }
                        $row_order_day++;
                    }
                }
    ?>
    <tr style="border-bottom:1px solid;">
        <td colspan="4"></td>
        <td align="right"><b>รวม</b></td>
        <td align="right"><b><?= number_format($per_day, 2) ?></b></td>
        <td style="padding-left:10px;"><b>บาท</b></td>
        <td colspan="3"></td>
    </tr>
<?php
        }
?>
<tr>
    <td colspan="3"></td>
    <td align="right" colspan="2"><b>รวมทั้งหมด(บาท)</b></td>
    <td align="right"><b><?= number_format($total_pay, 2) ?></b></td>
    <td style="padding-left:10px;"><b>บาท</b></td>
    <td colspan="3"></td>
</tr>
<tr>
    <td colspan="3"></td>
    <td align="right" colspan="2"><b>
            <font color='#DC1CE1'>รวมชำระด้วยเงินโอนทั้งหมด(บาท)
        </b></td>
    <td align="right"><b>
            <font color='#DC1CE1'><?= number_format($total_bank_trans, 2) ?>
        </b></td>
    <td style="padding-left:10px;"><b>
            <font color='#DC1CE1'>บาท</font>
        </b></td>
    <td colspan="3"></td>
</tr>
<tr style="border-bottom:1px solid;">
    <td colspan="3"></td>
    <td align="right" colspan="2"><b>
            <font color='#1E87C9'>รวมชำระด้วยเงินสดทั้งหมด(บาท)</font>
        </b></td>
    <td align="right"><b>
            <font color='#1E87C9   '><?= number_format($total_cash, 2) ?></font>
        </b></td>
    <td style="padding-left:10px;"><b>
            <font color='#1E87C9'>บาท</font>
        </b></td>
    <td colspan="3"></td>
</tr>
    </table>
    <br>
</body>