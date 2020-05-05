<head>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['staff'])) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
    }
    if (!isset($_GET['cusid'])) {
        echo "<script>window.location.assign('show_staff.php')</script>";
    }
    include('conf/header_admin.php');
    include('../conf/function.php');
    ?>
    <title>แก้ไขข้อมูลสมาชิก | Food Order System</title>

    <script>
         $(document).ready(function() {
             $("#editcustomer").validate({
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
                     cus_status: {
                         requred: "<font color='red'>กรุณาเลือกสถานะ</font>",
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
    $sql_edit = "SELECT * FROM customers WHERE cusid = '" . $_GET['cusid'] . "'";
    $result = mysqli_fetch_assoc(mysqli_query($link, $sql_edit));

    if ($result['cus_birth'] == "0000-00-00")
        $cus_birth = "";
    else $cus_birth = tothaiyear($result['cus_birth']);
    ?>
    <div class="container" style="padding-top: 135px; padding-bottom:15px;">
        <h1 class="page-header text-left">แก้ไขข้อมูลสมาชิก</h1>
        <div class="col-md-offset-1 col-md-12">
            <form method="POST" id="editcustomer" class="form-horizontal" action="edit_customer.php" enctype="multipart/form-data">
                <div class="form-group" style="margin-top:10px;">
                    <label class="control-label col-md-2 text-right" style="padding-top:7px">รหัสลูกค้า :</label>
                    <div class="col-md-2">
                        <input type="text" required class="form-control" value="<?php echo $result['cusid']; ?>" name="cusid" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 text-right" style="padding-top:7px">ชื่อ-นามสกุล :<span style="color:red;">*</span> </label>
                    <div class="col-md-3">
                        <input type="text" required class="form-control" id="cus_name" pattern="^[ก-๏a-zA-Z\s]+$" value="<?php echo $result['cus_name']; ?>" name="cus_name">
                    </div>
                </div>

                <div class="form-group" style="margin-top:10px;">
                    <label class="control-label col-md-2 text-right" style="padding-top:7px">วันเกิด :<span style="color:red;"></span> </label>
                    <div class="col-md-3">
                        <input type="text" class="form-control datepicker-cus" onkeypress="event.preventDefault(); return false;" value="<?= $cus_birth ?>" name="cus_birth">
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
                        <input type="text" required class="form-control" minlength="9" maxlength="10" pattern="[0]{1}[2,6,8,9]{1}[0-9]{7,}" oninvalid="this.setCustomValidity('กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" value="<?php echo $result['cus_tel']; ?>" name="cus_tel">
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
                        <input type="email" class="form-control" value="<?php echo $result['cus_email']; ?>" name="cus_email">
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
                        <textarea name="cus_address" required id="" cols="30" rows="4" class="form-control"><?= $result['cus_address']; ?></textarea>
                    </div>
                </div>

                <div class="form-group" style="margin-top:10px;">
                    <label class="control-label col-md-2 text-right" style="padding-top:7px">รหัสไปรษณีย์ :<span style="color:red;">*</span> </label>
                    <div class="col-md-2">
                        <input type="text" required class="form-control" style="width:150px" pattern="[1-9]{1}[0-9]{3}[0]{1}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" minlength="5" maxlength="5" value="<?php echo $result['cus_postnum']; ?>" name="cus_postnum">
                    </div>
                    <div class="col-md-4 col-md-offset-1">
                        <label class="control-label">
                            <font color="#8F8D8D">กรอกเป็นตัวเลข 5 ตัว</font>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2 text-right" style="padding-top:7px">สถานะ:<span style="color:red;">*</span> </label>
                    <div class="col-md-3">
                        <select class="form-control" style="width:250px" name="cus_status" required>
                            <option value="" disabled selected>-- กรุณาเลือกสถานะ --</option>
                            <option <?php if ($result['cus_status'] == 0) echo "selected"; ?> value="0">ลูกค้าปกติ</option>
                            <option <?php if ($result['cus_status'] == 1) echo "selected"; ?> value="1">บัญชีดำ</option>
                        </select>
                    </div>
                </div>
        </div>
        <div class="col-md-4 col-md-offset-5">
            <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
            <button type="reset" class="btn btn-danger">คืนค่า</button>
            <button type="button" class="btn btn-info" onclick="window.history.back()">ย้อนกลับ</button>
            </form>
        </div>
</body>