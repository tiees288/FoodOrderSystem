<head>
    <?php

    if (!isset($_GET['report_name'])) {
        header("location: index.php");
        exit();
    }
    switch ($_GET['report_name']) {
        case 'order_month' :
            $report_name = "รายงานการสั่งอาหารประจำเดือน";
            $report_file = "report_order_month.php";
            break;
        case 'reserve_month' :
            $report_name = "รายงานการจองประจำเดือน";
            $report_file = "report_reserve_month.php";
            break;
        case 'payment_month' :
            $report_name = "รายงานการรับชำระประจำเดือน";
            $report_file = "report_payment_month.php";
            break;
        case 'delivery_month' :
            $report_name = "รายงานการส่งอาหารประจำเดือน";
            $report_file = "report_delivery_month.php";
            break;
        default:
            echo "<script>window.location.assign('index.php');</script>";
            exit();
    }

    ?>
    <title> <?= $report_name ?> | Food Order System</title>
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
    ?>
    <div class="container" style="padding-top: 135px;">
        <h1 class="page-header text-left"><?= $report_name ?></h1>

        <div class="row" style="padding-top:15px;">
            <form name="report" action="<?= $report_file ?>" method="POST" target="_blank">
                <label class="control-label col-md-offset1 col-md-2 text-right" style="padding-top:5px;">เดือน :<font color="red">*</font> </label>
                <div class="col-md-3">
                    <select name="month" id="month" class="form-control" required>
                        <option value="" selected disabled>-- กรุณาเลือกเดือนที่ต้องการ --</option>
                        <option value="1">มกราคม</option>
                        <option value="2">กุมภาพันธ์</option>
                        <option value="3">มีนาคม</option>
                        <option value="4">เมษายน</option>
                        <option value="5">พฤษภาคม</option>
                        <option value="6">มิถุนายน</option>
                        <option value="7">กรกฎาคม</option>
                        <option value="8">สิงหาคม</option>
                        <option value="9">กันยายน</option>
                        <option value="10">ตุลาคม</option>
                        <option value="11">พฤศจิกายน</option>
                        <option value="12">ธันวาคม</option>
                    </select>
                </div>
                <label class="control-label col-md-2 text-right" style="padding-top:5px;">ปี พ.ศ. :<font color="red">*</font> </label>
                <div class="col-md-3">
                    <select name="year" id="year" class="form-control" required>
                        <option value="" selected disabled>-- กรุณาเลือกปี พ.ศ. ที่ต้องการ --</option>
                        <option value="2019">2562</option>
                        <?php
                        $yr_th = 2562;
                        $yr_ch = 2019;

                        for ($i = 1; $i <= 10; $i++) {
                            echo "<option value='" . ($yr_ch + $i) . "'>" . ($yr_th + $i) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <button class="btn btn-success" name="search" type="submit">ค้นหา</button>
            </form>
        </div>
        <hr>
    </div>

</body>