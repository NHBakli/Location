<?php

session_start();

?>

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

    <h1>Accueil</h1>

    <?php

    require '../crud/connection.php';

    $sql = "SELECT * FROM vehicles";

    if ($result = mysqli_query($connection, $sql)) {
        if (mysqli_num_rows($result) > 0) {
    ?>
            <div class="cars">

                <?php while ($row = mysqli_fetch_array($result)) {
                ?>

                    <div class=card>
                        
                        <div>
                            
                            <p><?= $row['marque'] . ' ' . $row['modele'] ?></p>
                            <p><?= $row['carburant'] ?></p>
                            
                        </div>
                        
                        <img src="../../IMG/<?= $row['picture'] ?>" width="300px">

                        <div class="price">

                            <p><?= $row['price_ht'] . '€' . ' HT' . ' (TVA : ' . $row['tva'] . '%)' ?></p>

                        </div>

                        <div>

                            <p><br> <?= $row['description'] ?></p>

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