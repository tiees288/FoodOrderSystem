<head>
    <title>แสดง/ลบข้อมูลโต๊ะ | Food Order System</title>
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
    include("../conf/connection.php");

    $strKeyword = null;
    $search_type = null;

    if (isset($_POST["search_tables"])) {
        $strKeyword = $_POST["search_tables"];
    }
    if (isset($_GET["search_tables"])) {
        $strKeyword = $_GET["search_tables"];
    }
    if (isset($_POST["search_type"])) {
        $search_type = $_POST["search_type"];
    }
    if (isset($_GET["search_type"])) {
        $search_type = $_GET["search_type"];
    }

    ?>
    <div class="container" style="padding-top: 135px; left: 50%; ">

        <h1 class="page-header text-left">แสดง/ลบข้อมูลโต๊ะ</h1>
        <form class="form-inline">
            <div class="col-md-2">
                <a href="addtable.php" class="btn btn-success"><i class="glyphicon glyphicon-plus" style="font-size:14px"></i> เพิ่มข้อมูล</a>
            </div>
            <div class="col-md-6 col-md-offset-4">
                <div class="form-group">
                    <select class="form-control input-md" name="search_type" style="width:220px;">
                        <option disabled selected value="">- เลือกข้อมูลที่ต้องการค้นหา -</option>
                        <option value="">ทั้งหมด</option>
                        <option <?php if ($search_type == "tables_no") {
                                    echo "selected";
                                } ?> value="tables_no">หมายเลขโต๊ะ</option>
                        <option <?php if ($search_type == "tanles_seats") {
                                    echo "selected";
                                } ?> value="tables_seats">จำนวนที่นั่ง</option>
                        <option <?php if ($search_type == "tables_status_use") {
                                    echo "selected";
                                } ?> value="tables_status_use">สถานะ</option>
                    </select>
                    <input class="form-control" type="text" name="search_tables" placeholder="ค้นหาข้อมูลโต๊ะ" style="width:220px;" aria-label="Search">
                </div>
                <button type="submit" class="btn btn-success mb-2">ค้นหา</button>
            </div><br><br>
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" align="center">
                <thead>
                    <th style="text-align:right; width:130px;">หมายเลขโต๊ะ</th>
                    <th style="text-align: right; width:250px;">จำนวนที่นั่ง (คน)</th>
                    <th style="text-align:left; width:170px;">สถานะ</th>
                    <th style=" text-align:center; width:140px;">แก้ไข</th>
                    <th style=" text-align:center; width:140px;">ลบ</th>
                </thead>
        </div>
        <?php
        //include('conf/connection.php');
        if ($search_type == "" || $search_type == null) {
            $sql = "SELECT * FROM tables WHERE tables_no LIKE '%" . $strKeyword . "%' OR tables_seats LIKE '%" . $strKeyword . "%' ";
        } else {
            if ($search_type == "tables_status_use") {
                //echo $strKeyword;
                if (preg_match("/โต๊ะว่าง/i", $strKeyword) || preg_match("/ปกติ/i", $strKeyword)) {
                    $strKeyword = 0;
                } else if (preg_match("/โต๊ะไม่ว่าง/i", $strKeyword)) {
                    $strKeyword = 1;
                }
            }
            $sql = "SELECT * FROM tables WHERE $search_type LIKE '%" . $strKeyword . "%'";
        }

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

        $sql .= " ORDER BY tables_no DESC LIMIT $row_start ,$row_end ";
        $query = mysqli_query($link, $sql);

        if ($num_rows > 0) { // ค้นหพบรายการอาหาร ให้แสดง
            while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                switch ($result['tables_status_use']) {
                    case 0:
                        $tables_status_use = "<span style='color:#12BB4F';>โต๊ะว่าง</span>";
                        break;
                    case 1:
                        $tables_status_use = "<span style='color:red'>โต๊ะไม่ว่าง</span>";
                        break;
                    default:
                        echo "Error";
                } ?>
                    <tr>
                        <td align="right"><?= $result["tables_no"]; ?></td>
                        <td align="right"> <?= $result["tables_seats"] ?></td>
                        <td><?= $tables_status_use ?></td>
                        <td align="center"><a href="edittable.php?tables_no=<?php echo $result['tables_no']; ?>" class="btn btn-primary" data-toggle="modal"><i class="fa fa-pencil"></i> แก้ไข</a>

                        </td>
                        <td align="center"><a href="#deletetables<?php echo $result['tables_no']; ?>" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash"></i> ลบ</a></td>
                        <?php include("table_modal.php"); ?>
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
                    echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$prev_page&search_food=$strKeyword&search_type=$search_type'>ก่อนหน้า</a></li>";
                } else {
                    // ทำให้คลิกไม่ได้
                    echo '<li class="page-item disabled"><a href="#" >ก่อนหน้า</a></li>';
                }

                for ($i = 1; $i <= $num_pages; $i++) {
                    if ($i != $page) {
                        echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=$i&search_food=$strKeyword&search_type=$search_type'>$i</a>" . '</li>';
                    } else {
                        echo '<li class="page-item active"><a href="#">' . $i . '</a></li>';
                    }
                }
                if ($page != $num_pages) {
                    echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$next_page&search_food=$strKeyword&search_type=$search_type'>ถัดไป</a></li>";
                } else {
                    echo '<li class="page-item disabled">' . "<a href ='#'>ถัดไป</a></li> ";
                }
                $conn = null;
                ?>
        </div>
    </nav>
    </div>






</body>