<?php
session_start();
require_once "db.php";
require 'login_nav.php';

// Add cookies 
if (!empty($_POST["remember"])) {
  setcookie("username", $_POST["email"], time() + (1), "/");
  setcookie("password", $_POST["password"], time() + (1), "/");

  // Cookies Set Successfuly
} else {
  setcookie("username", "");
  setcookie("password", "");
  //Cookies Not Set
}

if (isset($_SESSION['user_id']) != "") {
  header("Location: dashboard.php");
}

if (isset($_POST['login'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email_error = "Please Enter Valid Email ID";
  }
  if (strlen($password) < 6) {
    $password_error = "Password must be minimum of 6 characters";
  }
  $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '" . $email . "' and password = '" . md5($password) . "'");
  if (!empty($result)) {
    if ($row = mysqli_fetch_array($result)) {
      $_SESSION['user_id'] = $row['uid'];
      $_SESSION['user_name'] = $row['name'];
      $_SESSION['user_email'] = $row['email'];
      $_SESSION['user_mobile'] = $row['mobile'];
      header("Location: dashboard.php");
    }
  } else {
    $error_message = "Incorrect Email or Password!!!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>Library - Login</title>
    <style>
      body {
        background-image: url("library.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        color: white;
      }

      h1 {
        font-family: Gill Sans, Verdana;
        font-size: 60px;
        color: white;
      }

      p {
        font-family: 'Open Sans', Arial, Helvetica, sans-serif;
        color: #FFFFFF;
      }

      .formStyle {
        color: white;
      }
    </style>
    <link rel="stylesheet" type="text/css" href="user.css">
    <link rel="stylesheet" type="text/css"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  </head>

  <body>

    <div class="container">
      <div class="row">
        <div class="col-lg-10">
          <div class="page-header">
            <h1 style="color:white">Login</h1>
          </div>

          <p>Please fill all fields in the form</p>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="formStyle">
            <div class="form-group ">
              <label>Email</label>
              <!-- Add cookie -->
              <input type="email" name="email" class="form-control" value="<?php if (isset($_COOKIE["email"])) {
                echo $_COOKIE["email"];
              } ?>" maxlength="30" required="">
              <span class="text-danger">
                <?php if (isset($email_error))
                  echo $email_error; ?>
              </span>
            </div>
            <div class="form-group">
              <label>Password</label>
              <!-- Add cookie -->
              <input type="password" name="password" class="form-control" value="<?php if (isset($_COOKIE["password"])) {
                echo $_COOKIE["password"];
              } ?>" maxlength="8" required="">
              <span class="text-danger">
                <?php if (isset($password_error))
                  echo $password_error; ?>
              </span>
            </div>
            <!-- Remember me -->
            <p><input type="checkbox" name="remember" /> Remember me </p>
            <input type="submit" class="btn btn-primary" name="login" value="Submit">
            <br>
            You don't have account?<a href="registration.php" class="btn btn-outline-light" style="margin:20px">Click
              Here</a>
          </form>
        </div>
      </div>
    </div>
  </body>

</html>