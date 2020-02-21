<?php
    session_start();

    unset($_SESSION['user']);
    unset($_SESSION['user_id']);
    unset($_SESSION['user_status']);
    unset($_SESSION['food']);

    unset($_COOKIE['user_id']);
    unset($_COOKIE['user']);
    unset($_COOKIE['user_status']);
    setcookie('user_id', '', time() - 3600, '/');
    setcookie('user', '', time() - 3600, '/');
    setcookie('user_status', '', time() - 3600, '/');

  //  session_destroy();
    echo "<script> alert('ออกจากระบบเรียบร้อย');window.location.assign('index.php') </script>";
?>