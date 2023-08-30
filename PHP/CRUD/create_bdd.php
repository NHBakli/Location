<?php

// Fichier de première connexion et de création de la BDD
// http://localhost/VSCode/Github/Location/PHP/CRUD/create_bdd.php

$host = 'localhost';
$login = 'root';
$psswrd = '';
$connection = mysqli_connect($host, $login, $psswrd);

if(!$connection){
    die(mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS `location`";

if(mysqli_query($connection, $sql)){
    echo 'La BDD « location » a été créée';
}else{
    echo 'Erreur de création de la BDD « location »';
}

mysqli_close($connection);
?>