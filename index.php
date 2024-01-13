<!DOCTYPE html>
<html>

<head>
  <title>Login Page</title>
  <link rel="icon" type="image/png" sizes="32x32" href="admin/images/icon/favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container-fluid ps-md-0">
    <div class="row g-0">
      <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
      <div class="col-md-8 col-lg-6">
        <div class="login d-flex align-items-center py-5">
          <div class="container">
            <div class="row">
              <div class="col-md-9 col-lg-8 mx-auto">
                <h3 class="login-heading mb-4">Welcome back!</h3>

                <!-- Sign In Form -->
                <form id="login_form" class="login_form" action="login_func.php" method="POST">
                  <div class=" mb-3">
                    <label for="">username</label>
                    <input type="text" class="form-control" name="name">
                  </div>
                  <div class=" mb-3">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password">
                  </div>

                  <div class="d-grid">
                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit" value="Login" name="login">Sign in</button>
                    <div class="text-center">
                      <p> not a member?<a class="small btn-login text-uppercase fw-bold mb-2" href="user/registerUser.php">Register</a></p>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>

</html>