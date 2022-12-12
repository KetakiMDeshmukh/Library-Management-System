<?php
session_start();
require 'admin_nav.php';

if (isset($_SESSION['admin_id']) == "") {
  header("Location: admin_login.php");
}

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = "my_db";
$conn = mysqli_connect($servername, $username, $password, "$dbname");
if (!$conn) {
  die('Could not Connect MySql Server:' . mysql_error());
}
$sql = " SELECT users.name, books.title, issued.expectedReturnDate FROM issued inner join users on issued.uid = users.uid inner join books on issued.bookId = books.bookId WHERE issued.returnDate is NULL;";
$result = mysqli_query($conn, $sql)

  ?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>Library - Admin Dashboard</title>
    <style>
      body {
        background-image: url("library.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        color: white;
      }
    </style>
    <link rel="stylesheet" type="text/css" href="user.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

  </head>

  <body>


    <table style="color: #4a473e;">

      <?php
      while ($rows = $result->fetch_assoc()) {
      ?>
      <tr>
        <div class="container">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">
                <?php echo $rows['title']; ?>
              </h5>
              <p class="card-text">Issued to :
                <?php echo $rows['name']; ?>
              </p>
              <p class="card-text">Expected return date:
                <?php echo $rows['expectedReturnDate']; ?>
              </p>
            </div>
          </div>
        </div>

      </tr>
      <?php
      }
      ?>
    </table>
    </div>
  </body>

</html>