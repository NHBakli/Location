<?php

require './connection.php';

$sql = "CREATE TABLE IF NOT EXISTS users (
    id int(10) auto_increment PRIMARY KEY NOT NULL,
    login VARCHAR(128) UNIQUE NOT NULL,
    password VARCHAR(256) NOT NULL,
    role VARCHAR(20) NOT NULL,
    token_reset VARCHAR(256) NULL, 
    isVerified bool NULL)";

if (mysqli_query($connection,$sql)){
    echo '<br> Les tables ont été créée avec succès ! </br>';
}else{
    mysqli_error($connection,$sql);
}


$sql = "CREATE TABLE IF NOT EXISTS clients (
    id int(10) auto_increment PRIMARY KEY NOT NULL, 
    firstname VARCHAR(128) NOT NULL,
    lastname VARCHAR(128)  NOT NULL,
    address VARCHAR(256) NULL,
    postal_code VARCHAR(16) NULL,
    city VARCHAR(256) NULL,
    country VARCHAR(50) NULL,
    user_id int(6) NOT NULL,         
    FOREIGN KEY (user_id) REFERENCES users(id))";

if (mysqli_query($connection,$sql)){
    echo '<br> Les tables ont été créée avec succès ! </br>';
}else{
    mysqli_error($connection,$sql);
}


$sql = "CREATE TABLE IF NOT EXISTS vehicles (
    id int(10) auto_increment PRIMARY KEY NOT NULL, 
    picture VARCHAR(256) NOT NULL, 
    marque VARCHAR(128) NOT NULL,
    modele VARCHAR(128) NOT NULL,
    puissance VARCHAR(128) NOT NULL,
    carburant VARCHAR(128) NOT NULL,
    description VARCHAR(256) NULL,
    price_ht VARCHAR(128) NOT NULL,
    tva FLOAT(3) NOT NULL)";

if (mysqli_query($connection,$sql)){
    echo '<br> Les tables ont été créée avec succès ! </br>';
}else{
    mysqli_error($connection,$sql);
}


$sql = "CREATE TABLE IF NOT EXISTS contact(
    id int(6) unsigned auto_increment primary key,
    nom varchar(20) NULL,
    prenom varchar(20)  NULL,
    mail varchar(50) NOT NULL,
    message text NOT NULL)";

if (mysqli_query($connection,$sql)){
    echo '<br> Les tables ont été créée avec succès ! </br>';
}else{
    mysqli_error($connection,$sql);
}

mysqli_close($connection);

?>





