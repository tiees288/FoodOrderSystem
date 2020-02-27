<html>

<head>
	<title>เข้าสู่ระบบ | Food Order System</title>
	<?php
	session_start();
	if (isset($_SESSION['user'])) {
		header("Location: index.php");
		exit();
	}
	?>
	<link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
	<?php
	include("conf/header.php");
	?>
	<div class="container" style=" padding-top: 100px;">

		<div class="row justify-content-center">
			<div class="col-md-6 col-md-offset-3">
				<h1 class="page-header text-center">เข้าสู่ระบบ "ระบบขายอาหารตามสั่ง"</h1>

				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control" name="username" placeholder="ชื่อผู้ใช้" required="required">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							<input type="password" class="form-control" name="password" placeholder="รหัสผ่าน" required="required">
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success btn-block btn-md">เข้าสู่ระบบ</button>
					</div>
					<p class="hint-text text-left" data-toggle="modal" data-target="#forgetModal"><a href="#"><u>ลืมรหัสผ่าน?</u></a></p>

					<div class="modal-footer">ยังไม่เป็นสมาชิก? <a href="register.php"><u>สมัครสมาชิก</u></a></div>

				</form>
			</div>
			<!-- Modal -->
			<div class="modal fade" id="forgetModal" tabindex="-1" role="dialog" aria-labelledby="forgetModal" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="forgetModal"><b>ลืมรหัสผ่าน<b></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="container" style="min-height: 0%!important;">
								<div class="row">
									<div class="col-md-3" style="padding-bottom:7px;"><b>กรุณาติดต่อพนักงาน</b></div>
								</div>
								<div class="row">
									<label class="control-label col-sm-2 text-right"><i class="fa fa-envelope"></i> อีเมล :</label>
									<div class="col-2 col-sm-1" style="padding-bottom:7px;"><a href="mailto:Aimaroy_99@gmail.com"><u>Aimaroy_99@gmail.com</u></a></div>
								</div>
								<!-- Force next columns to break to new line at md breakpoint and up -->
								<div class="row">
									<label class="control-label col-sm-2 text-right"><i class="fa fa-phone"></i> เบอร์โทร :</label>
									<div class="col-2 col-sm-2"><a href="tel:061-576-0437"><u>061-576-0437</u></a></div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
						</div>
					</div>
				</div>
			</div>
</body>

</html>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	require_once('conf/connection.php');

	// ตรวจสอบว่ามีการล็อคอินอยู่แล้วหรือไม่

	$username	= mysqli_real_escape_string($link, $_POST['username']);
	$password	= mysqli_real_escape_string($link, $_POST['password']);

	$sql		=	"SELECT cusid, cus_user, cus_name, cus_password, cus_status FROM customers WHERE cus_user = '" . $username . "' AND cus_password = '" . sha1($password) . "' ";

	$data 		= 	mysqli_query($link, $sql);
	//เช็คผู้ใช้งานซ้ำ
	if (mysqli_num_rows($data) != "0") {
		$data_user 	=	mysqli_fetch_assoc($data);
		$_SESSION['user_id']	= $data_user['cusid'];
		$_SESSION['user'] 		= $data_user['cus_user'];
		$_SESSION['user_status'] = $data_user['cus_status'];

		echo "<script> alert('เข้าสู่ระบบสำเร็จ');window.location.assign('index.php') </script>";
	} else {
		echo "<script> alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'); </script>";
	}

	mysqli_close($link);
}
?>