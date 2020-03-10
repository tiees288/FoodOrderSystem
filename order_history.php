<head>
    <title>แสดงรายการสั่งอาหาร | Food Order System</title>
    <?php
    if (!isset($_SESSION)) {  // Check if sessio nalready start
        session_start();
    }
    ?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php
    if (!isset($_SESSION['user'])) {
        echo "<script>alert('กรุณาเข้าสู่ระบบ'); window.location.assign('login.php')</script>>";
    }
    include("conf/header.php");
    include("conf/connection.php");
    include("conf/function.php");

    $strKeyword = null;
    if (isset($_POST["search_orders"])) {
        $strKeyword = $_POST["search_orders"];
    }
    if (isset($_GET["search_orders"])) {
        $strKeyword = $_GET["search_orders"];
    }
    ?>
    <div class="container" style="padding-top: 90px;">
        <h1 class="page-header text-left">แสดงรายการสั่งอาหาร</h1>
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
                    <th style="text-align:center; width:150px;">รหัสการสั่ง</th>
                    <th style="text-align: center; width:250px;">วัน/เวลาสั่งอาหาร</th>
                    <th style="text-align:right">ราคา (บาท)</th>
                    <th style="text-align:left; width:180px;">สถานะ</th>
                    <th style="text-align:center; width:160px; ">แจ้งหลักฐาน</th>
                    <th style=" text-align:center; width:170px;">รายละเอียดการสั่ง</th>
                </thead>

                <?php
                include('conf/connection.php');
                $sql = "SELECT * FROM orders WHERE cusid = '" . $_SESSION['user_id'] . "' AND orderid LIKE '%" . $strKeyword . "%'";
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
                        switch ($result['order_status']) {
                            case 0:
                                $order_status = "<span style='color:orange'>ยังไม่แจ้งชำระ</span>";
                                break;
                            case 1:
                                $order_status = "<span style='color:#0072EE'>รอการตรวจสอบ</span>";
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
                            <td align="right"> <?= number_format($result["order_totalprice"], 2) ?></td>
                            <td><?= $order_status ?></td>
                            <td align="center"><?php if (($result['order_status'] == 0)) { ?>
                                    <a href="order_payment.php?oid=<?= $result['orderid'] ?>" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> แจ้งหลักฐาน</a>
                                <?php } elseif ($result['order_status'] == 1 || $result['order_status'] == 2) { ?>
                                    <?php if ($result['order_status'] == 2 && empty($result['order_evidence'])) {
                                                        echo "-";
                                                    } else { ?>
                                        <a href="#img_<?= $result['orderid'] ?>" data-toggle="modal"><img height="70px" style="border: 1px solid;" width="50px" src="<?= $result['order_evidence'] ?>"></a>
                                        <div class="modal fade" id="img_<?php echo $result['orderid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="col-md-3"></div>
                                                        <div class="col-md-6">
                                                            <h4 class="modal-title" id="myModalLabel">หลักฐานการชำระ</h4>
                                                        </div>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <img height="400px" width="300px" src="<?= $result['order_evidence'] ?>">
                                                            <hr>
                                                            <div class="col-md-7 col-md-offset-2">
                                                                <label>วันที่แจ้งหลักฐาน : &nbsp; </label><?= dt_tothaiyear($result['order_evidence_date']) ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                <?php }
                             } else echo "-"; ?>
                            </td>
                            <td align="center"><a href="order_detailed.php?oid=<?= $result['orderid'] ?>" class="btn btn-primary"><i class="fa fa-search-plus"></i> ดูรายละเอียด</a></td>
                        </tr>
                <?php }
                } else {
                    echo '
            <tr>
                <td colspan="6" align="center">ไม่พบข้อมูลในระบบ</td>
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
    <?php include("conf/footer.php"); ?>
</body>