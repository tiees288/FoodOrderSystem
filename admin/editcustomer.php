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
        <form method="POST" action="edit_customer.php" enctype="multipart/form-data">
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4 text-right" style="padding-top:7px">รหัสลูกค้า :</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" style="width:150px" value="<?php echo $result['cusid']; ?>" name="cusid" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4 text-right" style="padding-top:7px">ชื่อ-นามสกุล :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:300px" pattern="^[ก-๏a-zA-Z\s]+$" value="<?php echo $result['cus_name']; ?>" name="cus_name">
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4 text-right" style="padding-top:7px">วันเกิด :<span style="color:red;"></span> </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control datepicker-cus" onkeypress="event.preventDefault(); return false;" style="width:300px" value="<?= $cus_birth ?>" name="cus_birth">
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4 text-right" style="padding-top:7px">เบอร์โทรศัพท์ :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:300px" minlength="9" maxlength="10" pattern="[0]{1}[2,6,8,9]{1}[0-9]{7,}" oninvalid="this.setCustomValidity('กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" value="<?php echo $result['cus_tel']; ?>" name="cus_tel">
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4 text-right" style="padding-top:7px">อีเมล :<span style="color:red;"></span> </label>
                    <div class="col-md-8">
                        <input type="email" class="form-control" style="width:300px" value="<?php echo $result['cus_email']; ?>" name="cus_email">
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4 text-right" style="padding-top:7px">ที่อยู่ :<span style="color:red;">*</span> </label>
                    <div class="col-md-5">
                        <textarea name="cus_address" id="" cols="30" rows="4" class="form-control"><?= $result['cus_address']; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4 text-right" style="padding-top:7px">รหัสไปรษณีย์ :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:150px" pattern="[1-9]{1}[0-9]{3}[0]{1}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" minlength="5" maxlength="5" value="<?php echo $result['cus_postnum']; ?>" name="cus_postnum">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4 text-right" style="padding-top:7px">สถานะ:<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <select class="form-control" style="width:250px" name="cus_status">
                            <option value="" disabled selected>-- กรุณาเลือกสถานะ --</option>
                            <option <?php if ($result['cus_status'] == 0) echo "selected"; ?> value="0">ลูกค้าปกติ</option>
                            <option <?php if ($result['cus_status'] == 1) echo "selected"; ?> value="1">บัญชีดำ</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-4 col-md-offset-5">
                <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
                <button type="reset" class="btn btn-danger">คืนค่า</button>
                <button type="button" class="btn btn-info" onclick="window.history.back()">ย้อนกลับ</button>
        </form>
    </div>
</body>