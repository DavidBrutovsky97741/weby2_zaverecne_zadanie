<?php

session_start();

if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0)) {
    header("Location: /loginPage/index.php");
    die();
}

if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0) || (strcmp($_SESSION['type'], 'staff') != 0)) {
    // student
    header("Location: /mainPage/index.php");
    die();

    


}else{
    header("Location: /mainPage/indexTeacher.php");
    die(); 


}
?>
