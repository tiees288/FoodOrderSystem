<?php

if (!isset($_GET['oid'])) {
    echo "<script>window.location.assign('order_history.php')</script>";
    exit();
}
?>

<head>
    <title>ปรับปรุงรายการสั่งอาหาร | Food Order System</title>
    <?php
    if (!isset($_SESSION)) {  // Check if sessio nalready start
        session_start();
    }
    ?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php
    require_once("conf/header_admin.php");
    require_once("../conf/connection.php");
    include_once("../conf/function.php");

    $sql_orderdata  = "SELECT * FROM orders WHERE orderid = '{$_GET['oid']}'";
    $query_order = mysqli_query($link, $sql_orderdata);
    $order_data = mysqli_fetch_assoc($query_order);

    if ($order_data['order_status'] == 3) {
        echo "window.location.assign('staff_order_history.php');";
        exit();
    }

    $sql_cusdata    = "SELECT * FROM customers WHERE cusid = '{$order_data['cusid']}'";
    $query_customer = mysqli_query($link, $sql_cusdata);
    $cus_data = mysqli_fetch_assoc($query_customer);

    $sql_reserve = "SELECT * FROM reservations WHERE reserv_id = '{$order_data['reserv_id']}'";
    $reserve_data = mysqli_fetch_assoc(mysqli_query($link, $sql_reserve));

    switch ($order_data['order_status']) {
        case 0:
            $order_status = "<span style='color:orange'>ยังไม่แจ้งชำระ</span>";
            break;
        case 1:
            $order_status = "<span style='color:#0072EE'>รอการตรจสอบ</span>";
            break;
        case 2:
            $order_status = "<span style='color:#12BB4F'>ชำระแล้ว</span>";
            break;
        case 3:
            $order_status = "<span style='color:red;'>ยกเลิก</span>";
            break;
        default:
            echo "Error";
    }

    switch ($order_data['order_type']) {
        case 0:
            $order_type = "กลับบ้าน สั่งโดยพนักงาน";
            break;
        case 1:
            $order_type = "ทานที่ร้าน สั่งโดยพนักงาน";
            break;
        case 2:
            $order_type = "กลับบ้าน สั่งโดยลูกค้า";
            break;
        default:
            echo "Error";
    }
    ?>
    <div class="container" style="padding-top: 135px;">
        <div class="col">
            <h1 class="page-header text-center">ปรับปรุงรายการสั่งอาหาร</h1>
            <div class="container" style="width:970px">
                <div class="panel panel-default" align="center" style="background-color:#FBFBFB;">
                    <form id="basket" class="form" name="edit_order" method="POST" action="save_edit_order.php">
                        <table width="750px" border="0" align="center">
                            <tr>
                                <td height="13px"></td>
                            </tr>
                            <tr style="padding-top:15px">
                                <td width="" height="36px"><b>รหัสการสั่งอาหาร :</b></td>
                                <td width="30%">
                                    <?php echo $_GET['oid'] ?>
                                    <input hidden value="<?= $_GET['oid'] ?>" name="orderid" id="orderid">
                                </td>
                                <td width="20%"><b>สถานะ :</b></td>
                                <td><?= $order_status ?></td>
                            </tr>
                            <tr>
                                <td width="" height="36px"><b>รหัสลูกค้า :</b></td>
                                <td width="30%"><?php echo $cus_data['cusid'] ?></td>
                                <td width="20%" height="36px"><b>ชื่อ-นามสกุล :</b></td>
                                <td><?php echo $cus_data['cus_name']; ?></td>
                            </tr>
                            <tr>
                                <td height="40px" width="15%"><b>วันที่สั่ง :</b></td>
                                <td width="35%">
                                    <?= dt_tothaiyear($order_data['orderdate']); ?>
                                </td>
                                <td width="16%" height="40px"><b>เบอร์โทรศัพท์ :</b></td>
                                <td><?php echo $cus_data['cus_tel'] ?></td>
                            </tr>
                            <?php
                            if ($order_data['order_type'] == 0) {
                            ?>
                                <tr>
                                    <td width="15%" height="32px"><b>วันที่กำหนดส่ง :</b></td>
                                    <td width="35%">
                                        <?php
                                        if ($order_data['order_date_tobedelivery'] != "0000-00-00")
                                            echo tothaiyear($order_data['order_date_tobedelivery']);
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                    <td width="15%" height="32px"><b>เวลากำหนดส่ง :</b></td>
                                    <td>
                                        <?php
                                        if (substr($order_data['order_time_tobedelivery'], 0, 5) != "00:00")
                                            echo substr($order_data['order_time_tobedelivery'], 0, 5);
                                        else
                                            echo "-";
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td width="15%" height="40px"><b>ประเภทการสั่ง :</b></td>
                                <td>
                                    <?= $order_type ?>
                                </td>
                                <td width="15%" height="40px"><b>หมายเลขโต๊ะ :</b></td>
                                <td>
                                    <?php
                                    if ($order_data['tables_no'] != NULL)
                                        echo $order_data['tables_no'];
                                    else echo "-";
                                    ?>
                                </td>
                            </tr>
                            <?php if ($order_data['reserv_id'] != NULL) { ?>
                                <tr>
                                    <td width="15%" height="32px"><b>รหัสการจอง :</b></td>
                                    <td>
                                        <?php
                                        if ($order_data['reserv_id'] != NULL)
                                            echo $order_data['reserv_id'];
                                        else echo "-";
                                        ?>
                                    </td>
                                    <td width="15%" height="32px"><b>วัน/เวลาจอง :</b></td>
                                    <td>
                                        <?php
                                        if ($order_data['reserv_id'] != NULL)
                                            echo dt_tothaiyear($reserve_data['reserv_date_reservation']);
                                        else echo "-";
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="15%" height="40px"><b>วันที่นัด :</b></td>
                                    <td>
                                        <?php
                                        if ($order_data['reserv_id'] != NULL)
                                            echo tothaiyear($reserve_data['reserv_date_appointment']);
                                        else echo "-";
                                        ?>
                                    </td>
                                    <td width="15%" height="32px"><b>เวลานัด :</b></td>
                                    <td>
                                        <?php
                                        if ($order_data['reserv_id'] != NULL)
                                            echo substr($reserve_data['reserv_time_appointment'], 0, 5);
                                        else echo "-";
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td width="20%" height="32px"><b>สถานที่จัดส่ง :</b></td>
                                <td width="30%" height="75px">
                                    <?= $order_data['order_type'] != 1 ? $order_data['order_delivery_place'] : "-" ?>
                                </td>
                                <td width="20%" height="32px"><b>หลักฐานการชำระ :</b></td>
                                <td>
                                    <?php
                                    if ($order_data['order_status'] != 0 && $order_data['order_status'] != 3 && $order_data['order_evidence'] != "") { ?>
                                        <a style="padding-left:10%;" href="#img_<?= $order_data['orderid'] ?>" data-toggle="modal"><img height="70px" style="border: 1px solid;" width="50px" src="../<?= $order_data['order_evidence'] ?>"></a>
                                        <div class="modal fade" id="img_<?php echo $order_data['orderid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="col-md-4 col-md-offset-4">
                                                            <h4 class="modal-title" id="myModalLabel">หลักฐานการชำระ</h4>
                                                        </div>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid text-center">
                                                            <img height="400px" width="300px" src="../<?= $order_data['order_evidence'] ?>">
                                                            <hr>
                                                            <div class="col-md-7 col-md-offset-2">
                                                                <label>วันที่แจ้งหลักฐาน : &nbsp; </label><?= dt_tothaiyear($order_data['order_evidence_date']) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    <?php    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                </div>
            </div>
            <h3 class="page-header text-center">รายการอาหาร</h3>
            <table class="table table-striped table-bordered" style="width:1080px;" align="center" id="foodlist">
                <thead>
                    <th style="text-align:right; width:150px">รหัสรายการอาหาร</th>
                    <th width="140px">ชื่ออาหาร</th>
                    <th width="90px">หน่วยนับ</th>
                    <th style="text-align:right; width:110px;">ราคา (บาท)</th>
                    <th style="text-align:center; width:105px;">จำนวน</th>
                    <th style="width:130px; text-align:right">ราคารวม (บาท)</th>
                    <th>หมายเหตุ</th>
                    <th style="text-align: center; width:85px;">ยกเลิก</th>
                </thead>
                <?php
                $orderdet_sql = "SELECT * FROM orderdetails WHERE orderid = '" . $_GET['oid'] . "'";
                $orderdet_query = mysqli_query($link, $orderdet_sql);
                $i = 0;
                while ($orderdet_data = mysqli_fetch_array($orderdet_query)) {
                    $food_sql = "SELECT food_name, food_count FROM foods WHERE foodid = '" . $orderdet_data['foodid'] . "'";
                    $food_data = mysqli_fetch_assoc(mysqli_query($link, $food_sql));
                ?>
                    <tr <?php if ($orderdet_data['orderdet_status'] != 2) echo 'class="cnt"'; ?>)>
                        <td align="right"><?php echo $orderdet_data['foodid'] ?></td>
                        <td><?php echo $food_data['food_name']; ?></td>
                        <td><?= $food_data['food_count'] ?></td>
                        <td align="right">
                            <?= number_format($orderdet_data['orderdet_price'], 2); ?></td>
                        <td class="text-center">
                            <button <?= ((($orderdet_data['orderdet_status'] == 2) || ($order_data['order_type'] == 2)) || $order_data['order_date_delivered'] != '0000-00-00') ? "disabled" : "" ?> class="delete" type="button">-</button>
                            <input <?= ((($orderdet_data['orderdet_status'] == 2) || ($order_data['order_type'] == 2)) || $order_data['order_date_delivered'] != '0000-00-00') ? "disabled" : "" ?> type="text" maxlength="3" class="amount" onkeypress="return isNumberKey(event)" style="width:35px; text-align:center;" <?= $orderdet_data['orderdet_status'] == 2 ? "" : NULL ?>" autocomplete="off" id="amount-<?= $orderdet_data['foodid'] ?>" value="<?= $orderdet_data['orderdet_amount'] ?>" size="1" name="qty_<?= $i ?>">
                            <input type="text" name="id[]" value="<?= $orderdet_data['foodid'] ?>" hidden>
                            <button <?= ((($orderdet_data['orderdet_status'] == 2) || ($order_data['order_type'] == 2)) || $order_data['order_date_delivered'] != '0000-00-00') ? "disabled" : "" ?> class="plus" type="button"> + </button>
                            <!-- จำนวนเหลือ ใน Stock -->
                            <input type="text" value="<?= $orderdet_data['orderdet_amount'] ?>" id="stock_<?= $i ?>" name="stock_<?= $i ?>" hidden>
                            <!-- =================== -->
                        </td>
                        <td class="text-right <?php if ($orderdet_data['orderdet_status'] != 2) echo 'price-order-' . $i; ?>" id="price-<?= $orderdet_data['foodid'] ?>" data-value="<?= number_format($orderdet_data['orderdet_price'], 2) ?>">
                            <?= number_format($orderdet_data['orderdet_price'] * $orderdet_data['orderdet_amount'], 2) ?>
                        </td>
                        <td class="col-md-2"><textarea <?= ((($orderdet_data['orderdet_status'] == 2) || ($order_data['order_type'] == 2)) || $order_data['order_date_delivered'] != '0000-00-00') ? "disabled" : "" ?> class="form-control" name="order_note_edit_<?= $orderdet_data['orderdetid'] ?>"><?= $orderdet_data['orderdet_note'] ?></textarea></td>
                        <td align="center">
                            <?php
                            if ($order_data['order_type'] != 2 && $order_data['order_date_delivered'] == '0000-00-00') {
                                if ($orderdet_data['orderdet_status'] == 0) { ?>
                                    <a href="save_edit_order.php?del_oid=<?= $orderdet_data['orderdetid'] ?>" onclick="if(confirm('ต้องการยกเลิกรายการอาหารนี้หรือไม่?')) return true; else return false;"><span class="glyphicon glyphicon-remove" style="font-size: 20px; color:red;"></span></a>
                            <?php } elseif ($orderdet_data['orderdet_status'] == 2) {
                                    echo "<font color='red'>ยกเลิกแล้ว</font>";
                                }
                            } ?>
                        </td>
                    </tr>
                <?php $i++;
                } ?>
                <tr>
                    <td colspan="5" class="text-right"><b>ราคารวมทั้งหมด</b></td>
                    <td class="text-right" id="sum"><b><?= number_format($order_data['order_totalprice'], 2); ?></b></td>
                    <td colspan="2"></td>
                </tr>
        </div>
        </table>
        <?php
        if ($order_data['order_type'] != 2 && $order_data['order_date_delivered'] == '0000-00-00') {
        ?>
            <h3 class="page-header text-center">ตะกร้าสั่งเพิ่ม</h3>

            <table class="table table-striped table-bordered" id="foodlist2" align="center" style="width:1100px;">
                <thead>
                    <th style="width:150px; text-align:right;">รหัสรายการอาหาร</th>
                    <th style="width:140px;">ชื่ออาหาร</th>
                    <th style="width:90px;">หน่วยนับ</th>
                    <th style="text-align:right; width:110px;">ราคา (บาท)</th>
                    <th style="text-align:center; width:100px;">จำนวน</th>
                    <th style="width:130px; text-align:right">ราคารวม (บาท)</th>
                    <th>หมายเหตุ</th>
                    <th style="width:85px; text-align:center;">ยกเลิก</th>
                </thead>

                <?php
                if (!isset($_SESSION['food_admin']['list']['foodid'])) {
                    echo '<tr>
			<td colspan="8" class="text-center">ไม่มีสินค้าในตะกร้า</td>
		</tr>';
                } else {

                    $count_product = count($_SESSION['food_admin']['list']['foodid']);

                    for ($i = 0; $i < $count_product; $i++) {
                        $sql_sum        =    "SELECT * FROM foods WHERE foodid = '" . $_SESSION['food_admin']['list']['foodid'][$i] . "' ";
                        $data_sum        =    mysqli_query($link, $sql_sum);
                        $value            =    mysqli_fetch_assoc($data_sum);
                        $sum_price[]     = $_SESSION['food_admin']['list']['food_price'][$i] * $_SESSION['food_admin']['list']['amount'][$i];
                        $product_id[]     = $value['foodid'];

                        // สำหรับตรวจสอบถ้าในระบบไม่มีรูป
                        if ($value['food_image'] == "")
                            $food_img = "../images/default_food.png";
                        else $food_img = "../" . $value['food_image'];

                ?>
                        <input name="oid" type="text" value="<?= $_GET['oid'] ?>" hidden>
                        <tr>
                            <td align="right"><?php echo $value['foodid']; ?></td>
                            <td><?php echo $value['food_name']; ?></td>
                            <td><?= $value['food_count'] ?></td>
                            <td align="right"><?php echo number_format($value['food_price'], 2); ?></td>
                            <td class="text-center">
                                <button class="delete2" type="button">-</button>
                                <input type="text" maxlength="3" class="amount2" onkeypress="return isNumberKey(event)" style="width:35px; text-align:center;" autocomplete="off" id="amount2-<?= $value['foodid'] ?>" value="<?= $_SESSION['food_admin']['list']['amount'][$i] ?>" size="1" name="qty2_<?php echo $i; ?>">
                                <input type="text" name="id2[]" value="<?= $value['foodid'] ?>" hidden>
                                <button class="plus2" type="button"> + </button>
                                <!-- จำนวนเหลือ ใน Stock -->
                                <input type="text" value="<?= $value['food_qty'] ?>" id="stock2_<?= $i ?>" name="stock2_<?= $i ?>" hidden>
                                <!-- =================== -->
                            </td>
                            <td class="text-right price-order2-<?= $i ?>" data-value="<?= number_format($_SESSION['food_admin']['list']['food_price'][$i], 2) ?>" id="price2-<?= $value['foodid']  ?>"><?= number_format($_SESSION['food_admin']['list']['food_price'][$i] * $_SESSION['food_admin']['list']['amount'][$i], 2) ?></td>
                            <td class="col-md-2"><textarea class="form-control" name="order_note_<?= $value['foodid'] ?>"></textarea></td>
                            <td align="center" style="padding:25px; width:10px"><a href="staff_del_list_food.php?foodid=<?php echo $value['foodid']; ?>&oid=<?= $_GET['oid'] ?>"> <span class="glyphicon glyphicon-trash fa-2x" style="color:red; font-size:25px;" aria-hidden="true"></span></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td align="right" colspan="5"><b>ราคารวมทั้งหมด</b></td>
                        <td class="text-right"><b id="sum2"><?= number_format(array_sum($sum_price), 2); ?></b></td>
                        <td align="center" colspan="2"></td>
                    </tr>
            <?php }
            }
            ?>
            </table>

            <div class="col-md-offset-3 col-md-6" style="text-align: center;">
                <?php
                if ($order_data['order_type'] != 2 && $order_data['order_date_delivered'] == '0000-00-00') {
                ?>
                    <a class="btn btn-primary" id="od_more" href="show_food_typeall.php?oid=<?= $_GET['oid'] ?>" role="button">เพิ่มรายการ</a>
                    <input type="submit" name="submit" id="submit" onclick="if(confirm('ยืนยันปรับปรุงการสั่งอาหาร?')) return true; else return false;" class="btn btn-success" value="บันทึก" />
                    <input type="reset" name="reset" class="btn btn-danger" value="คืนค่า">
                <?php
                }
                ?>
                <button type="submit" name="cancel" onclick="if(confirm('ต้องการยกเลิกการสั่งอาหาร?')) return true; else return false;" class="btn btn-warning">ยกเลิกการสั่ง</button>
                </form>
                <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
            </div>
    </div>
    </div>
    <br>
    </div>
    <?php //include("conf/footer.php"); 
    ?>
</body>
<script type="text/javascript" src="lib/number/jquery.number.min.js"></script>
<script type="text/javascript">
    function add(a, b) {
        return a + b;
    }
    $(document).ready(function() {
        $('.delete').click(function(event) {
            let id = $(this).next().attr('id');
            let val = $('#' + id).val();
            let id2 = id.replace('amount-', 'price-');
            let price = $('#' + id2).data('value');

            if (val <= 1) {
                alert('จำนวนไม่สามารถน้อยกว่า 1 ได้');
            } else {
                let sum = parseInt(val) - 1;
                $('#' + id).val(sum);

                prices = price.replace(/,/g, ''),
                    asANumber = +prices;

                let price2 = sum * prices;

                let price3 = price2.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                });

                $('#' + id2).text(price3);

                let count_tr = ($('#foodlist tr').length);
                var sum2 = [];

                for (var i = 0; i < count_tr; i++) {
                    if ($('.price-order-' + i).text() != "") {
                        sum2.push(parseInt($('.price-order-' + i).text().replace(',', '')));
                    }
                }
                let sum3 = sum2.reduce(add, 0);
                let sum_tt = sum3.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                });
                $('#sum').text(sum_tt)


            }
        });
        $('.plus').click(function(event) {
            let id = $(this).prev().prev().attr('id');
            let val = $('#' + id).val();
            let id2 = id.replace('amount-', 'price-');
            let price = $('#' + id2).data('value');
            let sum = parseInt(val) + 1;

            if (isNaN(val) || val == "") {
                $('#' + id).val('1');
            } else {
                if (val >= 250) {
                    alert('จำนวนอาหารไม่สามารถมากกว่า 250 ได้');
                } else {
                    prices = price.replace(/,/g, ''),
                        asANumber = +prices;

                    let price2 = sum * prices;
                    let price3 = price2.toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    });
                    $('#' + id).val(sum);
                    $('#' + id2).text(price3);

                    let count_tr = ($('#foodlist tr').length);

                    var sum2 = [];
                    for (var i = 0; i < count_tr; i++) {
                        if ($('.price-order-' + i).text() != "") {
                            sum2.push(parseInt($('.price-order-' + i).text().replace(',', '')));
                        }
                    }
                    let sum3 = sum2.reduce(add, 0);
                    let sum_tt = sum3.toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    });
                    $('#sum').text(sum_tt)
                }
            }
        });
        $('.amount').keyup(function(event) {
            let id = $(this).attr('id');
            let val = parseInt($('#' + id).val()); //|| 0;
            let id2 = id.replace('amount-', 'price-');
            let price = $('#' + id2).data('value');
            let sum = parseInt(val);
            prices = price.replace(/,/g, ''),
                asANumber = +prices;

            let price2 = sum * prices;
            let price3 = price2.toLocaleString(undefined, {
                minimumFractionDigits: 2
            });

            let limit = 250; // ลิมิตจำนวน อาหารมากสุด
            //	parseInt($(this).prev().parent().prev().text()); // ลิมิตจำนวน
            if ((limit < val || val <= 0) || isNaN(val)) {
                if (val <= 0) {
                    alert('จำนวนไม่สามารถน้อยกว่า 1 ได้');
                    $('#' + id).val('1');
                    $('#' + id2).text(price);
                }
                if (val > limit) {
                    alert('จำนวนอาหารต้องน้อยกว่า 250');
                    $('#' + id).val(limit);
                    let price3 = price2.toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    });
                    $('#' + id2).text(price3);
                }

                let count_tr = ($('#foodlist tr').length);

                var sum2 = [];
                for (var i = 0; i < count_tr; i++) {
                    if ($('.price-order-' + i).text() != "") {
                        sum2.push(parseInt($('.price-order-' + i).text().replace(',', '')));
                    }
                }
                let sum3 = sum2.reduce(add, 0);
                let sum_tt = sum3.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                })
                $('#sum').text(sum_tt)

                /* if (!isNaN(val)) {
                       $.ajax({
                           type: 'post',
                           url: 'staff_update_qty_food.php',
                           data: $('form').serialize(),
                           success: function() {
                               //document.getElementById("demo").innerHTML = "Save your post done.";
                               //	alert('form was submitted');
                           }
                       }) 
                 } */
                //return
            } else {
                $('#' + id).val(sum);
                $('#' + id2).text(price3);
                let price = parseInt($('#price' + id).data('value'));
                let sum4 = price * val;

                let count_tr = ($('#foodlist tr').length);
                var sum2 = [];
                for (var i = 0; i < count_tr; i++) {
                    if ($('.price-order-' + i).text() != "") {
                        sum2.push(parseInt($('.price-order-' + i).text().replace(',', '')));
                    }
                }
                let sum3 = sum2.reduce(add, 0);
                let sum_tt = sum3.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                });
                $('#sum').text(sum_tt)
                /* $.ajax({
                     type: 'post',
                     url: 'staff_update_qty_food.php',
                     data: $('form').serialize(),
                     success: function() {
                         //document.getElementById("demo").innerHTML = "Save your post done.";
                         //	alert('form was submitted');
                     }
                 }) */
            }

            //	document.getElementById('basket').submit();
        });



        //// ส่วนของตะกร้า /////
        $('.delete2').click(function(event) {
            let id = $(this).next().attr('id');
            let val = $('#' + id).val();
            let id2 = id.replace('amount2-', 'price2-');
            let price = $('#' + id2).data('value');

            if (val <= 1) {
                alert('จำนวนไม่สามารถน้อยกว่า 1 ได้');
            } else {
                let sum = parseInt(val) - 1;
                $('#' + id).val(sum);

                prices = price.replace(/,/g, ''),
                    asANumber = +prices;

                let price2 = sum * prices;

                let price3 = price2.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                });

                $('#' + id2).text(price3);

                let count_tr = ($('#foodlist tr').length);
                var sum2 = [];

                for (var i = 0; i < count_tr; i++) {
                    if ($('.price-order2-' + i).text() != "") {
                        sum2.push(parseInt($('.price-order2-' + i).text().replace(',', '')));
                    }
                }
                let sum3 = sum2.reduce(add, 0);
                let sum_tt = sum3.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                });
                $('#sum2').text(sum_tt)
                $.ajax({ // Ajax สำหรับ ส่งค่า แก้ไขตะกร้า
                    type: 'post',
                    url: 'staff_update_qty_food2.php',
                    data: $('form').serialize(),
                    success: function() {
                        //document.getElementById("demo").innerHTML = "Save your post done.";
                        //	alert('form was submitted');
                    }
                })
            }
        });
        $('.plus2').click(function(event) {
            let id = $(this).prev().prev().attr('id');
            let val = $('#' + id).val();
            let id2 = id.replace('amount2-', 'price2-');
            let price = $('#' + id2).data('value');
            let sum = parseInt(val) + 1;

            if (isNaN(val) || val == "") {
                $('#' + id).val('1');
            } else {
                if (val >= 250) {
                    alert('จำนวนอาหารไม่สามารถมากกว่า 250 ได้');
                } else {
                    prices = price.replace(/,/g, ''),
                        asANumber = +prices;

                    let price2 = sum * prices;
                    let price3 = price2.toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    });
                    $('#' + id).val(sum);
                    $('#' + id2).text(price3);

                    let count_tr = ($('#foodlist2 tr').length);

                    var sum2 = [];
                    for (var i = 0; i < count_tr; i++) {
                        if ($('.price-order2-' + i).text() != "") {
                            sum2.push(parseInt($('.price-order2-' + i).text().replace(',', '')));
                        }
                    }
                    let sum3 = sum2.reduce(add, 0);
                    let sum_tt = sum3.toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    });
                    $('#sum2').text(sum_tt)
                    $.ajax({
                        type: 'post',
                        url: 'staff_update_qty_food2.php',
                        data: $('form').serialize(),
                        success: function() {
                            //document.getElementById("demo").innerHTML = "Save your post done.";
                            //	alert('form was submitted');
                        }
                    })
                }
            }
        });
        $('.amount2').keyup(function(event) {
            let id = $(this).attr('id');
            let val = parseInt($('#' + id).val()); //|| 0;
            let id2 = id.replace('amount2-', 'price2-');
            let price = $('#' + id2).data('value');
            let sum = parseInt(val);
            prices = price.replace(/,/g, ''),
                asANumber = +prices;

            let price2 = sum * prices;
            let price3 = price2.toLocaleString(undefined, {
                minimumFractionDigits: 2
            });

            let limit = 250; // ลิมิตจำนวน อาหารมากสุด
            //	parseInt($(this).prev().parent().prev().text()); // ลิมิตจำนวน
            if ((limit < val || val <= 0) || isNaN(val)) {
                if (val <= 0) {
                    alert('จำนวนไม่สามารถน้อยกว่า 1 ได้');
                    $('#' + id).val('1');
                    $('#' + id2).text(price);
                }
                if (val > limit) {
                    alert('จำนวนอาหารต้องน้อยกว่า 250');
                    $('#' + id).val(limit);
                    let price3 = price2.toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    });
                    $('#' + id2).text(price3);
                }

                let count_tr = ($('#foodlist2 tr').length);

                var sum2 = [];
                for (var i = 0; i < count_tr; i++) {
                    if ($('.price-order2-' + i).text() != "") {
                        sum2.push(parseInt($('.price-order2-' + i).text().replace(',', '')));
                    }
                }
                let sum3 = sum2.reduce(add, 0);
                let sum_tt = sum3.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                })
                $('#sum2').text(sum_tt)

                if (!isNaN(val)) {
                    $.ajax({
                        type: 'post',
                        url: 'staff_update_qty_food2.php',
                        data: $('form').serialize(),
                        success: function() {
                            //document.getElementById("demo").innerHTML = "Save your post done.";
                            //	alert('form was submitted');
                        }
                    })
                }
                //return
            } else {
                $('#' + id).val(sum);
                $('#' + id2).text(price3);
                let price = parseInt($('#price2' + id).data('value'));
                let sum4 = price * val;

                let count_tr = ($('#foodlist2 tr').length);
                var sum2 = [];
                for (var i = 0; i < count_tr; i++) {
                    if ($('.price-order2-' + i).text() != "") {
                        sum2.push(parseInt($('.price-order2-' + i).text().replace(',', '')));
                    }
                }
                let sum3 = sum2.reduce(add, 0);
                let sum_tt = sum3.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                });
                $('#sum2').text(sum_tt)
                $.ajax({
                    type: 'post',
                    url: 'staff_update_qty_food2.php',
                    data: $('form').serialize(),
                    success: function() {
                        //document.getElementById("demo").innerHTML = "Save your post done.";
                        //	alert('form was submitted');
                    }
                })
            }
            //	document.getElementById('basket').submit();
        });
    });
</script>