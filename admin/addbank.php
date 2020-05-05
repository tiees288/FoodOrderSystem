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
    <title>เพิ่มข้อมูลธนาคาร | Food Order System</title>
    <script>
        $(document).ready(function() {
            $("#addbank").validate({
                messages: {
                    bank_name: {
                        required: "<font color='red'>กรุณากรอกชื่อธนาคาร</font>",
                    },
                    bank_branch: {
                        required: "<font color='red'>กรุณากรอกสาขาของธนาคาร</font>",
                    },
                    bank_details: {
                        required: "<font color='red'>กรุณากรอกหมายเลขบัญชีธนาคาร</font>",
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
        <h1 class="page-header text-left">เพิ่มข้อมูลธนาคาร</h1>
        <form method="POST" id="addbank" action="add_bank.php" enctype="multipart/form-data">
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อธนาคาร :<span style="color:red;">*</span></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:250px" id="bank_name" value="" name="bank_name" required>
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สาขา :<span style="color:red;">*</span></label>
                    <div class="col-md-8">
                        <textarea style="width:300px" class="form-control" rows="3" cols="2" id="bank_branch" name="bank_branch" required></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">เลขที่บัญชี :<span style="color:red;">*</span></label>
                    <div class="col-md-8">
                        <textarea style="width:300px" required class="form-control" rows="3" cols="2" name="bank_details"></textarea>
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