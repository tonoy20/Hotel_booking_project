<?php
session_start();
if(($_SESSION["uname"] != "admin")) {
	header("location:../index.php");
}
?>