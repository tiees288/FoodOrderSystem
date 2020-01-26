     <div class="modal fade" id="editstaff<?php echo $result['staffid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <center>
                         <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลพนักงาน</h4>
                     </center>
                 </div>
                 <div class="modal-body">
                     <div class="container-fluid">
                         <form method="POST" action="edit_staff.php" enctype="multipart/form-data">
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รหัสพนักงาน :</label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" style="width:150px" value="<?php echo $result['staffid']; ?>" name="staffid" readonly>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อ-นามสกุล :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" style="width:300px" value="<?php echo $result['staff_name']; ?>" name="staff_name" pattern="^[ก-๏a-zA-Z\s]+$">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">วันเกิด :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control datepicker1" onkeypress="return false; event.preventDefault();" style="width:300px" value="<?= tothaiyear($result['staff_birth']) ?>" name="staff_birth" required>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">เบอร์โทรศัพท์ :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" style="width:300px" minlength="9" maxlength="10" onkeypress="return isNumberKey(event)" value="<?php echo $result['staff_tel']; ?>" name="staff_tel">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">อีเมล :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" style="width:300px" value="<?php echo $result['staff_email']; ?>" name="staff_email">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ที่อยู่ :<span style="color:red;">*</span> </label>
                                     <div class="col-md-7">
                                         <textarea name="staff_address" id="" cols="30" rows="4" class="form-control"><?= $result['staff_address']; ?></textarea>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รหัสไปรษณีย์ :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" style="width:150px" minlength="5" maxlength="5" value="<?php echo $result['staff_postnum']; ?>" name="staff_postnum">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หมายเลขบัตรประชาชน:<span style="color:red;">*</span></label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" style="width:300px" onkeypress="return isNumberKey(event)" minlength="13" maxlength="13" value="<?php echo $result['staff_nationid']; ?>" name="staff_nationid" readonly>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ระดับ:<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <select class="form-control" style="width:250px" name="staff_level">
                                             <option value="" disabled selected>-- กรุณาเลือกระดับ --</option>
                                             <option <?php if ($result['staff_level'] == 0) echo "selected"; ?> value="0">พนักงาน</option>
                                             <option <?php if ($result['staff_level'] == 1) echo "selected"; ?> value="1">เจ้าของร้าน</option>
                                         </select>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">สถานะ:<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <select class="form-control" style="width:250px" name="staff_status">
                                             <option value="" disabled selected>-- กรุณาเลือกสถานะ --</option>
                                             <option <?php if ($result['staff_status'] == 0) echo "selected"; ?> value="0">ทำงาน</option>
                                             <option <?php if ($result['staff_status'] == 1) echo "selected"; ?> value="1">ลาออก</option>
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


     <!-- Add Staff Modal -->
     <div class="modal fade" id="addstaff" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <center>
                         <h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูลพนักงาน</h4>
                     </center>
                 </div>
                 <div class="modal-body">
                     <div class="container-fluid">
                         <form method="POST" action="add_staff.php" enctype="multipart/form-data">
                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ชื่อ-นามสกุล :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" style="width:300px" value="" name="staff_name" required pattern="^[ก-๏a-zA-Z\s]+$">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">วันเกิด :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control datepicker1" onkeypress="return false; event.preventDefault();" style="width:300px" value="" name="staff_birth" required>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">เบอร์โทรศัพท์ :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" style="width:300px" required minlength="9" maxlength="10" onkeypress="return isNumberKey(event)" value="" name="staff_tel">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">อีเมล :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" required style="width:300px" value="" name="staff_email">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ที่อยู่ :<span style="color:red;">*</span> </label>
                                     <div class="col-md-7">
                                         <textarea name="staff_address" id="staff_address" required cols="30" rows="4" class="form-control"></textarea>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">รหัสไปรษณีย์ :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" required style="width:150px" onkeypress="return isNumberKey(event)" minlength="5" maxlength="5" value="" name="staff_postnum">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">หมายเลขบัตรประชาชน:<span style="color:red;">*</span></label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" required minlength="13" maxlength="13" onkeypress="return isNumberKey(event)" style="width:300px" value="" name="staff_nationid">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label col-md-4" style="margin-top:7px; text-align:right;">ระดับ:<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <select class="form-control" style="width:250px" name="staff_level" required>
                                             <option value="" disabled selected>-- กรุณาเลือกระดับ --</option>
                                             <option value="0">พนักงาน</option>
                                             <option value="1">เจ้าของร้าน</option>
                                         </select>
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

     <!-- Delete Staff -->

     <div class="modal fade" id="deletestaff<?php echo $result['staffid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <center>
                         <h4 class="modal-title" id="myModalLabel">ต้องการลบข้อมูลพนักงานหรือไม่</h4>
                     </center>
                 </div>
                 <div class="modal-body">
                     <div class="container-fluid">
                         <form method="POST" action="del_staff.php" enctype="multipart/form-data">
                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right">รหัสพนักงาน :</span> </label>
                                     <div class="col-md-8" style="padding-top:0px">
                                         <?= $result['staffid']; ?>
                                         <input type="text" style="width:150px" value="<?= $result['staffid'] ?>" name="staffid" hidden>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right">ชื่อ-นามสกุล :</label>
                                     <div class="col-md-8" style="padding-top:0px;">
                                         <?= $result['staff_name'] ?>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right">สถานะ :</label>
                                     <div class="col-md-8" style="padding-top:0px">
                                         <?php if ($result['staff_status'] == 0) {
                                                echo "<span style='color:#12BB4F'>ทำงาน</span>";
                                            } else if ($result['staff_status'] == 1) {
                                                echo "<span style='color:red'>ลาออก</span>";
                                            } ?>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <label class="control-label col-md-4 text-right">ระดับ :</label>
                                 <div class="col-md-8" style="padding-top:0px">
                                     <?php if ($result['staff_level'] == 0) {
                                            echo "พนักงาน";
                                        } else if ($result['staff_level'] == 1) {
                                            echo "เจ้าของร้าน";
                                        } ?>
                                 </div>
                             </div>
                     </div>
                 </div>
                 <div class="modal-footer">
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
     </script>