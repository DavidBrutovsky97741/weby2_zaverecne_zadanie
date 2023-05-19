<?php

session_start();

if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0)) {
    header("Location: /loginPage/index.php");
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

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navBar">


        <a class="navbar-brand" id="navName"> &nbsp; Záverečné zadanie webte2</a>


        <a href="/mainPage/index.php"><i class='material-icons'>home</i></a>


        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">


        </div>

        <a class="navAtt" id="logout" href="/api/logout-api.php">Ohlásiť sa </a>



        <a class="navAtt">&nbsp;&nbsp;&nbsp;</a>
        <a class="navAttname">
            <?php echo ($_SESSION['full_name']); ?> &nbsp;&nbsp;&nbsp;
        </a>

        <button class="flagbutton" onclick="slovakStudent()"><a class="navAttpic"> <img class="flagSize"
                    src="/images/slovakia.png" width=30></a></button>

        <button class="flagbutton" onclick="englishStudentTranslate()"><a class="navAttpic"> <img class="flagSize"
                    src="/images/gb.png" width=30></a> </button>

    </nav>

    <div class="navod">

        <?php

        if (!isset($_SESSION['login']) || (strcmp($_SESSION['login'], 'true') != 0) || (strcmp($_SESSION['type'], 'student') != 0)) {
            echo('        <h1>Návod</h1>

            <p>Po prihlásení aplikácia rozpozná (role - teacher), nie je teda potrebná žiadna špecifická autorizácia</p>
            <p>Pre učiteľa sa naskytne možnosť výberu 4 funkcionalít</p>
    
            <ol>
                <li>Pridať sadu úloh</li>
                <li>Prezrieť si všetkých študentov v db</li>
                <li>Vybrať ktoré sady budú zvolené na generovanie</li>
                <li>Zmeniť body za sadu</li>
            </ol>
    
            <h2>1.</h2>
    
            <p>Na stránke sa zobrazí okno pre vloženie folderu s latexami a folderu s obrázkami</p>
            <p>Po odoslaní sa uložia tieto súbory do db</p>
            <p>Sada automaticky dostne v sekcii (body za sadu) 10b</p>
    
    
            <h2>2.</h2>
    
            <p>Prehľadná tabuľka zobrazí všetky potrebné informácie o študentoch</p>
            <p>Tabuľka podporuje stránkovanie, vyhľadávanie a všetky potrebné usporiadania (podľa požiadavok zadania)</p>
    
            <h2>3.</h2>
    
            <p>Zobrazí sa prehľadná tabuľka s názvom sady a check boxom, ktorý je možné podľa ľubovôle označovať</p>
            <p>Ak je check_box chceked, znamená to že sada je pripravená na generovanie</p>
            <p>Nie je potreba žiadné dodatočné uloženie zmien</p>
    
            <h2>4.</h2>
    
            <p>Po kliknutí sa zobrazí prehľadná tabuľka s názvom sady počom aktuálnych bodov za sadu možnosťou ich zmeny</p>
            <p>Prázdny input napovedá možnosť na vloženie nového počtu bodov za sadu</p>
            <p>Minimálny počet bodov je 1 keďže mínusové hodnoty nedávajú zmysel a 0 to nie je lebo v dnešnej dobe ani pes nešteká zadarmo </p>
            <p>Naopak maximálny počet je 99</p>
            <p>Po zadaní počtu bodov do miesta vloženie treba body potvrdiť kliknutím na tlačidlo zmena</p>
    
        ');
        } else {


            echo ('<h1>Návod</h1>

        <p>Po prihlásení do aplikácií nadobudnete možnosť generovať si sady úloh, ktoré sú aktuálne pre Vás dostupné.</p>
        <p>Po vygenerovaní sád úloh si môžte vybrať sadu, ktrú budete písať</p>
        <p>Každá sada obsahuje N úloh, každá sada má X bodov</p>
   
        <h2>Písanie testu</h2>
   
        <p>Po vybraní sady je možné si zvoliť ktorú úlohu chcete písať v akom poradí</p>
        <p>Sadu je možné odoslať kedykoľvek, teda nemusia byť vyplenené všetky úlohy</p>
        <p>Pod tabuľkou s úlohami sa zobrazí aktuálne zvolená úloha</p>
        <p>Pod úlohou sa nachádza editor na vloženie Vašej odpovede</p>
        <p>Riešenie úlohy je nutné zadať bez rovniceho tvaru [y(t)= ... ], teda iba výsledok </p>
   
        <p>Aktuálny stav a výsledok úlohy sa zobrazuje v tabuľke</p>
   
        
   ');
        }

        ?>

</div>



    <!-- Button to trigger the saveAsPDF() function -->
    <button class="saveButton" id="saveButton" onclick="saveAsPDF()">Save Page as PDF</button>



    <script>
        function saveAsPDF() {
            // Get the current page's HTML content

            document.getElementById('navBar').style.display = 'none';
            document.getElementById('saveButton').style.display = 'none';

            const htmlContent = document.documentElement.innerHTML;



            // Create a new iframe element
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            document.body.appendChild(iframe);

            // Set iframe's content to the current page's HTML content
            iframe.contentDocument.open();
            iframe.contentDocument.write(htmlContent);
            iframe.contentDocument.close();

            // Wait for the iframe's content to load
            iframe.onload = function () {
                // Use the iframe's print() function to generate the PDF
                iframe.contentWindow.print();
            };
        }
    </script>


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