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
    <table border="1" width="1500px" align="center">
        <tr>
            <td colspan="13" align="right" style="border-bottom:1px solid;">
                วันที่พิมพ์ <?= fulldate_thai(date("d-m-Y")); ?>
            </td>
        </tr>
        <tr style="border-bottom:1px solid; height:30px; ">
            <th style="text-align:center; width:120px;">วันที่ส่ง</th>
            <th style="text-align:center; width:110px;">เวลาส่ง</th>
            <th style="text-align:center; width:170px;">วัน/เวลากำหนดส่ง</th>
            <th style="text-align:left; width:130px;">วันที่สั่งอาหาร</th>
            <th style="text-align:center; width:130px;">เลขที่ใบเสร็จ</th>
            <th style="text-align:center; width:120px;">รหัสการสั่ง</th>
            <th style="text-align:left; width:150px;">สถานะการชำระ</th>
            <th style="text-align:left; width:170px;">ชื่อลูกค้า</th>
            <th style="text-align:right; width:115px; padding-right:10px;">ราคารวม(บาท)</th>
            <th style="text-align:left; width:160px;">ชื่ออาหาร</th>
            <th style="text-align:right; width:100px;">จำนวน</th>
            <th style="text-align:right; width:130px;">ราคาต่อหน่วย(บาท)</th>
            <th style="text-align:right; width:120px;">ราคา(บาท)</th>
        </tr>
        <?php
        $sql_date = "SELECT DISTINCT date(order_date_delivered) FROM orders 
            WHERE (date(orders.order_date_delivered) >= date('" . tochristyear($_POST['startdate']) . "') 
            AND date(orders.order_date_delivered) <= date('" . tochristyear($_POST['enddate']) . "'))";
        $query_date = mysqli_query($link, $sql_date) or die(mysqli_error($link));


        if (mysqli_num_rows($query_date) == 0) {
            echo "<script>alert('ไม่พบข้อมูลที่ท่านค้นหา'); window.close();</script>";
            exit();
        }

        while ($result_date = mysqli_fetch_array($query_date)) {
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
        
        
            }
