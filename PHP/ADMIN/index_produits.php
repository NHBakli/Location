<?php
session_start();

if(isset($_SESSION['role'])){
    $role=$_SESSION['role'];
    if($role!='ADMIN'){
        header('location: ../index.php');
    } 
}else{
    $role='';
    if($role!='admin'){
        header('location: ../index.php');} 
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <title>Menu produits</title>
</head>

<body>

    <h1>Produits</h1>

    <div class="text-center">
        <?php
        echo '<a href="crud/create_produit.php" class="mr-3" title="create produit" data-toggle="tooltip"><button class="fas fa-plus" style="text-align: center"; padding: 5px; border:none; border-radius: 5px;">Ajout d\'un produit</button></a>';
        
        ?>
    </div>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                require '../../PHP/CRUD/config.php';

                $sql = "SELECT * FROM produits";

                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result)>0){
                        echo '<table class="table table-bordered table-striped">';
                            echo '<thead>';
                                echo '<tr>';
                                    echo '<th>Id</th>';
                                    echo '<th>Référence</th>';
                                    echo '<th>Catégorie</th>';
                                    echo '<th>Prix H.T.</th>';
                                    echo '<th>TVA</th>';
                                    echo '<th>Description</th>';
                                    echo '<th>Stock</th>';
                                echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            while($row = mysqli_fetch_array($result)){
                                echo '<tr>';
                                    echo '<td>' . $row['id'] . '</td>';
                                    echo '<td>' . $row['reference'] . '</td>';
                                    echo '<td>' . $row['categorie'] . '</td>';
                                    echo '<td>' . $row['prixht'] . '</td>';
                                    echo '<td>' . $row['tva'] . '</td>';
                                    echo '<td>' . $row['description'] . '</td>';
                                    echo '<td>' . $row['stock'] . '</td>';
                                    echo '<td>';
                                        echo '<a href="./CRUD/update_produit.php?id='.$row['id'].'" class="mr-3" title="update" data-toggle="tooltip"><span class="fas fa-pencil-alt"></span> </a>';
                                        echo '<a href="./CRUD/delete_produit.php?id='.$row['id'].'" class="mr-3" title="update" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                    echo '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                        echo '</table>';

                        }else{
                            echo '<div class="alert alert-danger"><em>Aucun produit trouvé.</em></div>';
                        }
                }else{
                    echo '<div class="alert alert-danger"><em>Erreur de connexion.</em></div>';
                }
                mysqli_close($conn);
                ?>
                </div>
            </div>
        </div>
    </div>
    <a href="../../index.php">Retour Accueil</a>
</body>

</html>