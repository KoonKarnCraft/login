<?php
    $url='localhost';
    $username='admin';
    $password='123456';
    $conn=mysqli_connect($url,$username,$password,"userdata");
    if(!$conn){
        die('Could not Connect My Sql:' .mysql_error());
    }
?>