<?php
/**
 * Created by PhpStorm.
 * User: Skriba
 * Date: 2019. 03. 17.
 * Time: 13:19
 */
session_start();
if(isset($_SESSION["userid"])) {
    session_destroy();
    header("Location: index.php");
}
?>