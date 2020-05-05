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
    <title>เพิ่มข้อมูลสมาชิก | Food Order System</title>

    <script>
    $(document).ready(function() {
        $("#addmaterials").validate({
            messages: {
                material_name: {
                    required: "<font color='red'>กรุณากรอกชื่อวัตถุดิบ</font>",
                },
                material_qty: {
                    required: "<font color='red'>กรุณากรอกจำนวนวัตถุดิบ</font>",
                    min: "<font color='red'>กรุณากรอกเป็นจำนวนเต็ม</font>",
                },
                material_count: {
                    required: "<font color='red'>กรุณากรอกหน่วยนับ</font>",
                },
            },
            onfocusout: function(element) {
                this.element(element);
            },
        });
    });
</script>
</head>

<body>
    <div class="container" style="padding-top: 135px;">
        <h1 class="page-header text-left">เพิ่มข้อมูลวัตถุดิบ</h1>
        <form method="POST" id="addmaterials" action="add_material.php" enctype="multipart/form-data">
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อวัตถุดิบ :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:300px" required name="material_name">
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">จำนวน :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" onkeypress="return isNumberKey(event)" style="width:150px" value="" min="0" max="300" required name="material_qty">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หน่วยนับ :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:300px" required name="material_count">
                    </div>
                </div>
            </div>
            <hr>
    </div>
    <div class="col-md-4 col-md-offset-5">
        <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
        <button type="reset" class="btn btn-danger">ล้างค่า</button>
        <button type="button" class="btn btn-info" onclick="window.history.back();" >ย้อนกลับ</button>
        </form>
    </div>
    </div>