<?php

//protection des inputs

function protect_montexte($param){
    $param = trim($param);
    $param = stripslashes($param);
    $param = htmlspecialchars($param);
    return $param;
}

//génération de token
function str_random($var){
    $string = "";
    $chaine = "a0b1c2d3e4f5g6h7i8j9klmnopqrstuvwxyz1234567890";
    srand((double)microtime()*1000000);
    for($i=0; $i<$var; $i++) {
        $string .= $chaine[rand()%strlen($chaine)];
    }
    return $string;
}

?>