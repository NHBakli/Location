<?php

session_start();

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    if ($role != 'ADMIN') {
        header('location: ../../../index.php');
    }
} else {
    $role = '';
    if ($role != 'ADMIN') {
        header('location: ../../../index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/admin.css">
    <?php include '../../COMPONENTS/important_link.php' ?>
    <title>Accueil Admin</title>
</head>
<body>
<?php include '../ADMIN_COMPONENTS/header_admin.php' ?>

<h1>Accueil Admin</h1>

</body>
</html>