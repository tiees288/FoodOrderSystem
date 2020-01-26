<?php
session_start();

if (!isset($_SESSION['staff'])) {
    header("location: login_staff.php");
    exit();
}

include("../conf/connection.php");
include("../conf/function.php");

//$totalprice = $_POST['totalprice'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirms'])) { // กรณียืนยัน
        mysqli_query($link, "UPDATE reservations SET reserv_status = 1 WHERE reserv_id = '" . $_POST['reserv_id'] . "' ");
        echo '<script>alert("ยืนยันกการจอง รหัสการจอง ' . str_pad($_POST['reserv_id'], 5, 0, STR_PAD_LEFT) . ' เรียบร้อย"); window.location.assign("staff_reserve_history.php")</script>';
    } elseif (isset($_POST['cancel'])) { //กรณียกเลิก
        mysqli_query($link, "UPDATE reservations SET reserv_status = 2 WHERE reserv_id = '" . $_POST['reserv_id'] . "' ");
        mysqli_query($link, "UPDATE reservelist SET reservlist_status = 2 WHERE reserv_id = '" . $_POST['reserv_id'] . "'");
        echo '<script>alert("ยกเลิกการจอง รหัสการจอง ' . str_pad($_POST['reserv_id'], 5, 0, STR_PAD_LEFT) . ' เรียบร้อย"); window.location.assign("staff_reserve_history.php")</script>';
    } elseif (isset($_POST['submit'])) {
        //$reserv_date_reservation = dt_tochristyear($_POST['reserv_date_reservation']);
        $reserv_date_appointment = date("Y-m-d", strtotime(tochristyear($_POST['reserv_date_appointment'])));

        $sqlreservations = "UPDATE reservations SET 
                reserv_date_appointment		= '" . $reserv_date_appointment . "',
                reserv_time_appointment		= '" . $_POST['reserv_time_appointment'] . "',
                reserv_status			    = '0',
                reserv_note                 = '" . $_POST['reserve_note'] . "' WHERE reserv_id = '" . $_POST['reserv_id'] . "'";

        mysqli_query($link, $sqlreservations) or die(mysqli_error($link));

        $sql_reservelist = mysqli_query($link, "SELECT * FROM `reservelist` WHERE reserv_id = '" . $_POST['reserv_id'] . "'");
        $count_reservelist = mysqli_num_rows($sql_reservelist);

        for ($i = 0; $i < $count_reservelist; $i++) {
            $result_reservelist = mysqli_fetch_array($sql_reservelist);
            $sql_update_reservelist = "UPDATE reservelist SET
            reservlist_note     =   '" . $_POST['reservlist_note_' . $i] . "' WHERE reservlist_id = '" . $result_reservelist['reservlist_id'] . "'";

            mysqli_query($link, $sql_update_reservelist);
        }
        echo '<script>alert("ปรับปรุงการจอง รหัสการจอง ' . str_pad($_POST['reserv_id'], 5, 0, STR_PAD_LEFT) . ' เรียบร้อย"); window.location.assign("staff_reserve_history.php")</script>';
    } else {
        echo "<script>window.location.assign('staff_reserve_history.php')</script>";
    }
}
