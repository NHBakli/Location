<?php

// Fichier de connexion à la BDD

$host = 'localhost';
$login = 'root';
$psswrd = '';
$db = 'location';
$connection = mysqli_connect($host, $login, $psswrd, $db);

if(!$connection){
    die(mysqli_connect_error());
}

?>