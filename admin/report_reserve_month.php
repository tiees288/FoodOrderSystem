<?php
if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['staff']) && ($_SESSION['staff_level'] != 1)) {
    echo "<script>alert('กรุณาตรรวจสอบสิทธิ์การเข้าใช้งาน'); window.location.assign('login_staff.php');</script>";
    exit();
}

if (!isset($_POST['month']) && !isset($_POST['year'])) {
    echo "<script>window.location.assign('monthly_report_selector.php?report_name=reserve_month');</script>";
    exit();
}

include("conf/lib.php");
include("../conf/function.php");
include("../conf/connection.php");

$month  = $_POST['month'];
$year    = $_POST['year'];
?>

<head>
    <title>รายงานการจองรประจำเดือน <?= fullmonth($month); ?> พ.ศ. <?= $year + 543 ?> | Food Order System</title>
    <style type="text/css" media="print">
        @page {
            size: auto;
        }
    </style>
</head>

<body>
    <div class="container" style="padding-top:20px; width:1350px;">
        <h3 class="text-center">รายงานการจองประจำเดือน</h3>
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
            <th style="text-align:left; padding-left:15px; width:140px;">สถานะ</th>
            <th style="text-align:center; width:130px;">วันที่จอง</th>
            <th style="text-align:center; width:120px;">รหัสการจอง</th>
            <th style="text-align:center; width:130px;">วันที่นัด</th>
            <th style="text-align:center; width:100px;">เวลานัด</th>
            <th style="text-align:left; width:180px;">ชื่อลูกค้า</th>
            <th style="text-align:left; width:130px;">เบอร์โทรศัพท์</th>
            <th style="width:100px; text-align:left; ">หมายเหตุ</th>
        </tr>
        <?php
        $sql_reserve = "SELECT DISTINCT date(reserv_date_reservation) FROM reservations
            WHERE month(reserv_date_reservation) = '$month' AND year(reserv_date_reservation) = '$year'";
        $sql_reserve_a = $sql_reserve_b = $sql_reserve;

        $query_reserve = mysqli_query($link, $sql_reserve) or die(mysqli_error($link));

        if (mysqli_num_rows($query_reserve) == 0) {
            echo "<script>alert('ไม่พบข้อมูลที่ท่านค้นหา'); window.close();</script>";
            exit();
        }
        ?>
        <tr>
            <td style="padding-left:15px; height:30px; color:#12BB4F">ยืนยันการจอง</td>

            <?php
            $status = 1; // เลขสถานะ
            $sql_reserve .= "AND reserv_status = '$status'";
            $query_date_reserve1 = mysqli_query($link, $sql_reserve) or die(mysqli_error($link));
            $row_date = 1;
            $count_list1 = $count_list0 = $count_list2 = 0;
            while ($result_date_reserve1 = mysqli_fetch_array($query_date_reserve1)) {
                if ($row_date > 1) {
                    echo "<td></td>";
                }
                echo "
                <td align='center'>
                 " . short_datetime_thai($result_date_reserve1['date(reserv_date_reservation)']) . "
                </td>";

                $sql_reserve1 = "SELECT * FROM reservations 
                    LEFT JOIN customers ON reservations.cusid = customers.cusid
                    WHERE date(reserv_date_reservation) = '" . $result_date_reserve1['date(reserv_date_reservation)'] . "'
                    AND reserv_status = '$status'";
                $query_reserve1 = mysqli_query($link, $sql_reserve1) or die(mysqli_error($link));
                $row_reserve1 = 1; // นับแถว

                while ($result_reserve1 = mysqli_fetch_array($query_reserve1)) {
                    $sql_order1 = "SELECT orderid FROM orders WHERE reserv_id = '" . $result_reserve1['reserv_id'] . "'";
                    $query_order1 = mysqli_query($link, $sql_order1) or die(mysqli_error($link));
                    $sql_reservelist = "SELECT tables_no FROM reservelist WHERE reserv_id = '" . $result_reserve1['reserv_id'] . "'";
                    $query_reservelist = mysqli_query($link, $sql_reservelist) or die(mysqli_error($link));

                    if ($row_reserve1 > 1) {
                        echo "<tr><td colspan='2'></td>";
                    }
            ?>
                    <td align="center" height="30px"><?= $result_reserve1['reserv_id'] ?></td>
                    <td align="center"><?= short_datetime_thai($result_reserve1['reserv_date_appointment'])  ?></td>
                    <td align="center"><?= substr($result_reserve1['reserv_time_appointment'], 0, 5) ?></td>
                    <td><?= $result_reserve1['cus_name'] ?></td>
                    <td><?= $result_reserve1['cus_tel'] ?></td>
                    <td align="left" ><?= ($result_reserve1['reserv_note']) ? $result_reserve1['reserv_note'] : "-" ?></td>

            <?php
                    $row_reserve1++;
                }
                echo "</tr>";
                $row_date++;
                $count_list1++;
            }
            ?>
        </tr>
        <tr height="30px" style="border-bottom:1px solid;">
            <td colspan="6" align="right"><b>รวม</b></td>
            <td style="padding-right:15px; text-align:right"><b><?= $count_list1 ?></b></td>
            <td><b>รายการ</b></td>
        </tr>
        <tr>
            <td style="padding-left:15px; height:30px; color:#0072EE">รอการตรวจสอบ</td>
            <!-- เพิ่มข้อมูล -->
            <?php
            $status = 0; // เลขสถานะ
            $sql_reserve_a .= "AND reserv_status = '$status'";

            $query_date_reserve1 = mysqli_query($link, $sql_reserve_a) or die(mysqli_error($link));
            $row_date = 1;
            while ($result_date_reserve1 = mysqli_fetch_array($query_date_reserve1)) {
                $row_reserve1 = 1;
                if ($row_date > 1) {
                    echo "<td></td>";
                }
                echo "
                <td align='center'>
                 " . short_datetime_thai($result_date_reserve1['date(reserv_date_reservation)']) . "
                </td>";

                $sql_reserve1 = "SELECT * FROM reservations 
                    LEFT JOIN customers ON reservations.cusid = customers.cusid
                    WHERE date(reserv_date_reservation) = '" . $result_date_reserve1['date(reserv_date_reservation)'] . "'
                    AND reserv_status = '$status'";
                $query_reserve1 = mysqli_query($link, $sql_reserve1) or die(mysqli_error($link));
                $row_reserve1 = 1; // นับแถว

                while ($result_reserve1 = mysqli_fetch_array($query_reserve1)) {
                    $sql_order1 = "SELECT orderid FROM orders WHERE reserv_id = '" . $result_reserve1['reserv_id'] . "'";
                    $query_order1 = mysqli_query($link, $sql_order1) or die(mysqli_error($link));
                    $sql_reservelist = "SELECT tables_no FROM reservelist WHERE reserv_id = '" . $result_reserve1['reserv_id'] . "'";
                    $query_reservelist = mysqli_query($link, $sql_reservelist) or die(mysqli_error($link));
                    if ($row_reserve1 > 1) {
                        echo "<tr><td colspan='2'></td>";
                    }
            ?>
                    <td align="center" height="30px"><?= $result_reserve1['reserv_id'] ?></td>
                    <td align="center"><?= short_datetime_thai($result_reserve1['reserv_date_appointment'])  ?></td>
                    <td align="center"><?= substr($result_reserve1['reserv_time_appointment'], 0, 5) ?></td>
                    <td><?= $result_reserve1['cus_name'] ?></td>
                    <td><?= $result_reserve1['cus_tel'] ?></td>
                    <td align="left" ><?= ($result_reserve1['reserv_note']) ? $result_reserve1['reserv_note'] : "-" ?></td>
        </tr>
<?php
                    $count_list0++;
                    $row_reserve1++;
                }
            }
