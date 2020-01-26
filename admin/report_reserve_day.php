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
    <title>รายงานการจองประจำวัน ตั้งแต่วันที่ <?= $_POST['startdate']; ?> ถึงวันที่ <?= $_POST['enddate'];  ?> | Food Order System</title>
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
            <th style="text-align:right; width:120px;">จำนวนที่นั่ง</th>
            <th style="text-align:left; width:145px; padding-left:15px;">หมายเหตุ</th>
        </tr>
        <?php
        $sql_date = "SELECT DISTINCT date(reserv_date_reservation) FROM reservations AS res 
            WHERE (date(res.reserv_date_reservation) >= date('" . tochristyear($_POST['startdate']) . "') 
            AND date(res.reserv_date_reservation) <= date('" . tochristyear($_POST['enddate']) . "'))";
        $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));


        if (mysqli_num_rows($query_date) == 0) {
            echo "<script>alert('ไม่พบข้อมูลที่ท่านค้นหา'); window.close();</script>";
            exit();
        }
        while ($result_date = mysqli_fetch_array($query_date)) {
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
        ?>
                <tr height="20px">
                    <td></td>
                    <td align="center"><?= $result_reserve['reserv_id'] ?></td>
                    <td align="left"><?= $result_reserve['cus_name'] ?></td>
                    <td align="left"><?= $result_reserve['cus_tel'] ?></td>
                    <td align="center"><?= short_datetime_thai($result_reserve['reserv_date_appointment']) ?></td>
                    <td align="center"><?=  substr($result_reserve['reserv_time_appointment'],0,5) ?></td>
                    <td align="left"></td>
                    <td style="padding-left:15px;" align="left"><?= ($result_reserve['reserv_note'] != "") ? "" : "-" ?></td>
                </tr>
        <?php
            }
        } ?>