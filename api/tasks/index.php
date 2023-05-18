<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../config.php');
require_once('../students/index.php');

function getAvailableTasks(PDO $db): array
{
    try {
        $sql = "SELECT * FROM Available_task_sets INNER JOIN Tasks_sets ON Available_task_sets.task_id = Tasks_sets.id";
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

function getAvailableTask(PDO $db, int $taskSetId): array
{
    try {
        $sql = "SELECT * FROM Available_task_sets INNER JOIN Tasks_sets ON Available_task_sets.task_id = Tasks_sets.id WHERE Tasks_sets.id = ?";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$taskSetId])) {
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

function generateStudentTaskSet(PDO $db, int $studentAisId, int $taskSetId)
{
    $availableTask = getAvailableTask($db, $taskSetId);
    if (count($availableTask) === 0)
        return false;
    $students = getStudentByAisId($db, $studentAisId);

    try {
        $sql = "INSERT INTO Student_task_sets (points_acquired, task_set_id , student_id, state) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([0, $taskSetId, $students[0]["id"], "GENERATED"])) {
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
            var_dump($response);
            return true;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}

function submitStudentTaskSet(PDO $db, int $pointsAcquired, int $studentTaskSetId)
{
    try {
        $sql = "UPDATE Student_task_sets SET Student_task_sets.state = 'Submited', Student_task_sets.points_acquired = ?  WHERE Student_task_sets.id = ?";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$pointsAcquired, $studentTaskSetId])) {
            return $stmt->rowCount() > 0 ? true : false;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}

?>