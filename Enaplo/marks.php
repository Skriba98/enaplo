<?php
/**
 * Created by PhpStorm.
 * User: Skriba
 * Date: 2019. 03. 18.
 * Time: 14:58
 */
include "config.php";
$MySQL_connect = mysqli_connect($MySQL_host, $MySQL_username, $MySQL_password, $MySQL_database) or die("MySQL kapcsolódási hiba: " . mysqli_connect_error());
$DBsubjectData = mysqli_query($MySQL_connect,"SELECT * FROM subjects");
$DBuserData = mysqli_query($MySQL_connect,"SELECT * FROM users");

//Insert data
$inputUserId = $_POST["inputUserId"];
$inputSubjectId = $_POST["inputSubjectId"];
$inputMark = $_POST["inputMark"];
$inputDate = $_POST["inputDate"];
$isSend = $_POST["isSend"];

if ($isSend) {
    mysqli_query($MySQL_connect, "INSERT INTO marks (Mark, Subject_id, User_id, Date) VALUES ('" . $inputMark . "', '" . $inputSubjectId . "', '" . $inputUserId . "', '" . $inputDate . "')");
}

//Select data
$DBmarkData = mysqli_query($MySQL_connect,"SELECT users.Surname as Surname, users.Lastname as Lastname, users.OM as OM, marks.id as Id,marks.Mark as Mark, marks.Date as Date ,subjects.Name as Subject FROM marks INNER JOIN subjects ON subjects.Id = Subject_id INNER JOIN users ON users.Id = User_id ");


//echo $inputUserId . " " . $inputSubjectId . " " . $inputMark . " " . $inputDate;

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
        <a class="nav" href="marks.php">Osztályzatok</a>
    </div>
    <div class="main_panel_container">
        <h1>Osztályzatok</h1>
        <table class="main_table">
            <thead class="table_header">
            <tr>
                <th>Név</th>
                <th>Tantárgy</th>
                <th>Jegy</th>
                <th>Dátum</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($markData = mysqli_fetch_array($DBmarkData)) {
                echo "<tr>";
                echo "<td>";
                echo $markData["Surname"] . " " . $markData["Lastname"] . " (" . $markData["OM"] . ")";
                echo "</td>";
                echo "<td>";
                echo $markData["Subject"];
                echo "</td>";
                echo "<td>";
                echo $markData["Mark"];
                echo "</td>";
                echo "<td>";
                echo $markData["Date"];
                echo "</td>";
                echo "<td align='center'>";
                $markID = $markData["Id"];
                echo "<button class='editButton' onclick=\"location.href='editmark.php?id=$markID'\">Szerkesztés</button>";
                echo "</td>";
                echo "<td align='center'>";
                echo "<button class='deleteButton' onclick=\"location.href='editmark.php?id=$markID&delete=true'\" >Törlés</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>

    <br/><br/>
        <div class="inputDiv">
        <h1>Jegybeírás</h1>
            <form action="" method="post">
            <table width="100%">
                <tr>
                    <td width="80px">
<label for="inputMark" class="MainInputLabel">Jegy:</label>
                    </td>
                    <td>

                        <select title="Jegy" name="inputMark" class="input_data" size="1">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
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

        <select title="Tanuló" name="inputUserId" class="input_data">
            <?php
            while ($userData = mysqli_fetch_array($DBuserData)) {
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
    </div>

</body>
</html>
