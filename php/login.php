<?php
session_start();
if(isset($_POST['login']))
{
    extract($_POST);
    include("database.php");
	
	$username = $_POST["username"];
	$password = mysqli_real_escape_string($conn, $_POST["password"]);
	$password = md5($password);

    $sql=mysqli_query($conn,"SELECT * FROM user where username='$username' and password='$password'");
    $row  = mysqli_fetch_array($sql);
    if(is_array($row))
    {
        $_SESSION["username"] = $row['username'];
        $_SESSION["password"]=$row['password'];
        $_SESSION["first_name"]=$row['first_name'];
        $_SESSION["last_name"]=$row['last_name'];
		$_SESSION["profile_image"]=$row['profile_image'];
        echo("<script>window.location = '../index.php';</script>");
    }
    else
    {
        echo "<script language='javascript'>alert('Username หรือรหัสผ่านไม่ถูกต้อง');</script>";
		echo("<script>window.location = '../index.php';</script>");
    }
}
?>