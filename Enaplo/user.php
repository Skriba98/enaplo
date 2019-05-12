<?php
/**
 * Created by PhpStorm.
 * User: Skriba
 * Date: 2019. 03. 26.
 * Time: 20:11
 */
include "config.php";
session_start();

if (!isset($_SESSION["userid"])) {
    header("Location: index.php");
}

$MySQL_connect = mysqli_connect($MySQL_host, $MySQL_username, $MySQL_password, $MySQL_database) or die("MySQL kapcsolódási hiba: " . mysqli_connect_error());
$userid = $_SESSION["userid"];
$DBuserData = mysqli_query($MySQL_connect, "SELECT * FROM marks INNER JOIN subjects ON subjects.Id = Subject_id WHERE User_id = '".$userid."' ORDER BY date DESC, Name DESC, Mark DESC, marks.Id DESC");

?>

<html>
<head>
    <title>Tanulók</title>
    <link href="main.css?V=<?php echo rand();?>" type="text/css" rel="stylesheet"/>
    <meta charset="UTF-8">
</head>
<body>
<div class="navbar">
    <a class="nav" href="">Osztalyzataim</a>
    <a class="nav" href="logout.php" style="border-right: hidden">Kijelentkezés</a>
</div>
<div class="main_panel_container">
    <h1>Osztályzataim</h1>
    <table class="main_table">
        <thead class="table_header">
        <tr>
            <th>Tantárgy</th>
            <th>Osztályzat</th>
            <th>Dátum</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($userData = mysqli_fetch_array($DBuserData)) {
            echo "<tr>";
            echo "<td>";
            echo $userData["Name"];
            echo "</td>";
            echo "<td>";
            echo $userData["Mark"];
            echo "</td>";
            echo "<td>";
            echo $userData["Date"];
            echo "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <br/>
</div>
</body>
</html>
