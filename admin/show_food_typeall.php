<head>
	<title>แสดงรายการอาหาร | Food Order System</title>
	<?php
	if (!isset($_SESSION)) {  // Check if sessio nalready start
		session_start();
	}
	if (!isset($_SESSION['staff'])) {
		echo  "<script> alert('กรุณาเข้าสู่ระบบ');window.location.assign('index.php') </script>";
		exit();
	}
	?>
	<link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
	<?php
	include("conf/header_admin.php");

	/*ini_set('display_errors', 1);
	error_reporting(~0);*/

	$strKeyword = null;
	$food_type = null;
	$order_more = null;

	if (isset($_POST["search_food"])) {
		$strKeyword = $_POST["search_food"];
		$order_more = $_POST['oid'];
	}
	if (isset($_GET["search_food"])) {
		$strKeyword = $_GET["search_food"];
	}
	if (isset($_GET["food_type"])) {
		$food_type = $_GET['food_type'];
	}
	if (isset($_GET["oid"])) {
		$order_more = $_GET['oid'];
	}
	?>
	<div class="container" style="padding-top: 135px;">
		<h1 class="page-header text-left">แสดงรายการอาหาร<?= isset($_GET['oid']) ? " (สั่งเพิ่ม)" : "" ?></h1>
		<form class="form-inline">
			<div class="col-sm-5">
				<select class="form-control" onchange="if (this.value) window.location.href=this.value">
					<option value="" disabled selected>-- เลือกประเภทอาหาร -- </option>
					<option value="show_food_typeall.php<?= ($order_more != null) ? "?oid=$order_more" : "" ?>">ทุกประเภท</option>
					<option value="show_food_typeall.php?food_type=0<?= ($order_more != null) ? "&oid=$order_more" : "" ?>">ประเภทผัด</option>
					<option value="show_food_typeall.php?food_type=1<?= ($order_more != null) ? "&oid=$order_more" : "" ?>">ประเภททอด</option>
					<option value="show_food_typeall.php?food_type=2<?= ($order_more != null) ? "&oid=$order_more" : "" ?>">ประเภทต้ม</option>
					<option value="show_food_typeall.php?food_type=3<?= ($order_more != null) ? "&oid=$order_more" : "" ?>">เครื่องดื่ม</option>
				</select>

				<?php /*if (!isset($_GET['food_type'])) {
								echo "selected";
							} 
					 if (isset($_GET['food_type'])) {
								if ($_GET['food_type'] == 0) {
									echo "selected";
								}
							}*/ ?>
			</div>
			<div class="col-sm-4">
				<h4 style="margin:8px;">
					<?php
					if (isset($_GET['food_type'])) {
						if ($_GET['food_type'] == "") {
							echo "ทุกประเภท";
						} elseif ($_GET['food_type'] == 0) {
							echo "ประเภทผัด";
						} elseif ($_GET['food_type'] == 1) {
							echo "ประเภททอด";
						} elseif ($_GET['food_type'] == 2) {
							echo "ประเภทต้ม";
						} elseif ($_GET['food_type'] == 3) {
							echo "เครื่องดื่ม";
						}
					} else {
						echo "ทุกประเภท";
					}

					?></h4>
			</div>
			<div class="col-md-9"></div>
			<div class="form-group">
				<input class="form-control" type="text" name="search_food" placeholder="ค้นหารายการอาหาร" aria-label="Search">
				<input type="text" name="oid" hidden value="<?= $order_more != null ? $order_more : "" ?>">
			</div>
			<button type="submit" class="btn btn-success mb-2">ค้นหา</button>
		</form>
		<hr>
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead>
					<th style="text-align:right; width:200px">รหัสรายการอาหาร</th>
					<th style="width:270px; text-align: center;">รูปภาพ</th>
					<th>ชื่ออาหาร</th>
					<th>หน่วยนับ</th>
					<th class="text-right">ราคา (บาท)</th>
					<th style="text-align: center;">ตะกร้าสินค้า</th>
				</thead>
				<?php
				include('../conf/connection.php');

				if (isset($_GET["food_type"])) {
					$food_type = $_GET['food_type'];
				}

				$sql = "SELECT * FROM foods WHERE food_name LIKE '%" . $strKeyword . "%' AND food_status = '0' AND food_type LIKE '%" . $food_type . "%'";
				$query = mysqli_query($link, $sql);

				$num_rows = mysqli_num_rows($query);

				$per_page = 5;   // จำนวนข้อมูลต่อหน้า
				$page  = 1;

				if (isset($_GET["Page"])) {
					$page = $_GET["Page"];
				}

				$prev_page = $page - 1;
				$next_page = $page + 1;

				//$row_start = (($per_page*$page)-$per_page);
				$row_start = ($page - 1) * $per_page;
				if ($num_rows <= $per_page) {
					$num_pages = 1;
				} else if (($num_rows % $per_page) == 0) {
					$num_pages = ($num_rows / $per_page);
				} else {
					$num_pages = ($num_rows / $per_page) + 1;
					$num_pages = (int) $num_pages;
				}
				$row_end = $per_page;
				if ($row_end > $num_rows) {
					$row_end = $num_rows;
				}

				$sql .= " ORDER BY foodid ASC LIMIT $row_start ,$row_end ";
				$query = mysqli_query($link, $sql);

				if ($num_rows > 0) { // ค้นหพบรายการอาหาร ให้แสดง
					while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
						if ($result['food_image'] == "")
							$food_img = "../images/default_food.png";
						else $food_img = "../" . $result['food_image'];

						echo '<tr>
						<td class="text-right">' . $result["foodid"] . '</td>
						<td align="center"><img height="160" width="200" src="' . $food_img . '"></td>
						<td>' . $result["food_name"] . '</td>
						<td>' . $result['food_count'] . '</td>
						<td class="text-right">' . number_format($result["food_price"], 2) . '</td>'; ?>
						<td style="text-align: center;"><a href="staff_add_list_food.php?foodid=<?= $result['foodid'] ?><?= isset($_GET['oid']) ? "&oid=" . $_GET['oid'] : "" ?>" class="btn btn-success btn-md">
								<span class="glyphicon glyphicon-shopping-cart"></span> ใส่ตะกร้า</a></td>
						</tr>
				<?php
					}
				} else {
					echo '
					<tr>
						<td colspan="5" align="center">ไม่พบข้อมูลในระบบ</td>
					</tr>
				';
				}
				?>
			</table>
		</div>
		<nav aria-label="Page navigation example" class="navbar-center">
			<div class="text-center">
				<ul class="pagination">
					<?php
					if ($prev_page) { ?>

						<li class="page-item n"><a href='<?= $_SERVER["SCRIPT_NAME"] ?>?Page=<?= $prev_page ?>&search_food=<?= $strKeyword ?>&food_type=<?= $food_type ?><?= ($order_more != null) ? "&oid=$order_more" : "" ?>'>ก่อนหน้า</a></li>
						<?php
					} else {
						// ทำให้คลิกไม่ได้
						echo '<li class="page-item disabled"><a href="#" >ก่อนหน้า</a></li>';
					}

					for ($i = 1; $i <= $num_pages; $i++) {
						if ($i != $page) { ?>
							<li class='page-item n'><a href='<?= $_SERVER["SCRIPT_NAME"] ?>?Page=<?= $i ?>&search_food=<?= $strKeyword ?>&food_type=<?= $food_type ?><?= ($order_more != null) ? "&oid=$order_more" : "" ?>'><?= $i ?></a></li>
						<?php
						} else {
							echo '<li class="page-item active"><a href="#">' . $i . '</a></li>';
						}
					}
					if ($page != $num_pages) { ?>
						<li class="page-item n"><a href='<?= $_SERVER["SCRIPT_NAME"]?>?Page=<?= $next_page ?>&search_food=<?= $strKeyword ?>&food_type=<?= $food_type ?><?= ($order_more != null) ? "&oid=$order_more" : "" ?>'>ถัดไป</a></li>
					<?php
					} else {
						echo '<li class="page-item disabled">' . "<a href ='#'>ถัดไป</a></li> ";
					}
					$conn = null;
					?>
			</div>
		</nav>

	</div>
</body>
<?php
if (isset($_SESSION['food_admin']['list']['foodid'])) {
	$cartcount = number_format(array_sum($_SESSION['food_admin']['list']['amount']));
} else {
	$cartcount = 0;
}
?>
<div class="sticky-div">
	<span class="badge badge-danger" style="position:absolute; right:-3px; top:-3px; background:red; font-size:15px;"><?= $cartcount ?></span>
	<a href="<?= (isset($_GET['oid'])) ? "order_more.php?oid=$order_more" : "staff_cart_order.php" ?>" class="sticky-cart btn btn-success"><i style="padding-top:10px; font-size:35px;" class="fa fa-shopping-basket"></i></a>
</div>

</html>