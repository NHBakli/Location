<?php

// Fichier de création des tables
// http://localhost/VSCode/Github/Location/PHP/CRUD/create_table.php

require './connection.php';

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(10) unsigned auto_increment PRIMARY KEY NOT NULL,
    login VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(256) NOT NULL,
    role VARCHAR(25) NOT NULL,
    token_reset VARCHAR(256) NULL, 
    isVerified BOOL NULL)";

if (mysqli_query($connection,$sql)){
    echo 'La table « users » a été créée</br>';    
}else{
    mysqli_error($connection,$sql);
    echo 'Erreur de création de la table « users »</br>';
}

$sql = "CREATE TABLE IF NOT EXISTS customers (
    id INT(10) unsigned auto_increment PRIMARY KEY NOT NULL, 
    lastname VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    country VARCHAR(50) NULL,
    city VARCHAR(50) NULL,
    postal_code VARCHAR(10) NULL,
    address VARCHAR(256) NULL,
    user_id INT(10) unsigned NOT NULL,         
    FOREIGN KEY (user_id) REFERENCES users(id))";

if (mysqli_query($connection,$sql)){
    echo 'La table « customers » a été créée</br>'; 
}else{
    mysqli_error($connection,$sql);
    echo 'Erreur de création de la table « customers »</br>';
}

$sql = "CREATE TABLE IF NOT EXISTS fleet (
    id INT(10) unsigned auto_increment PRIMARY KEY NOT NULL, 
    brand VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    power VARCHAR(20) NOT NULL,
    fuel VARCHAR(20) NOT NULL,
    description VARCHAR(256) NULL,
    -- type TEXT possible
    photo VARCHAR(256) NOT NULL,
    -- type BLOB possible, fonctionnement différent
    -- https://beaussier.developpez.com/articles/php/mysql/blob/
    price_ht FLOAT(10) NOT NULL,
    tva FLOAT(10) NOT NULL)";

if (mysqli_query($connection,$sql)){
    echo 'La table « fleet » a été créée</br>';
}else{
    mysqli_error($connection,$sql);
    echo 'Erreur de création de la table « fleet »</br>';
}

$sql = "CREATE TABLE IF NOT EXISTS contact (
    id INT(6) unsigned auto_increment primary key,
    lastname VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    message TEXT NOT NULL)";

if (mysqli_query($connection,$sql)){
    echo 'La table « contact » a été créée';
}else{
    mysqli_error($connection,$sql);
    echo 'Erreur de création de la table « contact »';
}

mysqli_close($connection);

?>





