<?php

require("info.php");
$username = $_POST["username"];
$password = $_POST["password"];

if (!isset($username) || !isset($password)) die("Fill out the fields!");

$conn = new mysqli($db_address, $db_username, $db_password, $db_dbname);
$result = $conn->query("SELECT * FROM $db_logintablename WHERE username='$username'");
if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
$joindate = $row["joined"];
if ($row["username"] == $username && $row["password"] == $password) {
$result->close();
setcookie("username", $username);
setcookie("password", $password);

/*$currentdate = date("Y-m-d h:i:sa");
$result = $conn->query("SELECT DATEDIFF(month, $joindate, $currentdate)");
if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
var_dump($row);
}*/

header("Location: ../index.php");

}
}

$conn->close();

die("Error logging in!");



?>
