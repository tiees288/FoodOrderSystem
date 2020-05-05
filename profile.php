<head>
	<title>แก้ไขข้อมูลผู้ใช้ | Food Order System</title>
	<link rel="shortcut icon" href="favicon.ico" />
	<?php
	if (!isset($_SESSION)) {  // Check if sessio nalready start
		session_start();
	}

	if (!isset($_SESSION['user'])) {
		echo  "<script> alert('กรุณาเข้าสู่ระบบ');window.location.assign('index.php') </script>";
		exit();
	}
	include("conf/header.php");

	?>

	<script type="text/javascript">
		function isNumberKey(evt) {
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode != 46 && charCode > 31 &&
				(charCode < 48 || charCode > 57))
				return false;
			return true;
		}


		function isNumericKey(evt) {
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode != 46 && charCode > 31 &&
				(charCode < 48 || charCode > 57))
				return true;
			return false;
		}

		// function valid(target) {
		// 	var name = $('#name').val();
		// 	var name2 = document.getElementById('name');


		// 	$('#profile').validator();

		// 	// if (1) {
		// 	// 	console.log("Checked.");
		// 	// 	//name2.setCustomValidity("ERROR");
		// 	// 	target.setCustomValidity("ERROR");



		// 	// }

		// 	console.log(name);
		// }

		function reset_form() {
			var number_phone = document.getElementById('number_phone');
			var post_num = document.getElementById('postnumber');
			var cf_password = document.getElementById('cf_password');

			post_num.setCustomValidity('');
			number_phone.setCustomValidity('');
			cf_password.setCustomValidity('');
		}

		function isPasswordPresent() {
			console.log($('#password').val());
			return $('#password').val().length > 0;
		}
		// Wait for the DOM to be ready
		$(document).ready(function() {
			console.log('ready');
			$("#profile").validate({
				// Specify validation rules
				focusout: true,
				rules: {
					name: {
						required: true,
					},
					email: {
						required: true,
						email: true,
					},
					number_phone: {
						required: true,
						digits: true,
						minlength: 10,
						maxlength: 10,
					},
					postnumber: {
						required: true,
						minlength: 5,
						maxlength: 5,
					},
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
							param: "password",
						}
					},
				},
				messages: {
					name: {
						required: "<font color='red'>กรุณากรอก ชื่อ-นามสกุล</font>",
					},
					number_phone: {
						required: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
						digits: "<font color='red'>กรุณากรอกเบอร์โทรศัพท์</font>",
						minlength: "<font color='red'>กรุณาระบุ ไม่น้อยกว่า 9 ตัวอักษร</font>",
						maxlength: "<font color='red'>กรุณาระบุ ไม่เกิน 10 ตัวอักษร</font>",
						pattern: "<font color='red'>กรุณาระบุเบอร์โทรศัพท์ให้ถูกต้อง</font>",
					},
					email: {
						required: "<font color='red'>กรุณากรอกอีเมลของท่าน</font>",
						email: "<font color='red'>กรุณากรอกอีเมลในรูปแบบที่ถูกต้อง</font>",
					},
					postnumber: {
						required: "<font color='red'>กรุณากรอกรหัสไปรษณีย์</font>",
						minlength: "<font color='red'>กรุุณากรอก ให้ครบ 5 ตัวอักษร</font>",
						maxlength: "<font color='red'>กรุุณากรอก ให้ครบ 5 ตัวอักษร</font>",
						pattern: "<font color='red'>กรุุณากรอกรหัสไปรษณีย์ที่ถูกต้อง</font>",
					},

					address: {
						required: "<font color='red'>กรุณากรอกที่อยู่ของท่าน</font>",
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
	require_once("conf/connection.php");
	require_once("conf/function.php");

	$sql_user	=	"SELECT * FROM customers WHERE cusid = '" . $_SESSION['user_id'] . "'";
	$data_user	=	mysqli_query($link, $sql_user);
	$get_user	=	mysqli_fetch_assoc($data_user);

	if ($get_user['cus_birth'] == "0000-00-00")
		$cus_birth = "";
	else $cus_birth = tothaiyear($get_user['cus_birth']);
	?>
	<div class="container" style="padding-top: 90px;">
		<h1 class="page-header text-left">แก้ไขข้อมูลผู้ใช้</h1>
		<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" name="profile" id="profile" onchange="//validators()" onreset="reset_form()" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<div class="form-group">
					<label class="control-label col-md-2" for="name">รหัสลูกค้า :</label>
					<div class="col-md-2">
						<input type="text" class="form-control" id="userid" name="userid" value="<?= $_SESSION['user_id'] ?>" disabled>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2" for="name">ชื่อ - นามสกุล :<font color="red">*</font></label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="name" name="name" value="<?= $get_user['cus_name'] ?>" pattern="^[ก-๏a-zA-Z\s]+$" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2" for="name">วันเกิด :<font color="red"></font></label>
					<div class="col-md-3">
						<input style="padding-left:15px;" class="form-control datepicker" autocomplete="off" onfocus="$(this).blur();" onkeypress="return false; this.preventDefault();" id="birthdate" type="text" name="birthdate" value="<?= $cus_birth ?>">
					</div>
					<div class="col-md-4 col-md-offset-1">
						<label class="control-label colmd-3">
							<font color="#8F8D8D">กรุณากรอกวันเกิดของท่านตามจริง</font>
						</label>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2" for="number_phone">เบอร์โทรศัพท์ :<font color="red">*</font>
					</label>
					<div class="col-md-3">
						<input type="text" class="form-control" id="number_phone" name="number_phone" pattern="[0]{1}[2,6,8,9]{1}[0-9]{7,}" oninvalid="this.setCustomValidity('กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" type="text" minlength="9" maxlength="10" value="<?= $get_user['cus_tel'] ?>" required>
					</div>
					<div class="col-md-offset-1 col-md-6">
						<label class="control-label col-md-1d3">
							<font color="#8F8D8D">กรอกเบอร์โทรศัพท์ อย่างน้อย 9 ตัว</font>
						</label>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2" for="email">อีเมล :<font color="red">*</font></label>
					<div class="col-md-4">
						<input type="email" class="form-control" id="email" name="email" value="<?= $get_user['cus_email'] ?>" required>
					</div>
					<div class="col-md-6">
						<label class="control-label">
							<font color="#8F8D8D">กรอกอีเมลให้ถูกต้องตามรูปแบบ เช่น email@example.com</font>
						</label>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2" for="address">ที่อยู่ :<font color="red">*</font></label>
					<div class="col-md-4">
						<textarea name="address" cols="30" rows="4" required class="form-control"><?= $get_user['cus_address'] ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2" for="postnumber">รหัสไปรษณีย์ :<font color="red">*</font></label>
					<div class="col-md-3">
						<input type="text" class="form-control" id="postnumber" name="postnumber" pattern="[1-9]{1}[0-9]{3}[0]{1}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" type="text" minlength="5" maxlength="5" value="<?= $get_user['cus_postnum'] ?>" required>
					</div>
					<div class="col-md-3 col-md-offset-1">
						<label class="control-label">
							<font color="#8F8D8D">กรอกเป็นตัวเลข 5 ตัว</font>
						</label>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2" for="user_name">ชื่อผู้ใช้ :</label>
					<div class="col-md-2">
						<input type="text" class="form-control" name="user_name" value="<?= $get_user['cus_user'] ?>" readonly>
					</div>

				</div>

				<div class="form-group">
					<label class="control-label col-md-2" for="password">รหัสผ่าน :<font color="red"></font></label>
					<div class="col-md-3">
						<input type="password" class="form-control" id="password" name="password" minlength="8" maxlength="16" value="">
					</div>
					<div class="col-md-4 col-md-offset-1"">
						<label class=" control-label colmd-3">
						<font color="#8F8D8D">กรอกอย่างน้อย 8-16 ตัว</font>
						</label>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2" for="cf_password">ยืนยันรหัสผ่าน :<font color="red"></font>
					</label>
					<div class="col-md-3">
						<input type="password" class="form-control" id="cf_password" name="cf_password" oninput='cf_password.setCustomValidity(cf_password.value != password.value ? "กรุณากรอกรหัสผ่านให้ตรงกัน!" : "")' minlength="8" maxlength="16" value="">
					</div>
					<div class="col-md-4 col-md-offset-1">
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
	<?php include("conf/footer.php"); ?>
</body>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	require('conf/connection.php');
	$name			=	$_POST['name'];
	$cus_birth		= 	tochristyear($_POST['birthdate']);
	$number_phone	=	$_POST['number_phone'];
	$email			=	$_POST['email'];
	$address 		=	$_POST['address'];
	$user_name		=	$_POST['user_name'];
	$password		=	$_POST['password'];
	$cus_postnum	=	$_POST['postnumber'];
	$data_user1 	= mysqli_query($link, "SELECT * FROM customers WHERE cus_user = '" . $user_name . "'");
	$data1 			= mysqli_fetch_assoc($data_user1);

	/*if(($data1['c_user'] != "") and ($_SESSION['user_id'] != $_POST['cusid'] )){
			echo "<script> alert('ชื่อผู้ใช้ซ้ำ'); window.history.back(); </script>"; 
		
				
			exit();
		}*/
	if ($password == "" && $_POST['cf_password'] == "") {
		// กรณีไม่เปลี่ยน Password
		$sql_update 	= "UPDATE customers SET 
							cus_name		= '" . $name . "',
							cus_birth		= '" . $cus_birth . "',
							cus_address		= '" . $address . "',
							cus_tel		= '" . $number_phone . "',
							cus_postnum		= '" . $cus_postnum . "',
							cus_email		= '" . $email . "'  WHERE cusid = '" . $_SESSION['user_id'] . "'";
	} else {
		if ($password != $_POST['cf_password']) {
			echo "<script> alert('รหัสผ่านไม่ตรงกัน');</script>";
			exit();
		}

		$sql_update 	= "UPDATE customers SET 
			cus_name		= '" . $name . "',
			cus_birth		= '" . $cus_birth . "',
			cus_tel			= '" . $number_phone . "',
			cus_email		= '" . $email . "',
			cus_address		= '" . $address . "',
			cus_postnum		= '" . $cus_postnum . "',
			cus_password	= '" . sha1($password) . "' WHERE cusid = '" . $_SESSION['user_id'] . "'";
	}


	//อัพแดท ข้อมูล ผู้ใช้งาน
	if (mysqli_query($link, $sql_update)) {
		//$data_user 	= mysqli_query($link, "SELECT * FROM customers WHERE cusid = '" . $_SESSION['user_id'] . "'");
		//$data 		= mysqli_fetch_assoc($data_user);
		//	$_SESSION['user'] 	= $data['cus_user'];	
		echo "<script> alert('แก้ไขข้อมูลเรียบร้อยแล้ว'); window.location.assign('index.php')</script>";
	}
}
?>