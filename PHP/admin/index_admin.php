<?php
session_start();

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    if ($role != 'ADMIN') {
        header('location: ../index.php');
    }
} else {
    $role = '';
    if ($role != 'admin') {
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
    <?php include '../COMPONENTS/important_link.php' ?>
    <title>Accueil Admin</title>
</head>

<body>

    <?php include '../COMPONENTS/header.php' ?>

    <h1>Utlisateurs :</h1>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
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
                                echo '<a href="./update.php?id=' . $row['id'] . '"></span> </a>';
                                echo '<a href="./delete.php?id=' . $row['id'] . '" class="mr-3" title="update" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo '<div class="alert alert-danger"><em>Aucun utilisateur trouvé.</em></div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger"><em>Aucun utilisateur trouvé.</em></div>';
                    }
                    mysqli_close($connection);
                    ?>
                </div>
            </div>
        </div>
    </div>


    <?php include '../COMPONENTS/footer.php' ?>

</body>

</html>