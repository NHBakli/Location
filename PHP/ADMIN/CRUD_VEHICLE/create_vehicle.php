<?php 
include "../../CRUD/connection.php";

session_start();

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    if ($role != 'ADMIN') {
        header('location: ../../../index.php');
    }
} else {
    $role = '';
    if ($role != 'ADMIN') {
        header('location: ../../../index.php');
    }
}

$image = $marque = $modele = $puissance = $carburant = $description = $prix_ht = $tva = "";
$image_err = $marque_err = $modele_err = $puissance_err = $err_carburant = $err_description = $err_prix_ht = $err_tva = "";

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
    } else {
        $image_err = "Veuillez sélectionner une image.";
    }

    $input_marque = trim($_POST["marque"]);
    if (empty($input_marque)) {
        $marque_err = "Entrer une marque";
    } else {
        $marque = $input_marque;
    }

    $input_modele = trim($_POST["modele"]);
    if (empty($input_modele)) {
        $modele_err = "Entrer une modele";
    } else {
        $modele = $input_modele;
    }

    $input_puissance = trim($_POST["puissance"]);
    if (empty($input_puissance)) {
        $puissance_err = "Entrer une puissance";
    } else {
        $puissance = $input_puissance;
    }

    $input_carburant = trim($_POST["carburant"]);
    if (empty($input_carburant)) {
        $carburant_err = "Entrer un carburant";
    } else {
        $carburant = $input_carburant;
    }

    $input_description = trim($_POST["description"]);
    if (empty($input_description)) {
        $description_err = "Entrer une description";
    } else {
        $description = $input_description;
    }

    $input_prix_ht = trim($_POST["prix_ht"]);
    if (empty($input_prix_ht)) {
        $prix_ht_err = "Entrer un prix hors taxe";
    } else {
        $prix_ht = $input_prix_ht;
    }

    $input_tva = trim($_POST["tva"]);
    if (empty($input_tva)) {
        $tva_err = "Entrer une TVA";
    } else {
        $tva = $input_tva;
    }

    if (empty($image_err) && empty($marque_err) && empty($modele_err) && empty($puissance_err) && empty($carburant_err) && empty($description_err) && empty($prix_ht_err) && empty($tva_err)) {


        $param_image = $image;
        $param_marque = $marque;
        $param_modele = $modele;
        $param_puissance = $puissance;
        $param_carburant = $carburant;
        $param_description = $description;
        $param_prix_ht = $prix_ht;
        $param_tva = $tva;
        


        $sql = "INSERT INTO vehicles (picture, marque, modele, puissance, carburant, description, price_ht, tva) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssd", $image, $marque, $modele, $puissance, $carburant, $description, $prix_ht, $tva);

        if (mysqli_stmt_execute($stmt)) {
            // Success
            mysqli_stmt_close($stmt);
            mysqli_close($connection);
            header("location: ./admin_vehicle.php");
            exit();
        } else {
            echo "Erreur lors de l'insertion dans la table.";
        }
    } else {
        echo "Erreur lors de l'insertion dans la table.";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/create_vehicle.css">
    <link rel="stylesheet" href="../../../css/header.css">
    <link rel="stylesheet" href="../../../css/footer.css">
    <title>Pannel Vehicule</title>
</head>

<body>

<?php include '../../ADMIN/ADMIN_COMPONENTS/header_admin.php' ?>

<main>

    <div class="categorie">

        <p>Photo</p>
        <p>Marque</p>
        <p>Modèle</p>
        <p>Puissance</p>
        <p>Carburant</p>
        <p>Description</p>
        <p>Prix HT</p>
        <p>TVA</p>

    </div class="create">
    
        <form action="" method="POST" enctype="multipart/form-data"> 
            <div class="affichage">
            <label>Ajouter une photo</label>
            <input type="file" name="image">
            <input type="text" name="marque" placeholder="Marque">
            <input type="text" name="modele" placeholder="Modele">
            <input type="text" name="puissance" placeholder="Puissance">
            <input type="text" name="carburant" placeholder="Carburant">
            <input type="text" name="description" placeholder="Description">
            <input type="text" name="prix_ht" placeholder="Prix HT">
            <input type="text" name="tva" placeholder="TVA">

            <button>Valider</button>
            <a href="./admin_vehicle.php">Annuler</a>
        </form>
    </div>

</main>

<?php include '../../COMPONENTS/footer.php' ?>
</body>
</html>