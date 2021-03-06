<head>
  <title>ติดต่อเรา | Food Order System</title>
  <?php
  if (!isset($_SESSION)) {  // Check if sessio nalready start
    session_start();
  }
  ?>
  <link rel="shortcut icon" href="favicon.ico" />
  <style type="text/css">
    iframe {
      width: 100%;
      height: 34%;
      overflow: scroll;
      /* border:1px solid; */
    }
  </style>
</head>

<body>
  <?php
  include("conf/header.php");
  ?>

  <div class="container" style="padding-top: 90px;">
    <div class="col">
      <h1 class="page-header text-left">ติดต่อเรา</h1>
      <div class="row">
        <div class="col-md-offset1 col-md-4 text-center">
          <img src="images/foodorder.jpg" width="250" class="img-fluid img-thumbnail" alt="Responsive image">
        </div>
        <div class="col-md-7">
          <h3><u>นโยบายของทางร้าน</u></h3>
          <iframe frameBorder="0" src="policy.php"></iframe>
        </div>
      </div>
      <hr>
      <section id="contact">
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-3 my-5">
            <div class="card border-0">
              <div class="card-body text-center">
                <i class="fa fa-phone fa-5x mb-3" aria-hidden="true"></i>
                <h4 class="text-uppercase mb-5">เบอร์โทรศัพท์</h4>
                <p><a href="tel:0615760437"><u>061-576-0437</u></a></p>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-5">
            <div class="card border-0">
              <div class="card-body text-center">
                <i class="fa fa-map-marker fa-5x mb-3" aria-hidden="true"></i>
                <h4 class="text-uppercase mb-5">สถานที่ตั้ง</h4>
                <address>หน้าหอพัก Grand modern condo ตรงข้ามมหาวิทยาลัยกรุงเทพ หมู่.5 ต.คลองหนึ่ง
                  อ.คลองหลวง จ.ปทุมธานี 12120</address>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-5">
            <div class="card border-0">
              <div class="card-body text-center">
                <i class="fa fa-clock-o fa-5x mb-3" aria-hidden="true"></i>
                <h4 class="text-uppercase mb-5">เวลาทำการ</h4>
                <p>8.00น.-18.00 น.</p>
                <p>ปิดทำการทุกวันอาทิตย์</p>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3 my-5">
            <div class="card border-0">
              <div class="card-body text-center">
                <i class="fa fa-envelope-o fa-5x mb-3" aria-hidden="true"></i>
                <h4 class="text-uppercase mb-5">email</h4>
                <p><a href="mailto:aimaroy_99@gmail.com"><u>Aimaroy_99@gmail.com</u></a></p>
              </div>
            </div>
          </div>
      </section>
    </div>
  </div>
  <?php include("conf/footer.php"); ?>
</body>