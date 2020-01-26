<head>
    <title>แสดงการจองโต๊ะ | Food Order System</title>
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
    if (isset($_POST["search_reserve"])) {
        $strKeyword = $_POST["search_reserve"];
    }
    if (isset($_GET["search_reserve"])) {
        $strKeyword = $_GET["search_reserve"];
    }
    ?>
    <div class="container" style="padding-top: 90px;">

        <h1 class="page-header text-left">แสดงการจองโต๊ะ</h1>
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
                    <th style="text-align:center; width:160px;">รหัสการจอง</th>
                    <th style="text-align: center; width:210px;">วัน/เวลาจอง</th>
                    <th style="text-align: center; width:190px;">วันที่นัด</th>
                    <th style="text-align: center; width:150px;">เวลาที่นัด</th>
                    <th style="text-align:left; width: 200px;">สถานะ</th>
                    <th style=" text-align:center; width:180px;">รายละเอียดการจอง</th>
                </thead>

                <?php
                include('conf/connection.php');
                $sql = "SELECT * FROM reservations WHERE cusid = '" . $_SESSION['user_id'] . "' AND reserv_id LIKE '%" . $strKeyword . "%'";
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
                                <td><?= $reserv_status ?></td>
                                <td align="center"><a href="reserve_detailed.php?rid=<?= $result['reserv_id'] ?>" class="btn btn-primary"><i class="fa fa-search-plus"></i> ดูรายละเอียด</a></td>
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
</body>
<?php
include("conf/footer.php");
?>