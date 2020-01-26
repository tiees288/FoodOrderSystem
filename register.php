<head>
	<title>สมัครสมาชิก | Food Order System</title>
	<?php
	if (!isset($_SESSION)) {  // Check if sessio nalready start
		session_start();
	}
	?>

	<link rel="shortcut icon" href="favicon.ico" />

</head>

<body>
	<?php
	if (isset($_SESSION['user'])) {
		header("Location: index.php");
		exit();
	} // ตรวจสอบว่ามีการเข้าสู่ระแบบแล้วหรือยัง

	include("conf/header.php");
	?>
	<div class="container" style="padding-top: 90px;">
		<div class="col">
			<h1 class="page-header text-left">สมัครสมาชิก</h1>
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" action="register_action.php" method="post">
					<div class="form-group">
						<label class="control-label col-md-2" for="name">ชื่อ - นามสกุล :<font color="red">*</font></label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="name" name="name" pattern="^[ก-๏a-zA-Z\s]+$" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2" for="name">วันเกิด :<font color="red"></font></label>
						<div class="col-md-3">
							<input type="text" id="birthdate" name="birthdate" class="form-control datepicker" onfocus="$(this).blur();" onkeypress="return false;" style="padding-left:10px" data-provide="datepicker" autocomplete="off" data-date-format="dd/mm//yyyy">
						</div>
						<div class="col-md-4 col-md-offset-1">
							<label class="control-label colmd-3">
								<font color="#BEBEBE">กรุณากรอกวันเกิดของท่านตามจริง</font>
							</label>
						</div>
					</div>

					<!--	<div class="form-group">
						<label class="control-label col-md-2" for="name">วันเกิด :<font color="red">*</font></label>
						<div class="col-md-2" style="width:450">
							<input class="form-control" id="birthdate " type="date" name="birthdate" max="<?= date("Y-m-d"); ?>" value="" required>
						</div>
					</div> -->

					<div class="form-group">
						<label class="control-label col-md-2" for="number_phone">เบอร์โทรศัพท์ :<font color="red">*</font></label>
						<div class="col-md-3">
							<input type="text" class="form-control" id="number_phone" name="number_phone" pattern="[0]{1}[2,6,8,9]{1}[0-9]{7,}" oninvalid="this.setCustomValidity('กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" type="text" minlength="9" maxlength="10" required>
						</div>
						<div class="col-md-offset-1 col-md-6">
							<label class="control-label col-md-1d3">
								<font color="#BEBEBE">กรอกเบอร์โทรศัพท์ อย่างน้อย 9 ตัว</font>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2" for="email">อีเมล :<font color="red">*</font></label>
						<div class="col-md-4">
							<input type="email" class="form-control" id="email" name="email" required>
						</div>
						<div class="col-md-6">
							<label class="control-label">
								<font color="#BEBEBE">กรอกอีเมลให้ถูกต้องตามรูปแบบ เช่น email@example.com</font>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2" for="address">ที่อยู่ :<font color="red">*</font></label>
						<div class="col-md-5">
							<textarea name="address" id="" cols="30" rows="4" class="form-control"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2" for="postnumber">รหัสไปรษณีย์ :<font color="red">*</font></label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="postnumber" name="postnumber" pattern="[1-9]{1}[0-9]{3}[0]{1}" oninvalid="this.setCustomValidity('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง')" oninput="this.setCustomValidity('')" onkeypress="return isNumberKey(event)" type="text" minlength="5" maxlength="5" required>
						</div>
						<div class="col-md-4">
							<label class="control-label" >
								<font color="#BEBEBE">กรอกเป็นตัวเลข 5 ตัว</font>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2" for="user_name">ชื่อผู้ใช้ :<font color="red">*</font></label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="user_name" name="user_name" minlength="5" pattern="^[a-zA-Z0-9\s]+$" required style="width:250">
						</div>
						<div class="col-md-4">
							<label class="control-label">
								<font color="#BEBEBE">กรอกเป็นตัวอักษร A-z และ 0-9 อย่างน้อย 5 ตัว</font>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2" for="password" required>รหัสผ่าน :<font color="red">*</font></label>
						<div class="col-md-4">
							<input type="password" class="form-control" id="password" name="password" required minlength="8" maxlength="16">
						</div>
						<div class="col-md-4">
							<label class="control-label colmd-3">
								<font color="#BEBEBE">กรอกอย่างน้อย 8-16 ตัว</font>
							</label>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2" for="cf_password" required>ยืนยันรหัสผ่าน :<font color="red">*</font></label>
						<div class="col-md-4">
							<input type="password" class="form-control" id="cf_password" name="cf_password" required minlength="8" maxlength="16" oninput='cf_password.setCustomValidity(cf_password.value != password.value ? "กรุณากรอกรหัสผ่านให้ตรงกัน!" : "")'>
						</div>
						<div class="col-md-4">
							<label class="control-label colmd-3">
								<font color="#BEBEBE">กรอกอย่างน้อย 8-16 ตัว ให้ตรงกับรหัสผ่าน</font>
							</label>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-4 col-md-6">
							<button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
							<button type="reset" class="btn btn-danger">ล้างค่า</button>
							<button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<p>
		<p>
			<?php include("conf/footer.php"); ?>
</body>