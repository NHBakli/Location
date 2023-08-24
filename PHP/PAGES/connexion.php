<?php 

session_start();

if(isset($_POST['submit'])){
    if(isset($_POST['mail']) && isset($_POST['password'])) {
        $email = $_POST['mail'];
        $password = $_POST['password'];
        $erreur = ""; 

        include_once "../CRUD/connection.php";

        $query = "SELECT * FROM users WHERE login = '$email'";
        $result = mysqli_query($connection, $query);

        if($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if(password_verify($password, $user['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['users'] = 'ok';
                $_SESSION['role'] = $user['role'];
                $_SESSION['id'] = $user['id'];
                header("Location: ../../index.php");
                exit();
            } else {
                $erreur = "Adresse Mail ou Mot de passe incorrect !";
            }
        } else {
            $erreur = "Adresse Mail ou Mot de passe incorrect !";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../COMPONENTS/important_link.php' ?>
    <link rel="stylesheet" href="../../css/connexion.css">
    <title>Document</title>
</head>
<body>
<?php include '../COMPONENTS/header.php'; ?>

<main>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="mail_container">
            <input type="email" placeholder="Email" name="mail" required>
        </div>
        <div class="password_container">
            <input type="password" placeholder="Mot de passe" name="password" required>
        </div>
        <div class="button_container">
            <button type="submit" name="submit" value="Enregistrer">Se connecter</button>
            <a href="../PAGES/inscription.php">Créer un compte</a>
        </div>
    </form>
</main>

<?php include '../COMPONENTS/footer.php' ?>
</body>
</html>