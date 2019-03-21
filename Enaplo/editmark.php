<?php
/**
 * Created by PhpStorm.
 * User: Skriba
 * Date: 2019. 03. 18.
 * Time: 17:06
 */
include "config.php";
$markId = $_GET["id"];
$MySQL_connect = mysqli_connect($MySQL_host, $MySQL_username, $MySQL_password, $MySQL_database) or die("MySQL kapcsolódási hiba: " . mysqli_connect_error());

//Módosítás
$InputStudentId = $_POST["inputStudentId"];
$InputSubjectId = $_POST["inputSubjectId"];
$InputMark = $_POST["inputMark"];
$InputDate = $_POST["inputDate"];
$isSend = $_POST["isSend"];

if ($isSend) {
    mysqli_query($MySQL_connect, "UPDATE marks SET Subject_id = '".$InputSubjectId."', User_id = '".$InputStudentId."', Mark = '".$InputMark."'  WHERE marks.Id='".$markId."'");
    echo "<br><br><br><br><br><br><br>";
    echo $InputMark;
}

//Lekérdezés
$DBmarkData = mysqli_query($MySQL_connect,"SELECT users.Surname as Surname, users.Lastname as Lastname, users.OM as OM, users.Id as UserId, marks.id as Id, marks.Mark as Mark, marks.Date as Date ,subjects.Name as Subject, subjects.Id as SubjectId FROM marks INNER JOIN subjects ON subjects.Id = Subject_id INNER JOIN users ON users.Id = User_id WHERE marks.Id='".$markId."'");

$markdata = mysqli_fetch_array($DBmarkData);
$mark_Surname = $markdata["Surname"];
$mark_Lastname  = $markdata["Lastname"];
$mark_OM = $markdata["OM"];
$mark_Subject = $markdata["Subject"];
$mark_Mark = $markdata["Mark"];
$mark_Date = $markdata["Date"];
$mark_User_Id = $markdata["UserId"];
$mark_Subject_Id = $markdata["SubjectId"];

//Lekérdezés összes

$DBsubjectData = mysqli_query($MySQL_connect,"SELECT * FROM subjects");
$DBuserData = mysqli_query($MySQL_connect,"SELECT * FROM users");


//Törlés
$isDelete = $_GET["delete"];
if ($isDelete == "true") {
    mysqli_query($MySQL_connect, "DELETE FROM marks WHERE Id = '".$markId."'");
    header('Location: marks.php');
}
?>

<html>
<head>
    <link href="main.css?V=<?php echo rand();?>" type="text/css" rel="stylesheet"/>
    <meta charset="UTF-8">
    <title>Jegyek</title>
</head>

<body>
<div class="navbar">
    <a class="nav" href="">Főoldal</a>
    <a class="nav" href="students.php">Tanulók</a>
    <a class="nav" href="subjects.php">Tantárgyak</a>
    <a class="nav" href="marks.php">Jegyek</a>
</div>
<div class="main_panel_container">
    <h1>Osztályzat módosítása</h1>
    <form action="" method="post">
        <table width="100%">
            <tr>
                <td width="80px">
                    <label for="inputMark" class="MainInputLabel">Jegy:</label>
                </td>
                <td>

                    <select title="Jegy" name="inputMark" class="input_data" size="1">
                        <option <?php if ($mark_Mark == 1) echo 'selected="selected"'?>>1</option>
                        <option <?php if ($mark_Mark == 2) echo 'selected="selected"'?>>2</option>
                        <option <?php if ($mark_Mark == 3) echo 'selected="selected"'?>>3</option>
                        <option <?php if ($mark_Mark == 4) echo 'selected="selected"'?>>4</option>
                        <option <?php if ($mark_Mark == 5) echo 'selected="selected"'?>>5</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="inputSubjectId" class="MainInputLabel">Tantárgy:</label>
                </td>
                <td>
                    <select title="Tantárgy" name="inputSubjectId" class="input_data">
                        <?php
                        while ($subjectData = mysqli_fetch_array($DBsubjectData)) {
                            if ($mark_Subject_Id == $subjectData["Id"])
                            echo "<option value='".$subjectData["Id"]."' selected='selected'>";
                            else
                                echo "<option value='".$subjectData["Id"]."'>";
                            echo $subjectData["Name"];
                            echo "</option>";
                        }
                        ?>
                        }
                    </select>

                </td>
            </tr>
            <tr>
                <td>
                    <label for="inputUserId" class="MainInputLabel">Tanuló:</label>
                </td>
                <td>

                    <select title="Tanuló" name="inputStudentId" class="input_data">
                        <?php
                        while ($userData = mysqli_fetch_array($DBuserData)) {
                            if ($mark_User_Id == $userData["Id"])
                            echo "<option value='".$userData["Id"]."' selected='selected'>";
                            else
                                echo "<option value='".$userData["Id"]."'>";
                            echo $userData["Surname"] . " " . $userData["Lastname"] . " (" . $userData["OM"] . ")" ;
                            echo "</option>";
                        }
                        ?>
                        }
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">

                    <input type="hidden" name="inputDate" value="<?php echo date("Y-m-d"); ?>"/>
                    <input type="hidden" name="isSend" value="true">
                    <input type="submit" value="Küldés" class="MainSubmit">
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>



