 <head>
     <title>เข้าสู่ระบบพนักงาน | เปิ้ลอาหารตามสั่ง</title>
     <link rel="shortcut icon" href="favicon.ico" />
     <?php
        session_start();
        if (isset($_SESSION['staff'])) {
            header("Location: index.php");
            exit();
        }

        include("conf/lib.php");

        ?>

     <style>
         body,
         html {
             height: 100%;
             background-repeat: no-repeat;
             background-image: linear-gradient(to left, rgb(0, 153, 0), rgb(153, 200, 174));
         }

         .card-container.card {
             max-width: 350px;
             padding: 40px 40px;
         }

         .btn {
             font-weight: 700;
             height: 36px;
             -moz-user-select: none;
             -webkit-user-select: none;
             user-select: none;
             cursor: default;
         }

         /*
 * Card component
 */
         .card {
             background-color: #F7F7F7;
             /* just in case there no content*/
             padding: 20px 25px 30px;
             margin: 0 auto 25px;
             margin-top: 50px;
             /* shadows and rounded borders */
             -moz-border-radius: 2px;
             -webkit-border-radius: 2px;
             border-radius: 2px;
             -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
             -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
             box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
         }

         .profile-img-card {
             width: 96px;
             height: 96px;
             margin: 0 auto 10px;
             display: block;
             -moz-border-radius: 50%;
             -webkit-border-radius: 50%;
             border-radius: 50%;
         }

         /*
 * Form styles
 */
         .profile-name-card {
             font-size: 16px;
             font-weight: bold;
             text-align: center;
             margin: 10px 0 0;
             min-height: 1em;
         }

         .reauth-email {
             display: block;
             color: #404040;
             line-height: 2;
             margin-bottom: 10px;
             font-size: 14px;
             text-align: center;
             overflow: hidden;
             text-overflow: ellipsis;
             white-space: nowrap;
             -moz-box-sizing: border-box;
             -webkit-box-sizing: border-box;
             box-sizing: border-box;
         }

         .form-signin #inputUsername,
         .form-signin #inputPassword {
             direction: ltr;
             height: 44px;
             font-size: 16px;
         }

         .form-control:focus {
             border-color: #29c68c;
             box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
         }

         .form-signin input[type=email],
         .form-signin input[type=password],
         .form-signin input[type=text],
         .form-signin button {
             width: 100%;
             display: block;
             margin-bottom: 10px;
             z-index: 1;
             position: relative;
             -moz-box-sizing: border-box;
             -webkit-box-sizing: border-box;
             box-sizing: border-box;
         }

         .form-signin .form-control:focus {
             border-color: #12ad20;
             outline: 1;

         }

         .btn.btn-signin {
             /*background-color: #4d90fe; */
             background-color: rgb(90, 160, 80);
             /* background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
             padding: 0px;
             font-weight: 700;
             font-size: 14px;
             height: 36px;
             -moz-border-radius: 3px;
             -webkit-border-radius: 3px;
             border-radius: 3px;
             border: none;
             -o-transition: all 0.218s;
             -moz-transition: all 0.218s;
             -webkit-transition: all 0.218s;
             transition: all 0.218s;
         }

         .forgot-password {
             color: rgb(104, 145, 162);
         }

         .forgot-password:hover,
         .forgot-password:active,
         .forgot-password:focus {
             color: rgb(12, 97, 33);
         }
     </style>
 </head>

 <body>
     <div class="container" style="padding-top:70px;">
         <div class="card card-container">
             <h3 style="margin: auto; text-align:center; color:gray;">เข้าสู่ระบบ</h3><br>
             <h4 style="margin: auto; text-align:center; color:gray;">ระบบขายอาหารตามสั่ง</h4><br>
             <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
             <img id="profile-img" class="profile-img-card" src="images/login-logo.png" />
             <p id="profile-name" class="profile-name-card"></p>
             <form class="form-signin" style=" color:red;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                 <span id="reauth-email" class="reauth-email"></span>
                 <input type="text" id="inputUsername" name="username" class="form-control" placeholder="ชื่อผู้ใช้งาน" required autofocus>
                 <input type="password" id="inputPassword" name="password" class="form-control" placeholder="รหัสผ่าน" required>

                 <button class="btn btn-lg btn-success btn-block btn-signin" type="submit">เข้าสู่ระบบ</button>
             </form><!-- /form -->
             <div class="col-md-offset-7 col-md-6 text-center">
                 <a href="#forgetModal" data-toggle="modal" data-target="#forgetModal"><u>ลืมรหัสผ่าน?</u></a>
             </div>
         </div><!-- /card-container -->
     </div><!-- /container -->
     <!-- Modal -->
     <div class="modal fade" id="forgetModal" tabindex="-1" role="dialog" aria-labelledby="forgetModal" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="forgetModal"><b>ลืมรหัสผ่าน<b></h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <div class="container" style="min-height: 0%!important;">
                         <div class="row">
                             <div class="col-md-3" style="padding-bottom:7px;"><b>กรุณาติดต่อพนักงาน</b></div>
                         </div>
                         <div class="row">
                             <label class="control-label col-sm-2 text-right"><i class="fa fa-envelope"></i> อีเมล :</label>
                             <div class="col-2 col-sm-1" style="padding-bottom:7px;"><a href="mailto:Aimaroy_99@gmail.com"><u>Aimaroy_99@gmail.com</u></a></div>
                         </div>
                         <!-- Force next columns to break to new line at md breakpoint and up -->
                         <div class="row">
                             <label class="control-label col-sm-2 text-right"><i class="fa fa-phone"></i> เบอร์โทร :</label>
                             <div class="col-2 col-sm-2"><a href="tel:061-576-0437"><u>061-576-0437</u></a></div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                 </div>
             </div>
         </div>
     </div>
 </body>
 <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('../conf/connection.php');

        // ตรวจสอบว่ามีการล็อคอินอยู่แล้วหรือไม่
        $username    = mysqli_real_escape_string($link, $_POST['username']);
        $password    = mysqli_real_escape_string($link, $_POST['password']);

        $sql        =    "SELECT staffid, staff_username, staff_password, staff_status, staff_level FROM staff WHERE staff_username = '" . $username . "' AND staff_password = '" . sha1($password) . "' ";

        $data         =     mysqli_query($link, $sql);
        //เช็คผู้ใช้งานซ้ำ



        if (mysqli_num_rows($data) != "0") {
            $data_user     =    mysqli_fetch_assoc($data);

            if ($data_user['staff_status'] == 1) {
                echo "<script>alert('ไม่ได้รับสิทธิ์ในการเข้าใช้งาน'); window.location.assign('index.php');</script>";
                exit();
            }


            $_SESSION['staff_id']    = $data_user['staffid'];
            $_SESSION['staff']         = $data_user['staff_username'];
            $_SESSION['staff_level'] = $data_user['staff_level'];
            echo "<script> alert('เข้าสู่ระบบสำเร็จ');window.location.assign('index.php') </script>";
        } else {
            echo "<script> alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'); </script>";
        }

        mysqli_close($link);
    }
    ?>