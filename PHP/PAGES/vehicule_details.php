<?php session_start();

if(isset($_SESSION['users'])) {
    $_SESSION['connect'] = 'ok'; // on récup "ok"
}else{
    unset($_SESSION['connect']);
}

if(isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
}else{
    $role = '';
}

require '../crud/connection.php';

// Récuperatiion des infos dans la table vehicles
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $vehicle_id = $_GET['id'];


$sql = "SELECT * FROM vehicles WHERE id = ? ";

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

}

$moisEnFrancais = array(
    'January' => 'janvier',
    'February' => 'février',
    'March' => 'mars',
    'April' => 'avril',
    'May' => 'mai',
    'June' => 'juin',
    'July' => 'juillet',
    'August' => 'août',
    'September' => 'septembre',
    'October' => 'octobre',
    'November' => 'novembre',
    'December' => 'décembre'
);


// Traitement du calendrier 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date_actuel = date("Y-m-d");
    $dateDebut = $_POST['date_debut'];


    $dateDebutObj = new DateTime($dateDebut);

    // Formatter les dates en français avec strftime()
    $dateDebutFormatee = strftime('%e', $dateDebutObj->getTimestamp()) . ' ' . $moisEnFrancais[$dateDebutObj->format('F')] . ' ' . $dateDebutObj->format('Y');

    $user_id = $_SESSION['id'];

    $vehicle_id = $_GET['id'];


    // Insérer les dates dans la base de données 
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "INSERT INTO location (user_id, vehicles_id, start_location) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iis", $user_id, $vehicle_id, $dateDebutFormatee);

    if ($stmt->execute()) {
        header("location:./location.php");
    } else {
        echo "Erreur lors de l'insertion dans la table";
    }

    $stmt->close();
    $connection->close();
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

<main>
    <div class="name_container">
        <p class="marque"><?= $marque; ?></p>
        <p><?= $modele; ?></p>
    </div>
    <div class="picture_container">
        <img src="../../IMG/<?= $picture ?>">
    </div>
    <div class="informations">
        <p><?="<span>Chevaux : </span>" . $puissance; ?></p>
        <p><?= "<span>Carburant : </span>" . $carburant?></p>
        <p><?= "<span>Description : </span>" . $description; ?></p>
    </div>
    <div class="price_container">
        <p><?= $price_ht . '€' . ' HT' . ' (TVA : ' . $tva . '%)' ?></p>
    </div>

    <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] == 'ok') :  ?>
    <div class="location">
    <h2>Sélectionnez les dates de location :</h2>
    <form method="post">
        <label for="date_debut">Date de début :</label>
        <input type="date" name="date_debut" required>
        <br>
        <button type="submit" >Louer !</button>
    </form>
    </div>
    <?php endif; ?>
</main>

<?php include '../COMPONENTS/footer.php' ?>
</body>
</html>