<?php
session_start();
unset($_SESSION["email"]);
$url = "../Admin/index.php";
if(isset($_GET["session_expired"])) {
	$url .= "?session_expired=" . $_GET["session_expired"];
}
header("Location:$url");

?>
