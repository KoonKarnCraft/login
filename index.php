<?php
    error_reporting(0);
    
    session_start();
    include("php/database.php");

    $result = mysqli_query($conn,"SELECT * FROM user WHERE username='" . $_SESSION["username"] . "'");

    if(!isset($_SESSION["username"])){
        echo"<style>.form--logined { display:none;}</style>";
    }else{
        echo"<style>.form--unlogin { display:none;}</style>";
        echo"<style>.form--logined { display:block;}</style>";
    }

    if(isset($_GET["logout"])){
        echo "<script language='javascript'>alert('คุณออกจากระบบแล้ว');</script>";
        session_destroy();
        unset($_SESSION["username"]);
        echo"<style>.form--unlogin { display:block;}</style>";
        echo"<style>.form--logined { display:none;}</style>";
    }
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
  </head>
  <body>
    <div class="container">
        <form class="form form--unlogin" id="login" method="post" action="/php/login.php" enctype="multipart/form-data">
            <h1 class="form__title">Login</h1>
            <div class="form__message form__message--error"></div>
            <div class="form__input-group">
                <input type="text" class="form__input" onkeydown="return /[a-z0-9_]/i.test(event.key)" minlength="4" maxlength="12" name="username" autofocus placeholder="Username" required>
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" class="form__input" minlength="6" name="password" autofocus placeholder="Password" required>
                <div class="form__input-error-message"></div>
            </div>
            <div class="row">
                <div class="col" >
                  <button class="form__button" type="submit" name="login">Login</button>
                </div>
                <div class="col">
                  <button class="form__button" style="background: #4234ff;" type="button" id="linkCreateAccount">Register</button>
                </div>
            </div>
        </form>
        <form class="form form--hidden" id="createAccount" method="post" action="/php/register.php" enctype="multipart/form-data">
            <h1 class="form__title">Create Account</h1>
            <div class="form__message form__message--error"></div>
            <div class="form__input-group">
                <input type="text" id="signupUsername" class="form__input" onkeydown="return /[a-z0-9_]/i.test(event.key)"  minlength="4" maxlength="12" name="username" autofocus placeholder="Username" required>
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" class="form__input" minlength="6" name="password" autofocus placeholder="Password" id="test" required>
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="text" class="form__input" maxlength="60" name="first_name" autofocus placeholder="First Name" required>
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="text" class="form__input" maxlength="60" name="last_name" autofocus placeholder="Last Name">
                <div class="form__input-error-message"></div>
            </div>

            <p>Profile Image</p>

            <input class="form-control form__input-group" type="file" id="formFile" accept=".jpg, .jpeg, .png, .bmp" name="profile_image" required>
            <button class="form__button" type="submit" name="save">Register</button>
        </form>
        <form class="form form--logined text-center" id="profile">
            <h1 class="form__title">Welcome!!</h1>
            <div style="margin-bottom: 1rem;">
            <?php
                while($row = mysqli_fetch_array($result))
                {
            ?>    
            <img src="image/<?php echo $row["profile_image"];?>" width="200px" height="200px" style="border-radius: 50%;">
            </div>
            <div style="margin-bottom: 1rem; font-size: 30px;">
                <?php 
                    echo "<tr>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td> " . $row['last_name'] . "</td>";
                    echo "</tr>";
                    }
                ?>
            </div>
            <button class="form__button" style="margin-bottom: 1rem;" type="button" id="linkeditProfile">Edit Profile</button>
            <a href="index.php?logout='1'" class="form__button" style="text-decoration: none; background: #ff5151; color: #ffffff;" type="submit">Logout</a>
        </form>
        <form class="form form--hidden" id="editProfile" method="post" action="/php/edit.php" enctype="multipart/form-data">
        <h1 class="form__title">Edit Profile</h1>
            <div class="form__message form__message--error"></div>
            <div class="form__input-group">
                <input type="text" id="signupUsername" class="form__input" onkeydown="return /[a-z0-9_]/i.test(event.key)"  minlength="4" maxlength="12" name="username" autofocus placeholder=<?php echo $_SESSION["username"]; ?> disabled>
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" class="form__input" minlength="6" name="password" autofocus placeholder="Password" id="test" required>
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="text" class="form__input" maxlength="60" name="first_name" autofocus placeholder="First Name" required>
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="text" class="form__input" maxlength="60" name="last_name" autofocus placeholder="Last Name">
                <div class="form__input-error-message"></div>
            </div>

            <p>Profile Image</p>

            <input class="form-control form__input-group" type="file" id="formFile" accept=".jpg, .jpeg, .png, .bmp" name="profile_image" required>
            <button class="form__button" type="submit" name="saveprofile">Confirm</button>
        </form>
    </div>
    <script src="main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>