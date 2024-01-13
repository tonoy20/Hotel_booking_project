<?php 
    include("../server.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="images/icon/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Registration form</title>
</head>

<?php
  if(isset($_POST['re_submit'])) {
    $uname =  $_POST['r_name'];
    $uemail =  $_POST['r_email'];
    $upass =  md5($_POST['r_pass']);
    $u_repass = md5($_POST['r_repass']);
    $checku = "SELECT * FROM users WHERE email = '$uemail' ";
    $res = mysqli_query($conn, $checku);
    $count = mysqli_num_rows($res);
    if($count>0) {
      echo '<script>alert("Email already singed up!!")</script>';
      echo '<script>window.location.href = "registerUser.php";</script>';
      exit;
    } else if($upass !== $u_repass) {
        echo '<script>alert("Password did not match !!")</script>';
        echo '<script>window.location.href = "registerUser.php";</script>';
        exit;
    } else {
      $sql = "INSERT INTO `users`(`name`, `email`, `password`, `userType`, `status`) VALUES ('$uname','$uemail','$upass','0','0')";

      $sq_run = mysqli_query($conn,$sql);
      if($sq_run) {
        header("location:../index.php");
      }
    }
  }
?>

<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                                    <form id="regis" class="mx-1 mx-md-4" method="POST">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" name="r_name" class="form-control" placeholder="Your Name" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" name="r_email" class="form-control" placeholder="Your Email" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="r_pass" class="form-control" placeholder="Password" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="r_repass" class="form-control" placeholder="Repeat your password" />
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <input type="submit" name="re_submit" value="register" class="btn btn-primary btn-lg"></input>
                                        </div>
                                    </form>
                                    <div class="text-center">
                                    <p> Already a Member? <a class="small btn-login text-uppercase fw-bold mb-2" href="../logout.php">Login</a></p>
                                </div>
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <!-- <img src="https://webrezpro.com/wp-content/uploads/2022/11/CentralizedReservations.jpg" class="img-fluid" alt="Sample image"> -->
                                    <img src="https://img.freepik.com/free-photo/sunset-pool_1203-3192.jpg?size=626&ext=jpg&ga=GA1.1.1916468697.1702033097&semt=ais" class="img-fluid" alt="Sample image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>

</html>