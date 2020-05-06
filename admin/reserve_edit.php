<head>
    <title>ปรับปรุงการจอง | Food Order System</title>
    <?php

    if (!isset($_GET['rid'])) {
        echo "<script>window.location.assign('reserve_history.php')</script>";
        exit();
    }

    if (!isset($_SESSION)) {  // Check if sessio nalready start
        session_start();
    }

    include('conf/header_admin.php');
    ?>

    <script>
        $(document).ready(function() {
            $("#edit_reserve").validate({
                // Specify validation rules
                messages: {
                    reserv_date_appointment: {
                        required: "<font size='2' style='padding-left:35px;' color='red'>กรุณาเลือกวันที่นัด</font>",
                    },
                    reserv_time_appointment: {
                        required: "<font size='2' style='padding-left:15px;' color='red'>กรุณาเลือกเวลานัด</font>",
                        min: "<font size='2' style='padding-left:15px;' color='red'>กรุณาระบุในเวลาที่กำหนด</font>",
                        max: "<font size='2' style='padding-left:15px;' color='red'>กรุณาระบุในเวลาที่กำหนด</font>",
                    },
                },
                onfocusout: function(element) {
                    // "eager" validation
                    this.element(element);
                },
            });
        });
    </script>
</head>

<body>
    <?php

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
        echo "<script>window.location.assign('staff_reserve_history.php');</script>";
        exit();
    }

    ?>
    <div class="container" style="padding-top: 135px;">
        <div class="col">
            <h1 class="page-header text-center">ปรับปรุงการจอง</h1>
            <div class="container" style="width:850px">
                <div class="panel panel-default" align="center" style="background-color:#FBFBFB;">
                    <p>
                        <form id="edit_reserve" class="form" name="checkout_order" method="POST" action="save_edit_reserve.php">
                            <table width="750px" border="0" align="center">
                                <tr>

                                </tr>
                                <tr style="padding-top:15px">
                                    <td width="" height="36px"><b>รหัสการจอง :</b></td>
                                    <td width="25%"><?php echo $_GET['rid'] ?></td>
                                    <input type="text" hidden name="reserv_id" id="reserv_id" value="<?= $_GET['rid'] ?>">
                                    <td width="20%"><b>สถานะ:</b></td>
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
                                    <?php // ตรวจสอบเวลาการจองว่ายังสามารถปรับปรุงได้ไหม
                                    $time = date("Y-m-d H:i");
                                    $reserve_time = date("Y-m-d H:i", strtotime($reserve_data['reserv_date_reservation']) + 60 * 60);
                                    if ($time > $reserve_time) {
                                        //   echo $time . " > " . $reserve_time;
                                        $editable = "disabled";
                                    } else {
                                        // echo $time . " < " . $reserve_time;;
                                        $editable = "";
                                    }
                                    ?>
                                    <td width="15%" height="32px"><b>วันที่นัด :<span style="color:red;">*</span></b></td>
                                    <td width="25%">
                                        <input class="form-control datepicker-checkout" <?= $editable ?> autocomplete="off" style="height:32px; width:215px; margin-left:-5%;" onchange="validate_reservetime();" onfocus="$(this).blur();" id="reserv_date_appointment" onkeypress="return false" onpaste="return false" type="text" name="reserv_date_appointment" required value="<?= tothaiyear($reserve_data['reserv_date_appointment']) ?>">
                                    </td>
                                    <td width="15%" height="32px"><b>เวลานัด :<span style="color:red;">*</span></b></td>
                                    <td>
                                        <input class="form-control" type="time" min="09:00" max="19:00" <?= $editable ?> required oninvalid="this.setCustomValidity('กรุณากรอกเวลาระหว่าง 09:00-19.00')" oninput="this.setCustomValidity('')" style="height:32px; width:180px; margin-left:-5%;" id="reserv_time_appointment" name="reserv_time_appointment" required value="<?= substr($reserve_data['reserv_time_appointment'], 0, 5) ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center" height="20px">
                                        <font color="097DB6">** สามารถปรับปรุง วัน/เวลานัดหลังจากทำการจอง ภายใน 1 ชั่วโมงเท่านั้น **</font>
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
                    $sum_seats = $i = 0;

                    while ($reservelist_data = mysqli_fetch_array($reservelist_query)) {
                        $sum_seats += $reservelist_data['reservlist_amount'];
                    ?>
                        <td align="right"><?php echo $reservelist_data['tables_no'] ?></td>
                        <td align="right"><?php echo $reservelist_data['reservlist_amount']; ?></td>
                        <td><textarea name="reservlist_note_<?= $i ?>" <?= $editable ?> class="form-control" rows="3" cols="30"><?= $reservelist_data['reservlist_note'] ?></textarea></td>
                        </tr>
                    <?php
                        $i++;
                    }   ?>
                    <tr>
                        <td class="text-right"><b>รวมทั้งหมด</b></td>
                        <td colspan="1" class="text-right"><b><?= $sum_seats ?></b></td>
                        <td><b>ที่นั่ง</b></td>
                    </tr>
            </div>
            </table>
            <div class="row">
                <div class="col-md-offset-2 col-md-3" style="text-align: center;">
                    <label>หมายเหตุ :</label>
                </div>
                <div class="col-md-4">
                    <textarea name="reserve_note" class="form-control" rows="4" cols="30"><?= $reserve_data['reserv_note'] ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 col-md-offset-3" style="text-align: center; padding-top:20px;">
                    <input type="submit" <?= $editable ?> name="submit" id="submit" onclick="if(confirm('ยืนยันการปรับปรุงการจอง?')) return true; else return false;" class="btn btn-success" value="บันทึก" />
                    <button type="reset" class="btn btn-danger">คืนค่า</button>
                    <button type="submit" name="confirms" onclick="if(confirm('ต้องการยืนยันการจอง?')) return true; else return false;" class="btn btn-primary">ยืนยันการจอง</button>
                    <button type="submit" name="cancel" onclick="if(confirm('ต้องการยกเลิการจอง?')) return true; else return false;" class="btn btn-warning">ยกเลิกการจอง</button></form>
                    <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>

                </div>
            </div>
        </div> <br>
    </div>
    <?php // include("conf/footer.php"); 
    ?>
</body>