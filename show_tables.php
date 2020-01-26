<head>
    <title>แสดงโต๊ะ | Food Order System</title>
    <?php
    if (!isset($_SESSION)) {  // Check if sessio nalready start
        session_start();
    }

    ?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php
    include("conf/header.php");
    include("conf/connection.php");

    $strKeyword = null;
    if (isset($_POST["search_tables"])) {
        $strKeyword = $_POST["search_tables"];
    }
    if (isset($_GET["search_tables"])) {
        $strKeyword = $_GET["search_tables"];
    }
    ?>
    <div class="container" style="padding-top: 90px;">
        <h1 class="page-header text-left">แสดงโต๊ะ</h1>
        <form class="form-inline">
            <div class="col-md-13">
                <div class="form-group">
                    <input class="form-control" type="text" name="search_tables" placeholder="ค้นหาหมายเลขโต๊ะ" aria-label="Search">
                    <button type="submit" class="btn btn-success mb-2">ค้นหา</button>
                </div>

            </div>
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" style="width:750px" align="center">
                <thead>
                    <th style="text-align:right; width:;">หมายเลขโต๊ะ</th>
                    <th style="text-align: right; width:;">จำนวนที่นั่ง (คน)</th>
                    <th style="text-align:center; width:px; text-align:center;">จองโต๊ะ</th>
                </thead>
        </div>
        <?php
        //include('conf/connection.php');
        $sql = "SELECT * FROM tables WHERE tables_no LIKE '%" . $strKeyword . "%' AND tables_status_use = '0'";
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
                ?>
                <tr>
                    <td align="right"><?= $result["tables_no"]; ?></td>
                    <td align="right"> <?= $result["tables_seats"] ?></td>
                    <td align="center"><a href="add_list_tables.php?tables_no=<?= $result['tables_no'] ?>" class="btn btn-success btn-md"><span class="glyphicon glyphicon-shopping-cart"></span> จองโต๊ะ</a></td>
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
                    echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$prev_page&search_tables=$strKeyword'>ก่อนหน้า</a></li>";
                } else {
                    // ทำให้คลิกไม่ได้
                    echo '<li class="page-item disabled"><a href="#" >ก่อนหน้า</a></li>';
                }

                for ($i = 1; $i <= $num_pages; $i++) {
                    if ($i != $page) {
                        echo "<li class='page-item n'><a href='$_SERVER[SCRIPT_NAME]?Page=$i&search_tables=$strKeyword'>$i</a>" . '</li>';
                    } else {
                        echo '<li class="page-item active"><a href="#">' . $i . '</a></li>';
                    }
                }
                if ($page != $num_pages) {
                    echo '<li class="page-item n">' . " <a href='$_SERVER[SCRIPT_NAME]?Page=$next_page&search_tables=$strKeyword'>ถัดไป</a></li>";
                } else {
                    echo '<li class="page-item disabled">' . "<a href ='#'>ถัดไป</a></li> ";
                }
                $link = null;
                ?>
        </div>
    </nav>
    </div>
<?php include("conf/footer.php"); ?>
</body>