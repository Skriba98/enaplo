<?php
/**
 * Created by PhpStorm.
 * User: Skriba
 * Date: 2019. 03. 17.
 * Time: 15:45
 */
include "config.php";
$MySQL_connect = mysqli_connect($MySQL_host, $MySQL_username, $MySQL_password, $MySQL_database) or die("MySQL kapcsolódási hiba: " . mysqli_connect_error());

//Felhasználó felvétele
$InputOM = $_POST["InputOM"];
$Input_Email = $_POST["InputEmail"];
$InputPassword1 = $_POST["InputPassword1"];
$InputPassword2 = $_POST["InputPassword2"];
$InputSurname = $_POST["InputSurname"];
$InputLastname = $_POST["InputLastname"];
$InputBirthdate = $_POST["InputBirthdate"];
$InputClass1 = $_POST["InputClass1"];
$InputClass2 = $_POST["InputClass2"];
$isSend = $_POST["isSend"];
$InputClass = $InputClass1 . '/' . $InputClass2;
$ShaPassword = sha1("valami");
$err_msg = "";
$used = 0;
if ($isSend) {
    $used = mysqli_query($MySQL_connect,"SELECT count(*) as used FROM users WHERE OM='".$InputOM."'");
    $used = mysqli_fetch_array($used);
    $used = $used["used"];
}

if ($used != 0)
    $err_msg = "Létező OM azonosító!";

if ($isSend && $used == 0) {
    mysqli_query($MySQL_connect, "INSERT INTO users (OM, Password,  Email, Surname, Lastname, Birthdate, Class) VALUES ('" . $InputOM . "', '" . $ShaPassword . "', '" . $Input_Email . "', '" . $InputSurname . "', '" . $InputLastname . "', '" . $InputBirthdate . "', '" . $InputClass . "')");
    echo mysqli_error($MySQL_connect);
}

//Lekérdezés
$isSearch = $_POST["isSearch"];
$search = $_POST["search"];
if ($isSearch) {
    $DBuserData = mysqli_query($MySQL_connect, "SELECT * FROM users WHERE CONCAT(Surname, ' ', Lastname) LIKE '%".($search)."%'");
}
else {
    $DBuserData = mysqli_query($MySQL_connect, "SELECT * FROM users");
}
?>

<html>
<head>
    <title>Tanulók</title>
    <link href="main.css?V=<?php echo rand();?>" type="text/css" rel="stylesheet"/>
    <meta charset="UTF-8">
</head>
<body>
<div class="navbar">
    <a class="nav" href="">Főoldal</a>
    <a class="nav" href="students.php">Tanulók</a>
    <a class="nav" href="subjects.php">Tantárgyak</a>
    <a class="nav" href="marks.php">Osztályzatok</a>
</div>
<div class="main_panel_container">
    <h1>Tanulók</h1>
<div id="searchBox">
    <form action="" method="post">
        <label for="search">Keresés név alapján: </label>
        <input type="text" title="Keresés" name="search" class="input_search"/>
        <input type="hidden" name="isSearch" value="true"/>
        <input type="submit" style="border-radius: 4px;" value="Keresés"/>
    </form>
</div>
<table class="main_table">
    <thead class="table_header">
    <tr>
        <th>Vezetéknév</th>
        <th>Keresztnév</th>
        <th>OM azonosító</th>
        <th>E-mail cím</th>
        <th>Születési dátum</th>
        <th>Osztály</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($userData = mysqli_fetch_array($DBuserData)) {
        echo "<tr>";
        echo "<td>";
        echo $userData["Surname"];
        echo "</td>";
        echo "<td>";
        echo $userData["Lastname"];
        echo "</td>";
        echo "<td>";
        echo $userData["OM"];
        echo "</td>";
        echo "<td>";
        echo $userData["Email"];
        echo "</td>";
        echo "<td>";
        echo $userData["Birthdate"];
        echo "</td>";
        echo "<td>";
        echo $userData["Class"];
        echo "</td>";
        echo "<td align='center'>";
        $userID = $userData["Id"];
        echo "<button class='editButton' onclick=\"location.href='editstudent.php?id=$userID'\">Szerkesztés</button>";
        echo "</td>";
        echo "<td align='center'>";
        echo "<button class='deleteButton' onclick=\"location.href='editstudent.php?id=$userID&delete=true'\">Törlés</button>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
    <br/>
    <div class="inputDiv">
        <h1>Tanuló felvétele</h1>
        <span class=""><?php echo $err_msg; ?></span>
    <form action="" method="post">
        <table border="0" width="100%">
            <tr>
                <td width="120px">
                    <label for="InputOM">OM azonosító: </label>
                </td>
                <td>
                    <input class="input_data" title="OM azonosító" name="InputOM" id="InputOM" type="text" maxlength="11" minlength="11" required="required"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="InputEmail">Email-cím:</label>
                </td>
                <td>
                    <input class="input_data" title="E-mail" name="InputEmail" id="InputEmail" type="text" required="required"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="input_surname">Vezetéknév:</label>
                </td>
                <td>
                    <input class="input_data" title="Vezetéknév" name="InputSurname" id="InputSurname" type="text" required="required"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="InputLastname">Keresztnév:</label>
                </td>
                <td>
                    <input class="input_data" title="Keresztnév" name="InputLastname" id="InputLastname" type="text" required="required"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="InputBirthdate">Születési dátum:</label>
                </td>
                <td>
                    <input class="input_data" title="Születési dátum" name="InputBirthdate" id="InputBirthdate" type="date" required="required"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="InputClass">Osztály:</label>
                </td>
                <td>
                    <select class="input_data" title="Osztály" name="InputClass1" id="InputClass1" required="required">
                        <option>9</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                    </select>
                    <select class="input_data" title="Osztály" name="InputClass2" id="InputClass2" required="required">
                        <option>A</option>
                        <option>B</option>
                        <option>C</option>
                        <option>D</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <br/>
                    <input type="hidden" name="isSend" value="true"/>

                    <input type="submit" class="MainSubmit"/>
                </td>
            </tr>
        </table>
    </form>
</div>
</div>
</body>
</html>
