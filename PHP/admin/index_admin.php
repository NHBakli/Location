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
    <?php include '../COMPONENTS/important_link.php' ?>
    <title>Accueil Admin</title>
</head>

<body>

    <?php include '../COMPONENTS/header.php' ?>

    <h1>Utlisateurs :</h1>

    <?php
    require '../CRUD/connection.php';

    $sql = "SELECT * FROM users";

    if ($result = mysqli_query($connection, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Login</th>';
            echo '<th>Role</th>';
            echo '<th>Compte vérifié</th>';
            echo '<th>Outils</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_array($result)) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['login'] . '</td>';
                echo '<td>' . $row['role'] . '</td>';
                echo '<td>' . $row['isVerified'] . '</td>';
                echo '<td>';
                echo '<a href="./update.php?id=' . $row['id'] . '"><iconify-icon icon="material-symbols:edit"></iconify-icon> </a>';
                echo '<a href="./delete.php?id=' . $row['id'] . '"><iconify-icon icon="ic:baseline-delete"></iconify-icon></a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div>Aucun utilisateur trouvé.</div>';
        }
    } else {
        echo '<div>Erreur de connexion à la BDD.</div>';
    }
    mysqli_close($connection);
    ?>

    <?php include '../COMPONENTS/footer.php' ?>

</body>

</html>