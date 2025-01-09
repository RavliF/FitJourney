<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    return header("location:../fitjourney/login.php");
}

?>