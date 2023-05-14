<?php

session_start();

if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0)) {
    header("Location: /weby2_zaverecne_zadanie/loginPage/index.php");
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
        
        if (strcmp($_SESSION['language'],'slovak')==0){
            echo('<a class="navbar-brand"> &nbsp; Záverečné zadanie webte2</a>');
        }else{
            echo('<a class="navbar-brand"> &nbsp; Final task webte2</a>');
        }
        
        ?>

        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">


        </div>
        <?php
        
        if (strcmp($_SESSION['language'],'slovak')==0){
            echo('<a class="navAtt" href="/weby2_zaverecne_zadanie/api/logout-api.php">Ohlásiť sa </a>');
        }else{
            echo('<a class="navAtt" href="/weby2_zaverecne_zadanie/api/logout-api.php">Log out </a>');
        }
        
        ?>
        
        <a class="navAtt">&nbsp;&nbsp;&nbsp;</a>
        <a class="navAttname">
            <?php echo ($_SESSION['full_name']); ?> &nbsp;&nbsp;&nbsp;
        </a>

        <a class="navAttpic" href="/weby2_zaverecne_zadanie/api/language-api.php?language=slovak"> <img src="https://flagsapi.com/SK/shiny/32.png"></a>

        <a class="navAttpic" href="/weby2_zaverecne_zadanie/api/language-api.php?language=english"> <img src="https://flagsapi.com/GB/shiny/32.png"></a>


    </nav>

    <?php

    if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0) || (strcmp($_SESSION['type'], 'staff') != 0)) {
        // student

        echo('    
        <div class="modalSet" id="modalSet">

        <table>
        <thead>
            <tr>');       
        
            if (strcmp($_SESSION['language'],'slovak')==0){
                echo(' <th colspan="2" id="setName">Názov setu</th>');
            }else{
                echo(' <th colspan="2" id="setName">Set name</th>');
            }
                echo('     
            </tr>
        </thead>
        <tbody>
            <tr>');

            if (strcmp($_SESSION['language'],'slovak')==0){
                echo('<td>Počet úloh</td>');
            }else{
                echo('<td>Number of tasks</td>');
            }
                echo('   
                <td id="countTasks">with two columns</td>
            </tr>
    
            <tr>');

            if (strcmp($_SESSION['language'],'slovak')==0){
                echo('<td>Maximálny počet bodov</td>');
            }else{
                echo('<td>Max points</td>');
            }
            
                echo(' 
                <td id="points">with two columns</td>
            </tr>
            <tr>');

            if (strcmp($_SESSION['language'],'slovak')==0){
                echo('<td>Stav</td>');
            }else{
                echo('<td>State</td>');
            }

                echo('
                <td id="taskState">with two columns</td>
            </tr>
        </tbody>
    </table>');

    if (strcmp($_SESSION['language'],'slovak')==0){
        echo(' <button type="button" class="btn btn-success">Písať test</button>');
        echo(' <button type="button" class="btn btn-danger" onclick="closeModal()">Zatvoriť</button>');
    }else{
        echo(' <button type="button" class="btn btn-success">Start test</button>');
        echo(' <button type="button" class="btn btn-danger" onclick="closeModal()">Close</button>');
    }      
    echo('
        </div>
    
        <div class="container">
            <button class="button" onclick="generateSets()">
                <div class="button__line"></div>
                <div class="button__line"></div> ');
                if (strcmp($_SESSION['language'],'slovak')==0){
                    echo(' <span class="button__text">Generuj sady úloh</span>');
                }else{
                    echo(' <span class="button__text">Generate sets of tasks</span>');
                }
               
                echo('
            </button>
    
        </div>
    
    
    
        <div class="sets" id="sets">');
        if (strcmp($_SESSION['language'],'slovak')==0){
            echo(' <p> Tu sa zobrazia generované sety úloh </p>');
        }else{
            echo(' <p>Here will be shown generated sets of tasks </p>');
        }
           
            echo('
        </div>');
    

    } else {

        echo('<div class="teacherCan">


        <div class="can" onclick="">
        <p>Nahrať novú sadu</p>
        </div>
        
        
        <div class="can">
        <p>Prehľad študentov</p>
        </div>
        
        
        <div class="can">
        <p>Výber sád na generovanie</p>
        </div>
        
        
        <div class="can">
        <p>Zmeniť body za sadu</p>
        </div>
        
        
        
        </div>');

    }

    ?>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/json2/20160511/json2.js"
        integrity="sha512-h3RrO+eudpiPUYFkwORXD2ppuy9jOXQ+MzVEIo7k+OuA7y9Ze5jsQ5WN/ZSgI+ZSIngT6pDSaqpgmnam2HPe1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="script.js"></script>



</body>

</html>