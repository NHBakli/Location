<?php

session_start();

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    if ($role != 'ADMIN') {
        header('location: ../../index.php');
    }
} else {
    $role = '';
    if ($role != 'ADMIN') {
        header('location: ../../index.php');
    }
}

require '../CRUD/connection.php';

$id = $_GET['id'];

if (isset($_POST['id']) && !empty($_POST['id'])) {

    $sql = "DELETE FROM users WHERE id=?";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        $param_id = trim($_POST['id']);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ./index_admin.php");
            exit();
        } else {
            echo "Erreur de suppression";
        }
    }
    mysqli_close($connection);
} else {

    if (empty(trim($_GET['id']))) {
        header('Location: ./index_admin.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Suppression d'un utilisateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div>
        <div>
            <div>
                <div>
                    <h2>Suppression d'un utilisateur</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div>
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
                            <p>Êtes vous sûr de vouloir supprimer cet utilisateur ?</p>
                            <p>
                                <input type="submit" value="Oui">
                                <a href="./admin_user.php">Non</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>