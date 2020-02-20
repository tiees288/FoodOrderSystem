        <head>
            <?php
            if (!isset($_SESSION)) {
                session_start();
            }
            if ((!isset($_SESSION['staff']) || ($_SESSION['staff_level'] != 1))) {
                echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
            }
            include('conf/header_admin.php');
            ?>
            <title>เพิ่มข้อมูลพนักงาน | Food Order System</title>
        </head>

        <body>
            <div class="container" style="padding-top: 135px;">
                <h1 class="page-header text-left">เพิ่มข้อมูลพนักงาน</h1>
                <form method="POST" action="add_staff.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อ-นามสกุล :<span style="color:red;">*</span> </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" style="width:300px" value="" name="staff_name" required pattern="^[ก-๏a-zA-Z\s]+$">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:10px;">
                        <div class="row">
                            <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">วันเกิด :<span style="color:red;">*</span> </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control datepicker1" autocomplete="off" onkeypress="return false; event.preventDefault();" onfocus="$(this).blur();" style="width:300px" value="" name="staff_birth" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:10px;">
                        <div class="row">
                            <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">เบอร์โทรศัพท์ :<span style="color:red;">*</span> </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" style="width:300px" required minlength="9" maxlength="10" pattern="[0]{1}[2,6,8,9]{1}[0-9]{7,}" oninvalid="this.setCustomValidity('กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" value="" name="staff_tel">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:10px;">
                        <div class="row">
                            <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">อีเมล :<span style="color:red;"></span> </label>
                            <div class="col-md-8">
                                <input type="email" class="form-control" style="width:300px" value="" name="staff_email">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:10px;">
                        <div class="row">
                            <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ที่อยู่ :<span style="color:red;">*</span> </label>
                            <div class="col-md-5">
                                <textarea name="staff_address" id="staff_address" required cols="20" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:10px;">
                        <div class="row">
                            <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รหัสไปรษณีย์ :<span style="color:red;">*</span> </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" required style="width:150px" pattern="[1-9]{1}[0-9]{3}[0]{1}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" minlength="5" maxlength="5" value="" name="staff_postnum">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:10px;">
                        <div class="row">
                            <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หมายเลขบัตรประชาชน:<span style="color:red;">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" required minlength="13" maxlength="13" onkeypress="return isNumberKey(event)" style="width:300px" value="" name="staff_nationid">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ระดับ:<span style="color:red;">*</span> </label>
                            <div class="col-md-8">
                                <select class="form-control" style="width:250px" name="staff_level" required>
                                    <option value="" disabled selected>-- กรุณาเลือกระดับ --</option>
                                    <option value="0">พนักงาน</option>
                                    <option value="1">เจ้าของร้าน</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-md-3 col-md-offset-5" style="padding-top:10px;">
                <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
                <button type="reset" class="btn btn-danger">คืนค่า</button>
                <button type="button" class="btn btn-info" onclick="window.history.back()">ย้อนกลับ</button>
                </form>
            </div>
        </body>