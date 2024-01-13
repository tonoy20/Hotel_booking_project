<?php

include("server.php");

session_start(); 

if($_SERVER["REQUEST_METHOD"]=="POST")
{
	$username=$_POST["name"];
	$password=md5($_POST["password"]);


	$sql="SELECT * from users WHERE name='".$username."' AND password='".$password."' ";

	$result=mysqli_query($conn, $sql);

	$row=mysqli_fetch_array($result);


	if(($row["userType"]==1) && ($row['name'] == $username) && ($row['name'] !== NULL)) {
		$_SESSION["uname"] = $username;
		$_SESSION["upass"] = $password;
		header("location:admin");
	} else if(($row["userType"]==0) && ($row['name'] == $username) && ($row['name'] !== NULL)) {
		$_SESSION["uid"] = $row['id'];
		$_SESSION["uname"] = $username;
		$_SESSION["upass"] = $password;
		header("location:user");
	} else {
		echo '<script>';
		echo 'alert("Invalid username or password!!");';
		echo 'window.location.href = "index.php";';
		echo '</script>';
	} 
}
?>