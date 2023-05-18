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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/json2/20160511/json2.js"
        integrity="sha512-h3RrO+eudpiPUYFkwORXD2ppuy9jOXQ+MzVEIo7k+OuA7y9Ze5jsQ5WN/ZSgI+ZSIngT6pDSaqpgmnam2HPe1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/mainPage/script.js"></script>


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
                <td style='cursor: pointer;'>Id </td>
                <td style='cursor: pointer;'>Meno</td>
                <td style='cursor: pointer;'>Priezvisko </td>

                <td style='cursor: pointer;'>Počet generovaných úloh </td>
                <td style='cursor: pointer;'>Počet odovzdaných úloh </td>
                <td style='cursor: pointer;'>Počet bodov </td>

            </tr>
        </thead>
        <tbody>
            <?php
            require_once("../../api/students/index.php");
            require_once("../../api/config.php");
            $studentsOverview = getStudentsSummary($db);
            foreach ($studentsOverview as $row) {
                echo "<tr>
                <td>" . $row["aisId"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["surname"] . "</td>
                <td>" . $row["generated_task_sets_count"] . "</td>
                <td>" . $row["submitted_task_sets_count"] . "</td>
                <td>" . $row["total_points_acquired"] . "</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>




    <script>


        $(document).ready(function () {
            $('#myTable').DataTable({
                columnDefs: [
                    {
            { "orderData": [3, 2], "targets": 3 },
                    { "orderData": [4, 2], "targets": 4 },
                    { "orderData": [5, 2], "targets": 5 },
        }
    ]  });
    
});



    </script>



</body>

</html>