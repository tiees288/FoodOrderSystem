<head>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['staff'])) {
        echo "<script>alert('กรุณาตรวจสอบสิทธิการเข้าใช้งาน'); window.location.assign('login_staff.php')</script>";
    }
    if (!isset($_GET['materialid'])) {
        echo "<script>window.location.assign('show_material.php')</script>";
    }
    include('conf/header_admin.php');
    include('../conf/function.php');
    ?>
    <title>แก้ไขข้อมูลวัตถุดิบ | Food Order System</title>
</head>

<body>
    <?php
    include('../conf/connection.php');
    $sql_edit = "SELECT * FROM materials WHERE materialid = '" . $_GET['materialid'] . "'";
    $result = mysqli_fetch_assoc(mysqli_query($link, $sql_edit));
    ?>
    <div class="container" style="padding-top: 135px; padding-bottom:15px;">
        <h1 class="page-header text-left">แก้ไขข้อมูลวัตถุดิบ</h1>
        <form method="POST" action="edit_material.php" enctype="multipart/form-data">
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รหัสวัตถุดิบ :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:150px" value="<?= $result['materialid'] ?>" name="materialid" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อวัตถุดิบ :<span style="color:red;">*</span> </label>
                    <div class="col-md-8" >
                        <input type="text" class="form-control" value="<?= $result['material_name'] ?>" style="width:280px" required name="material_name">
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top:10px;">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">จำนวน :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" onkeypress="return isNumberKey(event)" style="width:150px" value="<?= $result['material_qty'] ?>" min="0" required name="material_qty">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หน่วยนับ :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" style="width:250px" value="<?= $result['material_count'] ?>" required name="material_count">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สถานะ :<span style="color:red;">*</span> </label>
                    <div class="col-md-8">
                        <select class="form-control" style="width:200px" name="material_status">
                            <option value="" disabled selected>-- กรุณาเลือกสถานะ --</option>
                            <option <?php if ($result['material_status'] == 0) echo "selected"; ?> value="0">ใช้งาน</option>
                            <option <?php if ($result['material_status'] == 1) echo "selected"; ?> value="1">ยกเลิก</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
    </div>
    <div class="col-md-4 col-md-offset-5">
        <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
        <button type="reset" class="btn btn-danger">คืนค่า</button>
        <button type="button" class="btn btn-info" onclick="window.history.back();" >ย้อนกลับ</button>
        </form>
    </div>
    </div>