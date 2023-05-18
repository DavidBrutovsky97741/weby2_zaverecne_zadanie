<?php

session_start();

if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0)) {
    header("Location: /loginPage/index.php");
    die();
}

if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0) || (strcmp($_SESSION['type'], 'staff') != 0)) {
    // student
    header("Location: /mainPage/index.php");
    die();
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/js/bootstrap.min.js"></script>-->

    <!-- datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link rel="stylesheet" href="/mainPage/style.css">

    <title>Document</title>
</head>

<body>
    <div class="topBar"></div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <a class="navbar-brand" id="navName"> &nbsp; Záverečné zadanie webte2</a>

        <a href="/mainPage/indexTeacher.php"><i class='material-icons'>home</i></a>


        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">


        </div>
        <a class="navAtt" id="logout" href="/api/logout-api.php">Ohlásiť sa </a>

        <a class="navAtt">&nbsp;&nbsp;&nbsp;</a>
        <a class="navAttname">
            <?php echo ($_SESSION['full_name']); ?> &nbsp;&nbsp;&nbsp;
        </a>

        <button class="flagbutton" onclick="slovakTeacher()"><a class="navAttpic"> <img class="flagSize"
                    src="/images/slovakia.png" width=30></a></button>

        <button class="flagbutton" onclick="englishTeacherTranslate()"><a class="navAttpic"><img class="flagSize"
                    src="/images/gb.png" width=30></a> </button>



    </nav>


    <table id="myTable" class="table">

        <thead>
            <tr>
                <td style='cursor: pointer;'>Sada </td>
                <td style='cursor: pointer;'>Body</td>
                <td style='cursor: pointer;'>Nové body </td>
                <td style='cursor: pointer;'>Zmeniť </td>

            </tr>
        </thead>
        <tbody id="Tbody">
            <script>

                fetch("http://localhost:8000/api/tasks/index.php?getPoints").then((response) => {
                    if (response.ok) return response.text()
                }).then((data) => {
                    const parsed = JSON.parse(data)
                    //console.log(parsed)
                    count = parsed.length;


                    var tbody = document.getElementById('Tbody');

                    for (let i = 0; i < count; i++) {

                        var tr = document.createElement('tr');
                        tbody.appendChild(tr);

                        var td1 = document.createElement('td');
                        td1.textContent = parsed[i].name;
                        tr.appendChild(td1);

                        var td2 = document.createElement('td');
                        td2.textContent = parsed[i].max_points;
                        tr.appendChild(td2);

                        var td3 = document.createElement('td');
                        var state = document.createElement('input');
                        state.id = 'state' + parsed[i].id;
                        state.type = 'number';
                        state.min = 1;
                        state.max = 99;

                        td3.appendChild(state);
                        tr.appendChild(td3);

                        var td4 = document.createElement('td'); // pisat
                        var button = document.createElement('button');
                        button.id = parsed[i].id;
                        button.textContent = 'Zmena';

                        button.addEventListener('click', (function (buttonId) {
                            return function () {
                                let stateId = 'state' + buttonId;
                                let newPoints = document.getElementById(stateId).value;
                                changePoints(buttonId, newPoints);
                            };
                        })(button.id));

                        td4.appendChild(button);
                        tr.appendChild(td4);

                    }
                })

                function changePoints(id, newPoints) {
                    if (newPoints < 1 || newPoints > 99) {
                        return;
                    } else {

                        $.ajax({

                            url: "/api/tasks/index.php",

                            method: "POST",

                            data: {
                                id: id,
                                points: newPoints,

                            },

                            success: function (response) {
                                //console.log(response)
                                window.location.href="/mainPage/teacherPages/changePoints.php";
                        
                            }
                        }) 
                    }
                }

            </script>
        </tbody>
    </table>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/json2/20160511/json2.js"
        integrity="sha512-h3RrO+eudpiPUYFkwORXD2ppuy9jOXQ+MzVEIo7k+OuA7y9Ze5jsQ5WN/ZSgI+ZSIngT6pDSaqpgmnam2HPe1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="/mainPage/script.js"></script>



</body>

</html>