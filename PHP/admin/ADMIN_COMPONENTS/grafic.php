<?php
include "../../CRUD/connection.php";


// Définissez la locale sur le français
setlocale(LC_TIME, 'fr_FR.utf8', 'fr_FR', 'fr');

// On récupére le premier jour de la semaine (Lundi)
$first_day = date("Y-m-d", strtotime("monday this week"));

// On récupére le dernier jour de la semaine (dimanche)
$last_day = date("Y-m-d", strtotime("sunday this week"));

// On récupére le premier mois de l'année (Janvier)
$first_month = date("Y-m-d", strtotime("first day of January this year"));

// On récupére le dernier mois de l'année (Décembre)
$last_month = date("Y-m-d", strtotime("last day of December this year"));


// ↓ Affiche le nombre de visiteur dans la semaine ↓

if ($connection) {

    // tableau des jours de la semaine 
    $compteur_jours = array(
        'lundi' => 0,
        'mardi' => 0,
        'mercredi' => 0,
        'jeudi' => 0,
        'vendredi' => 0,
        'samedi' => 0,
        'dimanche' => 0
    );

    // Tableau des mois de l'année
    $compteur_month = array(
        'janvier' => 0,
        'fevrier' => 0,
        'mars' => 0,
        'avril' => 0,
        'mai' => 0,
        'juin' => 0,
        'juillet' => 0,
        'aout' => 0,
        'septembre' => 0,
        'octobre' => 0,
        'novembre' => 0,
        'decembre' => 0,
    );

    // Tableau des années
    $compteur_years = array(
        '2022' => 0,
        '2023' => 0,
        '2024' => 0,
        '2025' => 0,
        '2026' => 0,
    );

    // ↓ Requête sql pour récupérer le premier et dernier jour de la semaine ↓
    $sql = "SELECT DATE_FORMAT(date_visite, '%Y-%m-%d') as date_visite FROM visiteurs WHERE DATE(date_visite) BETWEEN '$first_day' AND '$last_day'";

    // ↓ Requête sql pour récupérer le premier et dernier mois de l'année ↓
    $sql2 = "SELECT DATE_FORMAT(date_visite, '%Y-%m-%d') as date_visite FROM visiteurs WHERE DATE(date_visite) BETWEEN '$first_month' AND '$last_month'";

    // ↓ Requête sql pour récupérer les année ↓
    $sql3 = "SELECT DATE_FORMAT(date_visite, '%Y') as annee FROM visiteurs";

    // ↓ On execute la requête pour les jours de la semaine ↓
    $resultat_days = mysqli_query($connection, $sql);

    // ↓ On execute la requête pour les mois ↓
    $resultat_months = mysqli_query($connection, $sql2);

    // ↓ On execute la requête pour les années ↓
    $resultat_years = mysqli_query($connection, $sql3);


    // ↓ Resultat jours de la semaine ↓ 
    if (mysqli_num_rows($resultat_days) > 0) {
        while ($row = mysqli_fetch_assoc($resultat_days)) {
            $date_visite = strtotime($row['date_visite']);
            $jour_de_la_semaine = strftime("%A", $date_visite);

            // ↓ Semaine ↓
            if (array_key_exists($jour_de_la_semaine, $compteur_jours)) {
                $compteur_jours[$jour_de_la_semaine]++;
            }

    // ↓ Resultat mois ↓ 
    if (mysqli_num_rows($resultat_months) > 0) {
        while ($row = mysqli_fetch_assoc($resultat_months)) {
            $date_visite = strtotime($row['date_visite']);
            $month_year = strftime("%B", $date_visite);

            // ↓ Mois ↓
            if (array_key_exists($month_year, $compteur_month)){
                $compteur_month[$month_year]++;
            }
        }
    
    // ↓ Resultat année ↓ 
    if (mysqli_num_rows($resultat_years) > 0) {
        while ($row = mysqli_fetch_assoc($resultat_years)) {
            $year = $row['annee'];

            // Comptage des visites par année
            if (array_key_exists($year, $compteur_years)){
                $compteur_years[$year]++;
            }
        }
        }
    }}} else {
        echo "Aucune date trouvée pour la semaine actuelle.";
    }

    // Variable des jours de la semaine 
    $lundi = $compteur_jours['lundi'];
    $mardi = $compteur_jours['mardi'];
    $mercredi = $compteur_jours['mercredi'];
    $jeudi = $compteur_jours['jeudi'];
    $vendredi = $compteur_jours['vendredi'];
    $samedi = $compteur_jours['samedi'];
    $dimanche = $compteur_jours['dimanche'];

    // Variable des mois de l'année
    $janvier = $compteur_month['janvier'];
    $fevrier = $compteur_month['fevrier'];
    $mars = $compteur_month['mars'];
    $avril = $compteur_month['avril'];
    $mai = $compteur_month['mai'];
    $juin = $compteur_month['juin'];
    $juillet = $compteur_month['juillet'];
    $aout = $compteur_month['aout'];
    $septembre = $compteur_month['septembre'];
    $octobre = $compteur_month['octobre'];
    $novembre = $compteur_month['novembre'];
    $decembre = $compteur_month['decembre'];

    // Variable des années
    $years_2022 = $compteur_years['2022'];
    $years_2023 = $compteur_years['2023'];
    $years_2024 = $compteur_years['2024'];
    $years_2025 = $compteur_years['2025'];
    $years_2026 = $compteur_years['2026'];

} else {
    echo "Erreur de connexion à la base de données.";
}

// ↓ On met les variables des jours de la semaines contenant le nombre de visiteur dans le jour correspondant dans un tableau ↓
$jour = [$lundi, $mardi, $mercredi, $jeudi, $vendredi, $samedi, $dimanche];
// ↓ On les encode pour pouvoir les utiliser en JS ↓
$json_jour = json_encode($jour);

// ↓ On met les variables des moins de l'année contenant le nombre de visiteur dans le mois correspondant dans un tableau ↓
$months = [$janvier, $fevrier, $mars, $avril, $mai, $juin, $juillet, $aout, $septembre, $octobre, $novembre, $decembre];
// ↓ On les encode pour pouvoir les utiliser en JS ↓
$json_months = json_encode($months);

// ↓ On met les variables des années contenant le nombre de visiteur dans l'année correspondant dans un tableau ↓
$years = [$years_2022, $years_2023, $years_2024, $years_2025, $years_2026];
// ↓ On les encode pour pouvoir les utiliser en JS ↓
$json_years = json_encode($years);

?>

<script src="../../../JS/grafic.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div>
    <canvas id="myChart" data-jour ="<?php echo $json_jour; ?>" width="200" height="50"></canvas>
    <canvas id="myChart2" data-months ="<?php echo $json_months; ?>" width="200" height="50"></canvas>
    <canvas id="myChart3" data-years ="<?php echo $json_years; ?>" width="200" height="50"></canvas>
</div>
