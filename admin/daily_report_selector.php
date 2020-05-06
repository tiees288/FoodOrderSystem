<head>
    <?php

    if (!isset($_GET['report_name'])) {
        header("location: index.php");
        exit();
    }
    switch ($_GET['report_name']) {
        case 'order_day':
            $report_name = "รายงานการสั่งอาหารประจำวัน";
            $report_file = "report_order_day.php";
            break;
        case 'reserve_day':
            $report_name = "รายงานการจองประจำวัน";
            $report_file = "report_reserve_day.php";
            break;
        case 'payment_day':
            $report_name = "รายงานการรับชำระประจำวัน";
            $report_file = "report_payment_day.php";
            break;
        case 'delivery_day':
            $report_name = "รายงานการส่งอาหารประจำวัน";
            $report_file = "report_delivery_day.php";
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
    include("conf/header_admin.php");
    ?>

    <script>
        $(document).ready(function() {
            $("#report_day").validate({
                // Specify validation rules
                messages: {
                    startdate: {
                        required: "<font size='2' style='padding-left:15px;' color='red'>กรุณาเลือกวันที่ต้องการเริ่มต้นการค้นหา</font>",
                    },
                    enddate: {
                        required: "<font size='2' style='padding-left:25px;' color='red'>กรุณาเลือกวันที่ต้องการสิ้นสุดการค้นหา</font>",
                    },
                },
                onfocusout: function(element) {
                    // "eager" validation
                    this.element(element);
                },
            });
        });
    </script>

</head>

<body>
    <?php
    include("../conf/connection.php");
    include("../conf/function.php");
    ?>
    <div class="container" style="padding-top: 135px;">
        <h1 class="page-header text-left"><?= $report_name ?></h1>

        <div class="row" style="padding-top:15px; padding-bottom:15px;">
            <form name="report_day" id="report_day" action="<?= $report_file ?>" method="POST" target="_blank">
                <label class="control-label col-md-offset- col-md-2 text-right" style="padding-top:5px;">ตั้งแต่วันที่ :<font color="red">*</font> </label>
                <div class="col-md-3">
                    <input type="text" class="form-control datepicker-start" name="startdate" id="startdate" placeholder="กรุณาเลือกวันที่ที่ต้องการ" onkeypress="return false; event.preventDefault();" onfocus="$(this).blur();" autocomplete="off" required>
                </div>
                <label class="control-label col-md-2 text-right" style="padding-top:5px;">ถึงวันที่ :<font color="red">*</font> </label>
                <div class="col-md-3">
                    <input type="text" class="form-control datepicker-end" name="enddate" id="enddate" placeholder="กรุณาเลือกวันที่ที่ต้องการ" onkeypress="return false; event.preventDefault();" onfocus="$(this).blur();" autocomplete="off" required>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success" id="search_report_daily" name="search" type="submit">ค้นหา</button>
                </div>
            </form>
        </div>
        <hr>
    </div>

</body>