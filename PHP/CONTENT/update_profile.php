<?php

session_start();

require '../CRUD/connection.php';
require '../CRUD/protect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $input_lastname = trim($_POST["lastname"]);
    $input_firstname = trim($_POST["firstname"]);
    $input_email = trim($_POST["email"]);
    $input_address = trim($_POST["address"]);
    $input_postal_code = trim($_POST["postal_code"]);
    $input_city = trim($_POST["city"]);
    $input_country = trim($_POST["country"]);

    $update_email = "UPDATE users SET login=? WHERE id=?";
    $update_email_stmt = mysqli_prepare($connection, $update_email);
    mysqli_stmt_bind_param($update_email_stmt, "si", $input_email, $_SESSION['id']);

    $sql = "UPDATE customers SET lastname=?, firstname=?, address=?, postal_code=?, city=?, country =? WHERE user_id=?";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssi", $param_lastname, $param_firstname, $param_address, $param_postal_code, $param_city, $param_country, $param_user_id);

        $param_lastname = $input_lastname;
        $param_firstname = $input_firstname;
        $param_address = $input_address;
        $param_postal_code = $input_postal_code;
        $param_city = $input_city;
        $param_country = $input_country;
        $param_user_id = $_SESSION['id'];

        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_execute($update_email_stmt)) {
                header("location: ./profile.php");
                exit();
            }
        } else {
            echo "Oops ! Une erreur est survenue, veuillez réessayer plus tard.";
        }

        mysqli_stmt_close($stmt, $update_email_stmt);
    }

    mysqli_close($connection);
}

$sql = "SELECT * FROM customers";

if ($result_clients = mysqli_query($connection, $sql)) {
    if (mysqli_num_rows($result_clients) > 0) {
        $row = mysqli_fetch_array($result_clients);

        $input_lastname = $row['lastname'];
        $input_firstname = $row['firstname'];
        $input_address = $row['address'];
        $input_postal_code = $row['postal_code'];
        $input_city = $row['city'];
        $input_country = $row['country'];
    }
}

$sql_users = "SELECT login FROM users";

if ($result_users = mysqli_query($connection, $sql_users)) {
    if (mysqli_num_rows($result_users) > 0) {
        $row_users = mysqli_fetch_array($result_users);

        $input_email = $row_users['login'];
    }
}

mysqli_close($connection);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/header.css">
    <link rel="stylesheet" href="../../CSS/update_profile.css">
    <link rel="stylesheet" href="../../CSS/footer.css">
    <title>Update client</title>
</head>

<body>

    <?php include '../COMPONENTS/header.php' ?>

    <main>
        <div class="container_input">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="update">
                <div class="container_top">
                    <div class="lastname_container">
                        <input type="text" placeholder="Nom" name="lastname" value="<?= $input_lastname ?>">
                    </div>
                    <div class="firstname_container">
                        <input type="text" placeholder="Prenom" name="firstname" value="<?= $input_firstname ?>">
                    </div>
                </div>
                <div class="mail_container">
                    <input type="email" placeholder="Adresse mail" name="email" value="<?= $input_email ?>">
                </div>
                <div class="container_item_adress">
                    <div class="address_container">
                        <input type="text" name="address" placeholder="address" value="<?= $input_address ?>">
                    </div>
                    <div class="adress_code_container">
                        <input type="text" placeholder="Code postal" name="postal_code" value="<?= $input_postal_code ?>">
                    </div>
                    <div class="city_container">
                        <input type="text" placeholder="Ville" name="city" value="<?= $input_city ?>">
                    </div>
                    <div class="country_container">
                        <input type="text" placeholder="Pays" name="country" value="<?= $input_country ?>">
                    </div>
                </div>
                <div class="button_container">
                    <div class="button_valid">
                        <button class="valid" type="submit" name="modified" value="Enregistrer">Enregistrer</button>
                    </div>
                </div>
            </form>
            <div class="button_cancel">
                <button class="cancel" type="submit" name="cancel" value="cancel"><a href="./profile.php">Annuler</a></button>
            </div>
        </div>
    </main>

    <?php include '../COMPONENTS/footer.php' ?>

</body>

</html>