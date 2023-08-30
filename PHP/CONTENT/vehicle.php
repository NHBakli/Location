<?php

session_start();

require '../crud/connection.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $vehicle_id = $_GET['id'];


$sql = "SELECT * FROM fleet WHERE id = ? ";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $vehicle_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $picture = $row['picture'];
                $marque = $row['marque'];
                $modele = $row['modele'];
                $puissance = $row['puissance'];
                $carburant = $row['carburant'];
                $description = $row['description'];
                $price_ht = $row['price_ht'];
                $tva = $row['tva'];
            }
        }
    }

    mysqli_close($connection);

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/vehicule_details.css">
    <?php include '../COMPONENTS/important_link.php' ?>
    <title>Vehicule</title>
</head>
<body>
<?php include '../COMPONENTS/header.php' ?>

<h1>Véhicule</h1>

<main>
    <div class="name_container">
        <p><?= $marque; ?> </p>
        <p><?= $modele; ?></p>
    </div>
    <div class="picture_container">
        <img src="../../IMG/<?= $picture ?>">
    </div>
    <div class="informations">
        <p><?= $puissance; ?></p>
        <p><?= $carburant . 'Chevaux' ?></p>
        <p><?= $description; ?></p>
    </div>
    <div class="price_container">
        <p><?= $price_ht; ?></p>
        <p><?= $tva; ?></p>
        <p><?= $price_ht . '€' . ' HT' . ' (TVA : ' . $tva . '%)' ?></p>
    </div>
</main>

<?php include '../COMPONENTS/footer.php' ?>

</body>
</html>