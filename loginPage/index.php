<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>Login</title>
</head>

<body>

    <div class="login-page">

        <div class="form">


            <div class="avatar">
                <img src="/images/logoStu.jpg" alt="Logo">
                <!-- weby2_zaverecne_zadanie/ je folder na serveri -->
            </div>

            <h2 id="login">Prihlásenie</h2>

            <?php

            if (isset($_GET['msg'])){
                $msg = $_GET['msg'];
                echo('<p style="color: red">'.$msg.'</p>');
            }
            ?>

            <form action="/api/login-api.php" method="post">
                <input type="text" placeholder="Prihlasovacie meno" name="name">
                <input type="password" placeholder="Heslo" name="password">
                <p > Teacher: </p>
                <input type="checkbox" name="adminRole">
                <button>Prihlásiť sa</button>
            </form>
            <p class="message">Prihlásenie podľa vašich osobných údajov Ais</p>
            <p class="copyright">Team Alpha Beta Gamma Delta<br>2023 ©</p>
        </div>
    </div>
</body>

</html> 