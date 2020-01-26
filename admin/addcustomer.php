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
         <form method="POST" action="add_customer.php" enctype="multipart/form-data">
             <div class="form-group">
                 <div class="row">
                     <label class="control-label col-md-4 text-right" style="padding-top:7px">ชื่อ-นามสกุล :<span style="color:red;">*</span> </label>
                     <div class="col-md-8">
                         <input type="text" class="form-control" pattern="^[ก-๏a-zA-Z\s]+$" style="width:300px" value="" name="cus_name" required>
                     </div>
                 </div>
             </div>
             <div class="form-group" style="margin-top:10px;">
                 <div class="row">
                     <label class="control-label col-md-4 text-right" style="padding-top:7px">วันเกิด :<span style="color:red;"></span> </label>
                     <div class="col-md-8">
                         <input type="text" class="form-control datepicker-cus" autocomplete="off" onkeypress="event.preventDefault(); return false;" style="width:300px" value="" name="cus_birth">
                     </div>
                 </div>
             </div>
             <div class="form-group" style="margin-top:10px;">
                 <div class="row">
                     <label class="control-label col-md-4 text-right" style="padding-top:7px">เบอร์โทรศัพท์ :<span style="color:red;">*</span> </label>
                     <div class="col-md-7">
                         <input type="text" class="form-control" style="width:300px" required minlength="9" maxlength="10" pattern="[0]{1}[2,6,8,9]{1}[0-9]{7,}" oninvalid="this.setCustomValidity('กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" value="" name="cus_tel">
                     </div>
                 </div>
             </div>
             <div class="form-group" style="margin-top:10px;">
                 <div class="row">
                     <label class="control-label col-md-4 text-right" style="padding-top:7px">อีเมล :<span style="color:red;"></span> </label>
                     <div class="col-md-8">
                         <input type="text" class="form-control" style="width:300px" value="" name="cus_email">
                     </div>
                 </div>
             </div>
             <div class="form-group" style="margin-top:10px;">
                 <div class="row">
                     <label class="control-label col-md-4 text-right" style="padding-top:7px">ที่อยู่ :<span style="color:red;">*</span> </label>
                     <div class="col-md-5">
                         <textarea name="cus_address" id="cus_address" required cols="30" rows="4" class="form-control"></textarea>
                     </div>
                 </div>
             </div>
             <div class="form-group" style="margin-top:10px;">
                 <div class="row">
                     <label class="control-label col-md-4 text-right" style="padding-top:7px">รหัสไปรษณีย์ :<span style="color:red;">*</span> </label>
                     <div class="col-md-8">
                         <input type="text" class="form-control" required style="width:150px" pattern="[1-9]{1}[0-9]{3}[0]{1}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" minlength="5" maxlength="5" value="" name="cus_postnum">
                     </div>
                 </div>
             </div>
             <hr>
     </div>
     <div class="col-md-4 col-md-offset-5">
         <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
         <button type="reset" class="btn btn-danger">ล้างค่า</button>
         <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
         </form>
     </div>