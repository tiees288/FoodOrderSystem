 <head>
     <?php
        if (!isset($_SESSION)) {
            session_start();
        }
        if ((!isset($_SESSION['staff']) || ($_SESSION['staff_level'] != 1))) {
            echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
        }
        if (!isset($_GET['staffid'])) {
            echo "<script>window.location.assign('show_staff.php')</script>";
        }
        include('conf/header_admin.php');
        include('../conf/function.php');
        ?>
     <title>แก้ไขข้อมูลพนักงาน | Food Order System</title>

     <script>
                $(document).ready(function() {
                    $("#editstaff").validate({
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
                            this.element(element);
                        },
                    });
                });
            </script>
 </head>

 <body>
     <?php
        include('../conf/connection.php');
        $sql_edit = "SELECT * FROM staff WHERE staffid = '" . $_GET['staffid'] . "'";
        $result = mysqli_fetch_assoc(mysqli_query($link, $sql_edit));
        ?>
     <div class="container" style="padding-top: 135px; padding-bottom:15px;">
         <h1 class="page-header text-left">แก้ไขข้อมูลพนักงาน</h1>
         <div class="col-md-offset-1 col-md-12">
             <form method="POST" id="editstaff" class="form-horizontal" action="edit_staff.php" enctype="multipart/form-data">
                 <div class="form-group" style="margin-top:10px;">
                     <label class="control-label col-md-2" style="text-align:right;">รหัสพนักงาน :</label>
                     <div class="col-md-8">
                         <input type="text" class="form-control" style="width:150px" value="<?php echo $result['staffid']; ?>" name="staffid" readonly>
                     </div>
                 </div>

                 <div class="form-group">
                     <label class="control-label col-md-2" style="text-align:right;">ชื่อ-นามสกุล :<span style="color:red;">*</span> </label>
                     <div class="col-md-3">
                         <input type="text" class="form-control" value="<?php echo $result['staff_name']; ?>" name="staff_name" pattern="^[ก-๏a-zA-Z\s]+$" required>
                     </div>
                 </div>

                 <div class="form-group" style="margin-top:10px;">
                     <label class="control-label col-md-2" style="text-align:right;">วันเกิด :<span style="color:red;">*</span> </label>
                     <div class="col-md-3">
                         <input type="text" class="form-control datepicker1" onkeypress="return false; event.preventDefault();" onfocus="$(this).blur();" value="<?= tothaiyear($result['staff_birth']) ?>" name="staff_birth" required>
                     </div>
                     <div class="col-md-3">
                         <label class="control-label colmd-3">
                             <font color="#8F8D8D">กรุณากรอกวันเกิดของท่านตามจริง</font>
                         </label>
                     </div>
                 </div>

                 <div class="form-group" style="margin-top:10px;">
                     <label class="control-label col-md-2" style="text-align:right;">เบอร์โทรศัพท์ :<span style="color:red;">*</span> </label>
                     <div class="col-md-3">
                         <input type="text" class="form-control" minlength="9" maxlength="10" pattern="[0]{1}[2,6,8,9]{1}[0-9]{7,}" oninvalid="this.setCustomValidity('กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" value="<?php echo $result['staff_tel']; ?>" name="staff_tel" required>
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
                         <input type="email" class="form-control" value="<?php echo $result['staff_email']; ?>" name="staff_email">
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
                         <textarea required name="staff_address" id="" cols="25" rows="4" class="form-control"><?= $result['staff_address']; ?></textarea>
                     </div>
                 </div>
                 <div class="form-group" style="margin-top:10px;">
                     <label class="control-label col-md-2" style="text-align:right;">รหัสไปรษณีย์ :<span style="color:red;">*</span> </label>
                     <div class="col-md-2">
                         <input type="text" required class="form-control" pattern="[1-9]{1}[0-9]{3}[0]{1}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง')" oninput="this.setCustomValidity('')" minlength="5" maxlength="5" value="<?php echo $result['staff_postnum']; ?>" name="staff_postnum">
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
                         <input type="text" required class="form-control" onkeypress="return isNumberKey(event)" minlength="13" maxlength="13" value="<?php echo $result['staff_nationid']; ?>" name="staff_nationid">
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
                             <option <?php if ($result['staff_level'] == 0) echo "selected"; ?> value="0">พนักงาน</option>
                             <option <?php if ($result['staff_level'] == 1) echo "selected"; ?> value="1">เจ้าของร้าน</option>
                         </select>
                     </div>
                 </div>

                 <div class="form-group">
                     <label class="control-label col-md-2" style="text-align:right;">สถานะ:<span style="color:red;">*</span> </label>
                     <div class="col-md-8">
                         <select class="form-control" required style="width:250px" name="staff_status">
                             <option value="" disabled selected>-- กรุณาเลือกสถานะ --</option>
                             <option <?php if ($result['staff_status'] == 0) echo "selected"; ?> value="0">ทำงาน</option>
                             <option <?php if ($result['staff_status'] == 1) echo "selected"; ?> value="1">ลาออก</option>
                         </select>
                     </div>
                 </div>
         </div>

         <div class="col-md-3 col-md-offset-4">
             <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
             <button type="reset" class="btn btn-danger">คืนค่า</button>
             <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
         </div>
         </form>
     </div>