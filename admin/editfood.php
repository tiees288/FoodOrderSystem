<head>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['staff'])) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
    }
    if (!isset($_GET['foodid'])) {
        echo "<script>window.location.assign('show_food.php')</script>";
    }
    include('conf/header_admin.php');
    include('../conf/function.php');
    ?>
    <title>แก้ไขข้อมูลรายการอาหาร | Food Order System</title>
</head>

<body>
    <?php
    include('../conf/connection.php');
    $sql_edit = "SELECT * FROM foods WHERE foodid = '" . $_GET['foodid'] . "'";
    $result = mysqli_fetch_assoc(mysqli_query($link, $sql_edit));
    ?>
    <div class="container" style="padding-top: 135px; padding-bottom:15px;">
        <h1 class="page-header text-left">แก้ไขข้อมูลรายการอาหาร</h1>
        <form method="POST" action="edit_food.php" enctype="multipart/form-data">
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รหัสรายการอาหาร :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:150px" value="<?php echo $result['foodid']; ?>" name="foodid" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อรายการอาหาร :<span style="color:red;">*</span> </label>
                    <div class="col-md-8" style="width:300px;">
                        <input type="text" class="form-control" value="<?php echo $result['food_name']; ?>" name="food_name">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ราคา (บาท) :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:150px" min="0" max="999" onkeypress="return isNumberKey(event)" value="<?php echo $result['food_price']; ?>" name="food_price">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4"></label>
                    <div class="col-md-8">
                        <img height="100" width="150" style="border:1px solid black;" src="../<?php echo $result['food_image']; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รูปภาพ :</label>
                    <div class="col-md-8" style="width:300px;">
                        <input type="file" class="form-control" id="food_image" name="food_image" accept="image/gif, image/jpeg, image/png">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ประเภท :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <select class="form-control" style="width:200px" name="food_type">
                            <option value="" disabled selected>-- กรุณาเลือกประเภท --</option>
                            <option <?php if ($result['food_type'] == 0) echo "selected"; ?> value="0">ประเภทผัด</option>
                            <option <?php if ($result['food_type'] == 1) echo "selected"; ?> value="1">ประเภททอด</option>
                            <option <?php if ($result['food_type'] == 2) echo "selected"; ?> value="2">ประเภทต้ม</option>
                            <option <?php if ($result['food_type'] == 3) echo "selected"; ?> value="3">เครื่องดื่ม</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">จำนวน :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" style="width:150px" min="0" max="999" onkeypress="return isNumberKey(event)" value="<?php echo $result['food_qty']; ?>" name="food_qty">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หน่วยนับ :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:150px" minlength="3" value="<?php echo $result['food_count']; ?>" name="food_count">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รายการแนะนำ :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" style="width:150px" min="0" max="999" onkeypress="return isNumberKey(event)" value="<?php echo $result['food_recomend']; ?>" name="food_recomend">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สถานะ:<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <select class="form-control" style="width:200px" name="food_status">
                            <option value="" disabled selected>-- กรุณาเลือกสถานะ --</option>
                            <option <?php if ($result['food_status'] == 0) echo "selected"; ?> value="0">ใช้งาน</option>
                            <option <?php if ($result['food_status'] == 1) echo "selected"; ?> value="1">ยกเลิก</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-4 col-md-offset-5">
                <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
                <button type="reset" class="btn btn-danger">คืนค่า</button>
                <button type="button" class="btn btn-info" onclick="window.history.back();">ย้อนกลับ</button>
            </div>
        </form>
    </div>