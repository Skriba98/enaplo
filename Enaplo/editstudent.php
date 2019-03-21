<?php
/**
 * Created by PhpStorm.
 * User: Skriba
 * Date: 2019. 03. 17.
 * Time: 17:38
 */
include "config.php";
$UserId = $_GET["id"];
$MySQL_connect = mysqli_connect($MySQL_host, $MySQL_username, $MySQL_password, $MySQL_database) or die("MySQL kapcsolódási hiba: " . mysqli_connect_error());

//Módosítás
$InputOM = $_POST["InputOM"];
$InputEmail = $_POST["InputEmail"];
$InputPassword1 = $_POST["InputPassword1"];
$InputPassword2 = $_POST["InputPassword2"];
$InputSurname = $_POST["InputSurname"];
$InputLastname = $_POST["InputLastname"];
$InputBirthdate = $_POST["InputBirthdate"];
$InputClass1 = $_POST["InputClass1"];
$InputClass2 = $_POST["InputClass2"];
$InputClass = $_POST["InputClass1"] . "/" . $_POST["InputClass2"];
$isSend = $_POST["isSend"];
$message = "";
if ($isSend) {
    mysqli_query($MySQL_connect, "UPDATE users SET OM = '".$InputOM."', Class = '".$InputClass."', Email = '".$InputEmail."', Surname = '".$InputSurname."', Lastname = '".$InputLastname."', Birthdate = '".$InputBirthdate."'  WHERE Id = '".$UserId."'");
    $message = "Sikeres módosítás";
}

//Lekérdezés
$DBuserData = mysqli_query($MySQL_connect,"SELECT * FROM users WHERE Id='".$UserId."'");
$userdata = mysqli_fetch_array($DBuserData);
$user_OM = $userdata["OM"];
$user_Email  = $userdata["Email"];
$user_Surname = $userdata["Surname"];
$user_Lastname = $userdata["Lastname"];
$user_Birthdate = $userdata["Birthdate"];
$user_Class = $userdata["Class"];
$user_Class2 = substr($user_Class, -1, 1);
$user_Class1 = substr($user_Class, -4, 2);
$user_Class1 = str_replace("/","",$user_Class1);

//Törlés
$isDelete = $_GET["delete"];
if ($isDelete == "true") {
    mysqli_query($MySQL_connect, "DELETE FROM marks WHERE User_id = '".$UserId."'");
    mysqli_query($MySQL_connect, "DELETE FROM users WHERE Id = '".$UserId."'");
    header('Location: students.php');
}

?>
<html>
<head>
    <link href="main.css?V=<?php echo rand();?>" type="text/css" rel="stylesheet"/>
    <meta charset="UTF-8">
    <title>Tanulók</title>
</head>

<body>
<div class="navbar">
    <a class="nav" href="">Főoldal</a>
    <a class="nav" href="students.php">Tanulók</a>
    <a class="nav" href="subjects.php">Tantárgyak</a>
    <a class="nav" href="marks.php">Osztályzatok</a>
</div>
<div class="main_panel_container">
    <h1>Tanuló adatainak módosítása</h1>
    <?php if($message != '') echo '<span class="ModifyMessage"> '.$message.' </span>'; ?>
<form action="" method="post">
    <table border="0" width="100%">
        <tr>
            <td width="120px">
                <label for="InputOM" class="edit_student_font">OM azonosító: </label>
            </td>
            <td>
                <input class="input_data" title="OM azonosító" name="InputOM" id="InputOM" type="text" maxlength="11" minlength="11" value="<?php echo $user_OM; ?>" required="required"/>
            </td>
        </tr>
        <tr>
            <td>
                <label for="InputEmail" class="edit_student_font">Email-cím:</label>
            </td>
            <td>
                <input class="input_data" title="E-mail" name="InputEmail" id="InputEmail" type="text" value="<?php echo $user_Email; ?>" required="required"/>
            </td>
        </tr>
        <tr>
            <td>
                <label for="input_surname" class="edit_student_font">Vezetéknév:</label>
            </td>
            <td>
                <input class="input_data" title="Vezetéknév" name="InputSurname" id="InputSurname" type="text" value="<?php echo $user_Surname; ?>" required="required"/>
            </td>
        </tr>
        <tr>
            <td>
                <label for="InputLastname" class="edit_student_font">Keresztnév:</label>
            </td>
            <td>
                <input class="input_data" title="Keresztnév" name="InputLastname" id="InputLastname" type="text" value="<?php echo $user_Lastname; ?>" required="required"/>
            </td>
        </tr>
        <tr>
            <td>
                <label for="InputBirthdate" class="edit_student_font">Születési dátum:</label>
            </td>
            <td>
                <input class="input_data" title="Születési dátum" name="InputBirthdate" id="InputBirthdate" type="date" value="<?php echo $user_Birthdate; ?>" required="required"/>
            </td>
        </tr>
        <tr>
            <td>
                <label for="InputClass" class="edit_student_font">Osztály:</label>
            </td>
            <td>
                <select class="input_data" title="Osztály" name="InputClass1" id="InputClass1">
                    <option <?php if ($user_Class1 == 9) echo 'selected="selected"'?>>9</option>
                    <option <?php if ($user_Class1 == 10) echo 'selected="selected"'?>>10</option>
                    <option <?php if ($user_Class1 == 11) echo 'selected="selected"'?>>11</option>
                    <option <?php if ($user_Class1 == 12) echo 'selected="selected"'?>>12</option>
                </select>
                <select class="input_data" title="Osztály" name="InputClass2" id="InputClass2">
                    <option <?php if ($user_Class2 == 'A') echo 'selected="selected"'?>>A</option>
                    <option <?php if ($user_Class2 == 'B') echo 'selected="selected"'?>>B</option>
                    <option <?php if ($user_Class2 == 'C') echo 'selected="selected"'?>>C</option>
                    <option <?php if ($user_Class2 == 'D') echo 'selected="selected"'?>>D</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <br/>
                <input type="hidden" name="isSend" value="true"/>

                <input type="submit" Value="Mentés" id="RegisterSubmit"/>
            </td>
        </tr>
    </table>
</form>
</div>
</body>
</html>
