<?php
session_start();

require '../CRUD/connection.php';
require '../CRUD/protected.php';
?>

<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_nom = trim($_POST["nom"]);
    $input_prenom = trim($_POST["prenom"]);
    $input_address = trim($_POST["address"]);
    $input_cp = trim($_POST["code"]);
    $input_ville = trim($_POST["city"]);
    $input_country = trim($_POST["country"]);
    $input_email = trim($_POST["email"]);


    $update_email = "UPDATE users SET login=? WHERE id=?";
    $update_email_stmt = mysqli_prepare($connection, $update_email);
    mysqli_stmt_bind_param($update_email_stmt, "si", $input_email, $_SESSION['id']);

    $sql = "UPDATE clients SET firstname=?, lastname=?, address=?, postal_code=?, city=?, country = ? WHERE user_id=?";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssi", $param_nom, $param_prenom, $param_address, $param_cp, $param_ville, $param_country, $param_user_id);
    
        $param_nom = $input_nom;
        $param_prenom = $input_prenom;
        $param_address = $input_address;
        $param_cp = $input_cp;
        $param_ville = $input_ville;
        $param_country = $input_country;
        $param_user_id = $_SESSION['id'];

        if(mysqli_stmt_execute($stmt)){
            if(mysqli_stmt_execute($update_email_stmt)){
            header("location: ./espace_client.php");
            exit();
            }
        } else { 
            echo "Oops ! Une erreur est survenue, veuillez réessayer plus tard.";
        }

        mysqli_stmt_close($stmt, $update_email_stmt);
    }

    mysqli_close($connection);
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/espace_clients_update.css">
    <?php include '../COMPONENTS/important_link.php' ?>
    <title>Update client</title>
</head>
<body>
<?php include '../COMPONENTS/header.php' ?>

<main>
    <div class="container_input">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post" class="update">
            <div class="container_top">
                <div class="firstname_container">
                    <input type="text" placeholder="Nom" name="nom" >
                </div>
                <div class="lastname_container">
                    <input type="text" placeholder="Prénom" name="prenom" >
                </div> 
            </div>
            <div class="mail_container">
                    <input type="email" placeholder="Email" name="email" >
                </div> 
            <div class="container_item_adress">
                <div class="address_container">
                    <input type="text" placeholder="Adresse" name="address" >
                </div>
                <div class="city_container">
                    <input type="text" placeholder="Ville" name="city" >
                </div>
                <div class="adress_code_container">
                    <input type="text" placeholder="Code postal" name="code" >
                </div> 
                <div class="country_container">
                    <input type="text" placeholder="Pays" name="country" >
                </div>
            </div> 
            <div class="button_container">
                <div class="button_valid">
                    <button class="valid" type="submit" name="modified" value="Enregistrer">Valider</button>
                </div>
            </div>
            </form>
            <div class="button_cancel">
                <button class="cancel" type="submit" name="cancel" value="cancel"><a href="./espace_client.php">Annuler</a></button>
            </div>
    </div>
</main>
<?php include '../COMPONENTS/footer.php' ?>
</body>
</html>