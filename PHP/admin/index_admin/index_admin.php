<?php session_start(); 

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
}?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../CSS/index_admin.css">
    <link rel="stylesheet" href="../../../CSS/header.css">
    <link rel="stylesheet" href="../../../CSS/footer.css">
    <?php include '../../COMPONENTS/important_link.php' ?>
    <title>Pannel Admin</title>
</head>
<body>
<?php include '../ADMIN_COMPONENTS/header_admin.php' ?>

<?php include '../ADMIN_COMPONENTS/grafic.php'; ?>



<?php include '../../COMPONENTS/footer.php' ?>
</body>
</html>