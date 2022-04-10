<!DOCTYPE html>
<html>
<head>
<title>New page</title>
</head>
<body>
<?php
require '../info.php';


$conn = new mysqli($db_address, $db_username, $db_password, $db_dbname);

$gettitle = $_GET["title"];
if ($gettitle) {
$result = $conn->query("SELECT post FROM $db_tablename WHERE title='$gettitle'");
if ($result->num_rows <= 0) die("error");
$row = $result->fetch_assoc();
$oldpost = $row["post"];

if (($tagpos = preg_match("/\<([a-z]|h\d|br)/i", $oldpost)) !== FALSE) {
$oldpost = substr($oldpost, 0, $tagpos).str_replace("<", "[", substr($oldpost, $tagpos));
$oldpost = substr($oldpost, 0, $tagpos).str_replace(">", "]", substr($oldpost, $tagpos));
}
$oldpost = str_replace(">", "]", $oldpost);




}





?>
<form action="?" method="post">
<input type="text" name="title" placeholder="title" required value=<?php echo $_GET["title"]; ?> ></input><br>
<input type="text" name="category" placeholder="category" value=<?php echo $_GET["category"]?> ></input><br>
<textarea rows="32" cols="200" name="post" required >
<?php echo $oldpost;?>
</textarea><br>
<input type="submit"></input>
</form>

<style>
body {
background-color:#E8E8E8;
}
</style>

<?php

if (!$_COOKIE["username"]) die("You must be <a href='../index.php?title=login'>logged in!</a><br><a href='../index.php'>[Back to home]</a>");

$date = date("Y-m-d h:i:sa");
$post = $_POST["post"];
$category = $_POST["category"];
$title = $_POST["title"];
$title = str_replace(" ", "_", $title);
$creator = $_COOKIE["username"];
$password = $_COOKIE["password"];


if ($post) {

$post = htmlspecialchars($post, ENT_NOQUOTES);
if ($post[0] != ' ') $post = str_replace($post[0], " ".$post[0], $post);
if (($tagpos = preg_match("/\[([a-z]|h\d)/i", $post)) !== FALSE) {
$post = substr($post, 0, $tagpos).str_replace("[", "<", substr($post, $tagpos));
$post = substr($post, 0, $tagpos).str_replace("]", ">", substr($post, $tagpos));
}






$result = $conn->query("SELECT * FROM $db_logintablename WHERE username='$creator'");
if ($result->num_rows <= 0) die("Username not found");
$row = $result->fetch_assoc();
if ($password != $row["password"]) die("Invalid login!");

$result = $conn->query("SELECT * FROM $db_tablename WHERE title='$title'");
if ($result->num_rows > 0) {
//die("There is already a title with the same name <a href='../index.php?title=$title'>here</a>");


$oldpost = 1;
foreach ($locked_pages as $locked_page) {
if ($title == $locked_page) unset($oldpost);
}

}
$result->close();

$post = $conn->real_escape_string($post);

if ($oldpost) {

/*
if (($tagpos = preg_match("/\<([a-z]|h\d)/i", $post)) !== FALSE) {
$post = substr($post, 0, $tagpos).str_replace("<", "[", substr($post, $tagpos));
$post = substr($post, 0, $tagpos).str_replace(">", "]", substr($post, $tagpos));
}*/




$res = $conn->query("UPDATE $db_tablename SET post='$post' WHERE title='$title'");
$res2 = $conn->query("UPDATE $db_tablename SET date='$date' WHERE title='$title'");

}
else $res = $conn->query("INSERT INTO $db_tablename (date, title, creator, category, post) VALUES ('$date', '$title', '$creator', '$category', '$post')");
if ($res === TRUE) header("Location: ../index.php?title=$title");
echo $conn->error;
//else header("Location: ../index.php");


$conn->close();
}
?>
<br><a href="../index.php">[Back to home]</a>
</body>
</html>	