?>
<tr height="30px" style="border-bottom:1px solid;">
    <td colspan="6" align="right"><b>รวม</b></td>
    <td style="padding-right:15px; text-align:right"><b><?= $count_list0 ?></b></td>
    <td><b>รายการ</b></td>
</tr>
<tr>
    <td style="padding-left:15px; height:30px; color:red">ยกเลิก</td>
    <!-- เพิ่มข้อมูล -->
    <?php
    $status = 2; // เลขสถานะ
    $sql_reserve_b .= "AND reserv_status = '$status'";
    $query_date_reserve1 = mysqli_query($link, $sql_reserve_b) or die(mysqli_error($link));
    $row_date = 1;
    while ($result_date_reserve1 = mysqli_fetch_array($query_date_reserve1)) {
        $row_reserve1 = 1;
        if ($row_date > 1) {
            echo "<td></td>";
        }
        echo "
                <td align='center'>
                 " . short_datetime_thai($result_date_reserve1['date(reserv_date_reservation)']) . "
                </td>";

        $sql_reserve1 = "SELECT * FROM reservations 
                    LEFT JOIN customers ON reservations.cusid = customers.cusid
                    WHERE date(reserv_date_reservation) = '" . $result_date_reserve1['date(reserv_date_reservation)'] . "'
                    AND reserv_status = '$status'";
        $query_reserve1 = mysqli_query($link, $sql_reserve1) or die(mysqli_error($link));
        $row_reserve1 = 1; // นับแถว

        while ($result_reserve1 = mysqli_fetch_array($query_reserve1)) {
            $sql_order1 = "SELECT orderid FROM orders WHERE reserv_id = '" . $result_reserve1['reserv_id'] . "'";
            $query_order1 = mysqli_query($link, $sql_order1) or die(mysqli_error($link));
            $sql_reservelist = "SELECT tables_no FROM reservelist WHERE reserv_id = '" . $result_reserve1['reserv_id'] . "'";
            $query_reservelist = mysqli_query($link, $sql_reservelist) or die(mysqli_error($link));
            if ($row_reserve1 > 1) {
                echo "<tr><td colspan='2'></td>";
            }
    ?>
            <td align="center" height="30px"><?= $result_reserve1['reserv_id'] ?></td>
            <td align="center"><?= short_datetime_thai($result_reserve1['reserv_date_appointment'])  ?></td>
            <td align="center"><?= substr($result_reserve1['reserv_time_appointment'], 0, 5) ?></td>
            <td><?= $result_reserve1['cus_name'] ?></td>
            <td><?= $result_reserve1['cus_tel'] ?></td>
            <td align="left" ><?= ($result_reserve1['reserv_note']) ? $result_reserve1['reserv_note'] : "-" ?></td>
    <?php
            echo "</tr>";
            $row_reserve1++;
        }
        $count_list2++;
        $row_date++;
    }
    ?>
