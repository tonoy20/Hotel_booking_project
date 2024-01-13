<?php

$host="localhost";
$user="root";
$password="";
$email="";
$username ="";
$db="hotelbooking";


$conn=mysqli_connect($host,$user,$password,$db);

if($conn===false)
{
	die("connection error");
}


define("UPLOAD_SRC",$_SERVER['DOCUMENT_ROOT']."/HotelbookingProject/uploads/");

define("MULTIPLE_IMG",$_SERVER['DOCUMENT_ROOT']."/HotelbookingProject/uploads/room_gallery/");

define("FETCH_SRC","http://127.0.0.1/HotelbookingProject/uploads/");

define("FETCH_MULTIPLE","http://127.0.0.1/HotelbookingProject/uploads/room_gallery/");

?>