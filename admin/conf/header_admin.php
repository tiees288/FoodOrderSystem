<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php

	if (!isset($_SESSION)) {
		session_start();
	}
	if (!isset($_SESSION['staff'])) {
		echo "<script>alert('กรุณาตรวจสอบสิทธิ์การเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
		exit();
	}
	include("lib.php");

	?>
	<style type="text/css">
		body {
			font-family: 'Open Sans', sans-serif;
		}

		.sticky-cart {
			/* Safari */
			width: 70px;
			height: 70px;
			/*	background: #67C868; */
			border-radius: 20px;
			box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.75);
		}

		.sticky-div {
			position: fixed;
			top: 90%;
			right: 5%;
			-webkit-transform: translateY(-50%);
			-ms-transform: translateY(-50%);
			transform: translateY(-50%);
		}

		.order_type0, .order_type1 {
			display:none;
		}

		.form-control {
			box-shadow: none;
			border-radius: 4px;
			border-color: #dfe3e8;
		}

		.form-control:focus {
			border-color: #29c68c;
			box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
		}

		.navbar-header.col {
			padding: 0 !important;
		}

		.navbar {
			background: #FBFBFB;
			padding-left: 1px;
			padding-right: 1px;
			border-bottom: 1px solid #dfe3e8;
			border-radius: 0;
		}

		.navbar .navbar-brand {
			font-size: 20px;
			padding-left: 0;
			padding-right: 50px;
		}

		.navbar .navbar-brand b {
			font-weight: bold;
			color: #29c68c;
		}

		.navbar ul.nav li a {
			color: #8F8D8D;
		}

		.navbar ul.nav li a:hover,
		.navbar ul.nav li a:focus {
			color: #8F8D8D !important;
		}

		.navbar ul.nav li.active>a,
		.navbar ul.nav li.open>a {
			color: #26bb84 !important;
			background: transparent !important;
		}

		.navbar .form-inline .input-group-addon {
			box-shadow: none;
			border-radius: 2px 0 0 2px;
			background: #f5f5f5;
			border-color: #dfe3e8;
			font-size: 16px;
		}

		.navbar .form-inline i {
			font-size: 16px;
		}

		.navbar .form-inline .btn {
			border-radius: 2px;
			color: #fff;
			border-color: #29c68c;
			background: #29c68c;
			outline: none;
		}

		.navbar .form-inline .btn:hover,
		.navbar .form-inline .btn:focus {
			border-color: #26bb84;
			background: #26bb84;
		}

		.navbar .search-form {
			display: inline-block;
		}

		.navbar .search-form .btn {
			margin-left: 4px;
		}

		.navbar .search-form .form-control {
			border-radius: 2px;
		}

		.navbar .login-form .input-group {
			margin-right: 4px;
			float: left;
		}

		.navbar .login-form .form-control {
			max-width: 158px;
			border-radius: 0 2px 2px 0;
		}

		.navbar .navbar-right {
			margin-top: 0;
		}

		.navbar .navbar-right .dropdown-toggle::after {
			display: none;
		}

		.navbar .dropdown-menu {
			border-radius: 1px;
			border-color: #e5e5e5;
			box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
		}

		.navbar .dropdown-menu li a {
			padding: 6px 20px;
		}

		.dropdown:hover .dropdown-menu {
			display: block !important;
		}

		.navbar .navbar-right .dropdown-menu {
			width: 180px;
			padding: 20px;
			left: auto;
			right: 0;
			font-size: 14px;
		}

		@media (min-width: 1900px) {
			.search-form .input-group {
				width: 300px;
				margin-left: 30px;
			}

			.navbar .dropdown-menu {
				width: 180px;
				padding: 20px;
				left: auto;
				right: 10px;
				font-size: 14px;
			}
		}

		@media (max-width: 768px) {
			.navbar .navbar-right .dropdown-menu {
				width: 100%;
				background: transparent;
				padding: 10px 20px;
			}

			.navbar .input-group {
				width: 100%;
				margin-bottom: 15px;
			}

			.navbar .input-group .form-control {
				max-width: none;
			}

			.navbar .login-form .btn {
				width: 100%;
			}
			#brand_details {
				display:none;
			}
		}

		.pagination>.active>a,
		.pagination>.active>span,
		.pagination>.active>a:hover,
		.pagination>.active>span:hover,
		.pagination>.active>a:focus,
		.pagination>.active>span:focus {
			background-color: #26BA56; 
			border-color: black;
			cursor: pointer;
			z-index: 2;
		}

		.pagination>li.page-item.n>a,
		.pagination>li.page-item.n>span {
			color: #1EAF4D;
			cursor: pointer;
			z-index: 2;
		}
	</style>
	<link rel="shortcut icon" href="favicon.ico" />
</head>