</tr>
<tr height="30px" style="border-bottom:1px solid;">
    <td colspan="6" align="right"><b>รวม</b></td>
    <td style="padding-right:15px; text-align:right"><b><?= $count_list2 ?></b></td>
    <td><b>รายการ</b></td>
</tr>
<!-- ส่วนสรุปรายงาน -->
<tr>
    <td colspan="4"></td>
    <td colspan="2" style="padding-left: 30px; height:30px;"><b>รวมทั้งหมด</b></td>
    <td align="right" style="padding-right:15px;"><b><?= $count_list0 + $count_list1 + $count_list2 ?></b></td>
    <td><b>รายการ</b></td>
</tr>
<tr>
    <td colspan="4"></td>
    <td colspan="2" style="color:#12BB4F; padding-left:30px; height:30px;"><b>รวมยืนยันการจองทั้งหมด</b></td>
    <td style="text-align:right; padding-right:15px; color:#12BB4F;"><b><?= $count_list1 ?></b></td>
    <td style="color:#12BB4F;"><b>รายการ</b></td>
</tr>
<tr>
    <td colspan="4"></td>
    <td colspan="2" style="padding-left: 30px; color:#0072EE; height:30px;"><b>รวมรอการตรวจสอบทั้งหมด</b></td>
    <td style="text-align:right; padding-right:15px; color:#0072EE;"><b><?= $count_list0 ?></b></td>
    <td style="color:#0072EE;"><b>รายการ</b></td>
</tr>
<tr style="border-bottom: 1px solid;">
    <td colspan="4"></td>
    <td colspan="2" style="padding-left: 30px; height:30px; color:red;"><b>รวมยกเลิกทั้งหมด</b></td>
    <td style="text-align:right; padding-right:15px; color:red;"><b><?= $count_list2 ?></b></td>
    <td style="color:red;"><b>รายการ</b></td>
</tr>
    </table>
    <br>
</body>