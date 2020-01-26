<html>

<head>
    <?php

    if (!isset($_SESSION)) {
        session_start();
    }

    include("conf/lib.php");
    include("../conf/function.php");
    include("../conf/connection.php");

    if (!isset($_SESSION['staff'])) {
        echo "<script>alert('กรุณาตรรวจสอบสิทธิ์การเข้าใช้งาน'); window.location.assign('login_staff.php');</script>";
    }

    ?>
    <title>รายงานเมนูอาหารแยกตามประเภท | ระบบขายอาหารตามสั่ง</title>
    <style type="text/css">
        .catg {
            padding-left: 10px;
        }
    </style>
</head>
<div class="container" style="padding-top:20px">
    <h3 class="text-center">รายงานเมนูอาหารแยกตามประเภท</h3>
    <br>


    <table border="0" width="75%" align="center">
        <tr>
            <td colspan="7" align="right" style="border-bottom:1px solid;">
                วันที่พิมพ์ <?= fulldate_thai(date("d-m-Y")); ?>
            </td>
        </tr>
        <tr style="border-bottom: 1.5px solid">
            <th class="catg text-left" width="12%">ประเภท</th>
            <th class="" width="20%" style="padding-left:15px" width="20%">ชื่ออาหาร</th>
            <th class="text-right" width="15%">ราคา (บาท)</th>
            <th class="text-left" style="padding-left:20px;" width="15%">หน่วยนับ</th>
            <th class="text-left" width="15%">สถานะ</th>
            <th class="text-center" width="40%">รูปอาหาร</th>
        <tr>

            <?php


            $sql_catg = "SELECT DISTINCT food_type FROM foods";
            $query_catg = mysqli_query($link, $sql_catg) or die(mysqli_error($link));


            while ($catg = mysqli_fetch_array($query_catg)) {
                //   echo $catg['food_type'];
                $sql = "SELECT * FROM foods WHERE food_type = '" . $catg['food_type'] . "'";
                $query = mysqli_query($link, $sql);
                $qty = 0;
                $count_sell = 0;
                $cont_notsell = 0;

                if ($catg['food_type'] == 0) {
                    $foodtype = "ผัด";
                } elseif ($catg['food_type'] == 1) {
                    $foodtype = "ทอด";
                } elseif ($catg['food_type'] == 2) {
                    $foodtype = "ต้ม";
                } elseif ($catg['food_type'] == 3) {
                    $foodtype = "เครื่องดื่ม";
                }

            ?>
        <tr>
            <td class="text-left catg" style="padding-top:15px;"><?= $foodtype ?></td>
        </tr>

        <?php
                while ($result = mysqli_fetch_array($query)) {

                    if ($result['food_status'] == 0) {
                        $food_status = "<font color='#10C13A'>ใช้งาน</font>";
                        $count_sell++;
                    } elseif ($result['food_status'] == 1) {
                        $food_status = "<font color='red'>ยกเลิก</font>";
                        $cont_notsell++;
                    }

                    if ($result['food_image'] == "")
                        $food_img = "../images/default_food.png";
                    else $food_img = "../" . $result['food_image'];

                    $qty++; // นับจำนวนของอาหารแต่ละประเภท
        ?>
            <tr>
                <td></td>
                <td class="" style="padding:15px;"><?= $result['food_name'] ?></td>
                <td class="text-right"><?= number_format($result['food_price'], 2); ?></td>
                <td class="text-left" style="padding-left:20px;"><?= $result['food_count']; ?></td>
                <td class="text-left"><?= $food_status; ?></td>
                <td class="text-center" style="padding:2px;"><img style="border:1px solid;" height="60px" width="80px" src="<?= $food_img ?>"></td>
            </tr>
        <?php } ?>
        <tr style="border-bottom: 1.5px solid">
            <td style="padding-top:10px" colspan="3" align="right"><b>รวม</b></td>
            <td style="padding-top:10px; padding-right:20px; text-align:right;" align="center"><?= $qty ?></td>
            <td colspan="2" style="padding-top:10px"><b>รายการ</b></td>
        </tr>
    <?php
                $sumqty[] = $qty;
                $sumsell[] = $count_sell;
                $sumnotsell[] = $cont_notsell;
                // $i++;
            }
    ?>
    <tr style="">
        <td style="padding-top:10px" colspan="3" align="right"><b>รวมทั้งหมด</b></td>
        <td style="padding-top:10px; padding-right:20px;" align="right"><?= number_format(array_sum($sumqty)) ?></td>
        <td colspan="2" style="padding-top:10px"><b>รายการ</b></td>
    </tr>
    <tr style="">
        <td style="padding-top:10px; " colspan="3" align="right"><b>
                <font color='#10C13A'>รวมยังขายอยู่ทั้งหมด</font>
            </b></td>
        <td style="padding-top:10px; padding-right:20px;" align="right">
            <font color='#10C13A'><?= number_format(array_sum($sumsell)) ?></font>
        </td>
        <td colspan="2" style="padding-top:10px"><b>
                <font color='#10C13A'>รายการ</font>
            </b></td>
    </tr>
    <tr style="border-bottom: 1.5px solid; padding-bottom:500px;">
        <td style="padding-top:10px;" colspan="3" align="right"><b>
                <font color="red">รวมไม่ขายแล้วทั้งหมด
            </b></td>
        <td style="padding-top:10px; padding-right:20px;" align="right">
            <font color="red"><?= number_format(array_sum($sumnotsell)) ?></font>
        </td>
        <td colspan="2" style="padding-top:10px;">
            <font color="red"><b>รายการ</b></font>
        </td>
    </tr>
    </table>
</div>
<p>
    </body>

</html>