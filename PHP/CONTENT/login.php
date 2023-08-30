<?php

session_start();

if (isset($_POST['submit'])) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $psswrd = $_POST['password'];
        $error = "";

        include_once "../CRUD/connection.php";

        $sql = "SELECT * FROM users WHERE login = '$email'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($psswrd, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $user['role'];
                $_SESSION['users'] = 'ok';
                // Utilité à retrouver
                header("Location: ../../index.php");
                exit();
            } else {
                $error = "Mot de passe incorrect";
            }

        } else {
            $error = "Adresse mail incorrecte";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/header.css">
    <link rel="stylesheet" href="../../CSS/login.css">
    <link rel="stylesheet" href="../../CSS/footer.css">
    <title>Connexion</title>
</head>

<body>

    <?php include '../COMPONENTS/header.php'; ?>

    <main>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

            <div class="mail_container">
                <input type="email" placeholder="Adresse mail" name="email" required>
            </div>

            <div class="password_container">
                <input type="password" placeholder="Mot de passe" name="password" required>
            </div>

            <div class="button_container">
                <button type="submit" name="submit" value="Enregistrer">Connexion</button>
                <a href="../CONTENT/register.php">Créer votre compte</a>
            </div>

        </form>

    </main>

    <?php include '../COMPONENTS/footer.php' ?>

</body>

</html>