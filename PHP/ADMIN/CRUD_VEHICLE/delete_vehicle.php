<?php

require '../../../PHP/CRUD/config.php';

$id = $_GET['id'];

if (isset($_POST['id']) && !empty($_POST['id'])){
    
    $sql = "DELETE FROM produits WHERE id=?";

    if ($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        $param_id = trim($_POST['id']);

        if(mysqli_stmt_execute($stmt)){
            header("Location: ../index_produits.php");
            exit();
        }else{
            echo "Erreur de suppression";
        }
    }
    mysqli_close($conn);
}else{
 
    if(empty(trim($_GET['id']))){
        header('Location: ../index_produits.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Corbeille</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .wrapper {
        width: 600px;
        margin: 0 auto;
    }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Suppression d'un produit</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
                            <p>Etes vous sûre de vouloir supprimer ce produit ?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="../index_produits.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>