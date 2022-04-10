<!DOCTYPE html>
<html>
<head>
<title>Wiki</title>
</head>
<body>
<style>

#search {
float:right;
}

#welcome, .titlelist {
border: 1px solid;
}



body {
background-color:#E8E8E8;
}



.hb {
background-color:#C0C0C0;
color:black;
padding: 14px 15px;
text-align:center;
text-decoration:none;
display:inline-block
}

.postdiv {
border-style:outset;
border-color:black;
border-width:1px;
background-color:#C8C8C8;
width:600px;
}

</style>


<div id="search">
<form action="index.php" method="get">
<input placeholder="search" name="search"></input>
<input type="submit"></input>
</form>
</div>


<?php



require 'info.php';
$get_title = $_GET["title"];

$conn = new mysqli($db_address, $db_username, $db_password, $db_dbname);
if ($conn->connect_error)
die("Connection failed: " . $conn->connect_error);

function backhome() {
echo "<a href='?'>[Back to home]</a>";
}

if ($get_title == "logout") {
setcookie("username", "", 1);
setcookie("password", "", 1);
header("Location: ?");
}

if ($get_title == NULL) {
$search = $_GET["search"];


if (!$search) {
echo "<div id='welcome'>
<h1>Welcome</h1>
<p>Welcome to the wiki. </p>
<a href='?title=categories'>categories</a><br>
<a href='?title=news'>news</a><br>
<a href='?title=faq'>faq</a><br>
<a href='?title=random'>random page</a><br>";
if (!isset($_COOKIE["username"])) echo "<a href='?title=login'>login</a><br>";
else echo "<a href='?title=logout'>logout</a><br><a href='newpage/index.php'>new page</a>";

echo "<br>
<br>
</div> ";
}

else echo "<p>Search results: </p><br>";


$result = $conn->query("SELECT title, category, creator FROM $db_tablename ORDER by date DESC");

if ($result->num_rows > 0) {
echo "<div class='titlelist'>";
while($row = $result->fetch_assoc()) {
$titlename = $row["title"];
if ($row["category"] == "style" && $row["creator"] != $_COOKIE["username"]) {
array_push($locked_pages, $titlename);
}


if ($search) {
if (stripos($titlename, $search) === FALSE && stripos($row["category"], $search) === FALSE) {
$titlename = NULL;
}
}
if (!in_array($titlename, $locked_pages))
if ($titlename)
echo "<a href=?title=$titlename>$titlename</a><br>";
}
echo "<br></div>";
}
if ($search) backhome();
$result->close();
}



if ($get_title) {

if ($get_title == "random") {
$res = $conn->query("SELECT title FROM $db_tablename order by RAND() LIMIT 1");
$row = $res->fetch_assoc();
$get_title = $row["title"];
$res->close();
}


if ($get_title == "categories") {
$res = $conn->query("SELECT category, date FROM $db_tablename order by date");
while($row = $res->fetch_assoc()) {
$categoryname = $row["category"];
echo "<a href=?search=$categoryname>$categoryname</a><br>";
}
$res->close();
}



$res = $conn->query("SELECT * FROM $db_tablename WHERE title='$get_title' ");
if ($res->num_rows == 1) {
$row = $res->fetch_assoc();
$post = $row["post"];

$date = $row["date"];
$category = $row["category"];

/*
$post = htmlspecialchars($post, ENT_NOQUOTES);
$post = str_replace($post[0], " ".$post[0], $post);
if (($tagpos = preg_match("/\[([a-z]|h\d)/i", $post)) !== FALSE) {
$post = substr($post, 0, $tagpos).str_replace("[", "<", substr($post, $tagpos));
$post = substr($post, 0, $tagpos).str_replace("]", ">", substr($post, $tagpos));
}
*/


echo "<h1>" . $row["title"] . "</h1><p>$post</p>";

$res->close();
}
elseif ($res->num_rows >= 2) {
while($row = $res->fetch_assoc()) {
$titlename = $row["title"];
echo "<a href=$titlename>$titlename</a><br>";
}
}

backhome();
foreach ($locked_pages as $locked_page) {
if ($get_title == $locked_page) $locked=1;
}
if (!$locked)
echo " <a href='newpage/index.php?title=$get_title&category=$category'>[edit]</a><br><br><i>$date</i>";
}
$conn->close();

?>

</body>
</html>
				
