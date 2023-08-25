<?php session_start();?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/espace_client.css">
    <?php include '../COMPONENTS/important_link.php' ?>
    <title>Espace Client</title>
</head>
<body>

<!--  Affichage des informations  -->
<?php include '../COMPONENTS/header.php' ?>

<?php

require '../CRUD/connection.php';
require '../CRUD/protected.php';

$query = "SELECT * FROM users
        JOIN clients ON users.id = clients.user_id
        WHERE user_id = ?";

if(isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $stmt = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param($stmt, "i", $id); 

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);

        ?>
        <main>
            <div class="container_p">
                <div class="container_img">
                    <h2>Informations</h2>
                    <img src="../../IMG/user.png" alt="user">
                </div>
                <div class="name_container">
                    <p>Nom : <?php echo $user_data['lastname'];?></p>
                    <p>Prénom : <?php echo $user_data['firstname'];?></p>
                </div>
                <div class="container_information">
                    <p>Adresse : <?php echo $user_data['address'];?></p>
                    <p>Code postal : <?php echo $user_data['postal_code'];?></p>
                    <p>Ville : <?php echo $user_data['city'];?></p>
                    <p>Email : <?php echo $user_data['login'];?></p">
                </div>
                <div class="button_modified">
                <button type="submit" class="modified" name="modified" value="Enregistrer"><a href="./espace_client_update.php">Modifier</a></button>
                </div>
            </div>
        </main>
        <?php
    }
}
?>

<?php include '../COMPONENTS/footer.php' ?>

</body>
</html>