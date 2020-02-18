<html>

<head>
    <title>ตะกร้ารับชำระ | Food Order System</title>
    <?php
    if (!isset($_SESSION))
        session_start();
    ?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php
    include("conf/header_admin.php");
    ?>

    <div class="container" style="padding-top: 135px;">
        <h1 class="page-header text-left">ตะกร้ารับชำระ</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" align="center">
                <thead>
                    <th style="text-align:center;" width="220px">รหัสการสั่ง</th>
                    <th style="text-align:center; width:230px;">วันที่สั่ง</th>
                    <th style="text-align:left; width:320px;">ชื่อลูกค้า</th>
                    <th style="text-align:right; width:200px;">หมายเลขโต๊ะ</th>
                    <th style="text-align:right; width:200px;">ราคาสุทธิ (บาท)</th>
                    <th style="width: 150px; text-align:center; width:150px;">ยกเลิก</th>
                </thead>

                <?php
                require_once("../conf/connection.php");
                require_once("../conf/function.php");

                if (!isset($_SESSION['food_admin']['payment'])) {
                    echo '<tr>
                    <td colspan="7" class="text-center">ไม่มีรายการรับชำระในตะกร้า</td>
                </tr>';
                } else {

                    $count_product = count($_SESSION['food_admin']['payment']['orderid']);
                    $sum_price = 0;
                    for ($i = 0; $i < $count_product; $i++) {
                        $sql_sum        =    "SELECT * FROM orders LEFT JOIN customers ON orders.cusid = customers.cusid WHERE orderid = '" . $_SESSION['food_admin']['payment']['orderid'][$i] . "' ";
                        $data_sum        =    mysqli_query($link, $sql_sum);
                        $value            =    mysqli_fetch_assoc($data_sum);
                        //  $sum_price[] 	= $_SESSION['food_admin']['list']['food_admin_price'][$i] * $_SESSION['food_admin']['list']['amount'][$i];
                        //   $product_id[] 	= $value['foodid'];
                ?>
                        <tr>
                            <td align="center"><?php echo $value['orderid']; ?></td>
                            <td align="center"><?php echo dt_tothaiyear($value['orderdate']); ?></td>
                            <td align="left"><?php echo $value['cus_name']; ?></td>
                            <td align="right"><?= ($value['tables_no'] != NULL) ? $value['tables_no'] : "-" ?></td>
                            <td align="right"><?= $value['order_totalprice'] ?></td>
                            <td align="center" style="padding:5px; width:10px"><a href="staff_del_list_payment.php?oid=<?php echo $value['orderid']; ?>"> <span class="glyphicon glyphicon-trash fa-2x" style="font-size:25px; color:red;" aria-hidden="true"></span></td>

                        </tr>
                    <?php
                        $sum_price += $value['order_totalprice'];
                    } ?>
                    <tr>
                        <td align="right" colspan="4"><b>รวมทั้งหมด</b></td>
                        <td align="right"><b><?= number_format($sum_price, 2) ?></b></td>
                        <td align=""><b></b></td>
                    </tr>
                <?php } ?>

            </table>
        </div>
        <div class="col-md-offset-3 col-md-6" style="text-align: center;">

            <?php
            if (isset($_SESSION['food_admin']['payment'])) { // ดึงค่า Order แรกในตะกร้ามาตรวจสอบประเภท
                $sql_type = "SELECT order_type FROM orders WHERE orderid = '" . $_SESSION['food_admin']['payment']['orderid'][0] . "'";
                $query_type = mysqli_query($link, $sql_type) or die(mysqli_error($link));
                $result_type = mysqli_fetch_assoc($query_type);
            } else {
                $result_type = null; // ให้ ประเภท null
            }

            if ($result_type['order_type'] != 2 || (!isset($_SESSION['food_admin']['payment']))) {
            ?>
                <a class="btn btn-primary" href="staff_order_history.php" role="button">เพิ่มรายการ</a>
            <?php } ?>
            <a class="btn btn-success <?php
                                        if (!isset($_SESSION['food_admin']['payment']['orderid'])) {
                                            echo "disabled";
                                        } ?>" href="staff_checkout_payment.php" role="button">ชำระเงิน</a>
            <!--<button type="submit" class="btn btn-info" name="save" <?php
                                                                        if (!isset($_SESSION['food_admin']['payment']['orderid'])) {
                                                                            echo "disabled";
                                                                        } ?>>บันทึกข้อมูล</button> -->

            <a class="btn btn-danger <?php
                                        if (!isset($_SESSION['food_admin']['payment']['orderid'])) {
                                            echo "disabled";
                                        } ?>" href="staff_del_list_payment_all.php" onclick="if(confirm('ต้องการล้างตะกร้าใช่หรือไม่?')) return true; else return false;">ล้างตะกร้า</a>
        </div>
    </div>
</body>

</html>