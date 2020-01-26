<html>

<head>
  <title>หน้าแรก หลังร้าน | Food Order System</title>
</head>

<?php
session_start();
if (!isset($_SESSION['staff'])) {
  echo "<script>window.location.assign('login_staff.php');</script>";
  exit();
}
include("conf/header_admin.php");
?>

<body>
  <div class="container" style="padding-top: 160px; ">
    <div align="center">
      <br><img src="../images/logo.png" style="width:250px;">
      <hr>
      <h4 class="text-left">เมนูอาหารแนะนำ</h4>
      <hr>
    </div>
  </div>

  <div class="container">
    <div class="row text-center">

      <?php
      require_once("../conf/connection.php");
      $num_recommend = 6; // จำนวนอาหารแนะนำที่แสดง
      $sql = "SELECT * FROM foods WHERE food_status = 0 ORDER BY food_recomend DESC";
      $query_reconend = mysqli_query($link, $sql);
      $i = 1;

      while ($i <= $num_recommend) {
        $result = mysqli_fetch_array($query_reconend) or die(mysqli_error($link));

        if ($result['food_image'] == "")
          $food_img = "images/default_food.png";
        else $food_img = $result['food_image'];

      ?>
        <div class="col-md-4 justify-content-center" style="padding-bottom:15px; ">
          <div class="card" style="border:1px solid #dfe3e8; height: 320px; width:380px; padding-top:5px; border-radius: 3%; background-color:#fdfdfd; box-shadow: 1px 1px 2px 0px rgba(215,219,215,1);">
            <div class="col-md-2" style="padding-bottom:7px;"></div>
            <img class="card-img-top" style="border:1px solid; border-radius: 3%;" src="../<?= $food_img ?>" height="190" width="340px" alt="Card image cap">
            <div class="card-body" style="color:green;">
              <b>
                <h4 class="card-title">
                  <?= $result['food_name'] ?>
                </h4>
              </b>
              <table border="0" width="180px" align="center">
                <tr>
                  <td align="right">
                    <p class="card-text">ราคา : </p>
                  </td>
                  <td align="right">
                    <p class="card-text"><?= number_format($result['food_price'], 2) ?></p>
                  </td>
                  <td width="15px"> </td>
                  <td>
                    <p class="card-text">บาท</p>
                  </td>
                <tr>
              </table>

              <a href="staff_add_list_food.php?foodid=<?= $result['foodid']; ?>" class="btn btn-success"><span class="glyphicon glyphicon-shopping-cart"></span> ใส่ตะกร้า</a>

            </div>
          </div>
        </div>
      <?php
        $i++;
      }  ?>
    </div>
  </div>
</body>
<?php
  include_once("../conf/footer.php");
?>
