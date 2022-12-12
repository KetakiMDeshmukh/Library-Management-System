<?php
session_start();
if (isset($_SESSION['user_id']) == "") {
    header("Location: login.php");
}

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = "my_db";
$conn = mysqli_connect($servername, $username, $password, "$dbname");
if (!$conn) {
    die('Could not Connect MySql Server:' . mysql_error());
}
?>

<?php
$id = $_GET["book"];

$sqlDate = "select CURRENT_DATE;";
$resultDate = mysqli_query($conn, $sqlDate);
$row = $resultDate->fetch_assoc();
$date = $row['CURRENT_DATE'];

$sqlDate7 = "select DATE_ADD('$date', INTERVAL 7 DAY) AS DATE;";
$resultDate7 = mysqli_query($conn, $sqlDate7);
$row = $resultDate7->fetch_assoc();
$date2 = $row['DATE'];

$sql1 = "UPDATE `issued` SET `returnDate`='$date' WHERE `uid` = '{$_SESSION['user_id']}' and `bookId` = '$id';";
$sql2 = "UPDATE `books` SET `availability` = availability + 1 WHERE bookId = '$id' and availability < totalQuantity;";

$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);

if ($result1 && $result2) {
    header("Location: dashboard.php");
}
?>