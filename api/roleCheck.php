<?php

session_start();

if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0)) {
    header("Location: /weby2_zaverecne_zadanie/loginPage/index.php");
    die();
}

if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0) || (strcmp($_SESSION['type'], 'staff') != 0)) {
    // student
    header("Location: /weby2_zaverecne_zadanie/mainPage/index.php");
    die();
}else{
    header("Location: /weby2_zaverecne_zadanie/mainPage/indexTeacher.php");
    die(); 
}
?>