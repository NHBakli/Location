<?php 
session_start();

$_SESSION['erreur'] = '';
$_SESSION['login'] = '';
$_SESSION['role'] = 'MEMBRE';

require_once '../CRUD/protected.php';
require_once "../CRUD/connection.php";

$erreur = '';


if(!empty($_POST['login'])){
    $login = $_POST['login'];
}else{
    $_SESSION['erreur'] = "Champ login vide";
    header('../PAGES/inscription.php');
    exit();
}

if(!empty($_POST['password'])){
    $password = $_POST['password'];
}else{
    $_SESSION['erreur'] = "Champ Mot de passe vide";
    header('Location: ../PAGES/connexion.php');
    exit();
}


$login_ok = protect_montexte($login);
$password_ok = protect_montexte($password);

$sql = "SELECT * FROM users";


if ($result = mysqli_query($conn, $sql)){
    if (mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result)){
            if(($login_ok == $row['login']) && (password_verify($password_ok, $row['password']))){
                $_SESSION['login'] = "ok";
                $_SESSION['role'] = $row['role'];
                $valide = "ok";
                $_SESSION['erreur'] = '';
                header('Location: ./index.php');
            }
        }
        if($valide != "ok"){
            $_SESSION['erreur'] = "Login ou mot de passe incorrect !";
            header('../PAGES/inscription.php');
            exit();
        }
    }
}

?>