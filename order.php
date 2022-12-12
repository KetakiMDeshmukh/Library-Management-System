<?php
use LDAP\Result;

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

$sql1 = "INSERT INTO `issued`(`uid`, `bookId`, `issueDate`, `expectedReturnDate`) VALUES ('{$_SESSION['user_id']}','$id','$date','$date2');";
$sql2 = "UPDATE `books` SET `availability`= availability - 1 WHERE bookId = '$id' and availability > 0;
";

$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);

if ($result1 && $result2) {
    header("Location: booklist.php");
}
?>