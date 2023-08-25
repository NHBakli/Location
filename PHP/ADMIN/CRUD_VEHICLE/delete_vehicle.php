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

include "../../CRUD/connection.php";

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = trim($_POST['id']);

    // Récupérer le nom de l'image associée au véhicule
    $sql_select_image = "SELECT picture FROM vehicles WHERE id=?";
    if ($stmt_select_image = mysqli_prepare($connection, $sql_select_image)) {
        mysqli_stmt_bind_param($stmt_select_image, "i", $param_id);
        $param_id = $id;
        if (mysqli_stmt_execute($stmt_select_image)) {
            $result_image = mysqli_stmt_get_result($stmt_select_image);
            if (mysqli_num_rows($result_image) == 1) {
                $row_image = mysqli_fetch_assoc($result_image);
                $image_name = $row_image['picture'];

                // Supprimer l'image du dossier IMG
                $image_path = "../../../IMG/" . $image_name;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }

                // Supprimer l'enregistrement de la base de données
                $sql_delete = "DELETE FROM vehicles WHERE id=?";
                if ($stmt_delete = mysqli_prepare($connection, $sql_delete)) {
                    mysqli_stmt_bind_param($stmt_delete, "i", $param_id);

                    if (mysqli_stmt_execute($stmt_delete)) {
                        header("Location: ./admin_vehicle.php");
                        exit();
                    } else {
                        echo "Erreur de suppression";
                    }
                }

                mysqli_close($connection);
            }
        }
    }
} else {
    if (empty(trim($_GET['id']))) {
        header('Location: ../index_admin.php');
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Suppression d'un véhicule</title>
</head>

<body>
    <div>
        <div>
            <div>
                <div>
                    <h2>Suppression d'un véhicule</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div>
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
                            <p>Êtes vous sûr de vouloir supprimer ce véhicule ?</p>
                            <p>
                                <input type="submit" value="Oui">
                                <a href="./admin_vehicle.php">Non</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
