<?php
/**
 * Created by PhpStorm.
 * User: Skriba
 * Date: 2019. 03. 18.
 * Time: 17:22
 */
include "config.php";

$MySQL_connect = mysqli_connect($MySQL_host, $MySQL_username, $MySQL_password, $MySQL_database) or die("MySQL kapcsolódási hiba: " . mysqli_connect_error());
$subjectId = mysqli_real_escape_string($MySQL_connect,$_GET["id"]);

//Módosítás
$InputName = mysqli_real_escape_string($MySQL_connect,$_POST["InputName"]);
$InputTeacher = mysqli_real_escape_string($MySQL_connect,$_POST["InputTeacher"]);
$isSend = $_POST["isSend"];
$message = "";
if ($isSend) {
    mysqli_query($MySQL_connect, "UPDATE subjects SET Name = '".$InputName."', Teacher = '".$InputTeacher."' WHERE Id = '".$subjectId."'");
    $message = "Sikeres módosítás";
}

//Lekérdezés
$DBsubjectData = mysqli_query($MySQL_connect,"SELECT * FROM subjects WHERE Id='".$subjectId."'");
$subjectdata = mysqli_fetch_array($DBsubjectData);
$subject_Name = $subjectdata["Name"];
$subject_Teacher = $subjectdata["Teacher"];

//Törlés

$isDelete = $_GET["delete"];
if ($isDelete == "true") {
    mysqli_query($MySQL_connect, "DELETE FROM marks WHERE Subject_id = '".$subjectId."'");
    mysqli_query($MySQL_connect, "DELETE FROM subjects WHERE Id = '".$subjectId."'");
    header('Location: subjects.php');
}

?>

<html>
<head>
    <link href="main.css?V=<?php echo rand();?>" type="text/css" rel="stylesheet"/>
    <meta charset="UTF-8">
    <title>Tárgyak</title>
</head>


<body>
<?php include "navbar.php"; ?>
<div class="main_panel_container">
    <h1>Tantárgy adatainak módosítása</h1>
    <?php if($message != '') echo '<span class="ModifyMessage"> '.$message.' </span>'; ?>
    <form action="" method="post">
        <table border="0" width="100%">
            <tr>
                <td width="120px">
                    <label for="InputName" class="edit_student_font">Tantárgynév:</label>
                </td>
                <td>
                    <input class="input_data" title="Tantárgynév:" name="InputName" id="InputName" type="text" value="<?php echo $subject_Name; ?>"/>
                </td>
            <tr>
                <td>
                    <label for="InputTeacher" class="edit_student_font">Tanár:</label>
                </td>
                <td>
                    <input class="input_data" title="Tanár" name="InputTeacher" id="InputTeacher" type="text" value="<?php print htmlentities($subject_Teacher, ENT_QUOTES); ?>"/>
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
