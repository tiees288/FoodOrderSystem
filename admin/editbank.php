<head>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['staff'])) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
    }
    if (!isset($_GET['bankid'])) {
        echo "<script>window.location.assign('show_bank.php')</script>";
    }
    include('conf/header_admin.php');
    include('../conf/function.php');
    ?>
    <title>แก้ไขข้อมูลธนาคาร | Food Order System</title>

    <script>
        $(document).ready(function() {
            let validator = $("#editbank").validate({
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
                    bank_status: {
                        required: "<font color='red'>กรุณาเลือกสถานะ</font>",
                    }
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
    $sql_edit = "SELECT * FROM banks WHERE bankid = '" . $_GET['bankid'] . "'";
    $result = mysqli_fetch_assoc(mysqli_query($link, $sql_edit));
    ?>
    <div class="container" style="padding-top: 135px; padding-bottom:15px;">
        <h1 class="page-header text-left">แก้ไขข้อมูลธนาคาร</h1>
        <form method="POST" id="editbank" action="edit_bank.php" enctype="multipart/form-data">
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รหัสธนาคาร :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:150px" value="<?php echo $result['bankid']; ?>" name="bankid" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อธนาคาร :<span style="color:red;">*</span></label>
                    <div class="col-md-8">
                        <input type="text" id="bank_name" class="form-control" style="width:250px" value="<?php echo $result['bank_name']; ?>" required name="bank_name">
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สาขา :<span style="color:red;">*</span></label>
                    <div class="col-md-8">
                        <textarea style="width:300px" id="bank_branch" class="form-control" rows="3" cols="2" required name="bank_branch"><?= $result['bank_branch'] ?></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">เลขที่บัญชี :<span style="color:red;">*</span></label>
                    <div class="col-md-8">
                        <textarea style="width:300px" required class="form-control" rows="3" cols="2" name="bank_details"><?= $result['bank_details'] ?></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สถานะ :<span style="color:red;">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control" style="width:200px" id="bank_status" name="bank_status" required>
                            <option value="" disabled selected>-- กรุณาเลือกสถานะ --</option>
                            <option <?php if ($result['bank_status'] == 0) echo "selected"; ?> value="0">ใช้งาน</option>
                            <option <?php if ($result['bank_status'] == 1) echo "selected"; ?> value="1">ไม่ใช้งาน</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-4 col-md-offset-5">
                <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
                <button type="reset" class="btn btn-danger">คืนค่า</button>
                <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
            </div>
        </form>
    </div>
</body>