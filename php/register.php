<?php
    include("database.php");
    $sql=mysqli_query($conn,"SELECT * FROM user where username ='".$_POST["username"]."'");

    $profile_image = $_POST["save"];

    $filename = $_FILES["profile_image"]["name"];
    $tempname = $_FILES["profile_image"]["tmp_name"];
    
    $extension = pathinfo($filename,PATHINFO_EXTENSION);
    $randomno = rand(0,100000);
    $rename = 'IMG-'.date('Ymd').$randomno;
    $newname = $rename.'.'.$extension;

    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $password = md5($password);

    $chpassword = $_POST['password'];
    $number = preg_match('@[0-9]@', $chpassword);
    $uppercase = preg_match('@[A-Z]@', $chpassword);
    $lowercase = preg_match('@[a-z]@', $chpassword);
    $specialChars = preg_match('@[^\w]@', $chpassword);

    if (isset($_POST['save'])) {
        if(mysqli_num_rows($sql)>=1){
            echo "<script language='javascript'>alert('Username นี้มีคนใช้แล้ว!');</script>";
            echo("<script>window.location = '../index.php';</script>");
        }else{
            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($chpassword) < 6){
                echo "<script language='javascript'>alert('1.รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร\\n2.รหัสผ่านต้องมี A-Z อย่างน้อย 1 ตัวอักษร\\n3.รหัสผ่านต้องมี a-z อย่างน้อย 1 ตัวอักษร\\n4.รหัสผ่านต้องมี 0-9 อย่างน้อย 1 ตัวอักษร\\n5.รหัสผ่านต้องมีอักษรพิเศษอย่างน้อย 1 ตัวอักษร');</script>";
                echo("<script>window.location = '../index.php';</script>");
            }else{
                $query = "INSERT INTO user(username, password, first_name, last_name, profile_image ) VALUES('".$_POST["username"]."', '$password', '".$_POST["first_name"]."', '".$_POST["last_name"]."', '$newname')";
                $sql=mysqli_query($conn,$query);
                $passlog = "INSERT INTO pass_log(username, password) VALUES('".$_POST["username"]."', '$password')";
                $sqlplog=mysqli_query($conn,$passlog);
                move_uploaded_file($tempname, '../image/'.$newname);
                echo "<script language='javascript'>alert('บันทึกข้อมูลเรียบร้อยแล้ว...');</script>";
                echo("<script>window.location = '../index.php';</script>");
            }
        }
    }
?>