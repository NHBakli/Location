<?php 
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
    
    
    $sql = "UPDATE vehicles SET picture=?, marque=?, modele=?, puissance=?, carburant=?, description=?, price_ht=?, tva=? WHERE id=?";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssssdi", $param_image, $param_marque, $param_modele, $param_puissance, $param_carburant, $param_description, $param_prix_ht, $param_tva, $param_id);
    
        $param_image = $image;
        $param_marque = $marque;
        $param_modele = $modele;
        $param_puissance = $puissance;
        $param_carburant = $carburant;
        $param_description = $description;
        $param_prix_ht = $prix_ht;
        $param_tva = $tva;


            if(mysqli_stmt_execute($stmt)){
                header("Location: ./index_vehicule.php");
                exit();
            }else{ 
                echo "Oops ! erreur inattendu, rééssayez plus tard !!!";
            }
        }

    mysqli_close($connection);
    }

else {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = trim($_GET['id']);

        $sql = "SELECT * FROM vehicles WHERE id=?";

        if ($stmt = mysqli_prepare($connection, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $reference = $row['Référence'];
                    $categorie = $row['Catégorie'];
                    $price = $row['puht'];
                    $tva = $row['tva'];
                    $description = $row['Description'];
                    $stock = $row['Stock'];
                    $id = $row['id'];
                } else {
                    header('Location: ./index_Produits.php');
                    exit();
                }
            } else {
                echo "Oops ! erreur inattendu, rééssayez plus tard ou parlez en au dev du site qui a du faire de la merde";
            }
        }
    } else {
        header('Location: ./index_Produits.php');
        exit();
    }
}


?>