<?php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['staff'])) {
    if (!isset($_GET['orderid']))
        exit();

    require_once("../conf/connection.php");
    require_once("../conf/function.php");

    $orderid = mysqli_real_escape_string($link, $_GET['orderid']);

    $sql_reserv = "SELECT reserv_date_appointment, reserv_time_appointment FROM reservations WHERE reserv_id = '" . $orderid . "'";
    $data = mysqli_fetch_assoc(mysqli_query($link, $sql_reserv));
    
    $obj = new \stdClass();;
    $obj->reserv_date_appointment = tothaiyear($data['reserv_date_appointment']);
    $obj->reserv_time_appointment = substr($data['reserv_time_appointment'],0,5);

    $json = json_encode($obj);
    echo $json;

    mysqli_close($link);
}
