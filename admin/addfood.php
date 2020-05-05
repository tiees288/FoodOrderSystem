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
    <title>เพิ่มข้อมูลรายการอาหาร | Food Order System</title>

    <script>
    $(document).ready(function() {
        $("#addfood").validate({
            messages: {
                food_name: {
                    required: "<font color='red'>กรุณากรอกชื่อวัตถุดิบ</font>",
                },
                food_price: {
                    required: "<font color='red'>กรุณากรอกจำนวนวัตถุดิบ</font>",
                },
                food_type: {
                    required: "<font color='red'>กรุณาเลือกประภทรายการอาหาร</font>",
                },
                food_qty: {
                    required: "<font color='red'>กรุณากรอกจำนวนรายการอาหาร</font>",
                    min: "<font color='red'>กรุณากรอกเป็นจำนวนเต็ม</font>",
                },
                food_count: {
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
        <h1 class="page-header text-left">เพิ่มข้อมูลรายการอาหาร</h1>
        <form method="POST" id="addfood" action="add_food.php" enctype="multipart/form-data">
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อรายการอาหาร :<span style="color:red;">*</span> </label>
                    <div class="col-md-8" style="width:300px;">
                        <input type="text" class="form-control" value="" name="food_name" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ราคา (บาท) :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:150px" min="1" onkeypress="return isNumberKey(event)" value="" name="food_price" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รูปภาพ :<span style="color:red;"></span></label>
                    <div class="col-md-8" style="width:300px;">
                        <input type="file" class="form-control" id="food_image" name="food_image" accept="image/gif, image/jpeg, image/png" >
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ประเภท :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <select class="form-control" style="width:200px" name="food_type" required>
                            <option value="" disabled selected>-- กรุณาเลือกประเภท --</option>
                            <option value="0">ประเภทผัด</option>
                            <option value="1">ประเภททอด</option>
                            <option value="2">ประเภทต้ม</option>
                            <option value="3">เครื่องดื่ม</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">จำนวน :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" style="width:150px" min="0" max="999" onkeypress="return isNumberKey(event)" value="" name="food_qty" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หน่วยนับ :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" required style="width:150px" minlength="3" value="" name="food_count">
                    </div>
                </div>
            </div><hr>
            <div class="col-md-4 col-md-offset-5">
                <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
                <button type="reset" class="btn btn-danger">ล้างค่า</button>
                <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
            </div>
        </form>
    </div>