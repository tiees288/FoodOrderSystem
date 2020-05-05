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

            <script>
                $(document).ready(function() {
                    $("#addstaff").validate({
                        messages: {
                            staff_name: {
                                required: "<font color='red'>กรุณากรอก ชื่อ-นามสกุล</font>",
                                //minlength: "<font color='red'>กรุณากรอก มากกว่า 5 ตัวอักษร</font>",
                                pattern: "<font color='red'>กรุณากรอกเฉพาะ ตัวอักษรเท่านั้น",
                            },
                            staff_birth: {
                                required: "<font color='red'>กรุณาเลือกวันเกิด</font>",
                            },
                            staff_tel: {
                                required: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
                                digits: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
                                minlength: "<font color='red'>กรุณาระบุ ไม่น้อยกว่า 9 ตัวอักษร</font>",
                                maxlength: "<font color='red'>กรุณาระบุ ไม่เกิน 10 ตัวอักษร</font>",
                                pattern: "<font color='red'>กรุณาระบุเบอร์โทรศัพท์ให้ถูกต้อง</font>",
                            },
                            staff_email: {
                                email: "<font color='red'>กรุณากรอกอีเมลในรูปแบบที่ถูกต้อง</font>",
                            },
                            staff_postnum: {
                                required: "<font color='red'>กรุณากรอกรหัสไปรษณีย์</font>",
                                minlength: "<font color='red'>กรุุณากรอก ให้ครบ 5 ตัวอักษร</font>",
                                maxlength: "<font color='red'>กรุุณากรอก ให้ครบ 5 ตัวอักษร</font>",
                                pattern: "<font color='red'>กรุุณากรอกรหัสไปรษณีย์ที่ถูกต้อง</font>",
                            },
                            staff_address: {
                                required: "<font color='red'>กรุณากรอกที่อยู่ของท่าน</font>",
                            },
                            staff_level: {
                                required: "<font color='red'>กรุณาเลือกระดับของพนักงาน</font>",
                            },
                            staff_nationid: {
                                required: "<font color='red'>กรุณาเกรอกหมายเลขบัตรประชาชน</font>",
                                max: "<font color='red'>กรุณากรอกให้ครบ 13 หลัก</font>",
                                min: "<font color='red'>กรุณากรอกให้ครบ 13 หลัก</font>",
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
                <div class="col">
                    <h1 class="page-header text-left">เพิ่มข้อมูลพนักงาน</h1>
                    <div class="col-md-offset-1 col-md-12">
                        <form class="form-horizontal" id="addstaff" method="POST" action="add_staff.php" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label col-md-2" style="text-align:right;">ชื่อ-นามสกุล :<span style="color:red;">*</span> </label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" value="" name="staff_name" required pattern="^[ก-๏a-zA-Z\s]+$">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2" style="text-align:right;">วันเกิด :<span style="color:red;">*</span> </label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control datepicker1" autocomplete="off" onkeypress="return false; event.preventDefault();" onfocus="$(this).blur();" value="" name="staff_birth" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label colmd-3">
                                        <font color="#8F8D8D">กรุณากรอกวันเกิดของท่านตามจริง</font>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" style="margin-top:10px;">
                                <label class="control-label col-md-2" style="text-align:right;">เบอร์โทรศัพท์ :<span style="color:red;">*</span> </label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" required minlength="9" maxlength="10" pattern="[0]{1}[2,6,8,9]{1}[0-9]{7,}" oninvalid="this.setCustomValidity('กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" value="" name="staff_tel">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label colmd-3">
                                        <font color="#8F8D8D">กรอกเบอร์โทรศัพท์ อย่างน้อย 9 ตัว</font>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" style="margin-top:10px;">
                                <label class="control-label col-md-2" style="text-align:right;">อีเมล :<span style="color:red;"></span> </label>
                                <div class="col-md-3">
                                    <input type="email" class="form-control" value="" name="staff_email">
                                </div>
                                <div class="col-md-7">
                                    <label class="control-label colmd-3">
                                        <font color="#8F8D8D">กรอกอีเมลให้ถูกต้องตามรูปแบบ เช่น email@example.com</font>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" style="margin-top:10px;">
                                <label class="control-label col-md-2" style="text-align:right;">ที่อยู่ :<span style="color:red;">*</span> </label>
                                <div class="col-md-3">
                                    <textarea name="staff_address" id="staff_address" required cols="20" rows="4" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group" style="margin-top:10px;">
                                <label class="control-label col-md-2" style="text-align:right;">รหัสไปรษณีย์ :<span style="color:red;">*</span> </label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" required pattern="[1-9]{1}[0-9]{3}[0]{1}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" minlength="5" maxlength="5" value="" name="staff_postnum">
                                </div>
                                <div class="col-md-4 col-md-offset-1">
                                    <label class="control-label">
                                        <font color="#8F8D8D">กรอกเป็นตัวเลข 5 ตัว</font>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" style="margin-top:10px;">
                                <label class="control-label col-md-2" style="text-align:right;">หมายเลขบัตรประชาชน:<span style="color:red;">*</span></label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" required minlength="13" maxlength="13" onkeypress="return isNumberKey(event)" value="" name="staff_nationid">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">
                                        <font color="#8F8D8D">กรอกหมายเลขบัตรประชาชนให้ครบ 13 หลัก</font>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" style="text-align:right;">ระดับ:<span style="color:red;">*</span> </label>
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
                <div class="col-md-3 col-md-offset-4" style="padding-top:10px;">
                    <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
                    <button type="reset" class="btn btn-danger">ล้างค่า</button>
                    <button type="button" class="btn btn-info" onclick="window.history.back()">ย้อนกลับ</button>
                    </form>
                </div>
        </body>