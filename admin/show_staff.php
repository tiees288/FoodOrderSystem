<head>
    <title>แสดง/ลบข้อมูลพนักงาน | Food Order System</title>
    <?php
    if (!isset($_SESSION)) {  // Check if sessio nalready start
        session_start();
    }

    if ((!isset($_SESSION['staff']) || ($_SESSION['staff_level'] != 1))) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
    }
    ?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php
    include("conf/header_admin.php");
    require_once("../conf/connection.php");
    require_once("../conf/function.php");

    $strKeyword = null;
    $search_type = null;
    if (isset($_POST["search_staff"])) {
        $strKeyword = $_POST["search_staff"];
    }
    if (isset($_GET["search_staff"])) {
        $strKeyword = $_GET["search_staff"];
    }
    if (isset($_POST["search_type"])) {
        $search_type = $_POST["search_type"];
    }
    if (isset($_GET["search_type"])) {
        $search_type = $_GET["search_type"];
    }
    ?>
    <div class="container" style="padding-top: 135px; left: 50%; ">

        <h1 class="page-header text-left">แสดง/ลบข้อมูลพนักงาน</h1>
        <form class="form-inline">
            <div class="col-md-2">
                <a href="addstaff.php" class="btn btn-success"><i class="glyphicon glyphicon-plus" style="font-size:14px"></i> เพิ่มข้อมูล</a>
            </div>
            <div class="col-md-6 col-md-offset-4">
                <div class="form-group">
                    <select class="form-control input-md" name="search_type" style="width:220px;">
                        <option disabled selected value="">- เลือกข้อมูลที่ต้องการค้นหา -</option>
                        <option value="">ทั้งหมด</option>
                        <option <?php if ($search_type == "staffid") {
                                    echo "selected";
                                } ?> value="staffid">รหัสพนักงาน</option>
                        <option <?php if ($search_type == "staff_name") {
                                    echo "selected";
                                } ?> value="staff_name">ชื่อ-นามสกุล</option>
                        <option <?php if ($search_type == "staff_tel") {
                                    echo "selected";
                                } ?> value="staff_tel">เบอร์โทรศัพท์</option>
                        <option <?php if ($search_type == "staff_email") {
                                    echo "selected";
                                } ?> value="staff_email">อีเมล</option>
                        <option <?php if ($search_type == "staff_status") {
                                    echo "selected";
                                } ?> value="staff_status">สถานะ</option>
                    </select>

                    <input class="form-control" type="text" name="search_staff" placeholder="ค้นหาข้อมูลพนักงาน" style="width:220px;" aria-label="Search">
                </div>
                <button type="submit" class="btn btn-success mb-2">ค้นหา</button>
            </div><br><br>
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" align="center" id="staff_table">
                <thead>
                    <th style="text-align:right; width:130px;">รหัสพนักงาน</th>
                    <th style="text-align: left; width:250px;">ชื่อ-นามสกุล</th>
                    <th style="text-align:left; width:170px;">เบอร์โทรศัพท์</th>
                    <th style="text-align:left; width:250px;">อีเมล</th>
                    <th style="text-align:left; width:200px;">สถานะ</th>
                    <th style=" text-align:center;">แก้ไข</th>
                    <th style=" text-align:center;">ลบ</th>
                </thead>
        </div>
        <?php
        //include('conf/connection.php');
        if ($search_type == "" || $search_type == null) {
            $sql = "SELECT * FROM staff WHERE staffid LIKE '%" . $strKeyword . "%' OR staff_name LIKE '%" . $strKeyword . "%' OR staff_tel LIKE '%" . $strKeyword . "%' OR staff_email LIKE '%" . $strKeyword . "%'";
        } else {
            if ($search_type == "staff_status") {
                //echo $strKeyword;
                if (preg_match("/ทำงาน/i", $strKeyword)) {
                    $strKeyword = 0;
                } else if (preg_match("/ลาออก/i", $strKeyword)) {
                    $strKeyword = 1;
                }
            }
            $sql = "SELECT * FROM staff WHERE $search_type LIKE '%" . $strKeyword . "%'";
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

        $sql .= " ORDER BY staffid DESC LIMIT $row_start ,$row_end ";
        $query = mysqli_query($link, $sql);

        if ($num_rows > 0) { // ค้นหพบรายการอาหาร ให้แสดง
            while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                switch ($result['staff_status']) {
                    case 0:
                        $staff_status = "<span style='color:#12BB4F';>ทำงาน</span>";
                        break;
                    case 1:
                        $staff_status = "<span style='color:red'>ลาออก</span>";
                        break;
                    default:
                        echo "Error";
                }

                if ($result["staff_email"] == "") {
                    $staff_email = "-";
                } else {
                    $staff_email = $result["staff_email"];
                }

                if ($result["staff_tel"] == "") {
                    $staff_tel = "-";
                } else {
                    $staff_tel = $result["staff_tel"];
                }
        ?>
                <tr>
                    <td align="right"><?= $result["staffid"]; ?></td>
                    <td align="left"> <?= $result["staff_name"] ?></td>
                    <td align="left"> <?= $staff_tel; ?></td>
                    <td align="left"> <?= $staff_email ?></td>
                    <td><?= $staff_status ?></td>
                    <td align="center"><a href="editstaff.php?staffid=<?php echo $result['staffid']; ?>" class="btn btn-primary" data-toggle="modal"><i class="fa fa-pencil"></i> แก้ไข</a>

                    </td>
                    <td align="center"><a href="#deletestaff<?php echo $result['staffid']; ?>" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash"></i> ลบ</a></td>
                    <?php include("staff_modal.php"); ?>
                </tr>
        <?php }
        } else {
            include("staff_modal.php");
            echo '
            <tr>
                <td colspan="7" align="center">ไม่พบข้อมูลในระบบ</td>
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
                    echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$prev_page&search_staff=$strKeyword&search_type=$search_type'>ก่อนหน้า</a></li>";
                } else {
                    // ทำให้คลิกไม่ได้
                    echo '<li class="page-item disabled"><a href="#" >ก่อนหน้า</a></li>';
                }

                for ($i = 1; $i <= $num_pages; $i++) {
                    if ($i != $page) {
                        echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=$i&search_staff=$strKeyword&search_type=$search_type'>$i</a>" . '</li>';
                    } else {
                        echo '<li class="page-item active"><a href="#">' . $i . '</a></li>';
                    }
                }
                if ($page != $num_pages) {
                    echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$next_page&search_staff=$strKeyword&search_type=$search_type'>ถัดไป</a></li>";
                } else {
                    echo '<li class="page-item disabled">' . "<a href ='#'>ถัดไป</a></li> ";
                }
                $conn = null;
                ?>
        </div>
    </nav>
    </div>
</body>