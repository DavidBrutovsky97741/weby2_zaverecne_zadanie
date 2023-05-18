<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function insertStudentDB($email, $aisId, $name, $surname)
{

    require('../api/config.php');

    try {
        $sql = "INSERT INTO Students (email, aisId, name, surname) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$email, $aisId, $name, $surname])) {
            return "ok";
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
        return "NotOk";
    }
}

function getStudentByAisId(PDO $db, int $aisId)
{
    try {
        $sql = "SELECT * FROM Students WHERE aisId = ?";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$aisId])) {
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $response;
        }
        return null;
    } catch (Exception $e) {
        return null;
    }
}


?>