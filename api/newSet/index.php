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

if (
    $_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST["name"])
    && isset($_POST["text"])
    && isset($_POST["maxPoints"])
    && isset($_POST["images"])
) {
    // $name = $_POST["name"];
    // $text = $_POST["text"];
    // $images = $_POST["images"];
    // $maxPoints = $_POST["maxPoints"];
    // $sql = "INSERT INTO Tasks_sets (latex_text, max_points, name) VALUES (?, ?, ?)";
    // $stmt = $db->prepare($sql);
    // if ($stmt->execute([$text, $maxPoints, $name])) {
    //     $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     echo json_encode($response);
    // }
    return;
}

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
    $pattern = '/\\\\section\*\{(.+?)\}.*?\\\\begin\{task\}(.*?)\\\\includegraphics\{(.*?)\}.*?\\\\end\{task\}.*?\\\\begin\{solution\}(.*?)\\\\end\{solution\}/s';
    preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);

    $tasks = array();
    foreach ($matches as $match) {
        $task = array();
        $task['section'] = trim($match[1]);
        $task['task'] = trim($match[2]);
        $task['image'] = trim($match[3]);
        $task['solution'] = trim($match[4]);
        $tasks[] = $task;
    }

    return $tasks;
}

function validateImages($tasks, $images): bool
{
    foreach ($tasks as $task) {
        if (count($task["images"]) === 0)
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

    // foreach ($images as $image) {
    //     $contains = false;
    //     foreach ($tasks as $task) {
    //         if (str_contains($task["image"], $image["name"]))
    //             $contains = true;
    //     }
    //     if ($contains == false)
    //         return false;
    // }
    // return true;
}


// function findImage($task, $images):array {
//     foreach ($image as $images) {
//         if (str_contains($task["image"], $image["fileName"])) return $image
//     }
//     return []
// }

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

// function createTasks(PDO $db, int $taskSetId, array $tasks, array $images){
//     foreach ($task as $images) {
//         # code...
//     }
// }

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
    // var_dump(createNewTaskSet($db, $name, $maxPoints, $latexText));



    // return new Ok(value: );
}

var_dump(createNewTaskSetBuild($db, [
    "name" => "aaaas",
    "maxPoints" => 485,
    "text" => $latexText,
    "images" => []
]))

    // if ($result->isOk()) {
//     echo "Result: " . $result->value;
// } else {
//     echo "Error: " . $result->error;
// }

    ?>