<?php
    session_start();

    unset($_SESSION['staff']);
    unset($_SESSION['staff_id']);
    unset($_SESSION['staff_level']);
    unset($_SESSION['food_admin']);
    
    echo "<script> alert('ออกจากระบบเรียบร้อย');window.location.assign('index.php') </script>";
?>