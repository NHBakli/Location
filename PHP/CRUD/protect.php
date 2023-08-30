<?php

// Protection basique des imputs
// Voir https://www.pierre-giraud.com/php-mysql-apprendre-coder-cours/securiser-valider-formulaire/
// Rajout futur longueur mini/maxi des imputs
// Voir également https://stackoverflow.com/questions/5505227/checking-string-length-max-and-minimum

function protect_imput($param){
    $param = trim($param);
    $param = stripslashes($param);
    $param = htmlspecialchars($param);
    return $param;
}

// Génération d'un token pour reset password

// function str_random($var){
//     $string = "";
//     $chaine = "a0b1c2d3e4f5g6h7i8j9klmnopqrstuvwxyz1234567890";
//     srand((double)microtime()*1000000);
//     for($i=0; $i<$var; $i++) {
//         $string .= $chaine[rand()%strlen($chaine)];
//     }
//     return $string;
// }

?>