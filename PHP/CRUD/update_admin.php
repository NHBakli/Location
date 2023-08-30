<?php

session_start();

// Requête à utiliser une fois connecté, penser à renseigner login et mdp
// http://localhost/VSCode\Github\Location\PHP\CRUD/role.php?login="?"&password=123456789ABCDEF123456789AB

require_once './connection.php';
require_once './protect.php';

$update_admin = protect_imput($_GET['login']);
$password_admin = protect_imput($_GET['password']);

if ($password_admin == "123456789ABCDEF123456789AB") { /* Mdp au choix */
    $sql = "UPDATE users SET role=? WHERE login=?";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, 'ss', $param_role, $param_login);
        $param_role = "ADMIN";
        $param_login = $update_admin;

        if (mysqli_stmt_execute($stmt)) {
            mysqli_close($connection);
            header('Location: ../CONTENT/logout.php');
            exit();
        }
    }
} else {
    header('Location: ../CONTENT/logout.php');
    exit();
}

?>
