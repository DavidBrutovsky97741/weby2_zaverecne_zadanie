<?php
$latexText = '\documentclass[a4paper, 12pt]{article}
\usepackage[utf8]{inputenc}
\usepackage[slovak]{babel}
\usepackage{graphicx}
\usepackage{amsmath,amssymb,amsfonts}

\newenvironment{task}{}{}
\newenvironment{solution}{\noindent\textbf{Riešenie:}}{}


\begin{document}


\section*{B34A5A}
\begin{task}
    Nájdite prenosovú funkciu $F(s)=\dfrac{Y(s)}{W(s)}$ pre systém opísaný blokovou schémou: 

    \includegraphics{zadanie99/images/blokovka01_00002.jpg} 
\end{task} 

\begin{solution}
    \begin{equation*}
        \dfrac{2s^2+13s+10}{s^3+7s^2+18s+15}
    \end{equation*}
\end{solution}

\section*{BA23B4}
\begin{task}
    Nájdite prenosovú funkciu $F(s)=\dfrac{Y(s)}{W(s)}$ pre systém opísaný blokovou schémou: 

    \includegraphics{zadanie99/images/blokovka01_00003.jpg} 
\end{task} 

\begin{solution}
    \begin{equation*}
        \dfrac{7s+10}{2s^3+11s^2+12s+10}
    \end{equation*}
\end{solution}

\section*{B2A76C}
\begin{task}
    Nájdite prenosovú funkciu $F(s)=\dfrac{Y(s)}{W(s)}$ pre systém opísaný blokovou schémou: 

    \includegraphics{zadanie99/images/blokovka01_00004.jpg} 
\end{task} 

\begin{solution}
    \begin{equation*}
        4\dfrac{3s+1}{s^3+10s^2+13s+14}
    \end{equation*}
\end{solution}


\end{document}';


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

function createNewTaskSet(PDO $db, array $request)
{
    $name = $request["name"];
    $maxPoints = $request["maxPoints"];
    $latexText = $request["text"];
    $images = $request["images"];

}

$tasks = parseLaTeX($latexText);
var_dump($tasks);

?>