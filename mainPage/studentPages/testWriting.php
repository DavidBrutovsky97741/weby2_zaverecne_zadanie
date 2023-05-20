<?php

session_start();

if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0)) {
    header("Location: /loginPage/index.php");
    die();
}

if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0) || (strcmp($_SESSION['type'], 'student') != 0)) {
    header("Location: /mainPage/indexTeacher.php");
    die();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="/mainPage/style.css">
    <title>Test</title>


    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>
</head>

<body>
    <div class="topBar"></div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">


        <a class="navbar-brand" id="navName"> &nbsp; Záverečné zadanie webte2</a>


        <a href="/mainPage/index.php"><i class='material-icons'>home</i></a>


        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">


        </div>

        <a class="navAtt" id="logout" href="/api/logout-api.php">Odhlásiť sa </a>



        <a class="navAtt">&nbsp;&nbsp;&nbsp;</a>
        <a class="navAttname">
            <?php echo ($_SESSION['full_name']); ?> &nbsp;&nbsp;&nbsp;
        </a>

        <button class="flagbutton" onclick="slovakStudentTranslateTest()"><a class="navAttpic"> <img class="flagSize" src="/images/slovakia.png" width=30></a></button>

        <button class="flagbutton" onclick="englishStudentTranslateTest()"><a class="navAttpic"> <img class="flagSize" src="/images/gb.png" width=30></a> </button>

    </nav>


    <table class="taskTable">
        <thead>
            <tr>
                <th>ID</th>
                <th id="taskName">Body</th>
                <th id="stateName">Stav</th>
                <th id="functionName">Funkcie</th>
            </tr>
        </thead>
        <tbody id="Tbody">



        </tbody>
    </table>

    <div id="taskContainer">
    </div>
    <img id="taskImage" alt="taskImage"/>

    <style>
        #taskContainer {
            text-align: center;
            padding: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            line-height: 1.5;
        }
    </style>



    <div class="containerNew" id="container">
        <button class="button" onclick="submitTaks()">
            <div class="button__line"></div>
            <div class="button__line"></div>
            <span class="button__text" id="buttonGenerate">Odoslať odpovede</span>

        </button>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/json2/20160511/json2.js" integrity="sha512-h3RrO+eudpiPUYFkwORXD2ppuy9jOXQ+MzVEIo7k+OuA7y9Ze5jsQ5WN/ZSgI+ZSIngT6pDSaqpgmnam2HPe1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="script.js"></script>





</body>

</html>


<?php
    require '../../equation-editor/src/app/html/EquationEditor.html';

?>