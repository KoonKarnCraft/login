<?php
    session_start();
    include("database.php");

    $profile_image = $_POST["saveprofile"];

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

    $cklogpass = mysqli_query($conn,"SELECT password FROM pass_log where username ='".$_SESSION["username"]."' order by no desc limit 5");

    while($row = mysqli_fetch_array($cklogpass)){
        $json[] = $row["password"];
    }

    //echo json_encode($json);

    if (isset($_POST['saveprofile'])) {
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($chpassword) < 6){
            echo "<script language='javascript'>alert('1.รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร\\n2.รหัสผ่านต้องมี A-Z อย่างน้อย 1 ตัวอักษร\\n3.รหัสผ่านต้องมี a-z อย่างน้อย 1 ตัวอักษร\\n4.รหัสผ่านต้องมี 0-9 อย่างน้อย 1 ตัวอักษร\\n5.รหัสผ่านต้องมีอักษรพิเศษอย่างน้อย 1 ตัวอักษร');</script>";
            echo("<script>window.location = '../index.php';</script>");
        }else{
            if($json == ''){
                $query = "UPDATE user set password='$password', first_name='" . $_POST['first_name'] . "', last_name='" . $_POST['last_name'] . "', profile_image='$newname' WHERE username='" . $_SESSION["username"] . "'";
                $sql=mysqli_query($conn,$query);

                $passlog = "INSERT INTO pass_log(username, password) VALUES('".$_SESSION["username"]."', '$password')";
                $sqlplog=mysqli_query($conn,$passlog);
                move_uploaded_file($tempname, '../image/'.$newname);
                echo "<script language='javascript'>alert('บันทึกข้อมูลเรียบร้อยแล้ว...');</script>";
                echo("<script>window.location = '../index.php';</script>");
            }else{
                if(in_array($password, $json)){
                    echo "<script language='javascript'>alert('รหัสผ่านนี้เป็นรหัสผ่านเก่า กรุณาใช้รหัสผ่านที่ไม่เหมือนรหัสเก่า');</script>";
                    echo("<script>window.location = '../index.php';</script>");
                }else{
                    $query = "UPDATE user set password='$password', first_name='" . $_POST['first_name'] . "', last_name='" . $_POST['last_name'] . "', profile_image='$newname' WHERE username='" . $_SESSION["username"] . "'";
                    $sql=mysqli_query($conn,$query);
    
                    $passlog = "INSERT INTO pass_log(username, password) VALUES('".$_SESSION["username"]."', '$password')";
                    $sqlplog=mysqli_query($conn,$passlog);
                    move_uploaded_file($tempname, '../image/'.$newname);
                    echo "<script language='javascript'>alert('บันทึกข้อมูลเรียบร้อยแล้ว...');</script>";
                    echo("<script>window.location = '../index.php';</script>");
                }
            }
        }
    }
?>