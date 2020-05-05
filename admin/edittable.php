head>
<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['staff'])) {
    echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
}
if (!isset($_GET['tables_no'])) {
    echo "<script>window.location.assign('show_table.php')</script>";
}
include('conf/header_admin.php');
include('../conf/function.php');
?>
<title>แก้ไขข้อมูลโต๊ะ | Food Order System</title>

<script>
    $(document).ready(function() {
        $("#edittable").validate({
            messages: {
                tables_seats: {
                    required: "<font color='red'>กรุณากรอกจำนวนที่นั่ง</font>",
                    min: "<font color='red'>กรุณากรอกจำนวนที่นั่งมากกว่า 2 ที่นั่ง</font>",
                    max: "<font color='red'>กรุณากรอกจำนวนที่นั่งไม่เกิน 12 ที่นั่ง</font>",
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
    include('../conf/connection.php');
    $sql_edit = "SELECT * FROM tables WHERE tables_no = '" . $_GET['tables_no'] . "'";
    $result = mysqli_fetch_assoc(mysqli_query($link, $sql_edit));
    ?>
    <div class="container" style="padding-top: 135px; padding-bottom:15px;">
        <h1 class="page-header text-left">แก้ไขข้อมูลโต๊ะ</h1>
        <form method="POST" id="edittable" action="edit_table.php" enctype="multipart/form-data">
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หมายเลขโต๊ะ :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:150px" value="<?php echo $result['tables_no']; ?>" name="tables_no" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">จำนวนที่นั่ง(คน) :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="number" required class="form-control" style="width:150px" min="2" max="12" onkeypress="return isNumberKey(event)" value="<?php echo $result['tables_seats']; ?>" name="tables_seats">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สถานะจอง:<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <select class="form-control" style="width:250px" name="tables_status_reserve">
                            <option value="" disabled selected>-- กรุณาเลือกสถานะ --</option>
                            <option <?php if ($result['tables_status_reserve'] == 0) echo "selected"; ?> value="0">ไม่มีการจอง</option>
                            <option <?php if ($result['tables_status_reserve'] == 1) echo "selected"; ?> value="1">มีการจอง</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สถานะพร้อมใช้:<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <select class="form-control" style="width:250px" name="tables_status_use">
                            <option value="" disabled selected>-- กรุณาเลือกสถานะ --</option>
                            <option <?php if ($result['tables_status_use'] == 0) echo "selected"; ?> value="0">โต๊ะว่าง</option>
                            <option <?php if ($result['tables_status_use'] == 1) echo "selected"; ?> value="1">โต๊ะไ่ม่ว่าง</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-4 col-md-offset-5">
                <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
                <button type="reset" class="btn btn-danger">คืนค่า</button>
                <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
        </form>
    </div>
    </div>