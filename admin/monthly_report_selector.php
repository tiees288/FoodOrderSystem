<head>
    <?php

    if (!isset($_GET['report_name'])) {
        header("location: index.php");
        exit();
    }
    switch ($_GET['report_name']) {
        case 'order_month':
            $report_name = "รายงานการสั่งอาหารประจำเดือน";
            $report_file = "report_order_month.php";
            $date_attr = "orderdate"; // ฟิลด์ข้อมูล
            $date_table = "orders";
            break;
        case 'reserve_month':
            $report_name = "รายงานการจองประจำเดือน";
            $report_file = "report_reserve_month.php";
            $date_attr = "reserv_date_reservation"; // ฟิลด์ข้อมูล
            $date_table = "reservations";
            break;
        case 'payment_month':
            $report_name = "รายงานการรับชำระประจำเดือน";
            $report_file = "report_payment_month.php";
            $date_attr = "pay_date"; // ฟิลด์ข้อมูล
            $date_table = "payment";
            break;
        case 'delivery_month':
            $report_name = "รายงานการส่งอาหารประจำเดือน";
            $report_file = "report_delivery_month.php";
            $date_attr = "order_date_delivered"; // ฟิลด์ข้อมูล
            $date_table = "orders";
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
            $("#report_month").validate({
                // Specify validation rules
                messages: {
                    month: {
                        required: "<font size='2' style='padding-left:35px;' color='red'>กรุณาเลือก เดือน ที่ต้องการค้นหา</font>",
                    },
                    year: {
                        required: "<font size='2' style='padding-left:35px;' color='red'>กรุณาเลือก ปี พ.ศ. ต้องการค้นหา</font>",
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

        <div class="row" style="padding-top:15px;">
            <form name="report_month" id="report_month" action="<?= $report_file ?>" method="POST" target="_blank">
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
                        <?php

                        $sql_year = "SELECT DISTINCT year($date_attr) FROM $date_table WHERE $date_attr != '0000-00-00'";
                        $query_year = mysqli_query($link, $sql_year) or die(mysqli_error($link));

                        while ($result_year = mysqli_fetch_array($query_year)) {
                            echo "<option value='" . $result_year[0] . "' >" . ($result_year[0] + 543) . "</option>";
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