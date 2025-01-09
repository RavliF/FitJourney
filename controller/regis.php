<?php
session_start();

include '../database/regis.php';

$regis = new Regis();

$action =  $_GET['action'];

if ($action == "login") {
    $result = $regis->login(
        $_POST['email'],
        $_POST['password']
    );

    if ($result) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['id'] = $result['id'];
        $_SESSION['name'] = $result['name'];
        return header("location:../");
    }
    
    return header("location:../login.php");
}
else if ($action == "register") {
    $regis->register(
        $_POST['name'],
        $_POST['email'],
        $_POST['password']
    );

    return header("location:../login.php");
}

?>