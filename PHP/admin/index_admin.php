<?php
session_start();

if(isset($_SESSION['role'])){
    $role=$_SESSION['role'];
    if($role!='ADMIN'){
        header('location: ../index.php');
    } 
}else{
    $role='';
    if($role!='ADMIN'){
        header('location: ../index.php');} 
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../COMPONENTS/important_link.php' ?>
    <link rel="stylesheet" href="../../CSS/index_admin.css">
    <title>Accueil Admin</title>
</head>

<body>

<?php include '../COMPONENTS/header.php' ?>

    <h1>Utlisateurs</h1>

    <div>
        <div>
            <div>
                <div>
                    <?php
                require '../php/crud/connection.php';

                $sql = "SELECT * FROM users";

                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result)>0){
                        echo '<table>';
                            echo '<thead>';
                                echo '<tr>';
                                    echo '<th>ID</th>';
                                    echo '<th>Adresse email</th>';
                                    echo '<th>RÔle</th>';
                                    echo '<th>Compte vérifié</th>';
                                    echo '<th>Outils</th>';
                                echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            while($row = mysqli_fetch_array($result)){
                                echo '<tr>';
                                    echo '<td>' . $row['id'] . '</td>';
                                    echo '<td>' . $row['login'] . '</td>';
                                    echo '<td>' . $row['role'] . '</td>';
                                    echo '<td>' . $row['isVerified'] . '</td>';
                                    echo '<td>';
                                        echo '<a href="./update.php?id='.$row['id'].'" class="mr-3" title="update" data-toggle="tooltip"><span class="fas fa-pencil-alt"></span> </a>';
                                        echo '<a href="./delete.php?id='.$row['id'].'" class="mr-3" title="update" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                    echo '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                        echo '</table>';

                        }else{
                            echo '<div class="alert alert-danger"><em>Aucun utilisateur trouvé.</em></div>';
                        }
                }else{
                    echo '<div class="alert alert-danger"><em>Aucun utilisateur trouvé.</em></div>';
                }
                mysqli_close($conn);
                ?>
                </div>
            </div>
        </div>
    </div>
    <a href="../index.php">Retour Accueil</a>

<?php include '../COMPONENTS/footer.php' ?>

</body>

</html>