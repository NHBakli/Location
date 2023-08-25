<?php

session_start();

include "../../CRUD/connection.php";

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

$marque = $modele = $puissance = $carburant = $description = $prix_ht = $tva = "";
$marque_err = $modele_err = $puissance_err = $err_carburant = $err_description = $err_prix_ht = $err_tva = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {



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
    
    $id = $_SESSION['id'];

    $sql = "UPDATE vehicles SET marque=?, modele=?, puissance=?, carburant=?, description=?, price_ht=?, tva=? WHERE id=$id";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssd", $param_marque, $param_modele, $param_puissance, $param_carburant, $param_description, $param_prix_ht, $param_tva);
    
        $param_marque = $marque;
        $param_modele = $modele;
        $param_puissance = $puissance;
        $param_carburant = $carburant;
        $param_description = $description;
        $param_prix_ht = $prix_ht;
        $param_tva = $tva;


            if(mysqli_stmt_execute($stmt)){
                header("Location: ./admin_vehicle.php");
                exit();
            }else{ 
                echo "Erreur de connexion à la BDD";
            }
        }

    mysqli_close($connection);
    }

else {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = trim($_GET['id']);

        $_SESSION["id"] = $_GET['id'];

        $sql = "SELECT * FROM vehicles WHERE id=?";

        if ($stmt = mysqli_prepare($connection, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $marque = $row['marque'];
                    $modele = $row['modele'];
                    $puissance = $row['puissance'];
                    $carburant = $row['carburant'];
                    $description = $row['description'];
                    $price_ht = $row['price_ht'];
                    $tva = $row['tva'];
                    $id = $row['id'];
                } else {
                    header('Location: ./admin_vehicle.php');
                    exit();
                }
            } else {
                echo "Erreur de suppression";
            }
        }
    } else {
        header('Location: ./admin_vehicle.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification d'un véhicule</title>
</head>

<body>

    <div>
        <div>
            <h2>Modification du véhicule</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post" class="update" enctype="multipart/form-data">
            <div>
                <a href="edit_image.php?id=<?php echo $id; ?>" class="btn btn-primary">Editer l'image</a>
                <input type="text" name="marque" placeholder="" value="<?=$marque;?>">
                <input type="text" name="modele" placeholder="Modele" value="<?=$modele;?>">
                <input type="text" name="puissance" placeholder="Puissance" value="<?=$puissance;?>">
                <input type="text" name="carburant" placeholder="Carburant" value="<?=$carburant;?>">
                <input type="text" name="description" placeholder="Description" value="<?=$description;?>">
                <input type="text" name="prix_ht" placeholder="Prix HT" value="<?=$price_ht;?>">
                <input type="text" name="tva" placeholder="TVA" value="<?=$tva;?>">
            </div>
            <input type="submit" value="Enregistrer">
            <a href="./admin_vehicle.php">Annuler</a>
        </form>
    </div>

</body>

</html>