<?php

session_start();


$language = $_GET['language'];

if (strcmp($language,'slovak')==0){
    
    $_SESSION['language'] = "slovak";
}else{
    $_SESSION['language'] = "english";
}

header("Location: /weby2_zaverecne_zadanie/mainPage/index.php");
die();

?>