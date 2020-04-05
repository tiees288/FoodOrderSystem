<html>

<head>
    <title>ค้นหา/เลือกลูกค้า | Food Order System</title>
    <?php
    session_start();
    ?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
    <?php

    if (!isset($_SESSION['staff'])) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิ์การเข้าใช้งาน'); window.location.assign('login_staff.php'); </script>";
        exit();
    }

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
        <h1 class="page-header text-left">ค้นหา/เลือกลูกค้า</h1>
        <form class="form-inline" method="POST">
            <div class="col-md-13 col-md-offset-3">
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
                    </select>

                    <input class="form-control" type="text" name="search_customer" placeholder="ค้นหาข้อมูลลูกค้าที่ต้องการสั่งอาหาร" style="width:350px;" aria-label="Search">
                </div>
                <button type="submit" class="btn btn-success mb-2">ค้นหา</button>
            </div>
        </form>
        <hr>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $strKeyword = null;
            $search_type = null;

            if (isset($_POST["search_customer"])) {
                $strKeyword = $_POST["search_customer"];
            }
            if (isset($_POST["search_type"])) {
                $search_type = $_POST["search_type"];
            }

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

            $query = mysqli_query($link, $sql)
        ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered" align="center">
                    <thead>
                        <th style="text-align:right; width:130px;">รหัสลูกค้า</th>
                        <th style="text-align: left; width:240px;">ชื่อ-นามสกุล</th>
                        <th style="text-align:left; width:170px;">เบอร์โทรศัพท์</th>
                        <th style="text-align:left; width:230px;">อีเมล</th>
                        <th style="text-align:left; width:160px;">สถานะ</th>
                        <th style=" text-align:center; width:120px;">เลือกลูกค้า</th>
                    </thead>
                    <?php
                    if (mysqli_num_rows($query) > 0)
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
                            }
                            if ($_GET['ref'] == 'order') {
                                $ref_href = "staff_checkout_order.php";
                            } elseif ($_GET['ref'] == 'reserve') {
                                $ref_href = "staff_checkout_reserve.php";
                            } elseif ($_GET['ref'] == 'payment') {
                                $ref_href = "staff_checkout_payment.php";
                            }

                    ?>

                        <tr>
                            <td align="right"><?= $result['cusid'] ?></td>
                            <td><?= $result['cus_name'] ?></td>
                            <td><?= $result['cus_tel'] ?></td>
                            <td><?= ($result['cus_email'] != "") ? $result['cus_email'] : "-" ?></td>
                            <td><?= $cus_status ?></td>
                            <td align="center">
                        <a href="<?= $ref_href ?>?cusid=<?= $result['cusid'] ?>" <?php if ($result['cus_status'] == 1) { ?> onclick=" if (confirm('ลูกค้าบัญชีดำ ต้องการทำรายการต่อหรือไม่?') ) {} else return false;" <?php } ?> class="btn btn-success btn-md">
                                    <span class="glyphicon glyphicon-user"></span> เลือก</a>
                            </td>
                        </tr>

                <?php } else {
                        echo "<tr><td align='center' colspan='6'>ไม่พบข้อมูลในระบบ</td></tr>";
                    }
                }
                ?>
            </div>