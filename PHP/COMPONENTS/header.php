<?php

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

$ip = $_SERVER['REMOTE_ADDR'];
$navigateur = $_SERVER['HTTP_USER_AGENT'];
$date_visite = date('Y-m-d H:i:s');

$connexion = mysqli_connect('localhost', 'utilisateur', 'mot_de_passe', 'location');

if ($connexion) {
    $date = date('Y-m-d');
    
    // Vérifiez si une entrée avec la même adresse IP et la même date existe déjà
    $sql = "SELECT * FROM visiteurs WHERE ip = '$ip' AND DATE(date_visite) = '$date'";
    $resultat = mysqli_query($connexion, $sql);
    
    if (mysqli_num_rows($resultat) > 0) {
    } else {
        // Si aucune entrée n'existe, insérez une nouvelle entrée
        $query = "INSERT INTO visiteurs (ip, navigateur, date_visite) VALUES ('$ip', '$navigateur', '$date_visite')";
        mysqli_query($connexion, $query);
        mysqli_close($connexion);
    }
}

?>



<header>

<ul>
    <li>
        <a href="../../index.php">Accueil</a>
    </li>

    <!-- Si l'utilisateur n'est pas connecté, on affiche -->
    <?php if (!isset($_SESSION['connect']) || $_SESSION['connect'] != 'ok') :  ?>
    <li >
        <a href="./connexion.php">Inscription/Connexion</a>
    </li>

    <!-- Si l'utilisateur est connecté, on affiche déconnexion et espace client -->
    <?php else: ?>
    <li>
        <a href="../PAGES/espace_client.php">Espace Client</a>
    </li>
    <li>
        <a href="../PAGES/location.php">Location</a>
    </li>
    <?php endif ; ?>

    <li>
        <a href="./contact.php">Contact</a>
    </li>

    <!-- Si le role de l'utilisateur est "ADMIN" alors on affiche la section Admin-->
    <?php if($role == 'ADMIN') : ?>
    <li >
        <a href="../ADMIN/index_admin/index_admin.php">Admin</a>
    </li>
    <?php endif ; ?>

    <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] == 'ok') :  ?>
    <li >
        <a href="./deconnexion.php">Déconnexion</a>
    </li>
    <?php endif ; ?>
</ul>

</header>
