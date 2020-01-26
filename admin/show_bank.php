<head>
    <title>แสดง/ลบข้อมูลธนาคาร | Food Order System</title>
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
    if (isset($_POST["search_bank"])) {
        $strKeyword = $_POST["search_bank"];
    }
    if (isset($_GET["search_bank"])) {
        $strKeyword = $_GET["search_bank"];
    }
    if (isset($_POST["search_type"])) {
        $search_type = $_POST["search_type"];
    }
    if (isset($_GET["search_type"])) {
        $search_type = $_GET["search_type"];
    }
    ?>
    <div class="container" style="padding-top: 135px; left: 50%; ">

        <h1 class="page-header text-left">แสดง/ลบข้อมูลธนาคาร</h1>
        <form class="form-inline">
            <div class="col-md-2">
                <a href="addbank.php" class="btn btn-success"><i class="glyphicon glyphicon-plus" style="font-size:14px"></i> เพิ่มข้อมูล</a>
            </div>
            <div class="col-md-6 col-md-offset-4">
                <div class="form-group">
                    <select class="form-control input-md" name="search_type" style="width:220px;">
                        <option disabled selected value="">- เลือกข้อมูลที่ต้องการค้นหา -</option>
                        <option value="">ทั้งหมด</option>
                        <option <?php if ($search_type == "bankid") {
                                    echo "selected";
                                } ?> value="bankid">รหัสธนาคาร</option>
                        <option <?php if ($search_type == "bank_name") {
                                    echo "selected";
                                } ?> value="bank_name">ชื่อธนาคาร</option>
                        <option <?php if ($search_type == "bank_branch") {
                                    echo "selected";
                                } ?> value="bank_branch">สาขา</option>
                        <option <?php if ($search_type == "bank_status") {
                                    echo "selected";
                                } ?> value="bank_status">สถานะ</option>
                    </select>
                    <input class="form-control" type="text" name="search_bank" placeholder="ค้นหารข้อมูลธนาคาร" style="width:220px;" aria-label="Search">
                </div>
                <button type="submit" class="btn btn-success mb-2">ค้นหา</button>

            </div><br><br>

        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" align="center">
                <thead>
                    <th style="text-align: right; width:120px;">รหัสธนาคาร</th>
                    <th style="text-align: left; width:150px;">ชื่อธนาคาร</th>
                    <th style="text-align:left; width:220px;">สาขา</th>
                    <th style="text-align:left; width:120px;">สถานะ</th>
                    <th style=" text-align:center; width:110px;">แก้ไข</th>
                    <th style=" text-align:center; width:110px;">ลบ</th>
                </thead>
        </div>
        <?php
        //include('conf/connection.php');
        if ($search_type == "" || $search_type == null) {
            $sql = "SELECT * FROM banks WHERE bankid LIKE '%" . $strKeyword . "%' OR bank_branch LIKE '%" . $strKeyword . "%' OR bank_name LIKE '%" . $strKeyword . "%' OR bank_branch LIKE '%" . $strKeyword . "%'";
        } else {
            if ($search_type == "bank_status") {
                //echo $strKeyword;
                if (preg_match("/ใช้งาน/i", $strKeyword)) {
                    $strKeyword = 0;
                } else if (preg_match("/ไม่ใช้งาน/i", $strKeyword)) {
                    $strKeyword = 1;
                }
            }
            $sql = "SELECT * FROM banks WHERE $search_type LIKE '%" . $strKeyword . "%'";
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

        $sql .= " ORDER BY bankid DESC LIMIT $row_start ,$row_end ";
        $query = mysqli_query($link, $sql);

        if ($num_rows > 0) { // ค้นหพบรายการอาหาร ให้แสดง
            while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                switch ($result['bank_status']) {
                    case 0:
                        $bank_status = "<span style='color:#12BB4F';>ใช้งาน</span>";
                        break;
                    case 1:
                        $bank_status = "<span style='color:red'>ไม่ใช้งาน</span>";
                        break;
                    default:
                        echo "Error";
                } ?>
                    <tr>
                        <td align="right"><?= $result["bankid"]; ?></td>
                        <td align="left"> <?= $result["bank_name"] ?></td>
                        <td align="left"> <?= $result["bank_branch"] ?></td>
                        <td><?= $bank_status ?></td>
                        <td align="center"><a href="editbank.php?bankid=<?php echo $result['bankid']; ?>" class="btn btn-primary" data-toggle="modal"><i class="fa fa-pencil"></i> แก้ไข</a>

                        </td>
                        <td align="center"><a href="#deletebank<?php echo $result['bankid']; ?>" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash"></i> ลบ</a></td>
                        <?php include("bank_modal.php"); ?>
                    </tr>
            <?php }
            } else {
                include("bank_modal.php");
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
                        echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=$i&search_bank=$strKeyword&search_type=$search_type'>$i</a>" . '</li>';
                    } else {
                        echo '<li class="page-item active"><a href="#">' . $i . '</a></li>';
                    }
                }
                if ($page != $num_pages) {
                    echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$next_page&search_bank=$strKeyword&search_type=$search_type'>ถัดไป</a></li>";
                } else {
                    echo '<li class="page-item disabled">' . "<a href ='#'>ถัดไป</a></li> ";
                }
                $conn = null;
                ?>
        </div>
    </nav>
    </div>






</body>