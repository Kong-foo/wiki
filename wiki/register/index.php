<?php
require("../info.php");
$username = $_POST["username"];
$password = $_POST["password"];
$joindate = date("Y-m-d h:i:sa");

if (!isset($username) || !isset($password)) die("All fields are not full");

$conn = new mysqli($db_address, $db_username, $db_password, $db_dbname);
$result = $conn->query("INSERT INTO $db_logintablename (username, password, joined) VALUES ('$username', '$password', '$joindate')");
if ($result === TRUE) {
setcookie("username", $username, time()+86400*30, "/");
setcookie("password", $password, time()+86400*30, "/");

header("Location: ../../index.php");
}
else echo "Username already in Use!<br><a href='../?'>[Back to home]</a>";

$conn->close();


?>
