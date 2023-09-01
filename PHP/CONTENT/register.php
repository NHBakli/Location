<?php

session_start();

require_once "../CRUD/connection.php";
require_once "../CRUD/protect.php";

$lastname = $firstname = $email = $psswrd = $country = $city = $postal_code = $address = "";
$err_lastname = $err_firstname = $err_email = $err_psswrd = $err_country = $err_city = $err_postal_code = $err_address = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $input_lastname = trim($_POST["lastname"]);
    if (empty($input_lastname)) {
        $err_lastname = "Renseignez votre Nom";
    } else {
        $lastname = $input_lastname;
    }

    $input_firstname = trim($_POST["firstname"]);
    if (empty($input_firstname)) {
        $err_firstname = "Renseignez votre Prénom";
    } else {
        $firstname = $input_firstname;
    }

    $input_email = trim($_POST["email"]);
    if (empty($input_email)) {
        $email_err = "Renseignez votre Adresse mail";
    } else {
        $email = $input_email;
    }

    $input_psswrd = trim($_POST["password"]);
    if (empty($input_psswrd)) {
        $err_psswrd = "Choisissez un Mot de passe";
    } else {
        $psswrd = $input_psswrd;
    }

    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $err_address = "Renseignez votre Adresse";
    } else {
        $address = $input_address;
    }

    $input_postal_code = trim($_POST["postal_code"]);
    if (empty($input_postal_code)) {
        $err_postal_code = "Renseignez votre Code postal";
    } else {
        $postal_code = $input_postal_code;
    }

    $input_city = trim($_POST["city"]);
    if (empty($input_city)) {
        $err_city = "Renseignez votre Ville";
    } else {
        $city = $input_city;
    }

    $input_country = trim($_POST["country"]);
    if (empty($input_country)) {
        $err_country = "Renseignez votre Pays";
    } else {
        $country = $input_country;
    }

    if (empty($err_lastname) && empty($err_firstname) && empty($err_email) && empty($err_psswrd) && empty($err_address) && empty($err_postal_code) && empty($err_city) && empty($err_country)) {

        $psswrd = protect_imput($psswrd);
        $psswrd_hashed = password_hash($psswrd, PASSWORD_DEFAULT);

        $param_lastname = $lastname;
        $param_firstname = $firstname;
        $param_email = $email;
        $param_psswrd_hashed = $psswrd_hashed;
        $param_address = $address;
        $param_postal_code = $postal_code;
        $param_city = $city;
        $param_country = $country;
        $role = "MEMBRE";

        // Insertion dans la table « users »
        $sql_users = "INSERT INTO users (login, password, role) VALUES (?, ?, ?)";
        $stmt_users = mysqli_prepare($connection, $sql_users);
        mysqli_stmt_bind_param($stmt_users, "sss", $param_email, $param_psswrd_hashed, $role);

        if (mysqli_stmt_execute($stmt_users)) {

            $param_user_id = mysqli_insert_id($connection);
            // Insertion dans la table « customers »
            $sql_customers = "INSERT INTO customers (lastname, firstname, country, city, postal_code, address, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_customers = mysqli_prepare($connection, $sql_customers);
            mysqli_stmt_bind_param($stmt_customers, "ssssssi", $param_lastname, $param_firstname, $param_address, $param_postal_code, $param_city, $param_country, $param_user_id);

            if (mysqli_stmt_execute($stmt_customers)) {

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

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="inscription">

                <div class="container_top">
                    <div class="lastname_container">
                        <input type="text" placeholder="Nom" name="lastname" required>
                    </div>
                    <div class="firstname_container">
                        <input type="text" placeholder="Prénom" name="firstname" required>
                    </div>
                </div>
                <div class="mail_container">
                    <input type="email" placeholder="Adresse mail" name="email" required>
                </div>
                <div class="password_container">
                    <input type="password" placeholder="Mot de passe" name="password" required>
                </div>
                <div class="container_item_adress">
                    <div class="address_container">
                        <input type="text" placeholder="Adresse" name="address" required>
                    </div>
                    <div class="adress_code_container">
                        <input type="text" placeholder="Code postal" name="postal_code" required>
                    </div>
                    <div class="city_container">
                        <input type="text" placeholder="Ville" name="city" required>
                    </div>
                    <div class="country_container">
                        <input type="text" placeholder="Pays" name="country" required>
                    </div>
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