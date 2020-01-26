<div class="modal fade" id="edittables<?php echo $result['tables_no']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center>
                    <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลโต๊ะ</h4>
                </center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="edit_table.php" enctype="multipart/form-data">
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หมายเลขโต๊ะ :</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" style="width:150px" value="<?php echo $result['tables_no']; ?>" name="tables_no" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">จำนวนที่นั่ง(คน) :<span style="color:red;">*</span> </label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" style="width:150px" min="2" max="12" onkeypress="return isNumberKey(event)" value="<?php echo $result['tables_seats']; ?>" name="tables_seats">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สถานะจอง:<span style="color:red;">*</span> </label>
                                <div class="col-md-8">
                                    <select class="form-control" style="width:250px" name="tables_status_reserve">
                                        <option value="" disabled selected>-- กรุณาเลือกสถานะ --</option>
                                        <option <?php if ($result['tables_status_reserve'] == 0) echo "selected"; ?> value="0">ไม่มีการจอง</option>
                                        <option <?php if ($result['tables_status_reserve'] == 1) echo "selected"; ?> value="1">มีการจอง</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สถานะพร้อมใช้:<span style="color:red;">*</span> </label>
                                <div class="col-md-8">
                                    <select class="form-control" style="width:250px" name="tables_status_use">
                                        <option value="" disabled selected>-- กรุณาเลือกสถานะ --</option>
                                        <option <?php if ($result['tables_status_use'] == 0) echo "selected"; ?> value="0">โต๊ะว่าง</option>
                                        <option <?php if ($result['tables_status_use'] == 1) echo "selected"; ?> value="1">โต๊ะไ่ม่ว่าง</option>
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


<!-- Add Table Modal -->
<div class="modal fade" id="addtables" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center>
                    <h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูลโต๊ะ</h4>
                </center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="add_table.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หมายเลขโต๊ะ :<span style="color:red;">*</span> </label>
                                <div class="col-md-8" style="padding-top:7px;">
                                    ( หมายเลขโต๊ะจะแสดงหลังจากเพิ่มโต๊ะ )
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">จำนวน (คน) :<span style="color:red;">*</span> </label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" style="width:150px" value="2" onkeypress="return isNumberKey(event)" min="2" max="12" required name="tables_seats">
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

<div class="modal fade" id="deletetables<?php echo $result['tables_no']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center>
                    <h4 class="modal-title" id="myModalLabel">ต้องการลบข้อมูลโต๊ะหรือไม่</h4>
                </center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="del_table.php" enctype="multipart/form-data">
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หมายเลขโต๊ะ :</label>
                                <div class="col-md-8" style="padding-top:7px;">
                                    <input type="text" style="width:150px" value="<?php echo $result['tables_no']; ?>" name="tables_no" hidden>
                                    <?php echo $result['tables_no']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4 text-right" style="margin-top:7px;">จำนวนที่นั่ง (คน) :</label>
                                <div class="col-md-8" style="padding-top:7px;">
                                    <?php echo $result['tables_seats']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4 text-right" style="margin-top:7px;">สถานะจอง :</label>
                                <div class="col-md-8" style="padding-top:7px; text-align:left;">
                                    <?php if ($result['tables_status_reserve'] == 0) {
                                        echo "<span style='color:#12BB4F;'>ไม่มีการจอง</span>";
                                    } elseif ($result['tables_status_reserve'] == 1) {
                                        echo "<span style='color:red;'>มีการจอง</span>";
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4 text-right" style="margin-top:7px;">สถานะพร้อมใช้ :</label>
                                <div class="col-md-8" style="padding-top:7px; text-align:left;">
                                    <?php if ($result['tables_status_use'] == 0) {
                                        echo "<span style='color:#12BB4F;'>โต๊ะว่าง</span>";
                                    } elseif ($result['tables_status_use'] == 1) {
                                        echo "<span style='color:red;'>โต๊ะไม่ว่าง</span>";
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