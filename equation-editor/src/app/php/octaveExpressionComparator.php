<?php

session_start();



if (isset($_POST['latexResult'])) {
    $_SESSION['latexResult'] = $_POST['latexResult'];
    // echo "Student result: " . $_POST['latexResult'];;
} else {
    // echo "Result was not set.";
}

if (isset($_POST['id'])) {
    $_SESSION['correctResultId'] = $_POST['id'];
     echo "ID: " . $_POST['id'];;
} else {
    // echo "ID parameter not found in the URL.";
}



require_once 'latexToOctaveParser.php';

// Function to compare two Octave symbolic expressions
function compareSymbolicExpressions($expr1, $expr2)
{
    // Octave command to compare symbolic expressions
    $command = "pkg load symbolic; syms a b c d e f g h i j k l m n o p q r s t u v w x y z alpha beta gamma delta epsilon zeta eta theta iota kappa lambda mu nu xi omicron pi rho sigma tau upsilon phi chi psi omega; isequal($expr1, $expr2)";
    
    try {

        // Execute Octave command
        exec("octave -q --eval '$command'", $output);

        // Extract the result from Octave output
    //    print_r($output);
        switch (trim($output[0])) {
            case 'ans = 0':
                $result = trim($output[0]);
                break;
            case 'ans = 1':
                $result = trim($output[0]);
                break;
                
            default:
                $result = trim($output[1]);
                break;
        }    
        // Return the comparison result as a boolean
        return ($result === "ans = 1");

    } catch (\Throwable $th) {
        return "0"; // odpoved zadana v nespravnom formate
    }
}


function getLatexResultByID($id) {
    $hostname = "172.20.128.2:3306";
$username = "root";
$password = "MYSQL_ROOT_PASSWORD";
$dbname = "zaverecne";
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
// header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
// header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// require_once('./../../config.php');
try {
    //$db = new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8", $username, $password);     
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    //echo $e->getMessage();
}

    try {
    
        // Assuming $id variable holds the ID value
    
        // Prepare and execute the SQL query
        $query = "SELECT answer FROM Tasks WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    
        // Fetch the result
        $row = $statement->fetch(PDO::FETCH_ASSOC);
    
        // Retrieve the 'answer' column value
        $answer = $row['answer'];
       // echo $answer;
        // Output the result
        return $answer;
    } catch (PDOException $e) {
      //  echo $e->getMessage();
    }
}



if (isset($_SESSION['latexResult']) && isset($_SESSION['correctResultId']) ) {
    
//   echo $_SESSION['latexResult'];
// echo $_SESSION['correctResultId'];
    // Get the correct symbolic expression from Bence


    $correctResultId = $_SESSION['correctResultId'];
    $rawCorrectResult = getLatexResultByID($correctResultId);
    $correctLatexExpression = parseCorrectLatexResult($rawCorrectResult);
    $correctOctaveExpression = latexToOctave($correctLatexExpression);
  //  echo "\n\nCorrect symbolic expression: $correctOctaveExpression\n";

    $studentLatexExpression = $_SESSION['latexResult'];
    $studentOctaveExpression = latexToOctave($studentLatexExpression);
 //  echo "Student's symbolic expression: $studentOctaveExpression\n";
 //   echo $correctLatexExpression, $studentLatexExpression;
    // Compare the two symbolic expressions
    $result = compareSymbolicExpressions($correctOctaveExpression, $studentOctaveExpression);


    $_SESSION['latexResult'] = null;
    if ($result) {
    //    echo "The expressions are equal.\n";
        echo($_SESSION['correctResultId'] . " " . "1/1");
        $_SESSION['correctResultId'] = null;
        return true; // spravna odpoved
    } else {
      //  echo "The expressions are not equal.\n";
        echo($_SESSION['correctResultId'] . " " . "0/1");
            $_SESSION['correctResultId'] = null;
        return false; // nespravna odpoved
    }
}


function parseCorrectLatexResult($inputString) {

    $newString = '';
    $copy = false;
    // Replace first "*}" with "="
    $inputString = str_replace('*}', '=', $inputString);

    // Replace first "\end" with "="
    $inputString = str_replace('\end', '=', $inputString);

    for ($i = 0; $i < strlen($inputString); $i++) {
        $char = $inputString[$i];

        if ($copy) {
            // Check if "=" is found
            if ($char === '=') {
                break;
            }

            // Append the character to the new string
            $newString .= $char;
        }

        // Check if "=" is found
        if ($char === '=') {
            $copy = true;
        }
    }
   // echo "daffafaf" . $newString;
    return $newString;
}

?>
