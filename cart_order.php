<html>

<head>
	<title>ตะกร้าสั่งอาหาร | Food Order System</title>
	<?php
	session_start();
	?>
	<link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
	<?php
	include("conf/header.php");
	if (!isset($_SESSION['user'])) {
		echo "<script>alert('กรุณาล็อคอินเข้าสู่ระบบเพื่อใช้งาน'); window.location.assign('index.php');</script>";
		exit(0);
	}
	?>

	<div class="container" style="padding-top: 100px;">
		<h1 class="page-header text-left">ตะกร้าสั่งอาหาร</h1>

		<form method="POST" id="basket" action="">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<th style="width:150px; text-align:right;">รหัสรายการอาหาร</th>
						<th style="width:200px; text-align: center;">รูปภาพ</th>
						<th style="width:160px;">ชื่ออาหาร</th>
						<th style="width:90px;">หน่วยนับ</th>
						<th style="text-align:right; width:100px;">ราคา (บาท)</th>
						<th style="text-align:center; width:130px;">จำนวน</th>
						<th style="width:120px; text-align:right">ราคารวม (บาท)</th>
						<th style="width:100px; text-align:center;">ยกเลิก</th>
					</thead>

					<?php
					require_once("conf/connection.php");



					if (!isset($_SESSION['food']['list']['foodid'])) {
						echo '<tr>
			<td colspan="8" class="text-center">ไม่มีสินค้าในตะกร้า</td>
		</tr>';
					} else {

						$count_product = count($_SESSION['food']['list']['foodid']);

						for ($i = 0; $i < $count_product; $i++) {
							$sql_sum		=	"SELECT * FROM foods WHERE foodid = '" . $_SESSION['food']['list']['foodid'][$i] . "' ";
							$data_sum		=	mysqli_query($link, $sql_sum);
							$value			=	mysqli_fetch_assoc($data_sum);
							$sum_price[] 	= $_SESSION['food']['list']['food_price'][$i] * $_SESSION['food']['list']['amount'][$i];
							$product_id[] 	= $value['foodid'];

							// สำหรับตรวจสอบถ้าในระบบไม่มีรูป
							if ($value['food_image'] == "")
								$food_img = "images/default_food.png";
							else $food_img = $value['food_image'];

							?>
							<tr>
								<td align="right"><?php echo $value['foodid']; ?></td>
								<td align="center"><img height="120" width="170" src="<?php echo $food_img ?>"></td>
								<td><?php echo $value['food_name']; ?></td>
								<td><?= $value['food_count'] ?></td>
								<td align="right"><?php echo number_format($value['food_price'], 2); ?></td>
								<td class="text-center">
									<button class="delete" type="button">-</button>
									<input type="text" maxlength="3" class="amount" onkeypress="return isNumberKey(event)" style="width:35px; text-align:center;" autocomplete="off" id="amount-<?= $value['foodid'] ?>" value="<?= $_SESSION['food']['list']['amount'][$i] ?>" size="1" name="qty_<?php echo $i; ?>">
									<input type="text" name="id[]" value="<?= $value['foodid'] ?>" hidden>
									<button class="plus" type="button"> + </button>
									<!-- จำนวนเหลือ ใน Stock -->
									<input type="text" value="<?= $value['food_qty'] ?>" id="stock_<?= $i ?>" name="stock_<?= $i ?>" hidden>
									<!-- =================== -->
								</td>
								<td class="text-right price-order-<?= $i ?>" data-value="<?= number_format($_SESSION['food']['list']['food_price'][$i], 2) ?>" id="price-<?= $value['foodid']  ?>"><?= number_format($_SESSION['food']['list']['food_price'][$i] * $_SESSION['food']['list']['amount'][$i], 2) ?></td>
								<td align="center" style="padding:25px; width:10px"><a href="del_list_food.php?foodid=<?php echo $value['foodid']; ?>"> <span class="glyphicon glyphicon-trash fa-2x" style="color:red;" aria-hidden="true"></span></td>
							</tr>
						<?php } ?>
						<tr>
							<td align="right" colspan="6"><b>ราคารวมทั้งหมด</b></td>
							<td class="text-right"><b id="sum"><?= number_format(array_sum($sum_price), 2); ?></b></td>
							<td align="center"></td>
						</tr>
					<?php } ?>

				</table>
			</div>
			<div class="col-md-offset-3 col-md-6" style="text-align: center;">
				<a class="btn btn-primary" href="show_food_typeall.php" role="button">เพิ่มรายการ</a>
				<a class="btn btn-success <?php
											if (!isset($_SESSION['food']['list']['foodid'])) {
												echo "disabled";
											} ?>" href="checkout_order.php" role="button">สั่งอาหาร</a>
				<!--<button type="submit" class="btn btn-info" name="save" <?php
																			if (!isset($_SESSION['food']['list']['foodid'])) {
																				echo "disabled";
																			} ?>>บันทึกข้อมูล</button> -->

				<a class="btn btn-danger <?php
											if (!isset($_SESSION['food']['list']['foodid'])) {
												echo "disabled";
											} ?>" href="del_list_food_all.php" onclick="if(confirm('ต้องการล้างตะกร้าใช่หรือไม่?')) return true; else return false;">ล้างตะกร้า</a>
			</div>
	</div>
	</form><br>
	<?php
	include("conf/footer.php");
	?>
</body>

