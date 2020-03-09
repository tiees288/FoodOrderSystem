     <div class="modal fade" id="editcustomer<?php echo $result['cusid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <center>
                         <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลลูกค้า</h4>
                     </center>
                 </div>
                 <div class="modal-body">
                     <div class="container-fluid">
                         <form method="POST" action="edit_customer.php" enctype="multipart/form-data">
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">รหัสลูกค้า :</label>
                                     <div class="col-md-7">
                                         <input type="text" class="form-control" style="width:150px" value="<?php echo $result['cusid']; ?>" name="cusid" readonly>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">ชื่อ-นามสกุล :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" style="width:300px" pattern="^[ก-๏a-zA-Z\s]+$" value="<?php echo $result['cus_name']; ?>" name="cus_name">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">วันเกิด :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control datepicker1" onkeypress="event.preventDefault(); return false;" style="width:300px" value="<?= tothaiyear($result['cus_birth']) ?>" name="cus_birth">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">เบอร์โทรศัพท์ :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" style="width:300px" minlength="9" maxlength="10" onkeypress="return isNumberKey(event)" value="<?php echo $result['cus_tel']; ?>" name="cus_tel">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">อีเมล :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" style="width:300px" value="<?php echo $result['cus_email']; ?>" name="cus_email">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">ที่อยู่ :<span style="color:red;">*</span> </label>
                                     <div class="col-md-7">
                                         <textarea name="cus_address" id="" cols="30" rows="4" class="form-control"><?= $result['cus_address']; ?></textarea>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">รหัสไปรษณีย์ :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" style="width:150px" onkeypress="return isNumberKey(event)" minlength="5" maxlength="5" value="<?php echo $result['cus_postnum']; ?>" name="cus_postnum">
                                     </div>
                                 </div>
                             </div>

                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">สถานะ:<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <select class="form-control" style="width:250px" name="cus_status">
                                             <option value="" disabled selected>-- กรุณาเลือกสถานะ --</option>
                                             <option <?php if ($result['cus_status'] == 0) echo "selected"; ?> value="0">ลูกค้าปกติ</option>
                                             <option <?php if ($result['cus_status'] == 1) echo "selected"; ?> value="1">บัญชีดำ</option>
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


     <!-- Add Customer Modal -->
     <div class="modal fade" id="addcustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <center>
                         <h4 class="modal-title" id="myModalLabel">เพิ่มข้อมูลสมาชิก</h4>
                     </center>
                 </div>
                 <div class="modal-body">
                     <div class="container-fluid">
                         <form method="POST" action="add_customer.php" enctype="multipart/form-data">
                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">ชื่อ-นามสกุล :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" pattern="^[ก-๏a-zA-Z\s]+$" style="width:300px" value="" name="cus_name" required>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">วันเกิด :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control datepicker1" onkeypress="event.preventDefault(); return false;" style="width:300px" value="" name="cus_birth">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">เบอร์โทรศัพท์ :<span style="color:red;">*</span> </label>
                                     <div class="col-md-7">
                                         <input type="text" class="form-control" style="width:300px" required minlength="9" maxlength="10" onkeypress="return isNumberKey(event)" value="" name="cus_tel">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">อีเมล :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" required style="width:300px" value="" name="cus_email">
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">ที่อยู่ :<span style="color:red;">*</span> </label>
                                     <div class="col-md-7">
                                         <textarea name="cus_address" id="cus_address" required cols="30" rows="4" class="form-control"></textarea>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group" style="margin-top:10px;">
                                 <div class="row">
                                     <label class="control-label col-md-4 text-right" style="padding-top:7px">รหัสไปรษณีย์ :<span style="color:red;">*</span> </label>
                                     <div class="col-md-8">
                                         <input type="text" class="form-control" required style="width:150px" onkeypress="return isNumberKey(event)" minlength="5" maxlength="5" value="" name="cus_postnum">
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

     <!-- Delete Customer -->

     <div class="modal fade" id="deletecustomer<?php echo $result['cusid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <center>
                         <h4 class="modal-title" id="myModalLabel">ต้องการลบข้อมูลสมาชิกหรือไม่</h4>
                     </center>
                 </div>
                 <div class="modal-body">
                     <div class="container-fluid">
                         <form method="POST" action="del_customer.php" enctype="multipart/form-data">
                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label text-right col-md-4">รหัสลูกค้า :</span> </label>
                                     <div class="col-md-8" style="padding-top:0px">
                                         <?= $result['cusid']; ?>
                                         <input type="text" style="width:150px" value="<?= $result['cusid'] ?>" name="cusid" hidden>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label text-right col-md-4">ชื่อ-นามสกุล :</label>
                                     <div class="col-md-8" style="padding-top:0px;">
                                         <?= $result['cus_name'] ?>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <div class="row">
                                     <label class="control-label text-right col-md-4">สถานะ :</label>
                                     <div class="col-md-8" style="padding-top:0px">
                                         <?php if ($result['cus_status'] == 0) {
                                                echo "<span style='color:#12BB4F'>ลูกค้าปกติ</span>";
                                            } else if ($result['cus_status'] == 1) {
                                                echo "<span style='color:red'>บัญชีดำ</span>";
                                            } ?>
                                     </div>
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