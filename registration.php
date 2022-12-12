<?php
require_once "db.php";
require 'login_nav.php';
if (isset($_SESSION['user_id']) != "") {
    header("Location: dashboard.php");
}

$name_error = $email_error = $mobile_error = $password_error = $cpassword_error = "";
$name = $email = $mobile = $password = $cpassword = "";

if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $name_error = "Name must contain only alphabets and space";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Please Enter Valid Email ID";
    }
    if (strlen($password) < 6) {
        $password_error = "Password must be minimum of 6 characters";
    }
    if (strlen($mobile) < 10) {
        $mobile_error = "Mobile number must be minimum of 10 characters";
    }
    if ($password != $cpassword) {
        $cpassword_error = "Password and Confirm Password doesn't match";
    }

    if ($name_error == "" && $email_error == "" && $mobile_error == "" && $password_error == "" && $cpassword_error == "") {
        if (mysqli_query($conn, "INSERT INTO users(name, email, mobile ,password) VALUES('" . $name . "', '" . $email . "', '" . $mobile . "', '" . md5($password) . "')")) {
            header("location: login.php");
            exit();
        } else {
            echo "Error:" . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Library - Registration</title>
        <link rel="stylesheet" type="text/css" href="user.css">
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
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-offset-2">
                    <div class="page-header">
                        <h1>Register</h1>
                    </div>
                    <p>Please fill all fields in the form</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                        class="formStyle">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="" maxlength="50" required="">
                            <span class="text-danger">
                                <?php
                                //  if (isset($name_error)) 
                                echo $name_error; ?>
                            </span>
                        </div>
                        <div class="form-group ">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="" maxlength="30" required="">
                            <span class="text-danger">
                                <?php if (isset($email_error))
                                    $email_error; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" name="mobile" class="form-control" value="" maxlength="12" required="">
                            <span class="text-danger">
                                <?php if (isset($mobile_error))
                                    echo $mobile_error; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="" maxlength="8"
                                required="">
                            <span class="text-danger">
                                <?php if (isset($password_error))
                                    echo $password_error; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="cpassword" class="form-control" value="" maxlength="8"
                                required="">
                            <span class="text-danger">
                                <?php if (isset($cpassword_error))
                                    echo $cpassword_error; ?>
                            </span>
                        </div>
                        <input type="submit" class="btn btn-primary" name="signup" value="Register">
                        <div>
                            Already have a account?<a href="login.php" class="btn btn-outline-light">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

</html>