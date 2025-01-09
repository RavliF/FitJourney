<?php

session_start();
unset($_SESSION['loggedIn']);
unset($_SESSION['user_id']);
unset($_SESSION['id']);
unset($_SESSION['name']);
    
return header("location:/fitjourney/login.php");

?>