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
             $("#addcustomer").validate({
                 messages: {
                     cus_name: {
                         required: "<font color='red'>กรุณากรอก ชื่อ-นามสกุล</font>",
                         //minlength: "<font color='red'>กรุณากรอก มากกว่า 5 ตัวอักษร</font>",
                         pattern: "<font color='red'>กรุณากรอกเฉพาะ ตัวอักษรเท่านั้น",
                     },
                     cus_tel: {
                         required: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
                         digits: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
                         minlength: "<font color='red'>กรุณาระบุ ไม่น้อยกว่า 9 ตัวอักษร</font>",
                         maxlength: "<font color='red'>กรุณาระบุ ไม่เกิน 10 ตัวอักษร</font>",
                         pattern: "<font color='red'>กรุณาระบุเบอร์โทรศัพท์ให้ถูกต้อง</font>",
                     },
                     cus_email: {
                         email: "<font color='red'>กรุณากรอกอีเมลในรูปแบบที่ถูกต้อง</font>",
                     },
                     cus_postnum: {
                         required: "<font color='red'>กรุณากรอกรหัสไปรษณีย์</font>",
                         minlength: "<font color='red'>กรุุณากรอก ให้ครบ 5 ตัวอักษร</font>",
                         maxlength: "<font color='red'>กรุุณากรอก ให้ครบ 5 ตัวอักษร</font>",
                         pattern: "<font color='red'>กรุุณากรอกรหัสไปรษณีย์ที่ถูกต้อง</font>",
                     },
                     cus_address: {
                         required: "<font color='red'>กรุณากรอกที่อยู่ของท่าน</font>",
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
         <h1 class="page-header text-left">เพิ่มข้อมูลสมาชิก</h1>
         <div class="col-md-offset-1 col-md-12">
             <form method="POST" id="addcustomer" class="form-horizontal" action="add_customer.php" enctype="multipart/form-data">
                 <div class="form-group">
                     <label class="control-label col-md-2 text-right" style="padding-top:7px">ชื่อ-นามสกุล :<span style="color:red;">*</span> </label>
                     <div class="col-md-3">
                         <input type="text" class="form-control" pattern="^[ก-๏a-zA-Z\s]+$" value="" id="cus_name" name="cus_name" required>
                     </div>
                 </div>

                 <div class="form-group" style="margin-top:10px;">
                     <label class="control-label col-md-2 text-right" style="padding-top:7px">วันเกิด :<span style="color:red;"></span> </label>
                     <div class="col-md-3">
                         <input type="text" class="form-control datepicker-cus" autocomplete="off" onfocus="$(this).blur();" value="" name="cus_birth">
                     </div>
                     <div class="col-md-4">
                         <label class="control-label colmd-3">
                             <font color="#8F8D8D">กรุณากรอกวันเกิดของท่านตามจริง</font>
                         </label>
                     </div>
                 </div>

                 <div class="form-group" style="margin-top:10px;">
                     <label class="control-label col-md-2 text-right" style="padding-top:7px">เบอร์โทรศัพท์ :<span style="color:red;">*</span> </label>
                     <div class="col-md-3">
                         <input type="text" class="form-control" required id="cus_tel" minlength="9" maxlength="10" pattern="[0]{1}[2,6,8,9]{1}[0-9]{7,}" oninvalid="this.setCustomValidity('กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" value="" name="cus_tel">
                     </div>
                     <div class="col-md-4">
                         <label class="control-label colmd-3">
                             <font color="#8F8D8D">กรอกเบอร์โทรศัพท์ อย่างน้อย 9 ตัว</font>
                         </label>
                     </div>
                 </div>

                 <div class="form-group" style="margin-top:10px;">
                     <label class="control-label col-md-2 text-right" style="padding-top:7px">อีเมล :<span style="color:red;"></span> </label>
                     <div class="col-md-3">
                         <input type="email" class="form-control" value="" id="cus_email" name="cus_email">
                     </div>
                     <div class="col-md-7">
                         <label class="control-label colmd-3">
                             <font color="#8F8D8D">กรอกอีเมลให้ถูกต้องตามรูปแบบ เช่น email@example.com</font>
                         </label>
                     </div>
                 </div>

                 <div class="form-group" style="margin-top:10px;">
                     <label class="control-label col-md-2 text-right" style="padding-top:7px">ที่อยู่ :<span style="color:red;">*</span> </label>
                     <div class="col-md-4">
                         <textarea name="cus_address" id="cus_address" required cols="30" rows="4" class="form-control"></textarea>
                     </div>
                 </div>

                 <div class="form-group" style="margin-top:10px;">
                     <label class="control-label col-md-2 text-right" style="padding-top:7px">รหัสไปรษณีย์ :<span style="color:red;">*</span> </label>
                     <div class="col-md-3">
                         <input type="text" class="form-control" id="cus_postnum" required style="width:150px" pattern="[1-9]{1}[0-9]{3}[0]{1}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" minlength="5" maxlength="5" value="" name="cus_postnum">
                     </div>
                     <div class="col-md-4">
                         <label class="control-label colmd-3">
                             <font color="#8F8D8D">กรอกเป็นตัวเลข 5 ตัว</font>
                         </label>
                     </div>
                 </div>

                 <div class="col-md-4 col-md-offset-3">
                     <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
                     <button type="reset" class="btn btn-danger">ล้างค่า</button>
                     <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
                 </div>
             </form>
         </div>