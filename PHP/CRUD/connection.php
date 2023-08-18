<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'location';
$connection = mysqli_connect($host, $user, $pass, $db);

if(!$connection){
    die(mysqli_connect_error());
}

?>