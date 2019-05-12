<?php
/**
 * Created by PhpStorm.
 * User: Skriba
 * Date: 2019. 03. 17.
 * Time: 13:09
 */

include "config.php";
//$MySQL_connect = mysqli_connect($MySQL_host, $MySQL_username, $MySQL_password, "teszt1") or die("MySQL kapcsolódási hiba: " . mysqli_connect_error());
?>

<html lang="hu">
<head>
    <link href="main.css?V=<?php echo rand();?>" type="text/css" rel="stylesheet"/>
    <meta charset="UTF-8">
    <title>Főoldal</title>
</head>

<body>
<?php include "navbar.php"; ?>
<div class="main_panel_container">
    <h1>E-naplo</h1>
    <h2><a href="login.php">Bejelentkezés tanulók számára<a></h2>
</div>
</body>
</html>