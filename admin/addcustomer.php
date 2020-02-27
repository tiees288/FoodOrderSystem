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
 </head>

 <body>
     <div class="container" style="padding-top: 135px;">
         <h1 class="page-header text-left">เพิ่มข้อมูลสมาชิก</h1>
         <div class="col-md-offset-1 col-md-12">
             <form method="POST" class="form-horizontal" action="add_customer.php" enctype="multipart/form-data">
                 <div class="form-group">
                     <label class="control-label col-md-2 text-right" style="padding-top:7px">ชื่อ-นามสกุล :<span style="color:red;">*</span> </label>
                     <div class="col-md-3">
                         <input type="text" class="form-control" pattern="^[ก-๏a-zA-Z\s]+$" value="" name="cus_name" required>
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
                         <input type="text" class="form-control" required minlength="9" maxlength="10" pattern="[0]{1}[2,6,8,9]{1}[0-9]{7,}" oninvalid="this.setCustomValidity('กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" value="" name="cus_tel">
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
                         <input type="email" class="form-control" value="" name="cus_email">
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
                         <input type="text" class="form-control" required style="width:150px" pattern="[1-9]{1}[0-9]{3}[0]{1}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" minlength="5" maxlength="5" value="" name="cus_postnum">
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