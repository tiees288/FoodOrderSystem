<head>
	<title>บันทึกการสั่งอาหาร | Food Order System</title>
	<?php
	if (!isset($_SESSION)) {  // Check if sessio nalready start
		session_start();
	}
	?>

	<link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
	<?php
	if (!isset($_SESSION['food']['list']['foodid'])) {
		echo "<script>alert('กรุณาเลือกสินค้าที่ต้องการสั่ง'); window.location.assign('cart_order.php');</script>";
		exit();
	}

	if ($_SESSION['user_status'] == 1) {
		echo "<script>alert('ไม่สามารภสั่งอาหารได้ กรุณาติดต่อพนักงาน'); window.location.assign('cart_order.php');</script>";
		exit();
	}


	include("conf/header.php");
	include("conf/connection.php");
	include_once("conf/function.php");

	$sql_cusdata	= "SELECT * FROM customers WHERE cusid = '{$_SESSION['user_id']}'";
	$q = mysqli_query($link, $sql_cusdata);
	$cus_data = mysqli_fetch_assoc($q);
	?>
	<div class="container" style="padding-top: 90px;">
		<div class="col">
			<h1 class="page-header text-center">บันทึกการสั่งอาหาร</h1>
			<div class="container" style="width:980px">
				<div class="panel panel-default" align="center" style="background-color:#FBFBFB;">
					<p>
						<form id="checkout_order" class="form" name="checkout_order" method="POST" action="save_checkout_order.php">
							<table width="750px" border="0" align="center">
								<tr>
									<td width="34px" height="36px"><b>รหัสลูกค้า :</b></td>
									<td width="30%"><?php echo $_SESSION['user_id'] ?></td>
									<td width="20%" height="36px"><b>ชื่อ-นามสกุล :</b></td>
									<td><?php echo $cus_data['cus_name']; ?></td>
								</tr>
								<tr>
									<td height="40px" width="15%"><b>วันที่สั่ง :</b></td>
									<td width="35%">
										<input class="form-control" style="height:32px; width:210px" id="orderdate" type="datetime-local" name="orderdate" value="<?= dt_tothaiyear2(date('Y-m-d H:i')); ?>" readonly>
									</td>
									<td width="16%" height="40px"><b>เบอร์โทรศัพท์ :</b></td>
									<td><?php echo $cus_data['cus_tel'] ?></td>
								</tr>
								<tr>
									<td width="15%" height="32px"><b>วันที่กำหนดส่ง :<span style="color:red;">*</span></b></td>
									<td width="35%">
										<input class="form-control datepicker-checkout" autocomplete="off" style="height:32px; width:215px" id="deliverydate" onfocus="$(this).blur();" onchange="validate_delverytime();" onkeypress="return false;" onpaste="return false" type="text" name="deliverydate" required>
									</td>
									<td width="15%" height="32px"><b>เวลากำหนดส่ง :<span style="color:red;">*</span></b></td>
									<td><input class="form-control" autocomplete="off" type="time" min="09:00" max="19:00" required oninvalid="this.setCustomValidity('กรุณากรอกเวลาระหว่าง 09:00-19.00')" oninput="this.setCustomValidity('')" style="height:32px; width:180px" id="deliverytime" name="deliverytime" required></td>
								</tr>
								<tr>
									<td width="20%" height="30px"><b>สถานที่จัดส่ง :<span style="color:red;">*</span></b></td>
									<td height="81px"><textarea name="deliveryplace" style="width:250px;" id="deliveryplace" cols="15" rows="3" class="form-control" required><?= $cus_data['cus_address'] . " " . $cus_data['cus_postnum'] ?></textarea></td>
									</td>
									<td colspan="2" align="right" style="vertical-align: top; ">
										<font color="red" style="font-size: 13px;">กำหนดส่งภายในเวลา 09:00 - 19:00 </font>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="right" style="padding-right:10px; margin-top:0px; vertical-align: top; ">
										<font color="red" style="font-size: 13px;">สถานที่ส่งจะต้องอยู่ในบริเวณ ม.กรุงเทพ เท่านั้น</font>
									</td>
								</tr>
							</table>
				</div>
				<h3 class="page-header text-center">รายการอาหาร</h3>
				<table class="table table-striped table-bordered">
					<thead>
						<th style="width:150px; text-align:right;">รหัสรายการอาหาร</th>
						<th style="width:160px;">ชื่ออาหาร</th>
						<th style="width:100px;">หน่วยนับ</th>
						<th style="text-align:right; width:110px;">ราคา (บาท)</th>
						<th style="text-align:right; width:70px;">จำนวน</th>
						<th style="width:130px; text-align:right">ราคารวม (บาท)</th>
						<th>หมายเหตุ</th>
					</thead>
					<?php
					$count_product = count($_SESSION['food']['list']['foodid']);
					for ($i = 0; $i < $count_product; $i++) {
						$sql_sum		=	"SELECT * FROM foods WHERE foodid = '" . $_SESSION['food']['list']['foodid'][$i] . "' ";
						$data_sum		=	mysqli_query($link, $sql_sum);
						$value			=	mysqli_fetch_assoc($data_sum);
						$sum_price[] 	= 	$_SESSION['food']['list']['food_price'][$i] * $_SESSION['food']['list']['amount'][$i];
						$product_id[] 	= 	$value['foodid'];

					?>
						<td class="text-right"><?php echo $value['foodid']; ?></td>
						<td><?php echo $value['food_name']; ?></td>
						<td><?= $value['food_count'] ?></td>
						<td align="right"><?php echo $value['food_price']; ?></td>
						<td class="text-right">
							<?= $_SESSION['food']['list']['amount'][$i] ?>
							<input type="text" name="id[]" value="<?= $value['foodid'] ?>" hidden>
						</td>
						<td class="text-right price-order-<?= $i ?>" data-value="<?= $_SESSION['food']['list']['food_price'][$i] ?>" id="price-<?= $value['foodid']  ?>"><?= number_format($_SESSION['food']['list']['food_price'][$i] * $_SESSION['food']['list']['amount'][$i], 2) ?></td>
						<td class="col-md-2"><textarea class="form-control" name="order_note_<?= $value['foodid'] ?>"></textarea></td>
						</tr>
					<?php }	?>
					<tr>
						<td colspan="5" class="text-right"><b>ราคารวมทั้งหมด</b></td>
						<td class="text-right"><b><?= number_format(array_sum($sum_price), 2); ?></b></td>
						<input type="text" name="totalprice" id="totalprice" value="<?= array_sum($sum_price); ?>" hidden />
						<td></td>
					</tr>
			</div>
			</table>
			<div class="col-md-offset-3 col-md-6" style="text-align: center;">
				<input type="submit" name="submit" id="submit_order" onclick="if(confirm('ยืนยันรายการสั่งอาหาร?')) { if (check_place()) return true; else return false; } else return false;" class="btn btn-success" value="บันทึก" />
				<button type="reset" class="btn btn-danger">ล้างค่า</button></form>
				<button type="back" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
			</div>
		</div>
	</div>
	<?php include("conf/footer.php"); ?>
</body>