<script type="text/javascript" src="lib/number/jquery.number.min.js"></script>
<script type="text/javascript">
	function add(a, b) {
		return a + b;
	}
	$(document).ready(function() {
		$('.delete').click(function(event) {
			let id = $(this).next().attr('id');
			let val = $('#' + id).val();
			let id2 = id.replace('amount-', 'price-');
			let price = $('#' + id2).data('value');

			if (val <= 1) {
				alert('จำนวนไม่สามารถน้อยกว่า 1 ได้');
			} else {
				let sum = parseInt(val) - 1;
				$('#' + id).val(sum);

				prices = price.replace(/,/g, ''),
					asANumber = +prices;

				let price2 = sum * prices;


				//alert(price2);

				//alert(sum*price);
				let price3 = price2.toLocaleString(undefined, {
					minimumFractionDigits: 2
				});
				$('#' + id2).text(price3);

				let count_tr = ($('tr').length - 2);
				var sum2 = [];

				for (var i = 0; i < count_tr; i++) {
					sum2.push(parseInt($('.price-order-' + i).text().replace(',', '')));
				}
				let sum3 = sum2.reduce(add, 0);
				let sum_tt = sum3.toLocaleString(undefined, {
					minimumFractionDigits: 2
				});
				$('#sum').text(sum_tt)

				$.ajax({ // Ajax สำหรับ ส่งค่า แก้ไขตะกร้า
					type: 'post',
					url: 'update_qty_food.php',
					data: $('form').serialize(),
					success: function() {
						//document.getElementById("demo").innerHTML = "Save your post done.";
						//	alert('form was submitted');
					}
				})
			}
		});
		$('.plus').click(function(event) {
			let id = $(this).prev().prev().attr('id');
			let val = $('#' + id).val();
			let id2 = id.replace('amount-', 'price-');
			let price = $('#' + id2).data('value');
			let sum = parseInt(val) + 1;

			if (val >= 250) {
				alert('จำนวนอาหารไม่สามารถมากกว่า 250 ได้');
			} else {
			prices = price.replace(/,/g, ''),
				asANumber = +prices;

			let price2 = sum * prices;
			let price3 = price2.toLocaleString(undefined, {
				minimumFractionDigits: 2
			});
			$('#' + id).val(sum);
			$('#' + id2).text(price3);

			let count_tr = ($('tr').length - 2);
			var sum2 = [];
			for (var i = 0; i < count_tr; i++) {
				sum2.push(parseInt($('.price-order-' + i).text().replace(',', '')));
			}
			let sum3 = sum2.reduce(add, 0);
			let sum_tt = sum3.toLocaleString(undefined, {
				minimumFractionDigits: 2
			});
			$('#sum').text(sum_tt)
			$.ajax({
				type: 'post',
				url: 'update_qty_food.php',
				data: $('form').serialize(),
				success: function() {
					//document.getElementById("demo").innerHTML = "Save your post done.";
					//	alert('form was submitted');
				}
			})
			}
		});
		$('.amount').keyup(function(event) {
			let id = $(this).attr('id');
			let val = parseInt($('#' + id).val()); //|| 0;
			let id2 = id.replace('amount-', 'price-');
			let price = $('#' + id2).data('value');
			let sum = parseInt(val);
			prices = price.replace(/,/g, ''),
				asANumber = +prices;

			let price2 = sum * prices;
			let price3 = price2.toLocaleString(undefined, {
				minimumFractionDigits: 2
			});

			let limit = 250; // ลิมิตจำนวน อาหารมากสุด
			//	parseInt($(this).prev().parent().prev().text()); // ลิมิตจำนวน
			if ((limit < val || val <= 0) || isNaN(val)) {
				if (val <= 0) {
					alert('จำนวนไม่สามารถน้อยกว่า 1 ได้');
					$('#' + id).val('1');

					$('#' + id2).text(price);

				}
				if (val > limit) {
					alert('จำนวนอาหารไม่สามารถมากกว่า 250 ได้');
					$('#' + id).val(limit);
					let price3 = price2.toLocaleString(undefined, {
						minimumFractionDigits: 2
					});
					$('#' + id2).text(price3);
				}

				let count_tr = ($('tr').length - 2);
				var sum2 = [];
				for (var i = 0; i < count_tr; i++) {
					sum2.push(parseInt($('.price-order-' + i).text().replace(',', '')));
				}
				let sum3 = sum2.reduce(add, 0);
				let sum_tt = sum3.toLocaleString(undefined, {
					minimumFractionDigits: 2
				})
				$('#sum').text(sum_tt)

				if (!isNaN(val)) {
					$.ajax({
						type: 'post',
						url: 'update_qty_food.php',
						data: $('form').serialize(),
						success: function() {
							//document.getElementById("demo").innerHTML = "Save your post done.";
							//	alert('form was submitted');
						}
					})
				}
				return
			} else {
				$('#' + id).val(sum);
				$('#' + id2).text(price3);
				let price = parseInt($('#price' + id).data('value'));
				let sum4 = price * val;

				let count_tr = ($('tr').length - 2);
				var sum2 = [];
				for (var i = 0; i < count_tr; i++) {
					sum2.push(parseInt($('.price-order-' + i).text().replace(',', '')));
				}
				let sum3 = sum2.reduce(add, 0);
				let sum_tt = sum3.toLocaleString(undefined, {
					minimumFractionDigits: 2
				});
				$('#sum').text(sum_tt)
				$.ajax({
					type: 'post',
					url: 'update_qty_food.php',
					data: $('form').serialize(),
					success: function() {
						//document.getElementById("demo").innerHTML = "Save your post done.";
						//	alert('form was submitted');
					}
				})
			}

			//	document.getElementById('basket').submit();
		});
	});
</script>

</html>