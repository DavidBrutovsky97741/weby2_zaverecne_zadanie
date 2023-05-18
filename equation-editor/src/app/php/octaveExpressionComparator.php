<?php

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
        print_r($output);
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

// Get the correct symbolic expression from Bence
$correctLatexExpression = "\\dfrac{2s^2+13s+10}{s^3+7s^2+18s+15}";
$correctOctaveExpression = latexToOctave($correctLatexExpression);
echo "Correct symbolic expression: $correctOctaveExpression\n";

// Get the student's symbolic expression
$studentLatexExpression = "\\frac{2s^{2}+13s+10}{s^{3}+7s^{2}+18s+15}";
$studentOctaveExpression = latexToOctave($studentLatexExpression);
echo "Student's symbolic expression: $studentOctaveExpression\n";

// Compare the two symbolic expressions
$result = compareSymbolicExpressions($correctOctaveExpression, $studentOctaveExpression);


if ($result) {
    echo "The expressions are equal.\n";
    return true; // spravna odpoved
} else {
    echo "The expressions are not equal.\n";
    return false; // nespravna odpoved
}

?>
