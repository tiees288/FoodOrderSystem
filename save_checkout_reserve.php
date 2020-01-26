<?php
session_start();
include("conf/connection.php");
include("conf/function.php");

//$totalprice = $_POST['totalprice'];

$reserv_date_reservation = dt_tochristyear($_POST['reserv_date_reservation']);
$reserv_date_appointment = date("Y-m-d", strtotime(tochristyear($_POST['reserv_date_appointment'])));


$sqlreservations = "INSERT INTO reservations SET 
                reserv_date_appointment		= '" . $reserv_date_appointment . "',
                reserv_time_appointment		= '" . $_POST['reserv_time_appointment'] . "',
                reserv_date_reservation		= '" . $reserv_date_reservation . "',
                reserv_status			    = '0',
                reserv_note                 = '". $_POST['reserve_note'] ."',
                cusid		                = '" . $_SESSION['user_id'] . "'";

mysqli_query($link, $sqlreservations) or die(mysqli_error($link));

$last_reserveid = mysqli_insert_id($link);

for ($i = 0; $i < count($_SESSION['food']['reserve']['tables_no']); $i++) {
    $sqlreservlist = "INSERT INTO reservelist SET 
                reservlist_amount		= '" . $_SESSION['food']['reserve']['seats'][$i] . "',
                reservlist_status		= '0',
                reservlist_note		    = '" . $_POST['reservlist_note_' . $i] . "',
                reserv_id			    = '" . $last_reserveid . "',
                tables_no		        = '" . $_SESSION['food']['reserve']['tables_no'][$i] . "'";

    mysqli_query($link, $sqlreservlist) or die(mysqli_error($link));
}



unset($_SESSION['food']['reserve']);

echo '<script>alert("บันทึกการจองเรียบร้อยแล้ว\nรหัสการจองคือ ' . str_pad($last_reserveid,5,0,STR_PAD_LEFT) . '"); window.location.assign("reserve_history.php")</script>';
mysqli_close($link);


?>