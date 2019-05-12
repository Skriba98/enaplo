<?php
/**
 * Created by PhpStorm.
 * User: Skriba
 * Date: 2019. 03. 16.
 * Time: 19:03
 */


$is_error = 0;
$err_msg = '';
$SendReg = $_POST["SendReg"];

//mysql beállítása
include "config.php";
$MySQL_connect = mysqli_connect($MySQL_host, $MySQL_username, $MySQL_password, $MySQL_database) or die("MySQL kapcsolódási hiba: " . mysqli_connect_error());

$InputUserName = mysqli_real_escape_string($MySQL_connect,$_POST["input_username"]);
$InputPassword = mysqli_real_escape_string($MySQL_connect,$_POST["input_password"]);

//Felhasználónév ellenőrzése

$userData = mysqli_query($MySQL_connect,"SELECT OM, Password, Id FROM users WHERE OM='".$InputUserName."'");
$userData = mysqli_fetch_array($userData);
$username = $userData["OM"];
$password = $userData["Password"];
$userid = $userData["Id"];

if($username == null) {
    $is_error = 1;
    $err_msg = 'Nincs ilyen OM azonosító';
}
else {
    if ($password != sha1($InputPassword)) {
        $is_error = 1;
        $err_msg = 'Hibás jelszó';
    }
}

if($is_error == 0) {
    session_start();
    $_SESSION["username"] = $username;
    $_SESSION["userid"] = $userid;
    header("Location: user.php");
}

if (!$SendReg)
    $err_msg = null;
?>

<html>
<head>
    <link href="main.css?V=<?php echo rand();?>" type="text/css" rel="stylesheet"/>
</head>
<body>
<div id="login_panel">
    <h1>Bejelentkezés</h1>
    <span style="color: red;"><?php echo $err_msg ?></span>
<form action="login.php" method="post">

            <label for="username" class="login_font">OM azonosító:</label>
<br/>
    <input class="input_data" type="text" name="input_username" id="LoginUser" title="Felhasználónév"/>
    <br/>
            <label for="password" class="login_font">Jelszó:</label>
    <br/>
            <input class="input_data" type="password" id="LoginPass" name="input_password" title="Jelszó"/>
    <br/>
    <a href="forgot.php" id="ForgotLabel">Elfelejtettem a jelszavamat</a>
<br/><br/><br/><br/><br/>
    <input type="submit" id="LoginSubmit"/>
    <input type="hidden" name="SendReg" value="true"/>
</form>

</div>
</body>
</html>
