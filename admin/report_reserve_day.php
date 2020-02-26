<?php
if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['staff']) && ($_SESSION['staff_level'] != 1)) {
    echo "<script>alert('กรุณาตรรวจสอบสิทธิ์การเข้าใช้งาน'); window.location.assign('login_staff.php');</script>";
    exit();
}

if (!isset($_POST['startdate']) && !isset($_POST['enddate'])) {
    echo "<script>window.location.assign('daily_report_selector.php?report_name=reserve_day');</script>";
    exit();
}

include("conf/lib.php");
include("../conf/function.php");
include("../conf/connection.php");
?>

<head>
    <title>รายงานการจองประจำวัน ตั้งแต่วันที่ <?= $_POST['startdate']; ?> ถึงวันที่ <?= $_POST['enddate'];  ?> | Food Order System</title>
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
        <h3 class="text-center">รายงานการจองประจำวัน</h3>
        <h3 class="text-center">ตั้งแต่วันที่ <?= fulldatetime_thai($startdate) ?> ถึงวันที่ <?= fulldatetime_thai($enddate) ?></h3>
        <br>
    </div>
    <table border="0" width="1150px" align="center">
        <tr>
            <td colspan="10" align="right" style="border-bottom:1px solid;">
                วันที่พิมพ์ <?= fulldate_thai(date("d-m-Y")); ?>
            </td>
        </tr>
        <tr style="border-bottom:1px solid; height:30px; ">
            <th style="text-align:center; width:140px;">วันที่จอง</th>
            <th style="text-align:center; width:110px;">รหัสการจอง</th>
            <th style="text-align:left; width:200px;">ชื่อลูกค้า</th>
            <th style="text-align:left; width:120px;">เบอร์โทรศัพท์</th>
            <th style="text-align:center; width:120px;">วันที่นัด</th>
            <th style="text-align:center; width:120px;">เวลานัด</th>
            <th style="text-align:left; width:125px;">สถานะ</th>

            <th style="text-align:right; width:120px;">หมายเลขโต๊ะ</th>
            <th style="text-align:right; width:120px; padding-right:10px;">จำนวนที่นั่ง</th>
            <th style="text-align:left; width:145px; padding-left:15px;">หมายเหตุ</th>
        </tr>
        <?php
        $sql_date = "SELECT DISTINCT date(reserv_date_reservation) FROM reservations AS res 
            WHERE (date(res.reserv_date_reservation) >= date('" . tochristyear($_POST['startdate']) . "') 
            AND date(res.reserv_date_reservation) <= date('" . tochristyear($_POST['enddate']) . "'))";
        $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));
        $type_a = $type_0 = $type_1 = $type_2 = 0;

        if (mysqli_num_rows($query_date) == 0) {
            echo "<script>alert('ไม่พบข้อมูลที่ท่านค้นหา'); window.close();</script>";
            exit();
        }
        while ($result_date = mysqli_fetch_array($query_date)) {
            $per_day = 0;
            echo "
               <tr height='25px'>
               <td align='center'>
                " . short_datetime_thai($result_date['date(reserv_date_reservation)']) . "
               </td>
               </tr>";

            $sql_reserve = "SELECT * FROM reservations AS res 
               LEFT JOIN customers AS cus ON res.cusid = cus.cusid
               WHERE date(reserv_date_reservation) = '" . $result_date['date(reserv_date_reservation)'] . "'";
            $query_reserve = mysqli_query($link, $sql_reserve) or die(mysqli_error($link));

            while ($result_reserve = mysqli_fetch_array($query_reserve)) {
                $per_day++;
                $type_a++;
                switch ($result_reserve['reserv_status']) {
                    case 0:
                        $reserv_status = "<span style='color:#0072EE'>รอการตรวจสอบ</span>";
                        $type_0++;
                        break;
                    case 1:
                        $reserv_status = "<span style='color:#12BB4F';>ยืนยันการจอง</span>";
                        $type_1++;
                        break;
                    case 2:
                        $reserv_status = "<span style='color:red;'>ยกเลิกการจอง</span>";
                        $type_2++;
                        break;
                    default:
                        $reserv_status = "-";
                }
        ?>
                <tr height="20px">
                    <td></td>
                    <td align="center"><?= $result_reserve['reserv_id'] ?></td>
                    <td align="left"><?= $result_reserve['cus_name'] ?></td>
                    <td align="left"><?= $result_reserve['cus_tel'] ?></td>
                    <td align="center"><?= short_datetime_thai($result_reserve['reserv_date_appointment']) ?></td>
                    <td align="center"><?= substr($result_reserve['reserv_time_appointment'], 0, 5) ?></td>
                    <td align="left"><?= $reserv_status ?></td>



                    <?php
                    $sql_tables = "SELECT tables_no, reservlist_amount, reservlist_note FROM reservelist
                    WHERE reserv_id = '" . $result_reserve['reserv_id'] . "'";
                    $query_tables = mysqli_query($link, $sql_tables) or die(mysqli_error($link));

                    $row_tables = 1;
                    while ($result_tables = mysqli_fetch_array($query_tables)) {
                        if ($row_tables > 1) {
                            echo "</tr><tr> <td colspan='7'></td>";
                        }
                    ?>
                        <td style="height:25px;" align="right"><?= $result_tables['tables_no'] ?></td>
                        <td align="right" style="padding-right:10px;"><?= $result_tables['reservlist_amount'] ?></td>
                        <td style="padding-left:15px;" align="left"><?= ($result_tables['reservlist_note'] != "") ? $result_tables['reservlist_note'] : "<span style='padding-left:5px;'>-</span>" ?></td>
                </tr>
        <?php
                        $row_tables++;
                    }
                } ?>
        <tr style="border-bottom:1px solid;">
            <td colspan="6"></td>
            <td align="right"><b>รวม</b></td>
            <td align="right"><b><?= $per_day ?></b></td>
            <td colspan="2" style="height:26px; padding-left:15px;"><b>รายการ</b></td>
        </tr>
    <?php
        }
    ?>
    <tr>
        <td colspan="6"></td>
        <td align="right"><b>รวมทั้งหมด</b></td>
        <td align="right"><b><?= $type_a ?></b></td>
        <td colspan="2" style="height:26px; padding-left:15px;"><b>รายการ</b></td>
    </tr>
    <tr style="color:#0072EE;">
        <td colspan="5"></td>
        <td align="" style="padding-left:5px;" colspan="2"><b>รวมรอการตรวจสอบทั้งหมด</b></td>
        <td align="right"><b><?= $type_0 ?></b></td>
        <td colspan="2" style="height:26px; padding-left:15px;"><b>รายการ</b></td>
    </tr>
    <tr style="color:#12BB4F;">
        <td colspan="5"></td>
        <td colspan="2" align="" style="padding-left:5px;"><b>รวมยืนยันการจองทั้งหมด</b></td>
        <td align="right"><b><?= $type_1 ?></b></td>
        <td colspan="2" style="height:26px; padding-left:15px;"><b>รายการ</b></td>
    </tr>
    <tr style="border-bottom:1px solid;">
        <td colspan="5"></td>
        <td align="" colspan="2" style="color:red; padding-left:5px;"><b>รวมยกเลิกการจองทั้งหมด</b></td>
        <td align="right" style="color:red;"><b><?= $type_2 ?></b></td>
        <td colspan="2" style="color:red; height:26px; padding-left:15px;"><b>รายการ</b></td>
    </tr>
    </table>
    <br>
</body>