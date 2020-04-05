<head>
	<title>สมัครสมาชิก | Food Order System</title>
	<?php
	if (!isset($_SESSION)) {  // Check if sessio nalready start
		session_start();
	}
	?>

	<link rel="shortcut icon" href="favicon.ico" />
	<style>
		.loader {
			display: none;
			margin-top: 5px;
			border: 5px solid #f3f3f3;
			/* Light grey */
			border-top: 5px solid #3498db;
			/* Blue */
			border-radius: 50%;
			width: 20px;
			height: 20px;
			animation: spin 2s linear infinite;
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}
	</style>

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
				<form class="form-horizontal" id="register" action="register_action.php" method="post">
					<div class="form-group">
						<label class="control-label col-md-2" for="name">ชื่อ - นามสกุล :<font color="red">*</font></label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="name" minlength="5" maxlength="30"  name="name" pattern="^[ก-๏a-zA-Z\s]+$" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2" for="name">วันเกิด :<font color="red"></font></label>
						<div class="col-md-3">
							<input type="text" id="birthdate" name="birthdate" class="form-control datepicker" onfocus="$(this).blur();" onkeypress="return false;" style="padding-left:10px" data-provide="datepicker" autocomplete="off" data-date-format="dd/mm//yyyy">
						</div>
						<div class="col-md-4 col-md-offset-1">
							<label class="control-label colmd-3">
								<font color="#8F8D8D">กรุณากรอกวันเกิดของท่านตามจริง</font>
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
								<font color="#8F8D8D">กรอกเบอร์โทรศัพท์ อย่างน้อย 9 ตัว</font>
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
								<font color="#8F8D8D">กรอกอีเมลให้ถูกต้องตามรูปแบบ เช่น email@example.com</font>
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
							<label class="control-label">
								<font color="#8F8D8D">กรอกเป็นตัวเลข 5 ตัว</font>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2" for="user_name">ชื่อผู้ใช้ :<font color="red">*</font></label>
						<div class="col-md-3">
							<input type="text" class="form-control" onblur="check_form(this.val,'username');" id="user_name" name="user_name" minlength="5" pattern="^[a-zA-Z0-9\s]+$" required>
						</div>
						<div class="col-md-1">
							<div id="loading" class="loader"></div>
							<span id="user-r"></span>
						</div>
						<div class="col-md-4">
							<label class="control-label">
								<font color="#8F8D8D">กรอกเป็นตัวอักษร A-z และ 0-9 อย่างน้อย 5 ตัว</font>
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
								<font color="#8F8D8D">กรอกอย่างน้อย 8-16 ตัว</font>
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
								<font color="#8F8D8D">กรอกอย่างน้อย 8-16 ตัว ให้ตรงกับรหัสผ่าน</font>
							</label>
						</div>
					</div>
					<div class="col-md-offset-3 col-md-3">
						<div class="g-recaptcha" data-callback="makeaction" data-sitekey="6Ld1aOEUAAAAANHUmu7MueMRPoSkDeQWrAl4QMIC"></div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-4 col-md-6" style="padding-top:10px;">
							<button type="submit" id="submit" disabled class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
							<button type="reset" onclick='$("#user-r").html("");' class="btn btn-danger">ล้างค่า</button>
							<button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
						</div>
					</div>
				</form>

				<script src='https://www.google.com/recaptcha/api.js'></script>

			</div>
		</div>
	</div>
	<p>
		<p>
			<?php include("conf/footer.php"); ?>
</body>

<script>
	function makeaction() {
		document.getElementById('submit').disabled = false;
	}

	function check_form(data2, type) {
		if ($("#user_name").val() != "") {
			//console.log($("#user_name").val());
			$("#loading").show();
			$.ajax({
				url: "ajax_register.php",
				data: 'user_name=' + $("#user_name").val(),
				type: "POST",
				error: function(data) {
					$("#loading").hide();
					$("#user-availability-status").html("Error!");
				},
				success: function(data) {
					if (data == "true") {
						console.log("true");
						$("#user-r").html("<i style='margin-top:7px; color:green; font-size:20px;' class='fa fa-check'></i>");
						$("#register").unbind('submit');
					} else {
						console.log("false");
						$("#user-r").html("<i style='margin-top:7px; color:red; font-size:20px;' class='fa fa-times'></i>");
						$("#register").bind('submit', function(e) {
							e.preventDefault();
							alert("ชื่อผู้ใช้งานซ้ำ หรือรูปแบบที่กรอกไม่ถูกต้อง");
							//$("#user_name").focus();
						});
					}
					$("#loading").hide();
				},
			});
		}
	}
</script>