<?php

session_start();

require_once "../CRUD/connection.php";
require_once "../CRUD/protect.php";

$nom = $pre = $email = $mess = $password = $country = $city = $code = $address ="";
$nom_err = $pre_err = $email_err = $err_mess = $err_password = $err_country = $err_city = $err_code = $err_address ="";

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

    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "entrer un mail";
    } else{
        $email = $input_email;
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

    if (empty($pre_err) && empty($nom_err) && empty($email_err) && empty($password_err) && empty($country_err) && empty($city_err) && empty($code_err) && empty($address_err)){

        $password = protect_imput($password);

        $pass = password_hash($password, PASSWORD_DEFAULT);

        $param_nom = $nom;
        $param_pre = $pre;
        $param_email = $email;
        $param_password = $pass;
        $param_country = $country;
        $param_city = $city;
        $param_code = $code;
        $param_address = $address;
        $role = "MEMBRE";

        // Insérer dans la première table
        $sql_users = "INSERT INTO users (login, password, role) VALUES (?, ?, ?)";
        $stmt_users = mysqli_prepare($connection, $sql_users);
        mysqli_stmt_bind_param($stmt_users, "sss", $param_email, $param_password, $role);

        if (mysqli_stmt_execute($stmt_users)) {

            $user_id = mysqli_insert_id($connection);
            // Insérer dans la deuxième table
            $sql_customers = "INSERT INTO customers (lastname, firstname, country, city, postal_code, address, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_customers = mysqli_prepare($connection, $sql_customers);
            mysqli_stmt_bind_param($stmt_customers, "sssssss", $param_nom, $param_pre, $param_country, $param_city, $param_code, $param_address, $user_id);

            if (mysqli_stmt_execute($stmt_customers)) {
                // Success
                mysqli_close($connection);
                header("location: ../../index.php");
                exit();
            } else {
                echo "Erreur lors de l'insertion dans la table .";
            }
            mysqli_stmt_close($stmt_customers);
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
    <link rel="stylesheet" href="../../CSS/header.css">    
    <link rel="stylesheet" href="../../CSS/register.css">
    <link rel="stylesheet" href="../../CSS/footer.css">
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
                <input type="email" placeholder="Email" name="email" required>
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
                <a href="../CONTENT/login.php">Avez-vous déjà un compte ?</a>
            </div>
        </form>
    </div>
</main>

<?php include '../COMPONENTS/footer.php' ?>

</body>
</html>