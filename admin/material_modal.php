<div class="modal fade" id="editmaterial<?php echo $result['materialid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center>
                    <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลว้ตถุดิบ</h4>
                </center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
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
                                <div class="col-md-8" style="">
                                    <input type="text" class="form-control" value="<?= $result['material_name'] ?>" style="width:280px" required name="material_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">จำนวน :<span style="color:red;">*</span> </label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" onkeypress="return isNumberKey(event)" style="width:150px" value="<?= $result['material_qty'] ?>" min="0" max="300" required name="material_qty">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หน่วยนับ :<span style="color:red;">*</span> </label>
                                <div class="col-md-8" style="">
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
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
                <button type="reset" class="btn btn-danger">คืนค่า</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Add Material Modal -->
<div class="modal fade" id="addmaterial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center>
                    <h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูลวัตถุดิบ</h4>
                </center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="add_material.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อวัตถุดิบ :<span style="color:red;">*</span> </label>
                                <div class="col-md-8" style="">
                                    <input type="text" class="form-control" style="width:300px" required name="material_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">จำนวน :<span style="color:red;">*</span> </label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" onkeypress="return isNumberKey(event)" style="width:150px" value="" min="0" max="300" required name="material_qty">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หน่วยนับ :<span style="color:red;">*</span> </label>
                                <div class="col-md-8" style="">
                                    <input type="text" class="form-control" style="width:300px" required name="material_count">
                                </div>
                            </div>
                        </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="if(confirm('ยืนยันการทำรายการ?')) return true; else return false;">บันทึก</button>
                <button type="reset" class="btn btn-danger">ล้างค่า</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Delete Table -->

<div class="modal fade" id="deletematerial<?php echo $result['materialid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center>
                    <h4 class="modal-title" id="myModalLabel">ต้องการลบข้อมูลวัตถุดิบหรือไม่</h4>
                </center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="del_material.php" enctype="multipart/form-data">
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="text-align:right;">รหัสวัตถุดิบ :</label>
                                <div class="col-md-8">
                                    <input type="text" style="width:150px" value="<?= $result['materialid'] ?>" name="materialid" hidden>
                                    <?= $result['materialid'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="text-align:right;" >ชื่อวัตถุดิบ :</label>
                                <div class="col-md-8" style="">
                                    <?= $result['material_name'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="text-align:right;" >สถานะ :</label>
                                <div class="col-md-8">
                                    <?php if ($result['material_status'] == 0) {
                                        echo "<span style='color:#12BB4F';>ใช้งาน</span>";
                                    } elseif ($result['material_status'] == 1) {
                                        echo "<span style='color:red'>ยกเลิก</span>";
                                    } ?>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class=" modal-footer">
                <button type="submit" class="btn btn-danger">ยืนยัน</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>






<script type="text/javascript">
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }


    function isNumericKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return true;
        return false;
    }


    function onlyAlphabets(e, t) {
        try {
            if (window.event) {
                var charCode = window.event.keyCode;
            } else if (e) {
                var charCode = e.which;
            } else {
                return true;
            }
            if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123))
                return true;
            else
                return false;
        } catch (err) {
            alert(err.Description);
        }
    }
</script>