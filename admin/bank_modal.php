<div class="modal fade" id="editbank<?php echo $result['bankid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center>
                    <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลธนาคาร</h4>
                </center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="edit_bank.php" enctype="multipart/form-data">
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รหัสธนาคาร :</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" style="width:150px" value="<?php echo $result['bankid']; ?>" name="bankid" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อธนาคาร :<span style="color:red;">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" style="width:250px" value="<?php echo $result['bank_name']; ?>" required name="bank_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สาขา :<span style="color:red;">*</span></label>
                                <div class="col-md-8">
                                    <textarea style="width:300px" class="form-control" rows="3" cols="2" required name="bank_branch"><?= $result['bank_branch'] ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รายละเอียด :</label>
                                <div class="col-md-8">
                                    <textarea style="width:300px" class="form-control" rows="3" cols="2" name="bank_details"><?= $result['bank_details'] ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สถานะ :<span style="color:red;">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control" style="width:200px" name="bank_status" required>
                                        <option value="" disabled selected>-- กรุณาเลือกสถานะ --</option>
                                        <option <?php if ($result['bank_status'] == 0) echo "selected"; ?> value="0">ใช้งาน</option>
                                        <option <?php if ($result['bank_status'] == 1) echo "selected"; ?> value="1">ไม่ใช้งาน</option>
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


<!-- Add bank Modal -->
<div class="modal fade" id="addbank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center>
                    <h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูลธนาคาร</h4>
                </center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="add_bank.php" enctype="multipart/form-data">
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อธนาคาร :<span style="color:red;">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" style="width:250px" value="" name="bank_name" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สาขา :<span style="color:red;">*</span></label>
                                <div class="col-md-8">
                                    <textarea style="width:300px" class="form-control" rows="3" cols="2" name="bank_branch" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รายละเอียด :</label>
                                <div class="col-md-8">
                                    <textarea style="width:300px" class="form-control" rows="3" cols="2" name="bank_details"></textarea>
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

<div class="modal fade" id="deletebank<?php echo $result['bankid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center>
                    <h4 class="modal-title" id="myModalLabel">ต้องการลบข้อมูลธนาคารหรือไม่</h4>
                </center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="del_bank.php" enctype="multipart/form-data">
                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="text-align:right;">รหัสธนาคาร :</label>
                                <div class="col-md-8">
                                    <input type="text" style="width:150px" value="<?php echo $result['bankid']; ?>" name="bankid" hidden>
                                    <?php echo $result['bankid']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="text-align:right;">ชื่อธนาคาร :</label>
                                <div class="col-md-8">
                                    <?php echo $result['bank_name']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top:10px;">
                            <div class="row">
                                <label class="control-label col-md-4" style="text-align:right;">สาขา :</label>
                                <div class="col-md-8">
                                    <?= $result['bank_branch'] ?>
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