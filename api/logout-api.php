<?php
session_start();

// Uvolni vsetky session premenne.
session_unset();

// Vymaz vsetky data zo session.
session_destroy();

session_start();

header("Location: /weby2_zaverecne_zadanie/loginPage/index.php");
die();

?>