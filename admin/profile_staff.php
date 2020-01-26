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
    ?>
</head>

<body>
    <?php
    include("conf/header_admin.php");
    require_once("../conf/connection.php");
    require_once("../conf/function.php");

    $sql_user    =    "SELECT * FROM staff WHERE staffid = '" . $_SESSION['staff_id'] . "'";
    $data_user    =    mysqli_query($link, $sql_user);
    $get_user    =    mysqli_fetch_assoc($data_user);
    ?>
    <div class="container" style="padding-top: 135px;">
        <h1 class="page-header text-left">แก้ไขข้อมูลผู้ใช้</h1>
        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <div class="col-md-1"></div>
                <label class="control-label col-md-2" for="name">รหัสพนักงาน :</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="userid" name="userid" value="<?= $_SESSION['staff_id'] ?>" style="width:350px" disabled>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-1"></div>
                <label class="control-label col-md-2" for="name">ชื่อ - นามสกุล :<font color="red">*</font></label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="name" name="name" value="<?= $get_user['staff_name'] ?>" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-1"></div>
                <label class="control-label col-md-2" for="name">วันเกิด :<font color="red">*</font></label>
                <div class="col-md-2" style="width:450">
                    <input class="form-control datepicker1" id="birthdate" type="text" style="padding-left:10px;" onkeypress="return false;" onfocus="$(this).blur();" name="birthdate" value="<?= tothaiyear($get_user['staff_birth']) ?>" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-1"></div>
                <label class="control-label col-md-2" for="number_phone">เบอร์โทรศัพท์ :<font color="red">*</font>
                </label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="number_phone" name="number_phone" pattern="[0]{1}[2,6,8,9]{1}[0-9]{7,}" oninvalid="this.setCustomValidity('กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" type="text" minlength="9" maxlength="10" value="<?= $get_user['staff_tel'] ?>" required>
                </div>

            </div>
            <div class="form-group">
                <div class="col-md-1"></div>
                <label class="control-label col-md-2" for="email">อีเมล :<font color="red"></font></label>
                <div class="col-md-6">
                    <input type="email" class="form-control" id="email" name="email" value="<?= $get_user['staff_email'] ?>">
                </div>

            </div>
            <div class="form-group">
                <div class="col-md-1"></div>
                <label class="control-label col-md-2" for="address">ที่อยู่ :<font color="red">*</font></label>
                <div class="col-md-6">
                    <textarea name="address" cols="30" rows="4" required class="form-control"><?= $get_user['staff_address'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-1"></div>
                <label class="control-label col-md-2" for="postnumber">รหัสไปรษณีย์ :<font color="red">*</font></label>
                <div class="col-md-6" style="width:200px">
                    <input type="text" class="form-control" id="postnumber" name="postnumber" pattern="[1-9]{1}[0-9]{3}[0]{1}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" type="text" minlength="5" maxlength="5" value="<?= $get_user['staff_postnum'] ?>" required>
                </div>

            </div>
            <div class="form-group">
                <div class="col-md-1"></div>
                <label class="control-label col-md-2" for="user_name">ชื่อผู้ใช้ :</label>
                <div class="col-md-6" style="width:200px">
                    <input type="text" class="form-control" name="user_name" value="<?= $get_user['staff_username'] ?>" readonly>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-1"></div>
                <label class="control-label col-md-2" for="postnumber">หมายเลขบัตรประชาชน :</label>
                <div class="col-md-6" style="width:450px;">
                    <input type="text" class="form-control" id="ืnationid" name="nationid" value="<?= $get_user['staff_nationid'] ?>" disabled>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-1"></div>
                <label class="control-label col-md-2" for="password">รหัสผ่าน :<font color="red"></font></label>
                <div class="col-md-6">
                    <input type="password" class="form-control" name="password" minlength="8" maxlength="16" value="">
                </div>

            </div>
            <div class="form-group">
                <div class="col-md-1"></div>
                <label class="control-label col-md-2" for="cf_password">ยืนยันรหัสผ่าน :<font color="red"></font>
                </label>
                <div class="col-md-6">
                    <input type="password" class="form-control" name="cf_password" minlength="8" maxlength="16" value="" oninput='cf_password.setCustomValidity(cf_password.value != password.value ? "กรุณากรอกรหัสผ่านให้ตรงกัน!" : "")'>
                </div>

            </div>

            <div class="form-group">
                <div class="col-md-1"></div>
                <div class="col-md-offset-4 col-md-6">
                    <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
                    <button type="reset" class="btn btn-danger">คืนค่า</button>
                    <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
                </div>
            </div>
        </form>

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
    $data_user1     = mysqli_query($link, "SELECT * FROM staff WHERE staff_username = '" . $user_name . "'");
    $data1             = mysqli_fetch_assoc($data_user1);

    /*if(($data1['c_user'] != "") and ($_SESSION['user_id'] != $_POST['cusid'] )){
			echo "<script> alert('ชื่อผู้ใช้ซ้ำ'); window.history.back(); </script>"; 
		
				
			exit();
		}*/
    if ($password == "" && $_POST['cf_password'] == "") {
        // กรณีไม่เปลี่ยน Password
        $sql_update     = "UPDATE staff SET 
							staff_name		= '" . $name . "',
							staff_birth		= '" . $cus_birth . "',
							staff_address		= '" . $address . "',
							staff_tel		= '" . $number_phone . "',
							staff_postnum		= '" . $cus_postnum . "',
							staff_email		= '" . $email . "'  WHERE staffid = '" . $_SESSION['staff_id'] . "'";
    } else {
        if ($password != $_POST['cf_password']) {
            echo "<script> alert('รหัสผ่านไม่ตรงกัน');</script>";
            exit();
        }

        $sql_update     = "UPDATE staff SET 
			staff_name		= '" . $name . "',
			staff_birth		= '" . $cus_birth . "',
			staff_tel			= '" . $number_phone . "',
			staff_email		= '" . $email . "',
			staff_address		= '" . $address . "',
			staff_postnum		= '" . $cus_postnum . "',
			staff_password	= '" . sha1($password) . "' WHERE staffid = '" . $_SESSION['staff_id'] . "'";
    }


    //อัพแดท ข้อมูล ผู้ใช้งาน
    if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
        //   $data_user     = mysqli_query($link, "SELECT * FROM customerห WHERE cusid = '" . $_SESSION['user_id'] . "'");
        // $data         = mysqli_fetch_assoc($data_user);
        //	$_SESSION['user'] 	= $data['cus_user'];	
        echo "<script> alert('แก้ไขข้อมูลเรียบร้อยแล้ว'); window.location.assign('index.php')</script>";
    }
}
?>