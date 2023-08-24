<?php
session_start();

require_once './connection.php';
require_once './protected.php';

$login_ok = protect_montexte($_GET['login']);
$password_ok = protect_montexte($_GET['password']);

// Requête à utiliser une fois connecté, penser à renseigner login et mdp
// http://localhost/VSCode\Github\Location\PHP\CRUD/role.php?login="?"&password="?"

if ($password_ok == "") { /* Choisir un mdp */
    $sql = "UPDATE users SET role=? WHERE login=?";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, 'ss', $param_role, $param_login);
        $param_role = "ADMIN";
        $param_login = $login_ok;

        if (mysqli_stmt_execute($stmt)) {
            mysqli_close($connection);
            header('Location: ../deconnexion.php');
            exit();
        }
    }
} else {
    header('Location: ../../index.php');
    exit();
}

?>
