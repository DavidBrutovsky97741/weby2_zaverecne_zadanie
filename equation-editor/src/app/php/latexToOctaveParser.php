<?php

function latexToOctave($latexExpression) {
    $matchingExpressions = [
        "\\div" => "./",
        "\\cdot" => "*",

        "\\dfrac" => "",
        "\\frac" => "",
        "\\right" => "",
        "\\left" => "",

        "\\leq" => "<=",
        "\\geq" => ">=",

        "\\approx" => "≈",
        "\\equiv" => "≡",
        "\\cong" => "≅",
        "\\neq" => "≠",
        "\\sim" => "∼",
        "\\propto" => "∝",
        "\\prec" => "≺",
        "\\preceq" => "⪯",
        "\\subset" => "⊂",
        "\\subseteq" => "⊆",
        "\\succ" => "≻",
        "\\succeq" => "⪰",
        "\\circ" => "◦",
        "\\in" => "∈",
        "\\times" => "×",
        "\\pm" => "±",
        "\\wedge" => "∧",
        "\\vee" => "∨",
        "\\perp" => "⊥",
        "\\mid" => "∣",
        "\\parallel" => "∥",


    ];

    $greekExpressions =   [
        "\\alpha" => "alpha",
        "\\beta" => "beta",
        "\\gamma" => "gamma",
        "\\delta" => "delta",
        "\\epsilon" => "epsilon",
        "\\zeta" => "zeta",
        "\\eta" => "eta",
        "\\theta" => "theta",
        "\\iota" => "iota",
        "\\kappa" => "kappa",
        "\\lambda" => "lambda",
        "\\mu" => "mu",
        "\\nu" => "nu",
        "\\xi" => "xi",
        "\\omicron" => "omicron",
        "\\pi" => "pi",
        "\\rho" => "rho",
        "\\sigma" => "sigma",
        "\\tau" => "tau",
        "\\upsilon" => "upsilon",
        "\\phi" => "phi",
        "\\chi" => "chi",
        "\\psi" => "psi",
        "\\omega" => "omega",
    ];
    

    $octaveExpression = '';
    $tempString = '';
    $braceCount = 0;
    $inFrac = false;
    $lastLetter = false;
    $lastGreek = false;
    $lastBracketClose = false;
    
    for ($i = 0; $i < strlen($latexExpression); $i++) {
        $char = $latexExpression[$i];
        
        if ($char == " "){
            continue;
        }
        if (is_numeric($char)) {
            $octaveExpression .= $char;
        }
        elseif (ctype_alpha($char)) {
            if ($lastLetter || $lastGreek || $lastBracketClose) {
                $octaveExpression .= "*";
            }
            $lastLetter = true;
            $octaveExpression .= $char;
            continue;
            
        }
        elseif (in_array($char, ["+", "-", "=", "<", ">", ":"])) {
            $octaveExpression .= $char;
        } 
        elseif ($char == "^") {
            $octaveExpression .= "**";
        } 
        elseif ($char == "\\") {
            $tempString .= $char;
            
            while (($i + 1) < strlen($latexExpression) && ctype_alpha($latexExpression[$i + 1])) {
                $i = $i + 1;
                $tempString .= $latexExpression[$i];
            }
            
            if (array_key_exists($tempString, $matchingExpressions)) {
                $octaveExpression .= $matchingExpressions[$tempString];
                if ($tempString == "\\frac" || $tempString == "\\dfrac") {
                   # $braceCount = 0;
                    $inFrac = true;
                }
                $tempString = '';
            }
            elseif (array_key_exists($tempString, $greekExpressions)) {

                if ($lastGreek || $lastLetter || $lastBracketClose) {
                    $octaveExpression .= "*";
                }
                $octaveExpression .= $greekExpressions[$tempString];
                $lastGreek = true;
                continue;
            } 
             else {
            return "false";
             }
            

        } 
        elseif ($char == "{") {
            if ($inFrac) {
                $braceCount++;
            }
            if ($lastLetter || $lastGreek || $lastBracketClose) {
                $octaveExpression .= "*";
            }
            $octaveExpression .= "(";
        } 
        elseif ($char == "}") {
            if ($inFrac) {
                $braceCount--;
            }
            $octaveExpression .= ")";
            
            if ($inFrac && $braceCount == 0) {
                $inFrac = false;
                $octaveExpression .= "./";
                }
            else {
                $lastBracketClose = true;
                continue;
            }
        }
        elseif ($char == "(" || $char == "[" || $char == "{") {
            if ($lastLetter || $lastGreek || $lastBracketClose) {
                $octaveExpression .= "*";
            }
            $octaveExpression .= $char;
        }

        elseif ($char == ")" || $char == "]" || $char == "}") {
            $lastBracketClose = true;
            $octaveExpression .= $char;
            continue;
        }
        else {
            $octaveExpression .= $char;
        }
        $lastLetter = false;
        $lastGreek = false;
        $lastBracketClose = false;
        }
    $octaveExpression = multiplicationCheck($octaveExpression);
    return $octaveExpression;
}

function multiplicationCheck($octaveExpression) {

    $currentLetter = "";
    $lastLetter = "";
    $updatedOctaveExpression = "";
    for ($i = 0; $i < strlen($octaveExpression); $i++) {
        $char = $octaveExpression[$i];
        $currentLetter = $char;

        if (is_numeric($lastLetter) && ctype_alpha($currentLetter)) {
            $updatedOctaveExpression .= "*";
        }
        
        if (is_numeric($lastLetter)){
            if ($currentLetter == "(" || $currentLetter == "[" || $currentLetter == "{") {
                $updatedOctaveExpression .= "*";
            }
        }

        else if ($lastLetter == ")" || $lastLetter == "]" || $lastLetter == "}") {
            if ($currentLetter == "(" || $currentLetter == "[" || $currentLetter == "{") {
                $updatedOctaveExpression .= "*";
            }
        }
        $updatedOctaveExpression .= $char;
        $lastLetter = $currentLetter;
    }
    return $updatedOctaveExpression;
}