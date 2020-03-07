<?php
// ------------------------------------ เข้ารหัส ------------------------------------- //
function utf8_strlen($s)
{

    $c = strlen($s);
    $l = 0;

    for ($i = 0; $i < $c; ++$i) if ((ord($s[$i]) & 0xC0) != 0x80) ++$l;

    return $l;
}

function encrypt($string, $type)
{
    $secret_key = '2562foodordersystem420'; // iv secretkey
    $secret_iv = 'foodordersystem4202562!'; //secret key iv

    $output = false;

    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($type == "en") {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } elseif ($type == "de") {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
// ------------------------------------------------------------------------------------ //

function tochristyear($dates)  // สำหรับ input type date พ.ศ. -> ค.ศ
{
    $d1 = substr($dates, 0, 2);
    $m1 = substr($dates, 3, 2);
    $y = substr($dates, 6, 4);
    $y1 = $y - 543;
    $h1 = substr($dates, 10, 6);
    if ($dates == "") {
        return "";
    } else {
        return $y1 . "-" . $m1 . "-" . $d1;
    }
}

function dt_tochristyear($dates) // สำหรับ input type date/time ค.ศ -> พ.ศ.
{
    $date = date("d-m-Y H:i", strtotime($dates));
    $d1 = substr($date, 0, 2);
    $m1 = substr($date, 3, 2);
    $y = substr($date, 6, 4);
    $y1 = $y - 543;
    $time = substr($date, 11, 6);

    if ($date == "") {
        return "";
    } else {
        return $y1 . "-" . $m1 . "-" . $d1 . "T" . $time;
    }
}

function tothaiyear($dates) // สำหรับ input type date ค.ศ -> พ.ศ.
{
    $date = date("d-m-Y", strtotime($dates));
    $d1 = substr($date, 0, 2);
    $m1 = substr($date, 3, 2);
    $y = substr($date, 6, 4);
    $y1 = $y + 543;
    $h1 = substr($date, 10, 6);
    if ($date == "") {
        return "";
    } else {
        return $d1 . "/" . $m1 . "/" . $y1;
    }
}

function dt_tothaiyear($dates) // สำหรับ input type date/time ค.ศ -> พ.ศ.
{
    $date = date("d-m-Y H:i", strtotime($dates));
    $d1 = substr($date, 0, 2);
    $m1 = substr($date, 3, 2);
    $y = substr($date, 6, 4);
    $y1 = $y + 543;
    $time = substr($date, 11, 6);

    if ($date == "") {
        return "";
    } else {
        return $d1 . "/" . $m1 . "/" . $y1 . " " . $time;
    }
}

function dt_tothaiyear2($dates) // สำหรับ input type date/time ค.ศ -> พ.ศ.
{
    $date = date("d-m-Y H:i", strtotime($dates));
    $d1 = substr($date, 0, 2);
    $m1 = substr($date, 3, 2);
    $y = substr($date, 6, 4);
    $y1 = $y + 543;
    $time = substr($date, 11, 6);

    if ($date == "") {
        return "";
    } else {
        return $y1 . "-" . $m1 . "-" . $d1 . "T" . $time;
    }
}

function fullmonth($month)
{
    $months = array(
        '',
        'มกราคม',
        'กุมภาพันธ์',
        'มีนาคม',
        'เมษายน',
        'พฤษภาคม',
        'มิถุนายน',
        'กรกฎาคม ',
        'สิงหาคม',
        'กันยายน',
        'ตุลาคม',
        'พฤศจิกายน',
        'ธันวาคม',
    );

    return $months[$month];
}


function fulldate_thai($dates)
{

    //$dates = date("d-m-Y", strtotime($date));

    $d = substr($dates, 0, 2);
    $m = substr($dates, 3, 2);
    $y = substr($dates, 6, 4);

    if ($d < 10) {
        $d = substr($d, 1, 1);
    }
    if ($m < 10) {
        $m = substr($m, 1, 1);
    }


    $months = array(
        '',
        'มกราคม',
        'กุมภาพันธ์',
        'มีนาคม',
        'เมษายน',
        'พฤษภาคม',
        'มิถุนายน',
        'กรกฎาคม ',
        'สิงหาคม',
        'กันยายน',
        'ตุลาคม',
        'พฤศจิกายน',
        'ธันวาคม',
    );


    if ($dates == "") {
        return "";
    } else {
        return $d . " " . $months[$m] . " พ.ศ. " . ($y + 543);
    }
}

function fulldatetime_thai($dates)
{

    //$dates = date("d-m-Y", $dates);

    $d = substr($dates, 0, 2);
    $m = substr($dates, 3, 2);
    $y = substr($dates, 6, 4);
    $hi = substr($dates, 11, 5);


    if ($d < 10) {
        $d = substr($d, 1, 1);
    }
    if ($m < 10) {
        $m = substr($m, 1, 1);
    }


    $months = array(
        '',
        'มกราคม',
        'กุมภาพันธ์',
        'มีนาคม',
        'เมษายน',
        'พฤษภาคม',
        'มิถุนายน',
        'กรกฎาคม ',
        'สิงหาคม',
        'กันยายน',
        'ตุลาคม',
        'พฤศจิกายน',
        'ธันวาคม',
    );


    if ($dates == "") {
        return "";
    } else {
        return $d . " " . $months[$m] . " พ.ศ. " . ($y);
    }
}

function short_datetime_thai($dates)
{

    $dates_n = tothaiyear($dates);

    $d = substr($dates_n, 0, 2);
    $m = substr($dates_n, 3, 2);
    $y = substr($dates_n, 6, 4);
    // $hi = substr($dates_n, 11, 5);


    if ($d < 10) {
        $d = substr($d, 1, 1);
        //  $d = "0".$d;
    }
    if ($m < 10) {
        $m = substr($m, 1, 1);
    }


    $months = array(
        '',
        'ม.ค.',
        'ก.พ.',
        'มี.ค.',
        'เม.ย.',
        'พ.ค.',
        'มิ.ย.',
        'ก.ค. ',
        'ส.ค.',
        'ก.ย.',
        'ต.ค.',
        'พ.ย.',
        'ธ.ค.',
    );


    if ($dates == "") {
        return "";
    } else {
        return $d . " " . $months[$m] . "" . ($y);
    }
}
