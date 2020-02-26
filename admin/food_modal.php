<div class="modal fade" id="morefood<?php echo $result['foodid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center>
                    <h4 class="modal-title" id="myModalLabel">เพิ่มจำนวนรายการอาหาร</h4>
                </center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="food_qty_add.php" enctype="multipart/form-data">
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-offset-1 col-md-4" style="text-align:right;">รหัสรายการอาหาร :</label>
                                <div class="col-md-6">
                                    <?= $result['foodid']; ?>
                                    <input type="text" name="foodid" id="foodid" value="<?= $result['foodid'] ?>" hidden>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row" style="padding-top:6px;">
                                <label class="control-label col-md-offset-1 col-md-4" style="text-align:right;">ชื่อรายการอาหาร :<span style="color:red;"></span> </label>
                                <div class="col-md-6">
                                    <?php echo $result['food_name']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row" style="padding-top:6px;">
                                <label class="control-label col-md-offset-1 col-md-4" style="text-align:right;">ราคา (บาท) :<span style="color:red;"></span> </label>
                                <div class="col-md-6">
                                    <?php echo $result['food_price']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-offset-1 col-md-4"></label>
                                <div class="col-md-6">
                                    <img height="100" width="150" style="border:1px solid black;" src="../<?php echo $result['food_image']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row" style="padding-top:6px;">
                                <label class="control-label col-md-offset-1 col-md-4" style="text-align:right;">จำนวน :<span style="color:red;"></span> </label>
                                <div class="col-md-6">
                                    <?php echo $result['food_qty']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-offset-1 col-md-4" style="margin-top:7px; text-align:right;">จำนวนที่ต้องการเพิ่ม :<span style="color:red;">*</span> </label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" style="width:150px" min="0" max="300" onkeypress="return isNumberKey(event)" required name="food_qty_add">
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

<!-- Add Food Modal -->
<div class="modal fade" id="addfood" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center>
                    <h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูลรายการอาหาร</h4>
                </center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="add_food.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อรายการอาหาร :<span style="color:red;">*</span> </label>
                                <div class="col-md-8" style="width:300px;">
                                    <input type="text" class="form-control" value="" name="food_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ราคา (บาท) :<span style="color:red;">*</span> </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" style="width:150px" min="1" onkeypress="return isNumberKey(event)" value="" name="food_price" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รูปภาพ :<span style="color:red;">*</span></label>
                                <div class="col-md-8" style="width:300px;">
                                    <input type="file" class="form-control" id="food_image" name="food_image" accept="image/gif, image/jpeg, image/png" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ประเภท :<span style="color:red;">*</span> </label>
                                <div class="col-md-8">
                                    <select class="form-control" style="width:200px" name="food_type" required>
                                        <option value="" disabled selected>-- กรุณาเลือกประเภท --</option>
                                        <option value="0">ประเภทผัด</option>
                                        <option value="1">ประเภททอด</option>
                                        <option value="2">ประเภทต้ม</option>
                                        <option value="3">เครื่องดื่ม</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">จำนวน :<span style="color:red;">*</span> </label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" style="width:150px" min="0" max="999" onkeypress="return isNumberKey(event)" value="" name="food_qty" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หน่วยนับ :<span style="color:red;">*</span> </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" style="width:150px" minlength="3" value="" name="food_count">
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

<div class="modal fade" id="deletefood<?php echo $result['foodid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center>
                    <h4 class="modal-title" id="myModalLabel">ต้องการลบข้อมูลรายการอาหารหรือไม่</h4>
                </center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="del_food.php" enctype="multipart/form-data">
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4"></label>
                                <div class="col-md-8">
                                    <img height="100" width="150" style="border:1px solid black;" src="../<?php echo $result['food_image']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="text-align:right;">รหัสรายการอาหาร :</label>
                                <div class="col-md-8" >
                                    <input type="text" style="width:150px" value="<?php echo $result['foodid']; ?>" name="foodid" hidden>
                                    <?php echo $result['foodid']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:5px; text-align:right;">ชื่อรายการอาหาร :</label>
                                <div class="col-md-8" style="padding-top:5px;">
                                    <?php echo $result['food_name']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:5px; text-align:right;">ประเภท :</label>
                                <div class="col-md-8" style="padding-top:5px;">
                                    <?php if ($result['food_type'] == 0) {
                                        echo "ประเภทผัด";
                                    } elseif ($result['food_type'] == 1) {
                                        echo "ปรเถททอด";
                                    } elseif ($result['food_type'] == 2) {
                                        echo "ประเภทต้ม";
                                    } elseif ($result['food_type'] == 3) {
                                        echo "เครื่องดื่ม";
                                    } ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="text-align:right; margin-top:5px;">สถานะ :</label>
                                <div class="col-md-8" style="padding-top:5px; text-align:left;">
                                    <?php if ($result['food_status'] == 0) {
                                        echo "<span style='color:#12BB4F;'>ใช้งาน</span>";
                                    } elseif ($result['food_status'] == 1) {
                                        echo "<span style='color:red;'>ไม่ใช้งาน</span>";
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