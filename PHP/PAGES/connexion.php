<?php
session_start();
    if (isset($_SESSION['erreur'])){
        $erreur = $_SESSION['erreur'];
    } else {    
        $erreur = '';
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../COMPONENTS/important_link.php' ?>
    <link rel="stylesheet" href="../../css/connexion.css">
    <title>Connexion</title>
</head>
<body>
<?php include '../COMPONENTS/header.php' ?>

<main>
    <form action="../CRUD/traitement.php" method="post">
        <div class="mail_container">
            <input type="email" placeholder="Email" name="mail" required>
        </div>
        <div class="password_container">
            <input type="password" placeholder="Mot de passe" name="password" required>
        </div>
        <div class="button_container">
            <button type="submit" name="submit" value="Enregistrer">Connexion</button>
            <a href="../PAGES/inscription.php">Créer un compte</a>
        </div>
    </form>
</main>

<?php include '../COMPONENTS/footer.php' ?>
</body>
</html>