<?php
    session_start();

   // $_SESSION = array();
    unset($_SESSION['user']);
    unset($_SESSION['id']);
    unset($_SESSION['food']);

  //  session_destroy();
    echo "<script> alert('ออกจากระบบเรียบร้อย');window.location.assign('index.php') </script>";
?>