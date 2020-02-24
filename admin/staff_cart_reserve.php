<html>

<head>
    <title>ตะกร้าจอง | Food Order System</title>
    <?php
    session_start();
    ?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php
    include("conf/header_admin.php");
    if (!isset($_SESSION['staff'])) {
        echo  "<script> alert('กรุณาเข้าสู่ระบบ');window.location.assign('index.php') </script>";
        exit();
    }
    ?>

    <div class="container" style="padding-top: 135px;">
        <h1 class="page-header text-left">ตะกร้าจอง</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" align="center" style="width:700px">
                <thead>
                    <th style="text-align:right;" width="250px">หมายเลขโต๊ะ</th>
                    <th style="text-align:right;">จำนวนที่นั่ง (คน)</th>
                    <th style="width: 150px; text-align:center;">ยกเลิก</th>
                </thead>

                <?php
                require_once("../conf/connection.php");



                if (!isset($_SESSION['food_admin']['reserve'])) {
                    echo '<tr>
                    <td colspan="7" class="text-center">ไม่มีรายการจองในตะกร้า</td>
                </tr>';
                } else {

                    $count_product = count($_SESSION['food_admin']['reserve']['tables_no']);

                    for ($i = 0; $i < $count_product; $i++) {
                        $sql_sum        =    "SELECT * FROM tables WHERE tables_no = '" . $_SESSION['food_admin']['reserve']['tables_no'][$i] . "' ";
                        $data_sum        =    mysqli_query($link, $sql_sum);
                        $value            =    mysqli_fetch_assoc($data_sum);
                        //  $sum_price[] 	= $_SESSION['food_admin']['list']['food_admin_price'][$i] * $_SESSION['food_admin']['list']['amount'][$i];
                        //   $product_id[] 	= $value['foodid'];
                        ?>
                        <tr>
                            <td align="right"><?php echo $value['tables_no']; ?></td>
                            <td align="right"><?php echo $value['tables_seats']; ?></td>
                            <td align="center" style="padding:5px; width:10px"><a href="staff_del_list_tables.php?tables_no=<?php echo $value['tables_no']; ?>"> <span class="glyphicon glyphicon-trash fa-2x" style="font-size:25px; color:red;" aria-hidden="true"></span></td>

                        </tr>
                    <?php } ?>
                    <tr>
                        <td align="right" colspan="1"><b>รวมทั้งหมด</b></td>
                        <td align="right"><b><?= number_format(array_sum($_SESSION['food_admin']['reserve']['seats']), 0) ?></b></td>
                        <td align=""><b>ที่นั่ง</b></td>
                    </tr>
                <?php } ?>

            </table>
        </div>
        <div class="col-md-offset-3 col-md-6" style="text-align: center;">
            <a class="btn btn-primary" href="show_tables_reserve.php" role="button">เพิ่มรายการ</a>
            <a class="btn btn-success <?php
                                        if (!isset($_SESSION['food_admin']['reserve']['tables_no'])) {
                                            echo "disabled";
                                        } ?>" href="select_customer.php?ref=reserve" role="button">จองโต๊ะ</a>
            <!--<button type="submit" class="btn btn-info" name="save" <?php
                                                                        if (!isset($_SESSION['food_admin']['reserve']['tables_no'])) {
                                                                            echo "disabled";
                                                                        } ?>>บันทึกข้อมูล</button> -->

            <a class="btn btn-danger <?php
                                        if (!isset($_SESSION['food_admin']['reserve']['tables_no'])) {
                                            echo "disabled";
                                        } ?>" href="staff_del_list_tables_all.php" onclick="if(confirm('ต้องการล้างตะกร้าใช่หรือไม่?')) return true; else return false;">ล้างตะกร้า</a>
        </div>
    </div>
</body>
</html>