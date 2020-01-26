<?php

if (!isset($_GET['rid'])) {
    echo "<script>window.location.assign('reserve_history.php')</script>";
    exit();
}
?>

<head>
    <title>รายละเอียดการจอง | Food Order System</title>
    <?php
    if (!isset($_SESSION)) {  // Check if sessio nalready start
        session_start();
    }

    ?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php

    include("conf/header_admin.php");
    include("../conf/connection.php");
    include_once("../conf/function.php");

    $sql_reservedata  = "SELECT * FROM reservations WHERE reserv_id = '{$_GET['rid']}'";
    $query_reserve = mysqli_query($link, $sql_reservedata);
    $reserve_data = mysqli_fetch_assoc($query_reserve);

    $sql_cusdata    = "SELECT * FROM customers WHERE cusid = '{$reserve_data['cusid']}'";
    $query_customer = mysqli_query($link, $sql_cusdata);
    $cus_data = mysqli_fetch_assoc($query_customer);

    if ($reserve_data['reserv_status'] == 0) {
        $reserve_status = "<font color='#0072EE'>รอการตรวจสอบ</font>";
    } elseif ($reserve_data['reserv_status'] == 1) {
        $reserve_status = "<font color='#12BB4F'>ยืนยันการจอง</font>";
    } elseif ($reserve_data['reserv_status'] == 2) {
        $reserve_status = "<font color='red'>ยกเลิกการจอง</font>";
    }

    ?>
    <div class="container" style="padding-top: 135px;">
        <div class="col">
            <h1 class="page-header text-center">รายละเอียดการจอง</h1>
            <div class="container" style="width:850px">
                <div class="panel panel-default" align="center" style="background-color:#FBFBFB;">
                    <p>
                        <table width="750px" border="0" align="center">
                            <tr>
                                <td height="13px"></td>
                            </tr>
                            <tr style="padding-top:15px">
                                <td width="" height="36px"><b>รหัสการจอง :</b></td>
                                <td width="25%"><?php echo $_GET['rid'] ?></td>
                                <td width="20%"><b>สถานะ :</b></td>
                                <td width="20%"><?= $reserve_status ?>
                            </tr>
                            <tr>
                                <td width="" height="36px"><b>รหัสลูกค้า :</b></td>
                                <td width="25%"><?php echo $cus_data['cusid'] ?></td>
                                <td width="20%" height="36px"><b>ชื่อ-นามสกุล :</b></td>
                                <td><?php echo $cus_data['cus_name']; ?></td>
                            </tr>
                            <tr>
                                <td height="40px" width="15%"><b>วัน/เวลาจอง :</b></td>
                                <td width="25%">
                                    <?= dt_tothaiyear($reserve_data['reserv_date_reservation']); ?>
                                </td>
                                <td width="16%" height="40px"><b>เบอร์โทรศัพท์ :</b></td>
                                <td><?php echo $cus_data['cus_tel'] ?></td>
                            </tr>
                            <tr>
                                <td width="15%" height="32px"><b>วันที่นัด :</b></td>
                                <td width="25%">
                                    <?= tothaiyear($reserve_data['reserv_date_appointment']) ?>
                                </td>
                                <td width="15%" height="32px"><b>เวลานัด :</b></td>
                                <td>
                                    <?= substr($reserve_data['reserv_time_appointment'], 0, 5) ?>
                                </td>
                            </tr>
                        </table>
                </div>
                <h3 class="page-header text-center">รายการจอง</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <th style="text-align:right; width:250px;">หมายเลขโต๊ะ</th>
                        <th style="text-align:right; width:250px;">จำนวนที่นั่ง</th>
                        <th style="text-align:center;">หมายเหตุ</th>
                    </thead>

                    <?php
                    $reservelist_sql = "SELECT * FROM reservelist WHERE reserv_id = '" . $_GET['rid'] . "'";
                    $reservelist_query = mysqli_query($link, $reservelist_sql);
                    $sum_seats = 0;

                    while ($reservelist_data = mysqli_fetch_array($reservelist_query)) {
                        $sum_seats += $reservelist_data['reservlist_amount'];
                        ?>
                        <td align="right"><?php echo $reservelist_data['tables_no'] ?></td>
                        <td align="right"><?php echo $reservelist_data['reservlist_amount']; ?></td>
                        <td height="80px"><?php
                                                if ($reservelist_data['reservlist_note'] == "") {
                                                    echo "<center>-</center>";
                                                } else {
                                                    echo $reservelist_data['reservlist_note'];
                                                } ?></td>

                        </tr>
                    <?php }   ?>
                    <tr>
                        <td class="text-right"><b>รวมทั้งหมด</b></td>
                        <td colspan="1" class="text-right"><b><?= $sum_seats ?></b></td>
                        <td><b>ที่นั่ง</b></td>
                    </tr>
            </div>
            </table>
            <div class="col-md-offset-2 col-md-3" style="text-align: center;">
                <label>หมายเหตุ :</label>
            </div>
            <div class="col-md-4">
                <?php
                if ($reserve_data['reserv_note'] == "") {
                    echo "-";
                } else {
                    echo $reserve_data['reserv_note'];
                }
                ?>
            </div>
            <br><br><br>
            <div class="col-md-offset-3 col-md-6" style="text-align: center;">
                <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
            </div>
        </div>
    </div>
    <br>
    </div>
    <?php // include("conf/footer.php"); 
    ?>
</body>