<?php
session_start();
if ((!isset($_SESSION['user_id'])) && (!isset($_SESSION['admin_id']))) {
  header("Location: login.php");
  exit();
}

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = "my_db";
$conn = mysqli_connect($servername, $username, $password, "$dbname");
if (!$conn) {
  die('Could not Connect MySql Server:' . mysql_error());
}

$sqlDate = "select CURRENT_DATE;";
$resultDate = mysqli_query($conn, $sqlDate);
$row = $resultDate->fetch_assoc();
$date = $row['CURRENT_DATE'];

// SELECT bookId, title, author, genre FROM books WHERE `availability` != 0 AND bookId not in ( SELECT issued.bookId from issued where issued.uid = 1 and (issued.returnDate is NULL OR issued.issueDate = "22/12/12") );

$sql = "SELECT bookId, title, author, genre FROM books WHERE `availability` != 0 AND bookId not in ( SELECT issued.bookId from issued where issued.uid = '{$_SESSION['user_id']}' and (issued.returnDate is NULL OR issued.issueDate = '$date' )) ;";
$result = mysqli_query($conn, $sql)

  ?>

<html>

  <head>

    <meta charset="utf-8">
    <title>Book List</title>
    <link rel="stylesheet" type="text/css" href="user.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
    <div id="wrapper">
      <div id="header">
        <br>

        <div id="dropdown">
          <ul id="drop-nav" style="font-family:Arial;">

            <li><a href="dashboard.php">HOME</a></li>

            <li><a href="booklist.php">VIEW BOOKS</a></li>

            <li><a href="logout.php">LOGOUT</a></li>

          </ul>

        </div>
      </div>
    </div>

    <table style="color: #4a473e;">

      <?php
      while ($rows = $result->fetch_assoc()) {
        $bookId = $rows['bookId'];
      ?>
      <tr>
        <div class="container">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">
                <?php echo $rows['title']; ?>
              </h5>
              <p class="card-text">Author:
                <?php echo $rows['author']; ?>
              </p>
              <p class="card-text">Genre:
                <?php echo $rows['genre']; ?>
              </p>
              <a href="order.php?book=<?php echo $bookId; ?>" class="btn btn-primary">Order Now</a>
            </div>

          </div>

      </tr>
      <?php
      }
      ?>
    </table>

    </div>

    </div>
  </body>

</html>