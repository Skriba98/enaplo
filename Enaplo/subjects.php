<?php
/**
 * Created by PhpStorm.
 * User: Skriba
 * Date: 2019. 03. 17.
 * Time: 22:22
 */
include "config.php";

$MySQL_connect = mysqli_connect($MySQL_host, $MySQL_username, $MySQL_password, $MySQL_database) or die("MySQL kapcsolódási hiba: " . mysqli_connect_error());
//Insert
$inputSubject = mysqli_real_escape_string($MySQL_connect,$_POST["inputSubject"]);
$inputTeacher = mysqli_real_escape_string($MySQL_connect,$_POST["inputTeacher"]);
$isSend = $_POST["isSend"];

if ($isSend) {
    mysqli_query($MySQL_connect, "INSERT INTO subjects (Name, Teacher) VALUES ('" . $inputSubject . "', '" . $inputTeacher . "')");
}
//Select

$DBsubjectData = mysqli_query($MySQL_connect,"SELECT * FROM subjects");

?>


<html>
<head>
    <link href="main.css?V=<?php echo rand();?>" type="text/css" rel="stylesheet"/>
    <meta charset="UTF-8">
    <title>Tantárgyak</title>
</head>
<body>
<?php include "navbar.php"; ?>
<div class="main_panel_container">
    <h1>Tantárgyak</h1>
    <table class="main_table">
        <thead class="table_header">
        <tr>
            <th>Név</th>
            <th>Tanár</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($subjectData = mysqli_fetch_array($DBsubjectData)) {
            echo "<tr>";
            echo "<td>";
            echo $subjectData["Name"];
            echo "</td>";
            echo "<td>";
            echo $subjectData["Teacher"];
            echo "</td>";
            echo "<td align='center'>";
            $subjectID = $subjectData["Id"];
            echo "<button class='editButton' onclick=\"location.href='editsubject.php?id=$subjectID'\">Szerkesztés</button>";
            echo "</td>";
            echo "<td align='center'>";
            echo "<button class='deleteButton' onclick=\"location.href='editsubject.php?id=$subjectID&delete=true'\">Törlés</button>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <br/><br/>
    <div class="inputDiv">
    <h1>Tantárgy hozzáadása</h1>
    <form action="" method="post">
        <table width="100%">
            <tr>
                <td width="80px">
        <label for="inputSubject" class="MainInputLabel">Tantárgynév:</label>
                </td>
                <td>
        <input title="Tantárgy" name="inputSubject" class="input_data" type="text" required="required"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="inputTeacher" class="MainInputLabel">Tanár:</label>
                </td>
                <td>
        <input title="Tanár" name="inputTeacher" class="input_data" type="text" required="required"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
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
