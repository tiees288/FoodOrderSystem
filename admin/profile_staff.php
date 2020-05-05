<head>
    <title>แก้ไขข้อมูลผู้ใช้ | Food Order System</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <?php
    if (!isset($_SESSION)) {  // Check if sessio nalready start
        session_start();
    }

    if (!isset($_SESSION['staff'])) {
        echo  "<script> alert('กรุณาเข้าสู่ระบบ');window.location.assign('index.php') </script>";
        exit();
    }
    include("conf/header_admin.php");
    ?>

    <script>
        function isPasswordPresent() {
            console.log($('#password').val());
            return $('#password').val().length > 0;
        }
        $(document).ready(function() {
            $("#profilestaff").validate({
                rules: {
                    password: {
                        //required: true is not required
                        minlength: {
                            depends: isPasswordPresent,
                            param: 8
                        },
                        maxlength: {
                            depends: isPasswordPresent,
                            param: 16
                        },
                    },
                    cf_password: {
                        required: isPasswordPresent,
                        minlength: 8,
                        equalTo: {
                            depends: isPasswordPresent,
                            param: '#password',
                        }
                    },
                },
                messages: {
                    name: {
                        required: "<font color='red'>กรุณากรอก ชื่อ-นามสกุล</font>",
                        //minlength: "<font color='red'>กรุณากรอก มากกว่า 5 ตัวอักษร</font>",
                        pattern: "<font color='red'>กรุณากรอกเฉพาะ ตัวอักษรเท่านั้น",
                    },
                    birthdate: {
                        required: "<font color='red'>กรุณาเลือกวันเกิด</font>",
                    },
                    number_phone: {
                        required: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
                        digits: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
                        minlength: "<font color='red'>กรุณากรอกไม่น้อยกว่า 9 ตัวอักษร</font>",
                        maxlength: "<font color='red'>กรุณากรอกไม่เกิน 10 ตัวอักษร</font>",
                        pattern: "<font color='red'>กรุณาระบุเบอร์โทรศัพท์ให้ถูกต้อง</font>",
                    },
                    email: {
                        email: "<font color='red'>กรุณากรอกอีเมลในรูปแบบที่ถูกต้อง</font>",
                    },
                    postnumber: {
                        required: "<font color='red'>กรุณากรอกรหัสไปรษณีย์</font>",
                        minlength: "<font color='red'>กรุุณากรอกให้ครบ 5 ตัวอักษร</font>",
                        maxlength: "<font color='red'>กรุุณากรอกให้ครบ 5 ตัวอักษร</font>",
                        pattern: "<font color='red'>กรุุณากรอกรหัสไปรษณีย์ที่ถูกต้อง</font>",
                    },
                    address: {
                        required: "<font color='red'>กรุณากรอกที่อยู่ของท่าน</font>",
                    },
                    nationid: {
                        required: "<font color='red'>กรุณาเกรอกหมายเลขบัตรประชาชน</font>",
                        max: "<font color='red'>กรุณากรอกให้ครบ 13 หลัก</font>",
                        min: "<font color='red'>กรุณากรอกให้ครบ 13 หลัก</font>",
                    },
                    password: {
						minlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-16 ตัวอักษร</font>",
						maxlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-16 ตัวอักษร</font>",
					},
					cf_password: {
						required: "<font color='red'>กรุณากรอกรหัสผ่านให้ตรงกัน</font>",
						minlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-16 ตัวอักษร</font>",
						maxlength: "<font color='red'>กรุณากรอกอย่างน้อย 8-16 ตัวอักษร</font>",
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
    <?php
    require_once("../conf/connection.php");
    require_once("../conf/function.php");

    $sql_user    =    "SELECT * FROM staff WHERE staffid = '" . $_SESSION['staff_id'] . "'";
    $data_user    =    mysqli_query($link, $sql_user);
    $get_user    =    mysqli_fetch_assoc($data_user);
    ?>
    <div class="container" style="padding-top: 135px;">
        <h1 class="page-header text-left">แก้ไขข้อมูลผู้ใช้</h1>
        <div class="col-md-offset-1 col-md-10">
            <form class="form-horizontal" id="profilestaff" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label class="control-label col-md-3" for="name">รหัสพนักงาน :</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="userid" name="userid" value="<?= $_SESSION['staff_id'] ?>" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="name">ชื่อ - นามสกุล :<font color="red">*</font></label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $get_user['staff_name'] ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="name">วันเกิด :<font color="red">*</font></label>
                    <div class="col-md-3">
                        <input class="form-control datepicker1" id="birthdate" type="text" style="padding-left:10px;" onkeypress="return false;" onfocus="$(this).blur();" name="birthdate" value="<?= tothaiyear($get_user['staff_birth']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label colmd-3">
                            <font color="#8F8D8D">กรุณากรอกวันเกิดของท่านตามจริง</font>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="number_phone">เบอร์โทรศัพท์ :<font color="red">*</font></label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="number_phone" name="number_phone" pattern="[0]{1}[2,6,8,9]{1}[0-9]{7,}" oninvalid="this.setCustomValidity('กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" type="text" minlength="9" maxlength="10" value="<?= $get_user['staff_tel'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label col-md-1d3">
                            <font color="#8F8D8D">กรอกเบอร์โทรศัพท์ อย่างน้อย 9 ตัว</font>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3" for="email">อีเมล :<font color="red"></font></label>
                    <div class="col-md-3">
                        <input type="email" class="form-control" id="email" name="email" value="<?= $get_user['staff_email'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">
                            <font color="#8F8D8D">กรอกอีเมลให้ถูกต้องตามรูปแบบ เช่น email@example.com</font>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="address">ที่อยู่ :<font color="red">*</font></label>
                    <div class="col-md-4">
                        <textarea name="address" cols="30" rows="4" required class="form-control"><?= $get_user['staff_address'] ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="postnumber">รหัสไปรษณีย์ :<font color="red">*</font></label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="postnumber" name="postnumber" pattern="[1-9]{1}[0-9]{3}[0]{1}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" type="text" minlength="5" maxlength="5" value="<?= $get_user['staff_postnum'] ?>" required>
                    </div>
                    <div class="col-md-3 col-m-1">
                        <label class="control-label">
                            <font color="#8F8D8D">กรอกเป็นตัวเลข 5 ตัว</font>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="user_name">ชื่อผู้ใช้ :</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="user_name" value="<?= $get_user['staff_username'] ?>" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="postnumber">หมายเลขบัตรประชาชน :<font color="red">*</font></label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="nationid" name="nationid" value="<?= $get_user['staff_nationid'] ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label">
                            <font color="#8F8D8D"> กรอกหมายเลขบัตรประชาชนให้ครบ 13 หลัก</font>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="password">รหัสผ่าน :<font color="red"></font></label>
                    <div class="col-md-3">
                        <input type="password" class="form-control" id="password" name="password" minlength="8" maxlength="16" value="">
                    </div>
                    <div class="col-md-4">
                        <label class="control-label colmd-3">
                            <font color="#8F8D8D">กรอกอย่างน้อย 8-16 ตัว</font>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="cf_password">ยืนยันรหัสผ่าน :<font color="red"></font>
                    </label>
                    <div class="col-md-3">
                        <input type="password" class="form-control" id="cf_password" name="cf_password" minlength="8" maxlength="16" value="" oninput='cf_password.setCustomValidity(cf_password.value != password.value ? "กรุณากรอกรหัสผ่านให้ตรงกัน!" : "")'>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label colmd-3">
                            <font color="#8F8D8D">กรอกอย่างน้อย 8-16 ตัว ให้ตรงกับรหัสผ่าน</font>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-4 col-md-6">
                        <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
                        <button type="reset" class="btn btn-danger">คืนค่า</button>
                        <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php include("../conf/footer.php"); ?>
</body>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require('../conf/connection.php');
    $name            =    $_POST['name'];
    $cus_birth        =    tochristyear($_POST['birthdate']);
    $number_phone    =    $_POST['number_phone'];
    $email            =    $_POST['email'];
    $address         =    $_POST['address'];
    $user_name        =    $_POST['user_name'];
    $password        =    $_POST['password'];
    $cus_postnum    =    $_POST['postnumber'];
    //$data_user1     = mysqli_query($link, "SELECT * FROM staff WHERE staff_username = '" . $user_name . "'");
    //$data1             = mysqli_fetch_assoc($data_user1);

    if ($password == "" && $_POST['cf_password'] == "") {
        // กรณีไม่เปลี่ยน Password
        $sql_update     = "UPDATE staff SET 
							staff_name		= '" . $name . "',
							staff_birth		= '" . $cus_birth . "',
							staff_address	= '" . $address . "',
							staff_tel		= '" . $number_phone . "',
                            staff_nationid  = '" . $_POST['nationid'] . "',
							staff_postnum	= '" . $cus_postnum . "',
							staff_email		= '" . $email . "'  WHERE staffid = '" . $_SESSION['staff_id'] . "'";
    } else {
        if ($password != $_POST['cf_password']) {
            echo "<script> alert('รหัสผ่านไม่ตรงกัน');</script>";
            exit();
        }

        $sql_update     = "UPDATE staff SET 
			staff_name		= '" . $name . "',
			staff_birth		= '" . $cus_birth . "',
			staff_tel		= '" . $number_phone . "',
            staff_nationid  = '" . $_POST['nationid'] . "',
			staff_email		= '" . $email . "',
			staff_address	= '" . $address . "',
			staff_postnum	= '" . $cus_postnum . "',
			staff_password	= '" . sha1($password) . "' WHERE staffid = '" . $_SESSION['staff_id'] . "'";
    }

    // ตรวจสอบหมายเลขบัตรประชาชนซ้ำ
    $sql_chk_nation = "SELECT staffid FROM staff WHERE staff_nationid = '" . $_POST['nationid'] . "' AND staff_username != '$user_name'";
    $query_chk_nation = mysqli_query($link, $sql_chk_nation) or die(mysqli_error($link));

    if (mysqli_num_rows($query_chk_nation) > 0) {
        echo "<script>alert('หมายเลขบัตรประชาชนนี้ถูกใช้แล้ว'); window.history.back(); </script>";
        exit();
    }

    if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
        echo "<script> alert('แก้ไขข้อมูลเรียบร้อยแล้ว'); window.location.assign('index.php')</script>";
    }
}
?>