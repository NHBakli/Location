<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'ADMIN') {
    header('Location: ../../../index.php');
    exit();
}

require '../../CRUD/connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (empty(trim($id))) {
        header('Location: ./index_user.php');
        exit();
    }
} else {
    header('Location: ./index_user.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql_delete_clients = "DELETE FROM clients WHERE user_id=?";
    if ($stmt_delete_clients = mysqli_prepare($connection, $sql_delete_clients)) {
        mysqli_stmt_bind_param($stmt_delete_clients, "i", $param_id);

        $param_id = $id;

        if (mysqli_stmt_execute($stmt_delete_clients)) {
            $sql_delete_user = "DELETE FROM users WHERE id=?";
            if ($stmt_delete_user = mysqli_prepare($connection, $sql_delete_user)) {
                mysqli_stmt_bind_param($stmt_delete_user, "i", $param_id);

                if (mysqli_stmt_execute($stmt_delete_user)) {
                    header("Location: ./index_user.php");
                    exit();
                } else {
                    echo "Erreur de suppression de l'utilisateur";
                }
            } else {
                echo "Erreur de préparation de la requête de suppression d'utilisateur";
            }
        } else {
            echo "Erreur de suppression des enregistrements clients liés";
        }
    } else {
        echo "Erreur de préparation de la requête de suppression de clients";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../CSS/delete.css">
    <title>Suppression d'un utilisateur</title>
</head>

<body>
    <div>
        <div>
            <div>
                <div>
                    <h2>Suppression d'un utilisateur</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" method="post">
                        <div>
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>" />
                            <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>
                            <p>
                                <input type="submit" value="Oui">
                                <a href="./index_user.php">Non</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
