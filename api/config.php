<?php
$hostname = "172.20.128.2:3306";
$username = "root";
$password = "MYSQL_ROOT_PASSWORD";
$dbname = "zaverecne";
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
// header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
// header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// require_once('./../../config.php');
try {
    //$db = new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8", $username, $password);     
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>