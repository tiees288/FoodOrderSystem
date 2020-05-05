<head>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['staff'])) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
    }
    include('conf/header_admin.php');
    ?>
    <title>เพิ่มข้อมูลโต๊ะ | Food Order System</title>

    <script>
        $(document).ready(function() {
            $("#addtable").validate({
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
    <div class="container" style="padding-top: 135px;">
        <h1 class="page-header text-left">เพิ่มข้อมูลโต๊ะ</h1>
        <form method="POST" id="addtable" action="add_table.php" enctype="multipart/form-data">
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หมายเลขโต๊ะ :<span style="color:red;">*</span> </label>
                    <div class="col-md-8" style="padding-top:7px;">
                        ( หมายเลขโต๊ะจะแสดงหลังจากเพิ่มโต๊ะ )
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">จำนวน (คน) :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" style="width:150px" value="2" onkeypress="return isNumberKey(event)" min="2" max="12" required name="tables_seats">
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-4 col-md-offset-5">
                <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
                <button type="reset" class="btn btn-danger">ล้างค่า</button>
                <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
            </div>
        </form>
    </div>
</body>