<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	define('SecretKey', "6Ld1aOEUAAAAAFXckdPliZN4KXVa9qB7XliEAT8x");

	require('conf/connection.php');
	require_once("conf/function.php");
	
	if (utf8_strlen($_POST['name'] > 25)) {
		echo "<script>alert('กรุณากรอก ชื่อ-นามสกุล ระหว่าง 5-25 ตัวอักษร'); window.history.back();</script>";
		exit();
	}

	$query_params = [
		'secret' => SecretKey,
		'response' => filter_input(INPUT_POST, 'g-recaptcha-response'),
		'remoteip' => $_SERVER['REMOTE_ADDR']
	];
	$url = 'https://www.google.com/recaptcha/api/siteverify?' . http_build_query($query_params);
	$result = json_decode(file_get_contents($url), true);

	if ($result['success']) {

		if (utf8_strlen($_POST['name'] > 25)) {
			echo "<script>alert('กรุณากรอก ชื่อ-นามสกุล ระหว่าง 5-25 ตัวอักษร'); window.history.back();</script>";
			exit();
		}

		$name			=	$_POST['name'];
		$number_phone	=	$_POST['number_phone'];
		$cus_birth		= 	tochristyear($_POST['birthdate']);
		$email			=	$_POST['email'];
		$address 		=	$_POST['address'];
		$user_name		=	trim($_POST['user_name']);
		$password		=	trim($_POST['password']);
		$cus_postnum	=	$_POST['postnumber'];


		if ($password != $_POST['cf_password']) {
			echo "<script> alert('รหัสผ่านไม่ตรงกัน'); window.history.back(); </script>";
			exit();
		}

		//ตรวจสอบ user ซ้ำ
		$chk_username	= mysqli_query($link, "SELECT * FROM customers WHERE cus_user = '" . $user_name . "'");
		//ถ้าในฐานข้อมูลมี ผู้ใช้งานแล้ว
		if (mysqli_num_rows($chk_username) != "") {
			echo "<script> alert('ชื่อผู้ใช้ถูกใช้แล้ว'); window.history.back();</script>";
			exit();
		}
		/*
	$chk_email	= mysqli_query($link, "SELECT * FROM customers WHERE cus_email = '" . $email . "'");
	//ถ้าในฐานข้อมูลมี ผู้ใช้งานแล้ว
	if (mysqli_num_rows($chk_email) != "0") {
		echo "<script> alert('อีเมลล์ถูกใช้แล้ว'); window.history.back();</script>";
		exit();
	}
	*/
		//ถ้าไม่มีให้เพิ่มข้อมูล
		//	echo "$name $number_phone $cus_birth $email $address $user_name $password $cus_postnum";
		$sql		=	"INSERT INTO customers SET 
						cus_name		= '" . $name . "',
						cus_user		= '" . $user_name . "',
						cus_birth		= '" . $cus_birth . "',
						cus_tel			= '" . $number_phone . "',
						cus_email		= '" . $email . "',
						cus_status		= '0',
						cus_password	= '" . sha1($password) . "',
						cus_postnum		= '" . $cus_postnum . "',
						cus_address		= '" . $address . "'";

		if (!isset($_COOKIE['register'])) {
			if (mysqli_query($link, $sql)) {
				$new_cusid = mysqli_insert_id($link);
				echo "<script> alert('สมัครสมาชิกสำเร็จ รหัสลูกค้าคือ : " . $new_cusid . "'); window.location.assign('index.php')</script>";
				//	setcookie("register", $new_cusid, time() + 3600); // กัน Flood สมัครสมาชิก
			}
		} else {
			echo "<script>alert('กรุณารออย่างน้อย 1 ชั่วโมง ก่อนการสมัครสมาชิกซ้ำ'); window.history.back();</script>";
		}
	} else {
	}
}
