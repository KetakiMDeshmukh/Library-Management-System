<?php
session_start();

require 'user_nav.php';
if (isset($_SESSION['user_id']) == "") {
  header("Location: login.php");
}

// if (isset($_SESSION['bookId']) != "") {
//   header("Location: login.php");
// }

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = "my_db";
$conn = mysqli_connect($servername, $username, $password, "$dbname");
if (!$conn) {
  die('Could not Connect MySql Server:' . mysql_error());
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>Library - Dashboard</title>
    <link rel="stylesheet" type="text/css" href="user.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

  </head>

  <body>
    <table style="color: #4a473e;">

      <?php
      $sql = " select issued.bookId, books.title, issued.issueDate, issued.expectedReturnDate from issued inner join books on issued.bookId = books.bookId where issued.uid = '{$_SESSION['user_id']}' and issued.returnDate is null order by issued.expectedReturnDate";
      $result = mysqli_query($conn, $sql);

      while (($rows = $result->fetch_assoc())) {
        $bookId = $rows['bookId'];
      ?>

      <tr>
        <div class="container">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">
                <?php echo $rows['title']; ?>
              </h5>
              <p class="card-text">Expected return date:
                <?php echo $rows['expectedReturnDate']; ?>
              </p>

              <a href="cancel.php?book=<?php echo $bookId; ?>" class="btn btn-primary">Return Now</a>

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