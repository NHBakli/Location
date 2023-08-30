<?php

session_start();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/header.css">
    <link rel="stylesheet" href="../../CSS/home.css">
    <link rel="stylesheet" href="../../CSS/footer.css">
    <title>Accueil</title>
</head>

<body>

    <?php include '../COMPONENTS/header.php' ?>

    <main>

        <h1>Accueil</h1>

        <h2>Flotte de véhicules disponibles à la location</h2>

        <?php

        require '../CRUD/connection.php';

        $sql = "SELECT * FROM fleet";

        if ($result = mysqli_query($connection, $sql)) {
            if (mysqli_num_rows($result) > 0) {

        ?>

                <div class="cars">

                    <?php
                    
                    while ($row = mysqli_fetch_array($result)) {
                        $id = $row['id'];
                        $url = "http://localhost/VSCode/Github/Location/PHP/CONTENT/vehicle.php?id=$id";
                        
                    ?>

                        <div class=card>

                            <a href="<?= $url; ?>" title='Voir les détails'>Voir les détails</a>
                            <img src="../../IMG/<?= $row['photo'] ?>" width="300px">

                            <div>

                                <p><?= $row['brand'] . ' ' . $row['model'] ?></p>
                                <p><?= $row['power'] . ' ' ?></p>
                                <p><?= $row['fuel'] ?></p>
                                <p><?= $row['description'] ?></p>

                            </div>

                            <div class="price">

                                <p><?= $row['price_ht'] . '€' . ' HT' . ' (TVA : ' . $row['tva'] . '%)' ?></p>

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

    </main>

    <?php include '../COMPONENTS/footer.php' ?>

</body>

</html>