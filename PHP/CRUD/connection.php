<?php

// Fichier de connexion à la BDD

$host = 'localhost';
$login = 'root';
$password = '';
$db = 'location';
$connection = mysqli_connect($host, $login, $password, $db);

if(!$connection){
    die(mysqli_connect_error());
}

?>