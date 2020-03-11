<head>
    <title>บันทึกการจอง | Food Order System</title>
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

    if (!isset($_SESSION['food_admin']['reserve']['tables_no'])) {
        echo "<script>alert('กรุณาเลือกโต๊ะที่ต้องการจอง'); window.location.assign('staff_cart_reserve.php');</script>";
        exit();
    }

    if (!isset($_GET['cusid'])) {
        echo "<script>window.location.assign('select_customer.php?ref=reserve');</script>";
        exit();
    }

    include("../conf/connection.php");
    include_once("../conf/function.php");

    $sql_cusdata    = "SELECT * FROM customers WHERE cusid = '{$_GET['cusid']}'";
    $q = mysqli_query($link, $sql_cusdata);
    $cus_data = mysqli_fetch_assoc($q);
    ?>
    <div class="container" style="padding-top: 135px; min-height:690px">
        <div class="col">
            <h1 class="page-header text-center">บันทึกการจอง</h1>
            <div class="container" style="width:850px">
                <div class="panel panel-default" align="center" style="background-color:#FBFBFB;">
                    <p>
                        <form id="checkout_order" class="form" name="checkout_order" method="POST" action="save_checkout_reserve.php">
                            <table width="750px" border="0" align="center">
                                <tr>
                                    <td align="center" height="36px" colspan="4"><a href="select_customer.php?ref=reserve"><u>เลือกลูกค้า</u></a></td>
                                </tr>
                                <tr>
                                    <td width="34px" height="36px"><b>รหัสลูกค้า :</b></td>
                                    <td width="30%">
                                        <?= $cus_data['cusid']; ?>
                                        <input type="text" hidden name="cusid" id="cusid" value="<?= $_GET['cusid'] ?>">
                                    </td>
                                    <td width="20%" height="36px"><b>ชื่อ-นามสกุล :</b></td>
                                    <td><?php echo $cus_data['cus_name']; ?></td>
                                </tr>
                                <tr>
                                    <td height="40px" width="15%"><b>วัน/เวลาจอง :</b></td>
                                    <td width="35%">
                                        <input class="form-control" style="height:32px; width:210px" id="reserv_date_reservation" type="datetime-local" name="reserv_date_reservation" value="<?= dt_tothaiyear2(date('Y-m-d H:i')); ?>" readonly>
                                    </td>
                                    <td width="16%" height="40px"><b>เบอร์โทรศัพท์ :</b></td>
                                    <td><?php echo $cus_data['cus_tel'] ?></td>
                                </tr>
                                <tr>
                                    <td width="15%" height="32px"><b>วันที่นัด :<span style="color:red;">*</span></b></td>
                                    <td width="35%">
                                        <input class="form-control datepicker-checkout" autocomplete="off" style="height:32px; width:215px" onchange="validate_reservetime();" onfocus="$(this).blur();" id="reserv_date_appointment" onkeypress="return false" onpaste="return false" type="text" name="reserv_date_appointment" required>
                                    </td>
                                    <td width="15%" height="32px"><b>เวลาที่นัด :<span style="color:red;">*</span></b></td>
                                    <td><input class="form-control" type="time" min="09:00" max="19:00" required oninvalid="this.setCustomValidity('กรุณากรอกเวลาระหว่าง 09:00-19.00')" oninput="this.setCustomValidity('')" style="height:32px; width:180px" id="reserv_time_appointment" name="reserv_time_appointment" required></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="1" align="center">
                                        <font color="red" style="padding-right:70px; font-size: 13px;">จองนัดล่วงหน้า ไม่เกิน 5 วัน</font>
                                    </td>
                                    <td colspan="2" style="text-align:right">
                                        <font color="red" style="padding-right: 35px; font-size: 13px; ">กำหนดจองภายในเวลา 08:00 - 18:00 </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center">
                                        <hr style="border-top: 0.1px solid #b8b8b8; margin: 10px; padding-bottom:0px;">
                                        <font color="red" style="font-size: 16px;">** ไม่สามารถเปลี่ยนแปลงได้ภายหลัง หากต้องการเปลี่ยนแปลง กรุณาติดต่อพนักงาน **</font>
                                    </td>
                                </tr>
                            </table>
                </div>
                <h3 class="page-header text-center">รายการจอง</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <th style="text-align:right; width:250px;">หมายเลขโต๊ะ</th>
                        <th style="text-align:right; width:250px;">จำนวนที่นั่ง (คน)</th>
                        <th style="text-align:center;">หมายเหตุ</th>

                    </thead>
                    <?php
                    $count_product = count($_SESSION['food_admin']['reserve']['tables_no']);
                    for ($i = 0; $i < $count_product; $i++) {
                        $sql_sum        =    "SELECT * FROM tables WHERE tables_no = '" . $_SESSION['food_admin']['reserve']['tables_no'][$i] . "' ";
                        $data_sum        =    mysqli_query($link, $sql_sum);
                        $value            =    mysqli_fetch_assoc($data_sum);
                        $sum_seats      = array_sum($_SESSION['food_admin']['reserve']['seats']);
                        //		$product_id[] 	= 	$value['tables_no'];

                    ?>
                        <td align="right"><?php echo $value['tables_no']; ?></td>
                        <td align="right"><?php echo $value['tables_seats']; ?></td>
                        <td><textarea name="reservlist_note_<?= $i ?>" class="form-control" rows="3" cols="30"></textarea> </td>

                        </tr>
                    <?php }    ?>
                    <tr>
                        <td colspan="1" class="text-right"><b>รวมทั้งหมด</b></td>
                        <td class="text-right"><b><?= number_format($sum_seats, 0); ?></b></td>
                        <td><b>ที่นั่ง</b></td>
                    </tr>
            </div>
            </table>
            <div class="row" style="padding-bottom:3%">
                <label class="control-label col-md-2 col-md-offset-2 text-right">หมายเหตุ : </label>
                <div class="col-md-4">
                    <textarea name="reserve_note" class="form-control" rows="4" cols="30"></textarea>
                </div>
            </div>
            <div class="col-md-offset-3 col-md-6" style="text-align: center; padding-bottom:20px;">
                <input type="submit" name="submit" id="submit" onclick="if(confirm('ยืนยันรายการจอง?')) return true; else return false;" class="btn btn-success" value="บันทึก" />
                <button type="reset" class="btn btn-danger">ล้างค่า</button></form>
                <button type="back" class="btn btn-info" onclick="window.location.assign('select_customer.php?ref=reserve');">ย้อนกลับ</button>
            </div>
        </div>
    </div>
    <?php //include("conf/footer.php"); 
    ?>
</body>