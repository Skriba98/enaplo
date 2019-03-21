<?php
/**
 * Created by PhpStorm.
 * User: Skriba
 * Date: 2019. 03. 17.
 * Time: 13:09
 */

include "config.php";
$MySQL_connect = mysqli_connect($MySQL_host, $MySQL_username, $MySQL_password, "teszt1") or die("MySQL kapcsolódási hiba: " . mysqli_connect_error());
