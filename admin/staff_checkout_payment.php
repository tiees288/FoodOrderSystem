<head>
    <title>บันทึกรับชำระ | Food Order System</title>
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

    if (!isset($_SESSION['food_admin']['payment']['orderid'])) {
        echo "<script>alert('กรุณาเลือก รหัสการสั่งที่ต้องการรับชำะ'); window.location.assign('staff_cart_payment.php');</script>";
        exit();
    }

  /*  if (!isset($_GET['cusid'])) {
        echo "<script>window.location.assign('select_customer.php?ref=reserve');</script>";
        exit();
    } */

    include("../conf/connection.php");
    include_once("../conf/function.php");

    $sql_cusdata    = "SELECT customers.cusid, customers.cus_tel, customers.cus_name FROM orders LEFT JOIN customers ON orders.cusid = customers.cusid WHERE orders.orderid = '". $_SESSION['food_admin']['payment']['orderid']['0'] ."'";
    $q = mysqli_query($link, $sql_cusdata);
    $cus_data = mysqli_fetch_assoc($q);
    ?>
    <div class="container" style="padding-top: 135px; min-height:690px">
        <div class="col">
            <h1 class="page-header text-center">บันทึกรับชำระ</h1>
            <div class="container" style="width:850px">
                <div class="panel panel-default" align="center" style="background-color:#FBFBFB;">
                    <p>
                        <form id="checkout_order" class="form" name="checkout_order" method="POST" action="save_checkout_payment.php">
                            <table width="750px" border="0" align="center">
                                <!--<tr>
                                    <td align="center" height="36px" colspan="4"><a href="select_customer.php?ref=payment">เลือกลูกค้า</a></td>
                                </tr> -->
                                <tr>
                                    <td width="34px" height="36px"><b>รหัสลูกค้า :</b></td>
                                    <td width="30%">
                                        <?= $cus_data['cusid']; ?>
                                       <!-- <input type="text" hidden name="cusid" id="cusid" value="<?php // $cus_data['cusid'] ?>"> -->
                                    </td>
                                    <td width="20%" height="36px"><b>ชื่อ-นามสกุล :</b></td>
                                    <td><?php echo $cus_data['cus_name']; ?></td>
                                </tr>
                                <tr>
                                    <td height="40px" width="15%"><b>วันที่รับชำระ :</b></td>
                                    <td width="35%">
                                        <input class="form-control" style="height:32px; width:210px" id="pay_date" type="datetime-local" name="pay_date" value="<?= dt_tothaiyear2(date('Y-m-d H:i')); ?>" readonly>
                                    </td>
                                    <td width="16%" height="40px"><b>เบอร์โทรศัพท์ :</b></td>
                                    <td><?php echo $cus_data['cus_tel'] ?></td>
                                </tr>
                            </table>
                </div>
                <h3 class="page-header text-center">รายการสั่งอาหาร</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <th style="text-align:center; width:20%;">รหัสการสั่ง</th>
                        <th style="text-align:center; width:30%;">วันที่สั่ง</th>
                        <th style="text-align:right; width:25%;">หมายเลขโต๊ะ</th>
                        <th style="text-align:right;">ราคารวม (บาท)</th>

                    </thead>
                    <?php
                    $count_product = count($_SESSION['food_admin']['payment']['orderid']);
                    $sum_price = 0;

                    for ($i = 0; $i < $count_product; $i++) {
                        $sql_sum        =    "SELECT * FROM orders WHERE orderid = '" . $_SESSION['food_admin']['payment']['orderid'][$i] . "' ";
                        $data_sum        =    mysqli_query($link, $sql_sum);
                        $value            =    mysqli_fetch_assoc($data_sum);
                        $sum_price      +=  $value['order_totalprice'];
                        //		$product_id[] 	= 	$value['tables_no'];

                    ?>
                        <td align="center"><?php echo $value['orderid']; ?></td>
                        <td align="center"><?php echo dt_tothaiyear($value['orderdate']); ?></td>
                        <td align="right"><?= ($value['tables_no'] != "") ? $value['tables_no'] : "-" ?></td>
                        <td align="right"><?php echo $value['order_totalprice']; ?></td>
                        </tr>
                    <?php }    ?>
                    <tr>
                        <td colspan="3" class="text-right"><b>รวมทั้งหมด</b></td>
                        <td class="text-right">
                            <b><?= number_format($sum_price, 2); ?></b>
                            <input hidden name="sum_price" id="sum_price" value="<?= $sum_price ?>">
                        </td>
                    </tr>
            </div>
            </table>
            <div class="row" style="padding-bottom: 2%; padding-top:1%;">
                <label class="control-label col-md-2 col-md-offset-1 text-right">ช่องทาง :<font style="color: red;">*</font></label>
                <div class="col-md-7">
                    <select class="form-control" name="bankid" id="bankid" required>
                        <option selected disabled value="" >-- กรุณาเลือกช่องทางการชำระเงิน --</option>
                        <option value="0">เงินสด</option>
                        <?php
                        $sql_bank = "SELECT * FROM banks WHERE bank_status = 0";
                        $q_bank = mysqli_query($link, $sql_bank);
                        while ($result_bank = mysqli_fetch_array($q_bank)) {
                        ?>
                            <option value="<?= $result_bank['bankid'] ?>">ธนาคาร</label><?= $result_bank['bank_name'] ?> | <?= $result_bank['bank_branch'] ?> | <?= $result_bank['bank_details'] ?></option>
                        <?php  } ?>
                    </select>
                </div>
            </div>
            <div class="row" style="padding-bottom:3%;">
                <label class="control-label col-md-2 col-md-offset-1 text-right">หมายเหตุ : </label>
                <div class="col-md-6">
                    <textarea name="pay_note" class="form-control" rows="4" cols="30"></textarea>
                </div>
            </div>
            <div class="col-md-offset-3 col-md-6" style="text-align: center; padding-bottom:20px;">
                <input type="submit" name="submit" id="submit" onclick="if(confirm('ยืนยันรายการรับชำระ?')) return true; else return false;" class="btn btn-success" value="บันทึก" />
                <button type="reset" class="btn btn-danger">ล้างค่า</button></form>
                <button type="back" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
            </div>
        </div>
    </div>
    <?php //include("conf/footer.php"); 
    ?>
</body>