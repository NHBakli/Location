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

$image = "";
$image_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $img_nom = $_FILES['image']['name'];
    $tmp_nom = $_FILES['image']['tmp_name'];
    $time = time();
    $nouveau_nom_img = $time . $img_nom;
    $deplacer_img = move_uploaded_file($tmp_nom, "../../../IMG/" . $nouveau_nom_img);
    if (!$deplacer_img) {
        $image_err = "Erreur lors de l'upload de l'image.";
    } else {
        $image = $nouveau_nom_img;
    }

    $id = $_SESSION['id'];
    
    // Récupérer le nom de l'ancienne image associée au véhicule
    $sql_select_old_image = "SELECT picture FROM vehicles WHERE id=?";
    if ($stmt_select_old_image = mysqli_prepare($connection, $sql_select_old_image)) {
        mysqli_stmt_bind_param($stmt_select_old_image, "i", $param_id);
        $param_id = $id;
        if (mysqli_stmt_execute($stmt_select_old_image)) {
            $result_old_image = mysqli_stmt_get_result($stmt_select_old_image);
            if (mysqli_num_rows($result_old_image) == 1) {
                $row_old_image = mysqli_fetch_assoc($result_old_image);
                $old_image_name = $row_old_image['picture'];


                // Supprimer l'ancienne image du dossier IMG
                $old_image_path = "../../../IMG/" . $old_image_name;
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }

                // Envoie vers la BDD
                $sql = "UPDATE vehicles SET picture=? WHERE id=?";
                if ($stmt = mysqli_prepare($connection, $sql)) {
                    mysqli_stmt_bind_param($stmt, "si", $param_image, $param_id);
                    $param_image = $image;
                    $param_id = $id;
                    if (mysqli_stmt_execute($stmt)) {
                        header("Location: ./admin_vehicle.php");
                        exit();
                    } else {
                        echo "Erreur de modification";
                    }
                }
                mysqli_close($connection);
            }
        }
    }
}
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit image</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post" class="update" enctype="multipart/form-data">
    <div>
        <input type="file" name="image" value="<?=$image;?>">
    </div>
    <input type="submit" value="Enregistrer">
    <a href="./admin_vehicle.php">Annuler</a>
    </form>
</body>
</html>