<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/accueil.css">
    <?php include '../COMPONENTS/important_link.php' ?>
    <title>Accueil</title>
</head>
<body>
    <?php include '../COMPONENTS/header.php' ?>


    <?php

    require '../crud/connection.php';

    $sql = "SELECT * FROM vehicles";

    if ($result = mysqli_query($connection, $sql)) {
        if (mysqli_num_rows($result) > 0) {
    ?>
            <div class="cars">

                <?php while ($row = mysqli_fetch_array($result)) {
                    $id = $row['id'];
                    $url = "http://localhost/php%20project/Location/PHP/PAGES/vehicule_details.php?id=$id";
                ?>


                    <div class=card>
                        
                        <div>
                            
                            <p><?= $row['marque'] . ' ' . $row['modele'] ?></p>
                            
                        </div>
                        
                        <img src="../../IMG/<?= $row['picture'] ?>" width="350px">

                        <div class="price">

                            <p><?= $row['price_ht'] . '€' . ' HT' . ' (TVA : ' . $row['tva'] . '%)' ?></p>

                        </div>

                        <div class="link">
                            <a href="<?= $url; ?>">Voir les détails</a>
                        </div>

                    </div>

                <?php

                }
                ?>
            </div>

    <?php
        }
    }
    mysqli_close($connection);

    ?>

    <?php include '../COMPONENTS/footer.php' ?>

</body>
</html>