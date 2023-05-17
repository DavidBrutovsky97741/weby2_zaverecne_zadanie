<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../config.php');
$_POST = json_decode(file_get_contents('php://input'), true);

if (
    $_SERVER["REQUEST_METHOD"] == "GET"
) {
    $sql = "SELECT * FROM Students ";
    $stmt = $db->prepare($sql);
    if ($stmt->execute()) {
        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "asdfas";
        echo json_encode($response);
    }
    return;
}

if (
    $_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST["email"])
    && isset($_POST["aisId"])
    && isset($_POST["name"])
    && isset($_POST["surname"])
) {
    $email = $_POST["email"];
    $aisId = $_POST["aisId"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $sql = "INSERT INTO Students (email, aisId, name, surname) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    if ($stmt->execute([$email, $aisId, $name, $surname])) {
        echo "ok";
    }
    return;
}

?>