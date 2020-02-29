<head>
    <title>แสดง/ลบข้อมูลสมาชิก | Food Order System</title>
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
    include("conf/header_admin.php");
    include("../conf/connection.php");
    include("../conf/function.php");

    $strKeyword = null;
    $search_type = null;

    if (isset($_POST["search_customer"])) {
        $strKeyword = $_POST["search_customer"];
    }
    if (isset($_GET["search_customer"])) {
        $strKeyword = $_GET["search_customer"];
    }
    if (isset($_POST["search_type"])) {
        $search_type = $_POST["search_type"];
    }
    if (isset($_GET["search_type"])) {
        $search_type = $_GET["search_type"];
    }
    ?>
    <div class="container" style="padding-top: 135px;">

        <h1 class="page-header text-left">แสดง/ลบข้อมูลสมาชิก</h1>
        <form class="form-inline">
            <div class="col-md-2">
                <a href="addcustomer.php" class="btn btn-success"><i class="glyphicon glyphicon-plus" style="font-size:14px"></i> เพิ่มข้อมูล</a>
            </div>
            <div class="col-md-6 col-md-offset-4">
                <div class="form-group">
                    <select class="form-control input-md" name="search_type" style="width:220px;">
                        <option disabled selected value="">- เลือกข้อมูลที่ต้องการค้นหา -</option>
                        <option value="">ทั้งหมด</option>
                        <option <?php if ($search_type == "cusid") {
                                    echo "selected";
                                } ?> value="cusid">รหัสลูกค้า</option>
                        <option <?php if ($search_type == "cus_name") {
                                    echo "selected";
                                } ?> value="cus_name">ชื่อ-นามสกุล</option>
                        <option <?php if ($search_type == "cus_tel") {
                                    echo "selected";
                                } ?> value="cus_tel">เบอร์โทรศัพท์</option>
                        <option <?php if ($search_type == "cus_email") {
                                    echo "selected";
                                } ?> value="cus_email">อีเมล</option>
                        <option <?php if ($search_type == "cus_status") {
                                    echo "selected";
                                } ?> value="cus_status">สถานะ</option>
                    </select>

                    <input class="form-control" type="text" name="search_customer" placeholder="ค้นหาข้อมูลสมาชิก" style="width:220px;" aria-label="Search">
                </div>
                <button type="submit" class="btn btn-success mb-2">ค้นหา</button>
            </div><br><br>
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" align="center">
                <thead>
                    <th style="text-align:right; width:130px;">รหัสลูกค้า</th>
                    <th style="text-align: left; width:240px;">ชื่อ-นามสกุล</th>
                    <th style="text-align:left; width:170px;">เบอร์โทรศัพท์</th>
                    <th style="text-align:left; width:230px;">อีเมล</th>
                    <th style="text-align:left; width:180px;">สถานะ</th>
                    <th style=" text-align:center;">แก้ไข</th>
                    <th style=" text-align:center;">ลบ</th>
                </thead>
        </div>
        <?php
        //include('conf/connection.php');
        if ($search_type == "" || $search_type == null) {
            $sql = "SELECT * FROM customers WHERE cusid LIKE '%" . $strKeyword . "%' OR cus_name LIKE '%" . $strKeyword . "%' OR cus_tel LIKE '%" . $strKeyword . "%' OR cus_email LIKE '%" . $strKeyword . "%'";
        } else {
            if ($search_type == "cus_status") {
                //echo $strKeyword;
                if (preg_match("/ลูกค้าปกติ/i", $strKeyword) || preg_match("/ปกติ/i", $strKeyword)) {
                    $strKeyword = 0;
                } else if (preg_match("/บัญชีดำ/i", $strKeyword)) {
                    $strKeyword = 1;
                }
            }
            $sql = "SELECT * FROM customers WHERE $search_type LIKE '%" . $strKeyword . "%'";
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

        $sql .= " ORDER BY cusid DESC LIMIT $row_start ,$row_end ";
        $query = mysqli_query($link, $sql);

        if ($num_rows > 0) { // ค้นหพบรายการอาหาร ให้แสดง
            while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                switch ($result['cus_status']) {
                    case 0:
                        $cus_status = "<span style='color:#12BB4F';>ลูกค้าปกติ</span>";
                        break;
                    case 1:
                        $cus_status = "<span style='color:red'>บัญชีดำ</span>";
                        break;
                    default:
                        echo "Error";
                } ?>
                <tr>
                    <td align="right"><?= $result["cusid"]; ?></td>
                    <td align="left"> <?= $result["cus_name"] ?></td>
                    <td align="left"> <?= $result["cus_tel"]; ?></td>
                    <td align="left"> <?= ($result["cus_email"] == "") ? "-" : $result["cus_email"] ?></td>
                    <td><?= $cus_status ?></td>
                    <td align="center"><a href="editcustomer.php?cusid=<?php echo $result['cusid']; ?>" class="btn btn-primary" data-toggle="modal"><i class="fa fa-pencil"></i> แก้ไข</a>

                    </td>
                    <td align="center"><a href="#deletecustomer<?php echo $result['cusid']; ?>" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash"></i> ลบ</a></td>
                    <?php include("customer_modal.php"); ?>
                </tr>
        <?php }
        } else {
            include("customer_modal.php");
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
                if ($page == 1) {
                    echo '<li class="page-item disabled">' . " <a href='#'><<</a></li>";
                } else {
                    echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=1&search_customer=$strKeyword&search_type=$search_type''><<</a></li>";
                }
                if ($prev_page) {
                    echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$prev_page&search_customer=$strKeyword&search_type=$search_type'>ก่อนหน้า</a></li>";
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
                                    echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=" . ($page + $i) . "&search_customer=$strKeyword&search_type=$search_type'>" . ($page + $i) . "</a>" . '</li>';
                                }
                            } else { // กรณีหน้าสุดท้าย
                                if ($page == $num_pages) {
                                    $offset = $num_pages - ($num_pages - 4);
                                }

                                for ($i = 0; $i <= 2, (($page - $offset) <= $num_pages); $i++) {

                                    if ($page - $offset == $page) {
                                        echo '<li class="page-item active"><a href="#">' . ($page - $offset) . '</a></li>';
                                    } else {
                                        echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=" . ($page - $offset) . "&search_customer=$strKeyword&search_type=$search_type'>" . ($page - $offset) . "</a>" . '</li>';
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
                                echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=$i&search_customer=$strKeyword&search_type=$search_type'>$i</a>" . '</li>';
                            }
                        }
                    }
                } else {
                    // เงื่อนไขเดิม ก่อนทำ Pagination เพิ่ม
                    for ($i = 1; $i <= $num_pages; $i++) {
                        if ($i != $page) {
                            echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=$i&search_customer=$strKeyword&search_type=$search_type'>$i</a>" . '</li>';
                        } else {
                            echo '<li class="page-item active"><a href="#">' . $i . '</a></li>';
                        }
                    }
                }
                // ------------------------------------------------------------------------
                if ($page != $num_pages) {
                    echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$next_page&search_customer=$strKeyword&search_type=$search_type'>ถัดไป</a></li>";
                } else {
                    echo '<li class="page-item disabled">' . "<a href ='#'>ถัดไป</a></li> ";
                }
                if ($page == $num_pages) { // ปุ่มหน้าสุดท้าย
                    echo '<li class="page-item disabled">' . " <a href='#'>>></a></li>";
                } else {
                    echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=" . $num_pages . "&search_customer=$strKeyword&search_type=$search_type'>>></a></li>";
                }
                $conn = null;
                ?>
        </div>
    </nav>
    </div>






</body>