<body>

	<nav class="navbar navbar-default navbar-expand-lg navbar-light navbar-fixed-top">
		<div class="navbar-header d-flex col">
			<a class="navbar-brand" style="padding-left:16px" href="index.php">เปิ้ล<b>อาหารตามสั่ง</b></a>
			<a class="navbar-brand col-md-8" id="brand_details" style="font-size:15px; position:fixed;">
				ม.5 ต.คลองหนึ่ง อ.คลองหลวง จ.ปทุมธานี (ตรงข้ามมหาวิทยาลัยกรุงเทพ) 061-576-0437 (เปิ้ล)
			</a>
			<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
				<span class="navbar-toggler-icon"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<!-- Collection of nav links, forms, and other content for toggling -->
		<div id="navbarCollapse" class="collapse navbar-collapse collapse justify-content-start">
			<ul class="nav navbar-nav navbar-right ml-auto" style="padding-right:20px ">
				<li class="nav-item dropdown">
					<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action"><i class="fa fa-user-o"></i> สวัสดี, <?= $_SESSION['staff']; ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="profile_staff.php" class="dropdown-item"><i class="fa fa-user-o"></i> แก้ไขข้อมูลผู้ใช้</a></li>
						<li class="divider dropdown-divider"></li>
						<li><a href="<?= ($_SESSION['staff_level'] == 1) ? "UserManualAdmin.pdf" : "UserManualEmployee.pdf" ?>"  target="_blank" class="dropdown-item"><i class="fa fa-book"></i> คู่มือการใช้งาน</a></li>
						<li class="divider dropdown-divider"></li>
						<li><a href="logout.php" class="dropdown-item"><i class="fa fa-power-off"></i> ออกจากระบบ</a></li>
					</ul>
				</li>
			</ul>
			<div style="border-top:1px solid #dfe3e8;">
				<ul class="nav navbar-nav ml-auto" style="border-top:1px solid #dfe3e8;">

					<li class="nav-item"><a href="index.php" class="nav-link">หน้าแรก</a></li>
					<?php if ($_SESSION['staff_level'] == 1) { ?>
						<li class="nav-item"><a href="show_staff.php" class="nav-link">แสดง/ลบข้อมูลพนักงาน</a></li> <?php }; ?>
					<li class="nav-item"><a href="show_customer.php" class="nav-link">แสดง/ลบข้อมูลสมาชิก</a></li>
					<li class="nav-item"><a href="show_table.php" class="nav-link">แสดง/ลบข้อมูลโต๊ะ</a></li>
					<li class="nav-item"><a href="show_material.php" class="nav-link">แสดง/ลบข้อมูลวัตถุดิบ</a></li>
					<li class="nav-item"><a href="show_food.php" class="nav-link">แสดง/ลบข้อมูลรายการอาหาร</a></li>
					<li class="nav-item"><a href="show_bank.php" class="nav-link">แสดง/ลบข้อมูลธนาคาร</a></li>
					<li class="nav-item"><a href="show_tables_reserve.php" class="nav-link">ค้นหา/แสดงโต๊ะ</a></li>
					<li class="nav-item"><a href="staff_reserve_history.php" class="nav-link">แสดง/ยกเลิกการจอง</a></li>
					<li class="nav-item"><a href="show_food_typeall.php" class="nav-link">แสดงรายการอาหาร</a></li>
					<li class="nav-item"><a href="staff_order_history.php" class="nav-link">แสดง/ยกเลิกการสั่งอาหาร</a></li>
					<li class="nav-item"><a href="staff_payment_history.php" class="nav-link">แสดงรายการรับชำระ</a></li>
					<?php if ($_SESSION['staff_level'] == 1) { ?>
						<li class="nav-item dropdown">
							<a class="nav-item" href="#">รายงาน <b class="caret"></b></a>
							<ul class="dropdown-menu" style="width:250px">
								<li><a href="daily_report_selector.php?report_name=order_day" class="dropdown-item">รายงานการสั่งอาหารประจำวัน</a></li>
								<li><a href="monthly_report_selector.php?report_name=order_month" class="dropdown-item">รายงานการสั่งอาหารประจำเดือน</a></li>
								<li><a href="daily_report_selector.php?report_name=payment_day" class="dropdown-item">รายงานการรับชำระประจำวัน</a></li>
								<li><a href="monthly_report_selector.php?report_name=payment_month" class="dropdown-item">รายงานการรับชำระประจำเดือน</a></li>
								<li><a href="daily_report_selector.php?report_name=delivery_day" class="dropdown-item">รายงานการส่งอาหารประจำวัน</a></li>
								<li><a href="monthly_report_selector.php?report_name=delivery_month" class="dropdown-item">รายงานการส่งอาหารประจำเดือน</a></li>
								<li><a href="daily_report_selector.php?report_name=reserve_day" class="dropdown-item">รายงานการจองประจำวัน</a></li>
								<li><a href="monthly_report_selector.php?report_name=reserve_month" class="dropdown-item">รายงานการจองประจำเดือน</a></li>
								<li><a href="report_bycategory.php" target="_blank" class="dropdown-item">รายงานเมนูอาหารแยกตามประเภท</a></li>
							</ul>
						</li>
					<?php } elseif ($_SESSION['staff_level'] == 0) { ?>
						<li class="nav-item"><a href="report_bycategory.php" target="_blank" class="nav-link">รายงานเมนูอาหารแยกตามประเภท</a></li>
					<?php } ?>
				</ul>
				<!--- <form class="navbar-form form-inline search-form"> //ช่องค้นหาข้อมูลในอนาคต
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
				</span>
			</div>
		</form> --->

			</div>
	</nav>
</body>

</html>