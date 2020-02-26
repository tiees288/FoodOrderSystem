<head>
    <title>แสดง/ลบข้อมูลวัตถุดิบ | Food Order System</title>
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

    $search_type = null;
    $strKeyword = null;
    if (isset($_POST["search_materials"])) {
        $strKeyword = $_POST["search_materials"];
    }
    if (isset($_GET["search_materials"])) {
        $strKeyword = $_GET["search_materials"];
    }
    if (isset($_POST["search_type"])) {
        $search_type = $_POST["search_type"];
    }
    if (isset($_GET["search_type"])) {
        $search_type = $_GET["search_type"];
    }
    ?>
    <div class="container" style="padding-top: 135px; left: 50%; ">

        <h1 class="page-header text-left">แสดง/ลบข้อมูลวัตถุดิบ</h1>
        <form class="form-inline">
            <div class="col-md-2">
                <a href="addmaterial.php" class="btn btn-success"><i class="glyphicon glyphicon-plus" style="font-size:14px"></i> เพิ่มข้อมูล</a>
            </div>
            <div class="col-md-6 col-md-offset-4">
                <div class="form-group">
                    <select class="form-control input-md" name="search_type" style="width:220px;">
                        <option disabled selected value="">- เลือกข้อมูลที่ต้องการค้นหา -</option>
                        <option value="">ทั้งหมด</option>
                        <option <?php if ($search_type == "materialid") {
                                    echo "selected";
                                } ?> value="materialid">รหัสวัตถุดิบ</option>
                        <option <?php if ($search_type == "material_name") {
                                    echo "selected";
                                } ?> value="material_name">ชื่อวัตถุดิบ</option>
                        <option <?php if ($search_type == "material_count") {
                                    echo "selected";
                                } ?> value="material_count">หน่วยนับ</option>
                        <option <?php if ($search_type == "material_status") {
                                    echo "selected";
                                } ?> value="material_status">สถานะ</option>
                    </select>
                    <input class="form-control" type="text" name="search_materials" placeholder="ค้นหารหัสหรือชื่อวัตถุดิบ" style="width:220px;" aria-label="Search">
                </div>
                <button type="submit" class="btn btn-success mb-2">ค้นหา</button>
            </div><br><br>
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" align="center">
                <thead>
                    <th style="text-align:right; width:130px;">รหัสวัตถุดิบ</th>
                    <th style="text-align: left; width:250px;">ชื่อวัตถุดิบ</th>
                    <th style="width:170px;">หน่วยนับ</th>
                    <th style="text-align:left; width:170px;">สถานะ</th>
                    <th style="text-align:center; width:130px;">เพิ่มจำนวน</th>
                    <th style=" text-align:center; width:130px;">แก้ไข</th>
                    <th style=" text-align:center; width:130px;">ลบ</th>
                </thead>
        </div>
        <?php
        //include('conf/connection.php');

        if ($search_type == "" || $search_type == null) {
            $sql = "SELECT * FROM materials WHERE materialid LIKE '%" . $strKeyword . "%' OR material_name LIKE '%" . $strKeyword . "%'";
        } else {
            if ($search_type == "material_status") {
                //echo $strKeyword;
                if (preg_match("/ใช้งาน/i", $strKeyword) || preg_match("/ปกติ/i", $strKeyword)) {
                    $strKeyword = 0;
                } else if (preg_match("/ยกเลิก/i", $strKeyword)) {
                    $strKeyword = 1;
                }
            }
            $sql = "SELECT * FROM materials WHERE $search_type LIKE '%" . $strKeyword . "%'";
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

        $sql .= " ORDER BY materialid DESC LIMIT $row_start ,$row_end ";
        $query = mysqli_query($link, $sql);

        if ($num_rows > 0) { // ค้นหพบรายการอาหาร ให้แสดง
            while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                switch ($result['material_status']) {
                    case 0:
                        $material_status = "<span style='color:#12BB4F';>ใช้งาน</span>";
                        break;
                    case 1:
                        $material_status = "<span style='color:red'>ยกเลิก</span>";
                        break;
                    default:
                        echo "Error";
                } ?>
                    <tr>
                        <td align="right"><?= $result["materialid"]; ?></td>
                        <td align="left"> <?= $result["material_name"] ?></td>
                        <td align="left"> <?= $result["material_count"] ?></td>
                        <td><?= $material_status ?></td>
                        <td align="center"><a href="#morematerial<?= $result['materialid'] ?>" data-toggle="modal" class="btn btn-primary"><i class="fa fa-refresh"></i> เพิ่มจำนวน</a></td>
                        <td align="center"><a href="editmaterial.php?materialid=<?php echo $result['materialid']; ?>" class="btn btn-primary" data-toggle="modal"><i class="fa fa-pencil"></i> แก้ไข</a>

                        </td>
                        <td align="center"><a href="#deletematerial<?php echo $result['materialid']; ?>" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash"></i> ลบ</a></td>
                        <?php include("material_modal.php"); ?>
                    </tr>
            <?php }
            } else {
                include("material_modal.php");
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
                    echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$prev_page&search_materials=$strKeyword&search_type=$search_type'>ก่อนหน้า</a></li>";
                } else {
                    // ทำให้คลิกไม่ได้
                    echo '<li class="page-item disabled"><a href="#" >ก่อนหน้า</a></li>';
                }

                for ($i = 1; $i <= $num_pages; $i++) {
                    if ($i != $page) {
                        echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=$i&search_materials=$strKeyword&search_type=$search_type'>$i</a>" . '</li>';
                    } else {
                        echo '<li class="page-item active"><a href="#">' . $i . '</a></li>';
                    }
                }
                if ($page != $num_pages) {
                    echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$next_page&search_materials=$strKeyword&search_type=$search_type'>ถัดไป</a></li>";
                } else {
                    echo '<li class="page-item disabled">' . "<a href ='#'>ถัดไป</a></li> ";
                }
                $conn = null;
                ?>
        </div>
    </nav>
    </div>






</body>