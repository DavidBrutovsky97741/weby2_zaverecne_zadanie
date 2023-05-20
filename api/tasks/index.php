<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../config.php');
require_once('../students/index.php');

session_start();
$studentAisId = $_SESSION['id'];
function getPoints(PDO $db): array
{
    try {
        $sql = "SELECT * FROM Tasks_sets";
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

function getAvailableTasks(PDO $db): array
{
    try {
        $sql = "SELECT * FROM Tasks_sets WHERE Tasks_sets.available = true";
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

function getTaskSetById(PDO $db, int $taskSetId): array
{
    try {
        $sql = "SELECT * FROM Tasks WHERE task_set_id = ?";
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


function getAvailableTask(PDO $db, int $taskSetId): array
{
    try {
        $sql = "SELECT * FROM Tasks_sets WHERE Tasks_sets.available = true AND Tasks_sets.id = ?";
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
        $sql = "UPDATE Tasks_sets SET Tasks_sets.available = true WHERE Tasks_sets.id = ?";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$taskSetId])) {
            return $stmt->rowCount() > 0 ? true : false;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}


function deleteFromAvailableTaskSets(PDO $db, string $taskSetId): bool
{
    try {
        $sql = "UPDATE Tasks_sets SET Tasks_sets.available = false WHERE Tasks_sets.id = ?";
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
function updateStudentGeneratedCount(PDO $db, int $studentId)
{
    try {
        $sql = "UPDATE Student SET Student.generated_task_sets_count = Student.generated_task_sets_count + 1 WHERE Student.id = ?";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$studentId])) {
            return $stmt->rowCount() > 0 ? true : false;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}

function generateStudentTaskSet(PDO $db, int $taskSetId)
{
    global $studentAisId;
    $availableTask = getAvailableTask($db, $taskSetId);
    if (count($availableTask) === 0)
        return false;
    $students = getStudentByAisId($db, intval($studentAisId));

    try {
        $sql = "INSERT INTO Student_task_sets (points_acquired, task_set_id , student_id, state) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([0, $taskSetId, $students[0]["id"], "GENERATED"])) {
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
            updateStudentGeneratedCount($db, $students[0]["id"]);
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

function getTaskSets(PDO $db)
{
    try {
        $sql = "SELECT * FROM Tasks_sets";
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

if (
    $_SERVER["REQUEST_METHOD"] == "GET"
    && isset($_GET["Available"])
    && isset($_GET["taskSetId"])
) {
    var_dump($_GET["Available"]);
    if ($_GET["Available"] === "true") {
        var_dump(addToAvailableTaskSets($db, intval($_GET["taskSetId"])));
    } else {
        echo deleteFromAvailableTaskSets($db, $_GET["taskSetId"]);
    }

    return;
}

function changePoints($id,$points,PDO $db){

    try {
        $sql = "UPDATE Tasks_sets SET max_points = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$points, $id])) {
            return $stmt->rowCount() > 0 ? true : false;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }

}

if (
    $_SERVER["REQUEST_METHOD"] == "GET"
    && isset($_GET["getAll"])
) {
    echo json_encode(getTaskSets($db));
    return;
}


if (
    $_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST["taskSetId"])
) {
    echo json_encode(getTaskSetById($db, intval($_POST["taskSetId"])));
    return;
}

if (
    $_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST["pointsAcquired"]) && isset($_POST["taskSetId2"])
) {
    echo json_encode(submitStudentTaskSet($db, intval($_POST["pointsAcquired"]), intval($_POST["taskSetId2"])));
    return;
}

if (
    $_SERVER["REQUEST_METHOD"] == "POST"

) {
    echo changePoints($_POST['id'],$_POST['points'],$db);
    return;
}

if (
    $_SERVER["REQUEST_METHOD"] == "GET"
    && isset($_GET["getPoints"])
) {
    echo json_encode(getPoints($db));
    return;
}


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo json_encode(getAvailableTasks($db));
    return;
}

if (
    $_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST['taskSetId3']))
    {
        echo json_encode(generateStudentTaskSet($db, intval($_POST["taskSetId3"])));
        return;
    }
 
 
// function getAvailableTask(PDO $db, int $taskSetId): array
// {
//     try {
//         $sql = "SELECT * FROM Tasks_sets WHERE Tasks_sets.available = true AND Tasks_sets.id = ?";
//         $stmt = $db->prepare($sql);
//         if ($stmt->execute([$taskSetId])) {
//             $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
//             return $response;
//         }
//         return [];
//     } catch (Exception $e) {
//         return [];
//     }
// }




?>