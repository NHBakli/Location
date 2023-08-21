<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/accueil.css">
    <?php include '../COMPONENTS/important_link.php' ?>
    <title>Accueil</title>
</head>
<body>
    <?php include '../COMPONENTS/header.php' ?>
    
    <?php if(isset($_SESSION['users']) && $_SESSION['users'] === 'ok') {
    echo "<p>Bienvenue, " . $_SESSION['email'] . " !</p>";
    }?>

    <?php include '../COMPONENTS/footer.php' ?>
</body>
</html>