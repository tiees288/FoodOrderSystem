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
 </head>

 <body>
     <?php
        include('../conf/connection.php');
        $sql_edit = "SELECT * FROM staff WHERE staffid = '" . $_GET['staffid'] . "'";
        $result = mysqli_fetch_assoc(mysqli_query($link, $sql_edit));
        ?>
     <div class="container" style="padding-top: 135px; padding-bottom:15px;">
         <h1 class="page-header text-left">แก้ไขข้อมูลพนักงาน</h1>
         <form method="POST" action="edit_staff.php" enctype="multipart/form-data">
             <div class="form-group" style="margin-top:10px;">
                 <div class="row">
                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รหัสพนักงาน :</label>
                     <div class="col-md-8">
                         <input type="text" class="form-control" style="width:150px" value="<?php echo $result['staffid']; ?>" name="staffid" readonly>
                     </div>
                 </div>
             </div>
             <div class="form-group">
                 <div class="row">
                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อ-นามสกุล :<span style="color:red;">*</span> </label>
                     <div class="col-md-8">
                         <input type="text" class="form-control" style="width:300px" value="<?php echo $result['staff_name']; ?>" name="staff_name" pattern="^[ก-๏a-zA-Z\s]+$">
                     </div>
                 </div>
             </div>
             <div class="form-group" style="margin-top:10px;">
                 <div class="row">
                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">วันเกิด :<span style="color:red;">*</span> </label>
                     <div class="col-md-8">
                         <input type="text" class="form-control datepicker1" onkeypress="return false; event.preventDefault();" onfocus="$(this).blur();" style="width:300px" value="<?= tothaiyear($result['staff_birth']) ?>" name="staff_birth" required>
                     </div>
                 </div>
             </div>
             <div class="form-group" style="margin-top:10px;">
                 <div class="row">
                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">เบอร์โทรศัพท์ :<span style="color:red;">*</span> </label>
                     <div class="col-md-8">
                         <input type="text" class="form-control" style="width:300px" minlength="9" maxlength="10" pattern="[0]{1}[2,6,8,9]{1}[0-9]{7,}" oninvalid="this.setCustomValidity('กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" value="<?php echo $result['staff_tel']; ?>" name="staff_tel">
                     </div>
                 </div>
             </div>
             <div class="form-group" style="margin-top:10px;">
                 <div class="row">
                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">อีเมล :<span style="color:red;"></span> </label>
                     <div class="col-md-8">
                         <input type="email" class="form-control" style="width:300px" value="<?php echo $result['staff_email']; ?>" name="staff_email">
                     </div>
                 </div>
             </div>
             <div class="form-group" style="margin-top:10px;">
                 <div class="row">
                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ที่อยู่ :<span style="color:red;">*</span> </label>
                     <div class="col-md-5">
                         <textarea name="staff_address" id="" cols="30" rows="4" class="form-control"><?= $result['staff_address']; ?></textarea>
                     </div>
                 </div>
             </div>
             <div class="form-group" style="margin-top:10px;">
                 <div class="row">
                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รหัสไปรษณีย์ :<span style="color:red;">*</span> </label>
                     <div class="col-md-8">
                         <input type="text" class="form-control" style="width:150px" pattern="[1-9]{1}[0-9]{3}[0]{1}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง')" oninput="this.setCustomValidity('')" minlength="5" maxlength="5" value="<?php echo $result['staff_postnum']; ?>" name="staff_postnum">
                     </div>
                 </div>
             </div>
             <div class="form-group" style="margin-top:10px;">
                 <div class="row">
                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หมายเลขบัตรประชาชน:<span style="color:red;">*</span></label>
                     <div class="col-md-8">
                         <input type="text" class="form-control" style="width:300px" onkeypress="return isNumberKey(event)" minlength="13" maxlength="13" value="<?php echo $result['staff_nationid']; ?>" name="staff_nationid" readonly>
                     </div>
                 </div>
             </div>
             <div class="form-group">
                 <div class="row">
                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ระดับ:<span style="color:red;">*</span> </label>
                     <div class="col-md-8">
                         <select class="form-control" style="width:250px" name="staff_level">
                             <option value="" disabled selected>-- กรุณาเลือกระดับ --</option>
                             <option <?php if ($result['staff_level'] == 0) echo "selected"; ?> value="0">พนักงาน</option>
                             <option <?php if ($result['staff_level'] == 1) echo "selected"; ?> value="1">เจ้าของร้าน</option>
                         </select>
                     </div>
                 </div>
             </div>
             <div class="form-group">
                 <div class="row">
                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สถานะ:<span style="color:red;">*</span> </label>
                     <div class="col-md-8">
                         <select class="form-control" style="width:250px" name="staff_status">
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