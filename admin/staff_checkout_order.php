<head>
    <title>บันทึกการสั่งอาหาร | Food Order System</title>
    <?php
    if (!isset($_SESSION)) {  // Check if sessio nalready start
        session_start();
    }
    include("conf/header_admin.php");
    ?>

    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php
    if (!isset($_SESSION['food_admin']['list']['foodid'])) {
        echo "<script>alert('กรุณาเลือกสินค้าที่ต้องการสั่ง'); window.location.assign('staff_cart_order.php');</script>";
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

    $today = date("Y-m-d"); // ตรวจสอบไม่แสดง Reservations ที่ผ่านมาแล้ว
    $sql_resrvations = "SELECT * FROM reservations WHERE cusid = '{$_GET['cusid']}' AND reserv_date_appointment >= '" . $today . "' AND reserv_status = 1 ORDER BY reserv_id DESC";
    $q_reservations = mysqli_query($link, $sql_resrvations);

    $sql_table = "SELECT * FROM tables WHERE tables_status_use = 0";
    $q_table = mysqli_query($link, $sql_table);
    ?>
    <div class="container" style="padding-top: 135px;">
        <div class="col">
            <h1 class="page-header text-center">บันทึกการสั่งอาหาร</h1>
            <div class="container" style="width:970px">
                <div class="panel panel-default" align="center" style="background-color:#FBFBFB;">
                    <p>
                        <form id="checkout_order" class="form" name="checkout_order" method="POST" action="save_checkout_order.php">
                            <table width="750px" border="0" align="center">
                                <tr>
                                    <td align="center" height="25px" colspan="4"><a href="select_customer.php?ref=order"><u>เลือกลูกค้า</u></a></td>
                                </tr>
                                <tr>
                                    <td width="20%" height="36px"><b>ประเภทการสั่ง :<span style="color:red;">*</span></b></td>
                                    <td width="30%">
                                        <select name="order_type" id="order_type" class="form-control" style="width:80%; height:33px;" required>
                                            <option value="" selected disabled>- กรุณาเลือกประเภทการสั่ง -</option>
                                            <option value="0">กลับบ้าน</option>
                                            <option value="1">ทานที่ร้าน</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="34px" height="36px"><b>รหัสลูกค้า :</b></td>
                                    <td width="30%">
                                        <?php echo $cus_data['cusid'] ?>
                                        <input type="text" hidden name="cusid" id="cusid" value="<?= $cus_data['cusid'] ?>">
                                    </td>
                                    <td width="20%" height="36px"><b>ชื่อ-นามสกุล :</b></td>
                                    <td><?php echo $cus_data['cus_name']; ?></td>
                                </tr>
                                <tr>
                                    <td height="40px" width="15%"><b>วันที่สั่ง :</b></td>
                                    <td width="35%">
                                        <input class="form-control" style="height:32px; width:210px" id="orderdate" type="datetime-local" name="orderdate" value="<?= dt_tothaiyear2(date('Y-m-d H:i')); ?>" readonly>
                                    </td>
                                    <td width="16%" height="40px"><b>เบอร์โทรศัพท์ :</b></td>
                                    <td><?php echo $cus_data['cus_tel'] ?></td>
                                </tr>
                                <tr class="order_type0">
                                    <td width="15%" height="32px"><b>วันที่กำหนดส่ง :<span style="color:red;">*</span></b></td>
                                    <td width="35%">
                                        <input class="form-control datepicker-checkout " autocomplete="off" style="height:32px; width:215px" id="deliverydate" onchange="validate_delverytime();" onfocus="$(this).blur();" onkeypress="return false;" onpaste="return false" type="text" name="deliverydate">
                                    </td>
                                    <td width="15%" height="32px"><b>เวลากำหนดส่ง :<span style="color:red;">*</span></b></td>
                                    <td><input class="form-control" autocomplete="off" type="time" min="09:00" max="19:00" oninvalid="this.setCustomValidity('กรุณากรอกเวลาระหว่าง 09:00-19.00')" oninput="this.setCustomValidity('')" style="height:32px; width:180px" id="deliverytime" name="deliverytime"></td>
                                </tr>
                                <tr class="order_type0">
                                    <td colspan="4" align="right" style="vertical-align: top; ">
                                        <font color="red" style="font-size: 13px; padding-right:0px;">กำหนดส่งภายในเวลา 09:00 - 19:00 </font>
                                    </td>
                                </tr>
                                <tr class="order_type1">
                                    <td height="30px" width="30%"><b>รหัสการจอง :</b></td>
                                    <td>
                                        <select class="form-control" name="reserv_id" style="width:220px;" onchange="chq_order_get_reserv($(this).val())">
                                            <option selected disabled value="">- กรุณาเลือกรหัสการจอง -</option>
                                            <?php
                                            while ($reserv_data = mysqli_fetch_array($q_reservations)) { ?>
                                                <option value="<?= $reserv_data['reserv_id'] ?>"><?= $reserv_data['reserv_id'] ?> | วันที่จอง <?= substr(dt_tothaiyear($reserv_data['reserv_date_reservation']), 0, 10) ?></option>
                                            <?php     }
                                            ?>
                                        </select>
                                    </td>
                                    <td height="30px" width="15%"><b>หมายเลขโต๊ะ :<span style="color:red;">*</span></b></td>

                                    <td>
                                        <select class="form-control" name="tables_no" id="tables_no" style="width:220px;">
                                            <option selected disabled value="">- กรุณาเลือกหมายเลขโต๊ะ -</option>
                                            <?php
                                            while ($result_table = mysqli_fetch_array($q_table)) { ?>
                                                <option value="<?= $result_table['tables_no'] ?>">หมายเลขโต๊ะ <?= $result_table['tables_no'] ?> | <?= $result_table['tables_seats'] ?> ที่นั่ง</option>

                                            <?php
                                            }
                                            ?>
                                        </select></td>
                                </tr>
                                <tr class="order_type1">
                                    <td height="42px" width="15%"><b>วันที่นัด :</b></td>
                                    <td><input type="text" id="reserv_date_appointment" name="reserv_date_appointment" class="form-control" style="height:32px; width:215px" readonly></td>
                                    <td height="42px" width="15%"><b>เวลานัด :</b></td>
                                    <td><input type="text" id="reserv_time_appointment" name="reserv_time_appointment" class="form-control" style="height:32px; width:180px" readonly></td>
                                </tr>
                                <tr class="order_type0">
                                    <td width="20%" height="32px"><b>สถานที่จัดส่ง :<span style="color:red;">*</span></b></td>
                                    <td height="70px"><textarea name="deliveryplace" style="width:230px;" id="deliveryplace" cols="15" rows="3" class="form-control"><?= $cus_data['cus_address'] ?></textarea></td>
                                    <td height="42px" width="15%"><b>รหัสไปรษณีย์ :<span style="color:red;">*</span></b></td>
                                    <td><input class="form-control" height="32px" value="<?= $cus_data['cus_postnum'] ?>" id="postnum" name="postnum" required></td>
                                </tr>
                                <tr class="order_type0">
                                    <td colspan="2" align="center" style="padding-left:120px; margin-top:0px; vertical-align: top; ">
                                        <font color="red" style="font-size: 13px;">สถานที่ส่งจะต้องอยู่ในบริเวณ ม.กรุงเทพ เท่านั้น
                                            <br>ในระยะทางไม่เกิน 3 กี่โลเมตร</font>
                                    </td>
                                </tr>
                            </table>
                </div>
                <h3 class="page-header text-center">รายการอาหาร</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <th style="width:150px; text-align:right;">รหัสรายการอาหาร</th>
                        <th style="width:160px;">ชื่ออาหาร</th>
                        <th style="width:100px;">หน่วยนับ</th>
                        <th style="text-align:right; width:110px;">ราคา (บาท)</th>
                        <th style="text-align:right; width:70px;">จำนวน</th>
                        <th style="width:130px; text-align:right">ราคารวม (บาท)</th>
                        <th>หมายเหตุ</th>
                    </thead>
                    <?php
                    $count_product = count($_SESSION['food_admin']['list']['foodid']);
                    for ($i = 0; $i < $count_product; $i++) {
                        $sql_sum        =    "SELECT * FROM foods WHERE foodid = '" . $_SESSION['food_admin']['list']['foodid'][$i] . "' ";
                        $data_sum        =    mysqli_query($link, $sql_sum);
                        $value            =    mysqli_fetch_assoc($data_sum);
                        $sum_price[]     =     $_SESSION['food_admin']['list']['food_price'][$i] * $_SESSION['food_admin']['list']['amount'][$i];
                        $product_id[]     =     $value['foodid'];

                    ?>
                        <td class="text-right"><?php echo $value['foodid']; ?></td>
                        <td><?php echo $value['food_name']; ?></td>
                        <td><?= $value['food_count'] ?></td>
                        <td align="right"><?php echo $value['food_price']; ?></td>
                        <td class="text-right">
                            <?= $_SESSION['food_admin']['list']['amount'][$i] ?>
                            <input type="text" name="id[]" value="<?= $value['foodid'] ?>" hidden>
                        </td>
                        <td class="text-right price-order-<?= $i ?>" data-value="<?= $_SESSION['food_admin']['list']['food_price'][$i] ?>" id="price-<?= $value['foodid']  ?>"><?= number_format($_SESSION['food_admin']['list']['food_price'][$i] * $_SESSION['food_admin']['list']['amount'][$i], 2) ?></td>
                        <td class="col-md-2"><textarea class="form-control" name="order_note_<?= $value['foodid'] ?>"></textarea></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan="5" class="text-right"><b>ราคารวมทั้งหมด</b></td>
                        <td class="text-right"><b><?= number_format(array_sum($sum_price), 2); ?></b></td>
                        <input type="text" name="totalprice" id="totalprice" value="<?= array_sum($sum_price); ?>" hidden />
                        <td></td>
                    </tr>
            </div>
            </table>
            <div class="row" style="padding-bottom: 20px;">
                <div class="col-md-offset-3 col-md-6" style="text-align: center;">
                    <input type="submit" name="submit" id="submit_order" onclick="if(confirm('ยืนยันรายการสั่งอาหาร?')) { if (check_place()) return true; else return false; } else return false;" class="btn btn-success" value="บันทึก" />
                    <button type="reset" class="btn btn-danger">ล้างค่า</button></form>
                    <button type="back" class="btn btn-info" onclick="window.location.assign('select_customer.php?ref=order');">ย้อนกลับ</button>
                </div>
            </div>
        </div>
    </div>
    <?php // include("conf/footer.php"); 
    ?>
</body>