<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  require('../conf/connection.php');

  $sql_update  = "UPDATE banks SET 
		        bank_name	      = '" . $_POST['bank_name'] . "',
                bank_branch       = '" . $_POST['bank_branch'] . "',
                bank_details      = '" . $_POST['bank_details'] . "',
                bank_status       = '" . $_POST['bank_status'] . "'  WHERE bankid = '" . $_POST['bankid'] . "' ";

  if (mysqli_query($link, $sql_update) or die(mysqli_error($link))) {
    echo "<script> alert('แก้ไขข้อมูล รหัสธนาคาร: ". $_POST['bankid']." เรียบร้อยแล้ว'); window.location.assign('show_bank.php')</script>";
  } else {
    echo "<script> alert('แก้ไขข้อมูลผิดพลาด'); window.location.assign('show_bank.php')</script>";
  }
}
