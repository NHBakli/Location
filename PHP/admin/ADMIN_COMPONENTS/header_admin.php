
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
    <!-- Si le role de l'utilisateur est "ADMIN" alors on affiche la section Admin-->
    <?php if($role == 'ADMIN') : ?>

    <li >
        <a href="../../../index.php">Retournez à l'accueil</a>
    </li>

    <li >
        <a href="../index_admin/index_admin.php">Admin Accueil</a>
    </li>

    <li >
        <a href="../CRUD_users/index_user.php">Pannel Users</a>
    </li>

    <li >
        <a href="../CRUD_Vehicule/index_vehicule.php">Pannel Vehicule</a>
    </li>
    <?php endif ; ?>

</ul>

</header>
