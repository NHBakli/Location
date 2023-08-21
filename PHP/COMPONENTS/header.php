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
    <?php endif ; ?>

    <li>
        <a href="../PAGES/contact.php">Contact</a>
    </li>

    <!-- Si le role de l'utilisateur est "ADMIN" alors on affiche la section Admin-->
    <?php if($role == 'ADMIN') : ?>
    <li >
        <a href="../ADMIN/index_admin.php">Admin</a>
    </li>
    <?php endif ; ?>

    <?php if (isset($_SESSION['connect']) && $_SESSION['connect'] == 'ok') :  ?>
    <li >
        <a href="../PAGES/deconnexion.php">Déconnexion</a>
    </li>
    <?php endif ; ?>
</ul>

</header>