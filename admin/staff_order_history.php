<head>
    <title>แสดง/ยกเลิกการสั่งอาหาร | Food Order System</title>
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
    //include("../conf/connection.php");
    include("../conf/function.php");

    $strKeyword = null;
    if (isset($_POST["search_orders"])) {
        $strKeyword = $_POST["search_orders"];
    }
    if (isset($_GET["search_orders"])) {
        $strKeyword = $_GET["search_orders"];
    }
    ?>
    <div class="container" style="width:1220px; padding-top: 135px;">

        <h1 class="page-header text-left">แสดง/ยกเลิกการสั่งอาหาร</h1>
        <div class="row">
            <form class="form-inline">
                <div class="col-xs-6">
                    <div class="form-group">
                        <input class="form-control" type="text" name="search_orders" placeholder="ค้นหารหัสการสั่งอาหาร" aria-label="Search">
                        <button type="submit" class="btn btn-success">ค้นหา</button>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" align="center">
                <thead>
                    <th style="text-align:center; width:130px;">รหัสการสั่ง</th>
                    <th style="text-align: center; width:190px;">วัน/เวลาสั่งอาหาร</th>
                    <th style="width:260px;">ชื่อลูกค้า</th>
                    <th style="text-align:right; width:135px;">ราคา (บาท)</th>
                    <th style="text-align:left; width:160px;">สถานะ</th>
                    <th style=" text-align:center; width:180px;">รายละเอียดการสั่ง</th>
                    <th style=" text-align:center; width:230px;">ปรับปรุงการสั่งอาหาร</th>
                    <th style=" text-align:center; width:120px;">สั่งเพิ่ม</th>
                    <th style=" text-align:center; width:145px;">เลือกรับชำระ</th>
                </thead>

                <?php
                include('../conf/connection.php');
                $sql = "SELECT * FROM orders WHERE orderid LIKE '%" . $strKeyword . "%'";
                $query = mysqli_query($link, $sql);

                $num_rows = mysqli_num_rows($query);

                $per_page = 10;   // จำนวนข้อมูลต่อหน้า
                $page  = 1;

                if (isset($_GET["Page"])) {
                    $page = $_GET["Page"];
                }

                $prev_page = $page - 1;
                $next_page = $page + 1;

                //$row_start = (($per_page*$page)-$per_page);
                $row_start = ($page - 1) * $per_page;
                if ($num_rows <= $per_page) {
                    $num_pages = 1;
                } else if (($num_rows % $per_page) == 0) {
                    $num_pages = ($num_rows / $per_page);
                } else {
                    $num_pages = ($num_rows / $per_page) + 1;
                    $num_pages = (int) $num_pages;
                }
                $row_end = $per_page;
                if ($row_end > $num_rows) {
                    $row_end = $num_rows;
                }

                $sql .= " ORDER BY orderid DESC LIMIT $row_start ,$row_end ";
                $query = mysqli_query($link, $sql);

                if ($num_rows > 0) { // ค้นหพบรายการอาหาร ให้แสดง
                    while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                        // $ordertime = strtotime($result["orderdate"]);

                        $q_cus = mysqli_query($link, "SELECT cus_name FROM customers WHERE cusid = '" . $result['cusid'] . "'");
                        $cus_data = mysqli_fetch_assoc($q_cus);

                        switch ($result['order_status']) {
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
                        } ?>
                        <tr>
                            <td align="center"><?= $result["orderid"]; ?></td>
                            <td align="center"> <?= dt_tothaiyear($result['orderdate']) ?></td>
                            <td><?= $cus_data['cus_name'] ?></td>
                            <td align="right"> <?= number_format($result["order_totalprice"], 2) ?></td>
                            <td><?= $order_status ?></td>
                            <td align="center"><a href="order_detailed.php?oid=<?= $result['orderid'] ?>" class="btn btn-primary"><i class="fa fa-search-plus"></i> ดูรายละเอียด</a></td>
                            <td align="center">
                                <?php if ($result['order_status'] == 0 || $result['order_status'] == 1) { ?>
                                    <a href="order_edit.php?oid=<?= $result['orderid'] ?>" class="btn btn-primary"><i class="fa fa-pencil"></i> ปรับปรุง</a></td>
                        <?php } ?>
                        </td>
                        <td align="center">
                            <?php if ($result['order_status'] == 0 || $result['order_status'] == 1) { ?>
                                <a href="order_more.php?oid=<?= $result['orderid'] ?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> สั่งเพิ่ม</a></td>
                    <?php } ?>
                    </td>
                    <td align="center">
                            <?php if ($result['order_status'] != 3 && $result['order_status'] != 2) { // ปุ่มเลือกรับชำระ
                            ?>
                                <a href="staff_add_list_pay.php?oid=<?= $result['orderid'] ?>" class="btn btn-primary"><i class="fa fa-wpforms"></i> รับชำระ</a></td>
                    <?php } ?>
                    </td>
                        </tr>
                <?php }
                } else {
                    echo '
            <tr>
                <td colspan="9" align="center">ไม่พบข้อมูลในระบบ</td>
            </tr>
        ';
                }
                ?>
            </table>
        </div>
        <nav aria-label="Page navigation example" class="navbar-center">
            <div class="text-center">
                <ul class="pagination">
                    <?php
                    if ($prev_page) {
                        echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$prev_page&search_food=$strKeyword'>ก่อนหน้า</a></li>";
                    } else {
                        // ทำให้คลิกไม่ได้
                        echo '<li class="page-item disabled"><a href="#" >ก่อนหน้า</a></li>';
                    }

                    for ($i = 1; $i <= $num_pages; $i++) {
                        if ($i != $page) {
                            echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=$i&search_food=$strKeyword'>$i</a>" . '</li>';
                        } else {
                            echo '<li class="page-item active"><a href="#">' . $i . '</a></li>';
                        }
                    }
                    if ($page != $num_pages) {
                        echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$next_page&search_food=$strKeyword'>ถัดไป</a></li>";
                    } else {
                        echo '<li class="page-item disabled">' . "<a href ='#'>ถัดไป</a></li> ";
                    }
                    $conn = null;
                    ?>
            </div>
        </nav>
    </div>
    <?php //include("conf/footer.php"); 
    ?>
</body>
<?php
if (isset($_SESSION['food_admin']['payment']['orderid'])) {
    $cartcount = count($_SESSION['food_admin']['payment']['orderid']);
} else {
    $cartcount = 0;
}
?>
<div class="sticky-div">
    <span class="badge badge-danger" style="position:absolute; right:-3px; top:-3px; background:red; font-size:15px;"><?= $cartcount ?></span>
    <a href="staff_cart_payment.php" class="sticky-cart btn btn-success"><i style="padding-top:10px; font-size:35px;" class="fa fa-shopping-basket"></i></a>
</div>