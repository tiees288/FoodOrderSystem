<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="theme-color" content="#48C55B">
	<link rel="shortcut icon" href="favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
	if (!isset($_SESSION)) {  // Check if sessio nalready start
		session_start();
	}

	if ((isset($_COOKIE['user'])) && (!isset($_SESSION['user']))) {
		$_SESSION['user_id'] = $_COOKIE['user_id'];
		$_SESSION['user'] = $_COOKIE['user'];
		$_SESSION['user_status'] = $_COOKIE['user_status'];
	} elseif (isset($_SESSION['user']) && (!isset($_COOKIE['user']))) {
		setcookie("user_id", $_SESSION['user_id'], time() + 86400, "/");
		setcookie("user", $_SESSION['user'], time() + 86400, "/");
		setcookie("user_status", $_SESSION['user_status'], time() + 86400, "/");
	}

	require_once("lib.php");
	?>
	<style type="text/css">
		body {
			font-family: 'Open Sans', sans-serif;
			height: 98%;
		}

		div.container {
			min-height: 95% !important;
			position: relative !important;
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
			padding-left: 16px;
			padding-right: 16px;
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
			color: #8F8D8D !important;
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
			color: #8F8D8D;
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

		.navbar .navbar-right .dropdown-toggle::after {
			display: none;
		}

		.navbar .dropdown-menu {
			border-radius: 1px;
			border-color: #e5e5e5;
			box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
		}

		.navbar .dropdown-menu li a {
			padding: 5px 10px;
		}

		.dropdown:hover .dropdown-menu {
			display: block !important;
		}

		.navbar .navbar-right .dropdown-menu {
			width: 190px;
			padding: 16px;
			left: auto;
			right: 0;
			font-size: 14px;
		}

		.badge-foodcart {
			font-size: 14px;
		}

		@media (min-width: 1200px) {
			.search-form .input-group {
				width: 300px;
				margin-left: 30px;
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
				display: none;
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
		<div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">

			<!--- <form class="navbar-form form-inline search-form"> //ช่องค้นหาข้อมูลในอนาคต
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
				</span>
			</div>
		</form> --->
			<?php

			if (!isset($_SESSION["user"])) {
				echo '<ul class="nav navbar-nav navbar-right ml-auto">
				<li class="nav-item"><a href="login.php" class="nav-link"><i class="fa fa-user-o"></i> เข้าสู่ระบบ</a></li>
				<li class="nav-item"><a href="register.php" class="nav-link"><i class="fa fa-key"></i> สมัครสมาชิก</a></li>';
			} else {
				$count_order = 0;

				if (isset($_SESSION['food']['list']['foodid'])) {
					$count_order = count($_SESSION['food']['list']['foodid']);

					for ($i = 0; $i <= $count_order; $i++) {
						$sum_qty = array_sum($_SESSION['food']['list']['amount']);
					}
				} else {
					$sum_qty = 0;
				}

				if (isset($_SESSION['food']['reserve']['tables_no'])) {
					$count_reserve = count($_SESSION['food']['reserve']['tables_no']);
				} else {
					$count_reserve = 0;
				}
				echo '
				<ul class="nav navbar-nav navbar-right ml-auto">
				<li class="nav-item dropdown">
							<li class="nav-item dropdown">
					<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action"><i class="fa fa-user-o"></i> ' . $_SESSION['user'] . '<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="profile.php" class="dropdown-item"><i class="fa fa-user-o"></i> แก้ไขข้อมูลผู้ใช้</a></li>
						<li class="divider dropdown-divider"></li>
						<li><a href="cart_reserve.php" class="dropdown-item"><i class="fa fa-shopping-basket"></i> ตะกร้าจอง <b><span class="badge-foodcart">(' . $count_reserve . ')</span></b></a></li>
						<li><a href="cart_order.php" class="dropdown-item"><i class="fa fa-shopping-basket"></i> ตะกร้าสั่งอาหาร <b><span class="badge-foodcart">(' . $sum_qty . ')</span></b></a></li>
						<li class="divider dropdown-divider"></li>
						<li><a href="UserManualCustomers.pdf" target="_blank" class="dropdown-item"><i class="fa fa-book"></i> คู่มือการใช้งาน</a></li>
						<li class="divider dropdown-divider"></li>
						<li><a href="logout.php" class="dropdown-item"><i class="fa fa-power-off"></i> ออกจากระบบ</a></li>
					</ul>
				</li>';
			}

			?>
			</ul>
			<div style="border-top:1px solid #dfe3e8;">
				<ul class="nav navbar-nav ml-auto col-md-12" style="border-top:1px solid #dfe3e8;">

					<li class="nav-item"><a href="index.php" class="nav-link">หน้าแรก</a></li>
					<li class="nav-item dropdown">
						<a class="nav-item" href="show_food_typeall.php">แสดงรายการอาหาร <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="show_food_typeall.php?food_type=0" class="dropdown-item">อาหารผัด</a></li>
							<li><a href="show_food_typeall.php?food_type=1" class="dropdown-item">อาหารทอด</a></li>
							<li><a href="show_food_typeall.php?food_type=2" class="dropdown-item">อาหารต้ม</a></li>
							<li><a href="show_food_typeall.php?food_type=3" class="dropdown-item">เครื่องดื่ม</a></li>
						</ul>
					</li>
					<?php
					if (isset($_SESSION['user'])) {
						echo '<li class="nav-item"><a href="show_tables.php" class="nav-link">แสดงโต๊ะ</a></li>
							<li class="nav-item"><a href="reserve_history.php" class="nav-link">แสดงการจองโต๊ะ</a></li>
							<li class="nav-item"><a href="order_history.php" class="nav-link">แสดงรายการสั่งอาหาร</a></li>
					
					';
					}
					?>
					<li class="nav-item"><a href="contact.php" class="nav-link">ติดต่อเรา</a></li>
				</ul>
			</div>
	</nav>
</body>

</html>