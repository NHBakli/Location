<header>

<ul>

    <!-- Si le role de l'utilisateur est "ADMIN" alors on affiche la section Admin-->
    <?php if($role == 'ADMIN') : ?>

    <li >
        <a href="../../../index.php">Retour Accueil</a>
    </li>

    <li >
        <a href="../INDEX/index_admin.php">Accueil Admin</a>
    </li>

    <li >
        <a href="../CRUD_USER/admin_user.php">Admin Utilisateurs</a>
    </li>

    <li >
        <a href="../CRUD_VEHICLE/admin_vehicle.php">Admin Vehicules</a>
    </li>
    <?php endif ; ?>

</ul>

</header>
