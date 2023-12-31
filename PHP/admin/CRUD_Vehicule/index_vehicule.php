<?php
session_start();
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    if ($role != 'ADMIN') {
        header('location: ../../index.php');
    }
} else {
    $role = '';
    if ($role != 'ADMIN') {
        header('location: ../../index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/index_admin.css">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="../../../css/panel_vehicule.css">
    <link rel="stylesheet" href="../../../css/header.css">
    <link rel="stylesheet" href="../../../css/footer.css">
    <title>Accueil Admin Véhicules</title>
</head>

<body>

<?php include '../../ADMIN/ADMIN_COMPONENTS/header_admin.php' ?>

    <h1>Véhicules :</h1>

    <?php

    include "../../CRUD/connection.php";

    $sql = "SELECT * FROM vehicles";

    if ($result = mysqli_query($connection, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Photo</th>';
            echo '<th>Marque</th>';
            echo '<th>Modèle</th>';
            echo '<th>Puissance (CV)</th>';
            echo '<th>Carburant</th>';
            echo '<th>Description</th>';
            echo '<th>Prix HT</th>';
            echo '<th>TVA</th>';
            echo '<th>Outils</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_array($result)) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td><img src="../../../IMG/' . $row['picture'] . '" alt="Image du véhicule"></td>';
                echo '<td>' . $row['marque'] . '</td>';
                echo '<td>' . $row['modele'] . '</td>';
                echo '<td>' . $row['puissance'] . '</td>';
                echo '<td>' . $row['carburant'] . '</td>';
                echo '<td>' . $row['description'] . '</td>';
                echo '<td>' . $row['price_ht'] . '</td>';
                echo '<td>' . $row['tva'] . '</td>';
                echo '<td>';
                echo '<a href="../CRUD_Vehicule/edit_vehicule.php?id=' . $row['id'] . '"><iconify-icon icon="material-symbols:edit"></iconify-icon> </a>';
                echo '<a href="../CRUD_Vehicule/delete_vehicule.php?id=' . $row['id'] . '"><iconify-icon icon="ic:baseline-delete"></iconify-icon></a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div>Aucun véhicule trouvé.</div>';
        }
    } else {
        echo '<div>Erreur de connexion à la BDD.</div>';
    } 
    mysqli_close($connection);
    ?>

<a href="./create_vehicule.php">Créer un Véhicule</a>

<?php include '../../COMPONENTS/footer.php' ?>

</body>

</html>