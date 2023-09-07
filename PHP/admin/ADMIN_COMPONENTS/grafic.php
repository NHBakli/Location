<?php
include "../../CRUD/connection.php";


// Définissez la locale sur le français
setlocale(LC_TIME, 'fr_FR.utf8', 'fr_FR', 'fr');

// Récupérez la date du premier jour de la semaine actuelle (lundi)
$premier_jour_semaine = date("Y-m-d", strtotime("monday this week"));

// Récupérez la date du dernier jour de la semaine actuelle (dimanche)
$dernier_jour_semaine = date("Y-m-d", strtotime("sunday this week"));



if ($connection) {
    // tableau des jours de la semaine initialisé à 0 
    $compteur_jours = array(
        'lundi' => 0,
        'mardi' => 0,
        'mercredi' => 0,
        'jeudi' => 0,
        'vendredi' => 0,
        'samedi' => 0,
        'dimanche' => 0
    );

    // on récupère les dates de la semaine actuelle dans la bdd
    $sql = "SELECT DATE_FORMAT(date_visite, '%Y-%m-%d') as date_visite FROM visiteurs WHERE DATE(date_visite) BETWEEN '$premier_jour_semaine' AND '$dernier_jour_semaine'";
    $resultat = mysqli_query($connection, $sql);

    if (mysqli_num_rows($resultat) > 0) {
        while ($row = mysqli_fetch_assoc($resultat)) {
            $date_visite = strtotime($row['date_visite']);
            $jour_de_la_semaine = strftime("%A", $date_visite);

        
            if (array_key_exists($jour_de_la_semaine, $compteur_jours)) {
                $compteur_jours[$jour_de_la_semaine]++;
            }

            
        }
    } else {
        echo "Aucune date trouvée pour la semaine actuelle.";
    }

    mysqli_close($connection);

    // Variable des jours de la semaine qui contiennent les nombres de visites correspondant au jour 
    $lundi = $compteur_jours['lundi'];
    $mardi = $compteur_jours['mardi'];
    $mercredi = $compteur_jours['mercredi'];
    $jeudi = $compteur_jours['jeudi'];
    $vendredi = $compteur_jours['vendredi'];
    $samedi = $compteur_jours['samedi'];
    $dimanche = $compteur_jours['dimanche'];
} else {
    echo "Erreur de connexion à la base de données.";
}


$jour = [$lundi, $mardi, $mercredi, $jeudi, $vendredi, $samedi, $dimanche];


$json_jour = json_encode($jour);
?>

<script src="../../../JS/grafic.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div>
    <canvas id="myChart" data-jour="<?php echo $json_jour; ?>" width="200" height="50"></canvas>
</div>

