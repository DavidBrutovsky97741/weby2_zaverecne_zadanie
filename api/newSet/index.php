<?php
$latexText = '\documentclass[a4paper, 12pt]{article}
\usepackage[utf8]{inputenc}
\usepackage[slovak]{babel}
\usepackage{graphicx}
\usepackage{amsmath,amssymb,amsfonts}

\newenvironment{task}{}{}
\newenvironment{solution}{\noindent\textbf{Riešenie:}}{}


\begin{document}


\section*{O23A7A}
\begin{task}
    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou
    \begin{equation*}
        F(s)=\dfrac{6}{(5s+2)^2}e^{-4s}
    \end{equation*}
\end{task} 

\begin{solution}
    \begin{equation*}
        y(t)=\left[ \dfrac{3}{2}-\dfrac{3}{2}e^{-\frac{2}{5}(t-4)}-\dfrac{3}{5}(t-4)e^{-\frac{2}{5}(t-4)} \right] \eta(t-4)
    \end{equation*}
\end{solution}

%===============================================================


\section*{O5A67B}
\begin{task}
    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou
    \begin{equation*}
        F(s)=\dfrac{35}{(2s+5)^2}e^{-6s}
    \end{equation*}
\end{task} 

\begin{solution}
    \begin{equation*}
        y(t)=\left[ \dfrac{7}{5}-\dfrac{7}{5}e^{-\frac{5}{2}(t-6)}-\dfrac{7}{2}(t-6)e^{-\frac{5}{2}(t-6)} \right] \eta(t-6)
    \end{equation*}
\end{solution}

%=============================================================

\section*{OAC346}
\begin{task}
    Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou
    \begin{equation*}
        F(s)=\dfrac{12}{(5s+4)^2}e^{-7s}
    \end{equation*}
\end{task} 

\begin{solution}
    \begin{equation*}
        y(t)=\left[ \dfrac{3}{4}-\dfrac{3}{4}e^{-\frac{4}{5}(t-7)}-\dfrac{3}{5}(t-7)e^{-\frac{4}{5}(t-7)} \right] \eta(t-7)
    \end{equation*}
\end{solution}



\end{document}
';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../config.php');
$_POST = json_decode(file_get_contents('php://input'), true);

abstract class Result
{
    public function isOk(): bool
    {
        return $this instanceof Ok;
    }

    public function isErr(): bool
    {
        return $this instanceof Err;
    }
}

class Ok extends Result
{
    public $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}

class Err extends Result
{
    public $error;

    public function __construct($error)
    {
        $this->error = $error;
    }
}


function parseLaTeX($text)
{
    $pattern = '/\\\\section\*\{(.+?)\}.*?\\\\begin\{task\}(.*?)(?:\\\\includegraphics\{(.*?)\})?.*?\\\\end\{task\}.*?\\\\begin\{solution\}(.*?)\\\\end\{solution\}/s';
    preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);

    $tasks = array();
    foreach ($matches as $match) {
        $task = array();
        $task['section'] = trim($match[1]);
        $task['task'] = trim($match[2]);
        $task['image'] = isset($match[3]) && $match[3] != "" ? trim($match[3]) : null;
        $task['solution'] = trim($match[4]);
        $tasks[] = $task;
    }
    return $tasks;
}

function validateImages($tasks, $images): bool
{
    foreach ($tasks as $task) {
        if (is_null($task["image"]) || $task["image"] === "")
            continue;
        $contains = false;
        foreach ($images as $image) {
            if (str_contains($task["image"], $image["fileName"]))
                $contains = true;
        }
        if ($contains == false)
            return false;
    }
    return true;
}


function findImage($task, $images): array
{
    foreach ($images as $image) {
        if (str_contains($task["image"], $image["fileName"]))
            return $image;
    }
    return [];
}

/** */
function createNewTaskSet(
    PDO $db
    , string $name
    , int $maxPoints
    , string $latexText
): Result {
    try {
        $sql = "INSERT INTO Tasks_sets (latex_text, max_points, name) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$latexText, $maxPoints, $name])) {
            if ($stmt->rowCount() == 0)
                return new Err(error: "no rows affected");
            return new Ok(value: $db->lastInsertId());
        }
        return new Err(error: "execute failed");
    } catch (Exception $e) {
        return new Err(error: $e->getMessage());
    }
}

function createImage(PDO $db, array $image): Result
{
    try {
        $sql = "INSERT INTO Images (image_base64, file_name) VALUES (?, ?)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$image["image64"], $image["fileName"]])) {
            if ($stmt->rowCount() == 0)
                return new Err(error: "no rows affected");
            return new Ok(value: $db->lastInsertId());
        }
        return new Err(error: "execute failed");
    } catch (Exception $e) {
        return new Err(error: $e->getMessage());
    }
}

function createTask(PDO $db, int $taskSetId, array $task, int|null $imageId): Result
{
    try {
        $sql = "INSERT INTO Tasks (task_set_id, task_text, task_image_id, answer ) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$taskSetId, $task["task"], $imageId, $task["solution"]])) {
            if ($stmt->rowCount() == 0)
                return new Err(error: "no rows affected");
            return new Ok(value: $db->lastInsertId());
        }
        return new Err(error: "execute failed");
    } catch (Exception $e) {
        return new Err(error: $e->getMessage());
    }
}

function createTasks(PDO $db, int $taskSetId, array $tasks, array $images): Result
{
    foreach ($tasks as $task) {
        $image = findImage($task, $images);
        echo "asdfasdfasd: " . $task["image"];
        $imageResult = null;
        if (!is_null($task["image"]) || $task["image"] != "") {
            $imageResult = createImage($db, $image);
            if ($imageResult->isErr())
                return $imageResult;
        }
        $taskResult = createTask($db, $taskSetId, $task, $imageResult ? $imageResult?->value : null);
        if ($taskResult->isErr())
            return $taskResult;
    }
    return new Ok(value: "tasks created");
}

function createNewTaskSetBuild(PDO $db, array $request): Result
{
    $name = $request["name"];
    $maxPoints = $request["maxPoints"];
    $latexText = $request["text"];
    $images = $request["images"];
    $tasks = parseLaTeX($latexText);
    if (!validateImages($tasks, $images))
        return new Err(error: "missing images");

    $newSetResult = createNewTaskSet($db, $name, $maxPoints, $latexText);
    if ($newSetResult->isErr())
        return $newSetResult;

    return createTasks($db, $newSetResult?->value, $tasks, $images);
}

// var_dump(createNewTaskSetBuild($db, [
//     "name" => "aaaas",
//     "maxPoints" => 485,
//     "text" => $latexText,
//     "images" => []
// ]));

if (
    $_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST["name"])
    && isset($_POST["text"])
    && isset($_POST["maxPoints"])
    && isset($_POST["images"])
) {
    createNewTaskSetBuild($db, $_POST);
    return;
}

?>