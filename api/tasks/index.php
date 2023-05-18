<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../config.php');

function getAvailableTasks(PDO $db): array
{
    try {
        $sql = "SELECT * FROM Available_task_sets";
        $stmt = $db->prepare($sql);
        if ($stmt->execute()) {
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $response;
        }
        return [];
    } catch (Exception $e) {
        return [];
    }
}

function addToAvailableTaskSets(PDO $db, int $taskSetId): bool
{
    try {
        $sql = "INSERT INTO Available_task_sets (task_id) VALUES (?)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$taskSetId])) {
            // $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return true;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}


function deleteFromAvailableTaskSets(PDO $db, int $taskSetId): bool
{
    try {
        $sql = "DELETE FROM Available_task_sets WHERE ?";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$taskSetId])) {
            return $stmt->rowCount() > 0 ? true : false;
            // $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}

function generateRandomStudentTaskSet(PDO $db, int $studentAisId, int $taskSetid)
{
    $availableTasks = getAvailableTasks($db);
    var_dump($availableTasks);
    $randomTaskSet = rand(0, count($availableTasks) - 1);
    $taskSetId = $availableTasks[$randomTaskSet]["task_id"];

    try {
        $sql = "INSERT INTO Student_task_sets (task_id) VALUES (?)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$taskSetId])) {
            // $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return true;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}

addToAvailableTaskSets($db, 45);
generateRandomStudentTaskSet($db, 2134);

?>