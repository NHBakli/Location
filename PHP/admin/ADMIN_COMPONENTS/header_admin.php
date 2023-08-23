<?php
session_start();

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

    <!-- Si le role de l'utilisateur est "ADMIN" alors on affiche la section Admin-->
    <?php if($role == 'ADMIN') : ?>

    <li >
        <a href="../../index.php">Retournez à l'accueil</a>
    </li>

    <li >
        <a href="../../ADMIN/index_admin.php">Admin Accueil</a>
    </li>

    <li >
        <a href="../ADMIN/CRUD_users/pannel_users.php">Pannel Users</a>
    </li>

    <li >
        <a href="../ADMIN/CRUD_Vehicule/pannel_vehicule.php">Pannel Vehicule</a>
    </li>
    <?php endif ; ?>

</ul>

</header>
