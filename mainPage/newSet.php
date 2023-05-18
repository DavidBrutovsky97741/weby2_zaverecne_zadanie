<?php

session_start();

if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0)) {
    header("Location: /loginPage/index.php");
    die();
}

if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0) || (strcmp($_SESSION['type'], 'staff') != 0)) {
    header("Location: /maniPage/index.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <div class="topBar"></div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <?php

        if (strcmp($_SESSION['language'], 'slovak') == 0) {
            echo ('<a class="navbar-brand"> &nbsp; Záverečné zadanie webte2</a>');
        } else {
            echo ('<a class="navbar-brand"> &nbsp; Final task webte2</a>');
        }

        ?>

        <a href="/mainPage/index.php"><i class='material-icons'>home</i></a>


        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">


        </div>
        <?php

        if (strcmp($_SESSION['language'], 'slovak') == 0) {
            echo ('<a class="navAtt" href="/api/logout-api.php">Ohlásiť sa </a>');
        } else {
            echo ('<a class="navAtt" href="/api/logout-api.php">Log out </a>');
        }

        ?>

        <a class="navAtt">&nbsp;&nbsp;&nbsp;</a>
        <a class="navAttname">
            <?php echo ($_SESSION['full_name']); ?> &nbsp;&nbsp;&nbsp;
        </a>

        <a class="navAttpic" href="/api/language-api.php?language=slovak"> <img class="flagSize"
                src="/images/slovakia.png" width=30></a></button>

        <a class="navAttpic" href="/api/language-api.php?language=english"> <img class="flagSize" src="/images/gb.png"
                width=30></a> </button>


    </nav>

    <div class="formUpload">

        <form id="folderUploadForm">

            <div class="formUploadsection">
                <label for="imageFolder">Image Folder:</label>
                <input type="file" id="imageFolder" webkitdirectory directory multiple>
            </div>

            <div class="formUploadsection">
                <label for="latexFolder">LaTeX Folder:</label>
                <input type="file" id="latexFolder" webkitdirectory directory multiple required>
            </div>

            <button type="submit">Upload</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/json2/20160511/json2.js"
        integrity="sha512-h3RrO+eudpiPUYFkwORXD2ppuy9jOXQ+MzVEIo7k+OuA7y9Ze5jsQ5WN/ZSgI+ZSIngT6pDSaqpgmnam2HPe1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="script.js"></script>



</body>

</html>