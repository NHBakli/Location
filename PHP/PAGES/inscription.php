<?php
require_once "../CRUD/connection.php";
require_once "../CRUD/protected.php";


$nom = $pre = $mail = $mess = $password = $country = $city = $code = $address ="";
$nom_err = $pre_err = $mail_err = $err_mess = $err_password = $err_country = $err_city = $err_code = $err_address ="";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_nom = trim($_POST["nom"]);
    if(empty($input_nom)){
        $nom_err = "entrer un nom"; 
    } else{
        $nom = $input_nom;
    }
    
    $input_pre = trim($_POST["pre"]);
    if(empty($input_pre)){
        $pre_err = "entrer un prénom";     
    } else{
        $pre = $input_pre;
    }

    $input_mail = trim($_POST["mail"]);
    if(empty($input_mail)){
        $mail_err = "entrer un mail";
    } else{
        $mail = $input_mail;
    }
    
    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "entrer un mot de passe";     
    } else{
        $password = $input_password;
    }

    $input_country = trim($_POST["country"]);
    if(empty($input_country)){
        $country_err = "entrer une ville";     
    } else{
        $country = $input_country;
    }

    $input_city = trim($_POST["city"]);
    if(empty($input_city)){
        $city_err = "entrer votre villle";     
    } else{
        $city = $input_city;
    }

    $input_code = trim($_POST["code"]);
    if (empty($input_code)) {
        $code_err = "Veuillez entrer un code.";
    } else {
        $code = $input_code;
    }

    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Veuillez entrer une adresse.";
    } else {
        $address = $input_address;
    }

    if (empty($pre_err) && empty($nom_err) && empty($mail_err) && empty($password_err) && empty($country_err) && empty($city_err) && empty($code_err) && empty($address_err)){

        $password = protect_montexte($password);

        $pass = password_hash($password, PASSWORD_DEFAULT);

        $param_nom = $nom;
        $param_pre = $pre;
        $param_mail = $mail;
        $param_password = $pass;
        $param_country = $country;
        $param_city = $city;
        $param_code = $code;
        $param_address = $address;
        $role = "MEMBRE";

        // Insérer dans la première table
        $sql_users = "INSERT INTO users (login, password, role) VALUES (?, ?, ?)";
        $stmt_users = mysqli_prepare($connection, $sql_users);
        mysqli_stmt_bind_param($stmt_users, "sss", $param_mail, $param_password, $role);

        if (mysqli_stmt_execute($stmt_users)) {

            $user_id = mysqli_insert_id($connection);
            // Insérer dans la deuxième table
            $sql_clients = "INSERT INTO clients (user_id, firstname, lastname, address, postal_code, city, country) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_clients = mysqli_prepare($connection, $sql_clients);
            mysqli_stmt_bind_param($stmt_clients, "sssssss", $user_id, $param_nom, $param_pre, $param_address, $param_code, $param_city, $param_country);

            if (mysqli_stmt_execute($stmt_clients)) {
                // Success
                mysqli_close($connection);
                header("location: ../PAGES/accueil.php");
                exit();
            } else {
                echo "Erreur lors de l'insertion dans la table .";
            }
            mysqli_stmt_close($stmt_clients);
} else {
    echo "Erreur lors de l'insertion dans la table 'users'.";
}
mysqli_stmt_close($stmt_users);
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/inscription.css">
    <?php include '../COMPONENTS/important_link.php' ?>
    <title>Inscription</title>
</head>
<body>
<?php include '../COMPONENTS/header.php' ?>

<main>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post" class="inscription">
            <div class="container_top">
                <div class="firstname_container">
                    <input type="text" placeholder="Nom" name="nom" required>
                </div>
                <div class="lastname_container">
                    <input type="text" placeholder="Prénom" name="pre" required>
                </div> 
            </div>
            <div class="mail_container">
                <input type="email" placeholder="Email" name="mail" required>
            </div>
            <div class="password_container">
                <input type="password" placeholder="Mot de passe" name="password" required>
            </div>
            <div class="container_item_adress">
                <div class="country_container">
                    <input type="text" placeholder="Pays" name="country" required>
                </div>
                <div class="city_container">
                    <input type="text" placeholder="Ville" name="city" required>
                </div>
                <div class="adress_code_container">
                    <input type="text" placeholder="Code postal" name="code" required>
                </div> 
            </div> 
            <div class="address_container">
                <input type="text" placeholder="Adresse" name="address" required>
            </div>
            <div class="button_container">
                <button type="submit" name="submit" value="Enregistrer">S'inscrire</button>
                <a href="../PAGES/connexion.php">Vous avez déjà un compte</a>
            </div>
        </form>
    </div>
</main>


<?php include '../COMPONENTS/footer.php' ?>
</body>
</html>