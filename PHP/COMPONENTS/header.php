<?php

if(isset($_SESSION['users'])) {
    $connect = $_SESSION['users']; // on récup "ok"
}else{
    $connect = 'ko';
}

if(isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
}else{
    $role = '';
}
?>


<header>

<ul>
    <li>
        <a href="../../index.php">Accueil</a>
    </li>

    <!-- Si l'utilisateur n'est pas connecté, on affiche -->
    <?php if($connect != 'ok') :  ?>
    <li >
        <a href="./connexion.php">Inscription/Connexion</a>
    </li>

    <!-- Si l'utilisateur est connecté, on affiche déconnexion et espace client -->
    <?php else: ?>
    <li>
        <a href="../PAGES/espace_client.php">Espace Client</a>
    </li>
    <li >
        <a href="./Deconnexion.php">Déconnexion</a>
    </li>
    <?php endif ; ?>

    <li>
        <a href="./contact.php">Contact</a>
    </li>

    <!-- Si le role de l'utilisateur est "ADMIN" alors on affiche la section Admin-->
    <?php if($role == 'ADMIN') : ?>
    <li >
        <a href="../admin/index_admin.php">Admin</a>
    </li>
    <?php endif ; ?>
</ul>

</header>