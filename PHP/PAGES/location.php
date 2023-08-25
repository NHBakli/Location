<?php
session_start();

include "../CRUD/connection.php";


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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['rendre']) && isset($_POST['location_id'])) {
    $now = date('Y-m-d'); 
    $now = new DateTime($now);
    $now = strftime('%e', $now->getTimestamp()) . ' ' . $moisEnFrancais[$now->format('F')] . ' ' . $now->format('Y');
    $location_id = mysqli_real_escape_string($connection, $_POST['location_id']);
    $updateQuery = "UPDATE location SET end_location = '$now' WHERE id = $location_id";
    mysqli_query($connection, $updateQuery);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../COMPONENTS/important_link.php' ?>
    <link rel="stylesheet" href="../../css/location.css">
    <title>Location</title>
</head>

<body>

<?php include '../COMPONENTS/header.php' ?>

    <h1>Location :</h1>

    <?php
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];

        $sql = "SELECT l.*, vehicles.picture, vehicles.marque, vehicles.modele FROM location l
            JOIN vehicles ON l.vehicles_id = vehicles.id
            WHERE l.user_id = $user_id";

        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            echo '<h2>Locations en cours</h2>';
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Photo Véhicule</th>';
            echo '<th>Véhicule</th>';
            echo '<th>Début de la location</th>';
            echo '<th>Fin de la location</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['end_location'] == null) {
                echo '<tr>';
                echo '<td><img src="../../IMG/' . $row['picture'] . '" alt="Image du véhicule"></td>';
                echo '<td>' . $row['marque'] . ' ' . $row['modele'] . '</td>';
                echo '<td>' . $row['start_location'] . '</td>';
                echo '<td>' . ($row['end_location'] ? $row['end_location'] : 'Non rendu') . '</td>';
                echo '<td>';
                    ?>
                    <form method="post">
                        <input type="hidden" name="location_id" value="<?php echo $row['id']; ?>">
                        <input type="submit" name="rendre" value="Rendre">
                    </form>
                    <?php
                }
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';

            mysqli_data_seek($result, 0);

            echo '<h2>Historique de location</h2>';
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Photo Véhicule</th>';
            echo '<th>Véhicule</th>';
            echo '<th>Début de la location</th>';
            echo '<th>Fin de la location</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['end_location'] !== null) {
                    echo '<tr>';
                    echo '<td><img src="../../IMG/' . $row['picture'] . '" alt="Image du véhicule"></td>';
                    echo '<td>' . $row['marque'] . ' ' . $row['modele'] . '</td>';
                    echo '<td>' . $row['start_location'] . '</td>';
                    echo '<td>' . $row['end_location'] . '</td>';
                    echo '</tr>';
                }
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div>Aucun véhicule trouvé.</div>';
        }

        mysqli_close($connection);
    } else {
        echo "Vous n'êtes pas connecté !";
    }
    ?>

<?php include '../COMPONENTS/footer.php' ?>

</body>

</html>
