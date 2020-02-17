<head>
    <title>แสดง/ยกเลิกการจอง | Food Order System</title>
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
    include("../conf/function.php");

    $strKeyword = null;
    if (isset($_POST["search_reserve"])) {
        $strKeyword = $_POST["search_reserve"];
    }
    if (isset($_GET["search_reserve"])) {
        $strKeyword = $_GET["search_reserve"];
    }
    ?>
    <div class="container" style="padding-top: 135px;">

        <h1 class="page-header text-left">แสดง/ยกเลิกการจอง</h1>
        <div class="row">
            <form class="form-inline">
                <div class="col-xs-6">
                    <div class="form-group">
                        <input class="form-control" type="text" name="search_reserve" placeholder="ค้นหารหัสการจอง" aria-label="Search">
                        <button type="submit" class="btn btn-success">ค้นหา</button>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" align="center">
                <thead>
                    <th style="text-align:center; width:130px;">รหัสการจอง</th>
                    <th style="text-align: center; width:180px;">วัน/เวลาจอง</th>
                    <th style="text-align: center; width:130px;">วันที่นัด</th>
                    <th style="text-align: center; width:100px;">เวลาที่นัด</th>
                    <th style="text-align:left; width: 250px;">ชื่อลูกค้า</th>
                    <th style="text-align:left; width: 180px;">สถานะ</th>
                    <th style=" text-align:center; width:170px;">ปรับปรุงการจอง</th>
                    <th style=" text-align:center; width:180px;">รายละเอียดการจอง</th>
                </thead>

                <?php
                include('../conf/connection.php');
                $sql = "SELECT * FROM reservations WHERE reserv_id LIKE '%" . $strKeyword . "%'";
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

                $sql .= " ORDER BY reserv_id DESC LIMIT $row_start ,$row_end ";
                $query = mysqli_query($link, $sql);

                if ($num_rows > 0) { // ค้นหพบรายการอาหาร ให้แสดง
                    while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                        // $ordertime = strtotime($result["orderdate"]);

                        $sql_cus = "SELECT cusid, cus_name FROM customers WHERE cusid = '" . $result['cusid'] . "'";

                        $cus_data = mysqli_fetch_assoc(mysqli_query($link, $sql_cus));

                        switch ($result['reserv_status']) {
                            case 0:
                                $reserv_status = "<span style='color:#0072EE'>รอการตรวจสอบ</span>";
                                break;
                            case 1:
                                $reserv_status = "<span style='color:#12BB4F';>ยืนยันการจอง</span>";
                                break;
                            case 2:
                                $reserv_status = "<span style='color:red;'>ยกเลิกการจอง</span>";
                                break;
                            default:
                                echo "Error";
                        } ?>
                        <tr>
                            <td align="center"><?= $result["reserv_id"]; ?></td>
                            <td align="center"> <?= dt_tothaiyear($result['reserv_date_reservation']) ?></td>
                            <td align="center"> <?= tothaiyear($result["reserv_date_appointment"]); ?></td>
                            <td align="center"> <?= substr($result["reserv_time_appointment"], 0, 5) ?></td>
                            <td><?= $cus_data['cus_name'] ?></td>
                            <td><?= $reserv_status ?></td>
                            <td align="center">
                                <?php if ($result['reserv_status'] == 0) { ?>
                                    <a href="reserve_edit.php?rid=<?= $result['reserv_id'] ?>" class="btn btn-primary"><i class="fa fa-pencil"></i> ปรับปรุง</a></td>
                        <?php } ?>
                        <td align="center"><a href="reserve_detailed.php?rid=<?= $result['reserv_id'] ?>" class="btn btn-primary"><i class="fa fa-search-plus"></i> ดูรายละเอียด</a></td>
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
                        echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=1&search_reserve=$strKeyword'><<</a></li>";
                    }
                    if ($prev_page) {
                        echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$prev_page&search_reserve=$strKeyword'>ก่อนหน้า</a></li>";
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
                                        echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=" . ($page + $i) . "&search_reserve=$strKeyword'>" . ($page + $i) . "</a>" . '</li>';
                                    }
                                } else { // กรณีหน้าสุดท้าย
                                    if ($page == $num_pages) {
                                        $offset = $num_pages - ($num_pages - 4);
                                    }

                                    for ($i = 0; $i <= 2, (($page - $offset) <= $num_pages); $i++) {

                                        if ($page - $offset == $page) {
                                            echo '<li class="page-item active"><a href="#">' . ($page - $offset) . '</a></li>';
                                        } else {
                                            echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=" . ($page - $offset) . "&search_reserve=$strKeyword'>" . ($page - $offset) . "</a>" . '</li>';
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
                                    echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=$i&search_reserve=$strKeyword'>$i</a>" . '</li>';
                                }
                            }
                        }
                    } else {
                        for ($i = 1; $i <= $num_pages; $i++) {
                            if ($i != $page) {
                                echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=$i&search_reserve=$strKeyword'>$i</a>" . '</li>';
                            } else {
                                echo '<li class="page-item active"><a href="#">' . $i . '</a></li>';
                            }
                        }
                    }
                    //----------------------------------------------------------------------------------

                    if ($page != $num_pages) {
                        echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$next_page&search_reserve=$strKeyword'>ถัดไป</a></li>";
                    } else {
                        echo '<li class="page-item disabled">' . "<a href ='#'>ถัดไป</a></li> ";
                    }
                    if ($page == $num_pages) { // ปุ่มหน้าสุดท้าย
                        echo '<li class="page-item disabled">' . " <a href='#'>>></a></li>";
                    } else {
                        echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=" . $num_pages . "&search_reserve=$strKeyword'>>></a></li>";
                    }
                    ?>
            </div>
        </nav>
    </div>
</body>