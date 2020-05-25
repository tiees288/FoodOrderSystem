<head>
    <title>แสดงรายการับชำระ | Food Order System</title>
    <?php
    if (!isset($_SESSION)) {  // Check if sessio nalready start
        session_start();
    }
    ?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php
    include_once("conf/header_admin.php");
    include_once("../conf/function.php");

    $strKeyword = null;
    if (isset($_POST["search_payment"])) {
        $strKeyword = $_POST["search_payment"];
    }
    if (isset($_GET["search_payment"])) {
        $strKeyword = $_GET["search_payment"];
    }
    ?>
    <div class="container" style="padding-top: 135px;">

        <h1 class="page-header text-left">แสดงรายการรับชำระ</h1>
        <div class="row">
            <form class="form-inline">
                <div class="col-xs-6">
                    <div class="form-group">
                        <input class="form-control" type="text" name="search_payment" placeholder="ค้นหาเลขที่ใบเสร็จ" aria-label="Search">
                        <button type="submit" class="btn btn-success">ค้นหา</button>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" align="center">
                <thead>
                    <th style="text-align:center; width:140px;">เลขที่ใบเสร็จ</th>
                    <th style="text-align: center; width:180px;">วันที่ชำระ</th>
                    <th style="text-align:left; width: 250px;">ชื่อลูกค้า</th>
                    <th style="text-align:right; width: 100px;">ยอดชำระ</th>
                    <th style="text-align:left; width: 130px;">สถานะ</th>
                    <th style=" text-align:center; width:155px;">ใบเสร็จรับเงิน</th>
                    <th style=" text-align:center; width:210px;">ยกเลิกใบเสร็จรับเงิน</th>
                </thead>

                <?php
                require_once('../conf/connection.php');
                $sql = "SELECT * FROM payment WHERE payno LIKE '%" . $strKeyword . "%'";
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

                $sql .= " ORDER BY payno DESC LIMIT $row_start ,$row_end ";
                $query = mysqli_query($link, $sql);

                if ($num_rows > 0) { // ค้นหพบรายการอาหาร ให้แสดง
                    while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                        // $ordertime = strtotime($result["orderdate"]);
                        $sql_cus = "SELECT orders.orderid, orders.payno_cancel,customers.cusid, customers.cus_name FROM orders
                            LEFT JOIN customers ON orders.cusid = customers.cusid WHERE orders.payno = '" . $result['payno'] . "'";
                        $query_cusd = mysqli_query($link, $sql_cus) or die(mysqli_error($link));
                        $cus_data = mysqli_fetch_assoc($query_cusd);

                        if (!isset($cus_data['cusid'])) {
                            mysqli_free_result($query_cusd);
                            $sql_cus = "SELECT orders.orderid, orders.payno_cancel, customers.cusid, customers.cus_name FROM orders
                            LEFT JOIN customers ON orders.cusid = customers.cusid WHERE orders.payno_cancel = '" . $result['payno'] . "'";
                            $cus_data = mysqli_fetch_assoc(mysqli_query($link, $sql_cus));
                        }

                        switch ($result['pay_status']) {
                            case 0:
                                $pay_status = "<span style='color:orange'>ยังไม่ชำระ</span>";
                                break;
                            case 1:
                                $pay_status = "<span style='color:#12BB4F';>ชำระแล้ว</span>";
                                break;
                            case 2:
                                $pay_status = "<span style='color:red;'>ยกเลิก</span>";
                                break;
                            default:
                                echo "Error";
                        } ?>
                        <tr>
                            <td align="center"><?= $result["payno"]; ?></td>
                            <td align="center"> <?= dt_tothaiyear($result['pay_date']) ?></td>
                            <td><?= $cus_data['cus_name'] ?></td>
                            <td align="right"><?= number_format($result['payamount'], 2) ?></td>
                            <td><?= $pay_status ?></td>
                            <td align="center">
                                <?php
                                $sql_check_delivery = "SELECT * FROM payment LEFT JOIN orders ON payment.payno = orders.payno WHERE payment.payno = '" . $result['payno'] . "'";
                                $result_delivery = mysqli_fetch_assoc(mysqli_query($link, $sql_check_delivery));

                                ?>
                                <a href="bill_payment.php?bill=<?= $result['payno'] ?>" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> ใบเสร็จรับเงิน</a>
                            </td>
                            <td align="center" height="50px;">
                                <?php
                                if ($result_delivery['pay_status'] != 2) {
                                    $today = date("Y-m-d");
                                    $pay_date = date("Y-m-d", strtotime($result['pay_date'] . ' + 3 days'));
                                    if ($today < $pay_date) { // ตรวจสอบ เกิน 3 วันไม่สามารถยกเลิกใบเสร็จ
                                        $sql_od1 = "SELECT order_type FROM orders WHERE payno = '" . $result['payno'] . "' ";
                                        $query_od1 = mysqli_query($link, $sql_od1);
                                        $result_od1 = mysqli_fetch_assoc($query_od1);
                                        if ($result_od1['order_type'] == 1) {
                                            if ($cus_data['payno_cancel'] == "") {
                                ?>
                                                <a href="staff_cancel_payment.php?pno=<?= $result['payno'] ?>" onclick="if(confirm('ต้องการยกเลิกใบเสร็จรับเงิน เลขที่ <?= $result['payno'] ?> ใช่หรือไม่?')) return true; else return false;" class="btn btn-danger"><i class="fa fa-times"></i> ยกเลิกใบเสร็จรับเงิน
                                                </a>
                                <?php
                                            }
                                        }
                                    }
                                } ?>
                            </td>
                        </tr>
                <?php }
                } else {
                    echo '
            <tr>
                <td colspan="8" align="center">ไม่พบข้อมูลในระบบ</td>
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
                    if ($page == 1) {
                        echo '<li class="page-item disabled">' . " <a href='#'><<</a></li>";
                    } else {
                        echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=1&search_payment=$strKeyword'><<</a></li>";
                    }
                    if ($prev_page) {
                        echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$prev_page&search_payment=$strKeyword'>ก่อนหน้า</a></li>";
                    } else {
                        // ทำให้คลิกไม่ได้
                        echo '<li class="page-item disabled"><a href="#" >ก่อนหน้า</a></li>';
                    }

                    // ---------------------------- Pagination แบบจำกัดจำนวน ---------------------------- //
                    // ----------------- ประกาศตัวแปรที่จำเป็น ----------------------
                    $total_pagination = 5;        // จำนวนเลขหน้าที่แสดงได้สูงสุด
                    $high = floor($total_pagination / 2); // หาร เพื่อหาค่า Mean
                    $low = "-" . $high;
                    if (($page + $high) > $num_pages) {
                        $y = $num_pages + $low;
                    } elseif (($page - $high) < 1) {
                        $y =  $total_pagination;
                    } else {
                        $y = $total_pagination;
                    }
                    // ----------------------------------------------------------
                    if ($page > 4) {
                        if ($page >= $total_pagination - 3) { // กรณีมากกว่าหน้าแรก
                            $offset = 3; // ฮอฟเซทการแสดงผลหน้าสุดท้าย
                            for ($i = $low; $i <= $high; $i++) {
                                if (($page + $high) <= $num_pages) {
                                    if ($page + $i == $page) {
                                        echo '<li class="page-item active"><a href="#">' . ($page + $i) . '</a></li>';
                                    } else {
                                        echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=" . ($page + $i) . "&search_payment=$strKeyword'>" . ($page + $i) . "</a>" . '</li>';
                                    }
                                } else { // กรณีหน้าสุดท้าย
                                    if ($page == $num_pages) {
                                        $offset = $num_pages - ($num_pages - 4);
                                    }

                                    for ($i = 0; $i <= 2, (($page - $offset) <= $num_pages); $i++) {

                                        if ($page - $offset == $page) {
                                            echo '<li class="page-item active"><a href="#">' . ($page - $offset) . '</a></li>';
                                        } else {
                                            echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=" . ($page - $offset) . "&search_payment=$strKeyword'>" . ($page - $offset) . "</a>" . '</li>';
                                        }
                                        $offset--;
                                    }
                                }
                            }
                        } else {
                            for ($i = 1; $i <= $y; $i++) {
                                if ($i == $page) {
                                    echo '<li class="page-item active"><a href="#">' . $i . '</a></li>';
                                } else {
                                    echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=$i&search_payment=$strKeyword'>$i</a>" . '</li>';
                                }
                            }
                        }
                    } else {
                        for ($i = 1; $i <= (($num_pages < 5) ? $num_pages : "5"); $i++) {
                            if ($i != $page) {
                                echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=$i&search_payment=$strKeyword'>$i</a>" . '</li>';
                            } else {
                                echo '<li class="page-item active"><a href="#">' . $i . '</a></li>';
                            }
                        }
                    }
                    // ------------------------------------------------------------------------------------
                    if ($page != $num_pages) {
                        echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$next_page&search_payment=$strKeyword'>ถัดไป</a></li>";
                    } else {
                        echo '<li class="page-item disabled">' . "<a href ='#'>ถัดไป</a></li> ";
                    }
                    if ($page == $num_pages) { // ปุ่มหน้าสุดท้าย
                        echo '<li class="page-item disabled">' . " <a href='#'>>></a></li>";
                    } else {
                        echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=" . $num_pages . "&search_payment=$strKeyword'>>></a></li>";
                    }
                    $conn = null;
                    ?>
            </div>
        </nav>
    </div>
</body>