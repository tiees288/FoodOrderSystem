<head>
    <title>แสดง/ลบข้อมูลรายการอาหาร | Food Order System</title>
    <?php
    if (!isset($_SESSION)) {  // Check if sessio nalready start
        session_start();
    }

    if ((!isset($_SESSION['staff']))) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
    }
    ?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php
    if (!isset($_SESSION['staff'])) {
        echo "<script>alear('กรุณาเข้าสู่ระบบ'); window.location.assign('login.php')</script>>";
    }
    include("conf/header_admin.php");
    include("../conf/connection.php");

    $strKeyword = null;
    $search_type = null;
    if (isset($_POST["search_food"])) {
        $strKeyword = $_POST["search_food"];
    }
    if (isset($_GET["search_food"])) {
        $strKeyword = $_GET["search_food"];
    }
    if (isset($_POST["search_type"])) {
        $search_type = $_POST["search_type"];
    }
    if (isset($_GET["search_type"])) {
        $search_type = $_GET["search_type"];
    }
    ?>
    <div class="container" style="padding-top: 135px;">

        <h1 class="page-header text-left">แสดง/ลบข้อมูลรายการอาหาร</h1>
        <form class="form-inline">
            <div class="col-md-2">
                <a href="addfood.php" class="btn btn-success"><i class="glyphicon glyphicon-plus" style="font-size:14px"></i> เพิ่มข้อมูล</a>
            </div>
            <div class="col-md-6 col-md-offset-4">
                <div class="form-group">
                    <select class="form-control input-md" name="search_type" style="width:220px;">
                        <option disabled selected value="">- เลือกข้อมูลที่ต้องการค้นหา -</option>
                        <option value="">ทั้งหมด</option>
                        <option <?php if ($search_type == "foodid") {
                                    echo "selected";
                                } ?> value="foodid">รหัสรายการอาหาร</option>
                        <option <?php if ($search_type == "food_name") {
                                    echo "selected";
                                } ?> value="food_name">ชื่อรายการอาหาร</option>
                        <option <?php if ($search_type == "food_count") {
                                    echo "selected";
                                } ?> value="food_count">หน่วยนับ</option>
                        <option <?php if ($search_type == "food_price") {
                                    echo "selected";
                                } ?> value="food_price">ราคา</option>
                        <option <?php if ($search_type == "food_status") {
                                    echo "selected";
                                } ?> value="food_status">สถานะ</option>
                    </select>
                    <input class="form-control" type="text" name="search_food" placeholder="ค้นหาข้อมูลรายการอาหาร" style="width:220px;" aria-label="Search">
                </div>
                <button type="submit" class="btn btn-success mb-2">ค้นหา</button>

            </div><br><br>
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" align="center">
                <thead>
                    <th style="text-align:right; width:150px;">รหัสรายการอาหาร</th>
                    <th style="text-align: left; width:180px;">ชื่อรายการอาหาร</th>
                    <th style="width:100px;">หน่วยนับ</th>
                    <th style="text-align:right; width:120px;">ราคา (บาท)</th>
                    <th style="text-align:center; width:26px;">รูปภาพ</th>
                    <th style="text-align:left; width:100px;">สถานะ</th>
                    <th style="text-align:center; width:130px;">เพิ่มจำนวน</th>
                    <th style=" text-align:center;">แก้ไข</th>
                    <th style=" text-align:center;">ลบ</th>
                </thead>
        </div>
        <?php
        //include('conf/connection.php');
        if ($search_type == "" || $search_type == null) {
            $sql = "SELECT * FROM foods WHERE foodid LIKE '%" . $strKeyword . "%' OR food_name LIKE '%" . $strKeyword . "%' OR food_price LIKE '%" . $strKeyword . "%'";
        } else {
            if ($search_type == "food_status") {
                //echo $strKeyword;
                if (preg_match("/ใช้งาน/i", $strKeyword)) {
                    $strKeyword = 0;
                } else if (preg_match("/ยกเลิก/i", $strKeyword)) {
                    $strKeyword = 1;
                }
            }
            $sql = "SELECT * FROM foods WHERE $search_type LIKE '%" . $strKeyword . "%'";
        }

        $query = mysqli_query($link, $sql);

        $num_rows = mysqli_num_rows($query);

        $per_page = 5;   // จำนวนข้อมูลต่อหน้า
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

        $sql .= " ORDER BY foodid DESC LIMIT $row_start ,$row_end ";
        $query = mysqli_query($link, $sql);

        if ($num_rows > 0) { // ค้นหพบรายการอาหาร ให้แสดง
            while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                switch ($result['food_status']) {
                    case 0:
                        $food_status = "<span style='color:#12BB4F';>ใช้งาน</span>";
                        break;
                    case 1:
                        $food_status = "<span style='color:red'>ยกเลิก</span>";
                        break;
                    default:
                        echo "Error";
                }
                if ($result['food_image'] == "")
                    $food_img = "../images/default_food.png";
                else $food_img = "../" . $result['food_image'];
                ?>

                    <tr>
                        <td align="right"><?= $result["foodid"]; ?></td>
                        <td align="left"> <?= $result["food_name"] ?></td>
                        <td><?= $result['food_count'] ?></td>
                        <td align="right"> <?= number_format($result["food_price"], 2); ?></td>
                        <td align="center"><img width="140px" height="100px" src="<?= $food_img ?>"></td>
                        <td><?= $food_status ?></td>
                        <td align="center"><a href="#morefood<?= $result['foodid'] ?>" class="btn btn-primary"><i class="fa fa-refresh"></i> เพิ่มจำนวน</a></td>
                        <td align="center"><a href="editfood.php?foodid=<?php echo $result['foodid']; ?>" class="btn btn-primary" data-toggle="modal"><i class="fa fa-pencil"></i> แก้ไข</a>
                        </td>
                        <td align="center"><a href="#deletefood<?php echo $result['foodid']; ?>" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash"></i> ลบ</a></td>
                        <?php include("food_modal.php"); ?>
                    </tr>
            <?php }
            } else {
                echo '
            <tr>
                <td colspan="8" align="center">ไม่พบข้อมูลในระบบ</td>
            </tr>
        ';
            }
            if ($num_rows == 0) {
                include("food_modal.php");
            } ?>
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