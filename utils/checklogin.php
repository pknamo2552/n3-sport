<?php
	session_start();
	include 'connect.php';

	$strSQL = "SELECT * FROM member WHERE username = '".mysqli_real_escape_string($conn,$_POST['username'])."' 
	and password = '".mysqli_real_escape_string($conn,$_POST['password'])."'";
	$objQuery = mysqli_query($conn,$strSQL);
	$objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
	if(!$objResult)
	{
			echo "Username and Password Incorrect!";
			header("location:login.php");
	}
	else
	{
			$_SESSION["id"] = $objResult["id"];
			$_SESSION["name"] = $objResult["name"];
            $_SESSION["username"] = $objResult["username"];
            $_SESSION["password"] = $objResult["password"];
            $_SESSION["phone"] = $objResult["phone"];
			 $_SESSION["email"] = $objResult["email"];
            $_SESSION["status"] = $objResult["status"];

			session_write_close();
			
			if($objResult["status"] == "admin")
			{
				header("location:admin.php");
			}
			else
			{
				header("location:profile.php");
			}
	}
	mysqli_close($conn);
?>