<?php
/**
 * Created by PhpStorm.
 * User: Skriba
 * Date: 2019. 03. 04.
 * Time: 20:16
 */
//Felhasználó regisztrálása
$is_error = false;
$err_msg = '';
$InputOM = $_POST["InputOM"];
$Input_Email = $_POST["InputEmail"];
$InputPassword1 = $_POST["InputPassword1"];
$InputPassword2 = $_POST["InputPassword2"];
$InputSurname = $_POST["InputSurname"];
$InputLastname = $_POST["InputLastname"];
$InputBirthdate = $_POST["InputBirthdate"];
$InputClass1 = $_POST["InputClass1"];
$InputClass2 = $_POST["InputClass2"];
$SendReg = $_POST["SendReg"];
$InputClass = $InputClass1 . '/' . $InputClass2;
echo $InputClass;
//mysql beállítása
include "config.php";
$MySQL_connect = mysqli_connect($MySQL_host, $MySQL_username, $MySQL_password, $MySQL_database) or die("MySQL kapcsolódási hiba: " . mysqli_connect_error());

//Felhasználónév ellenőrzése

$used = mysqli_query($MySQL_connect,"SELECT count(*) as used FROM users WHERE OM='".$InputOM."'");
$used = mysqli_fetch_array($used);
$used = $used["used"];

if ($used != 0) {
    $is_error = true;
    $err_msg .= "Ezzel az OM azonosítóval már regisztráltak!</br>";
}

if ($InputPassword1 != $InputPassword2) {
    $is_error = true;
    $err_msg .= "A jelszavak nem egyeznek </br>";
}

if ($InputPassword1 == null || $InputPassword2 == null || $InputOM == null || $Input_Email == null || $InputSurname == null || $InputLastname == null || $InputClass1 == null || $InputClass2 == null || $InputBirthdate == null ) {
    $is_error = true;
    $err_msg .= "Minden mezőt ki kell tölteni! </br>";
}

if ($is_error == false) {
    $ShaPassword = sha1($InputPassword1);
    mysqli_query($MySQL_connect, "INSERT INTO users (OM, Password,  Email, Surname, Lastname, Birthdate, Class) VALUES ('".$InputOM."', '".$ShaPassword."', '".$Input_Email."', '".$InputSurname."', '".$InputLastname."', '".$InputBirthdate."', '".$InputClass."')");
    echo mysqli_error($MySQL_connect);
    header("Location: login.php");
}
if (!$SendReg)
$err_msg = null;

?>

<html>
<head>
    <link href="main.css?V=<?php echo rand();?>" type="text/css" rel="stylesheet"/>
</head>
<body>
<div class="navbar">
    <a class="nav" href="">Főoldal</a>
    <a class="nav" href="students.php">Tanulók</a>
    <a class="nav" href="subjects.php">Tantárgyak</a>
    <a class="nav" href="marks.php">Osztályzatok</a>
</div>
<div class="main_panel_container">
<div id="register_panel">
    <h2>Regisztráció</h2>
    <span style="color: red;"><?php echo $err_msg ?></span>
<form action="" method="post">
    <table border="0" width="100%">
        <tr>
            <td width="120px">
    <label for="InputOM">OM azonosító: </label>
            </td>
            <td>
    <input class="input_data" title="OM azonosító" name="InputOM" id="InputOM" type="text" maxlength="11" minlength="11"/>
            </td>
        </tr>
        <tr>
            <td>
                <label for="InputEmail">Email-cím:</label>
            </td>
            <td>
                <input class="input_data" title="E-mail" name="InputEmail" id="InputEmail" type="text"/>
            </td>
        </tr>
        <tr>
            <td>
                <label for="input_surname">Vezetéknév:</label>
            </td>
            <td>
                <input class="input_data" title="Vezetéknév" name="InputSurname" id="InputSurname" type="text"/>
            </td>
        </tr>
        <tr>
            <td>
                <label for="InputLastname">Keresztnév:</label>
            </td>
            <td>
                <input class="input_data" title="Keresztnév" name="InputLastname" id="InputLastname" type="text"/>
            </td>
        </tr>
        <tr>
            <td>
                <label for="InputBirthdate">Születési dátum:</label>
            </td>
            <td>
                <input class="input_data" title="Születési dátum" name="InputBirthdate" id="InputBirthdate" type="date"/>
            </td>
        </tr>
        <tr>
            <td>
    <label for="InputClass">Osztály:</label>
            </td>
            <td>
                <select class="input_data" title="Osztály" name="InputClass1" id="InputClass1">
                    <option>9</option>
                    <option>10</option>
                    <option>11</option>
                    <option>12</option>
                </select>
                <select class="input_data" title="Osztály" name="InputClass2" id="InputClass2" type="text">
                    <option>A</option>
                    <option>B</option>
                    <option>C</option>
                    <option>D</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="InputPassword1">Jelszó:</label>
            </td>

            <td>
                <input class="input_data" title="Jelszó" name="InputPassword1" id="InputPassword1" type="password" minlength="3"/>
            </td>
        </tr>
        <tr>
            <td>
                <label for="InputPassword1">Jelszó újra:</label>
            </td>
            <td>
                <input class="input_data" title="Jelszó újra" name="InputPassword2" id="InputPassword2" type="password" minlength="3"/>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
            <br/>
                <input type="hidden" name="SendReg" value="true"/>

                <input type="submit" id="RegisterSubmit"/>
            </td>
        </tr>
    </table>
</form>
</div>
</div>
</body>

</html>