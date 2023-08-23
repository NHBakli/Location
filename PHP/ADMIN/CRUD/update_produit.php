<?php
require '../../../php/crud/config.php';

$ref = $cat = $pht = $tva = $desc = $stock ='';
$ref_err = $cat_err = $pht_err = $tva_err = $desc_err = $stock_err ='';

if(isset($_POST['id']) && !empty($_POST['id'])){

    $input_ref = trim($_POST["ref"]);
    if(empty($input_ref)){
        $ref_err = "Renseignez une référence"; 
    } else{
        $ref = $input_ref;
    }
    
    $input_cat = trim($_POST["cat"]);
    if(empty($input_cat)){
        $cat_err = "Renseignez une catégorie";     
    } else{
        $cat = $input_cat;
    }

    $input_pht = trim($_POST["pht"]);
    if(empty($input_pht)){
        $pht_err = "Renseignez le prix hors taxe";
    } else{
        $pht = $input_pht;
    }
    
    $input_tva = trim($_POST["tva"]);
    if(empty($input_tva)){
        $tva_err = "Renseignez la tva";     
    } else{
        $tva = $input_tva;
    }

    $input_desc = trim($_POST["desc"]);
    if(empty($input_desc)){
        $desc_err = "Renseignez la description";     
    } else{
        $desc = $input_desc;
    }

    $input_stock = trim($_POST["stock"]);
    if(empty($input_stock)){
        $stock_err = "Renseignez le stock";     
    } else{
        $stock = $input_stock;
    }

    if(empty($ref_err) && empty($cat_err) && empty($pht_err) && empty($tva_err) && empty($desc_err) && empty($stock_err)){

        $sql = 'update produits set reference=?, categorie=?, prixht=?, tva=?, description=?, stock=? where id=?';

        if($stmt=mysqli_prepare($conn,$sql)){
            mysqli_stmt_bind_param($stmt, "ssiisii", $param_ref, $param_cat, $param_pu,$param_tva, $param_desc, $param_stock, $param_id);

            $param_ref = $ref;
            $param_cat = $cat;
            $param_pht = $pht;
            $param_tva = $tva;
            $param_desc = $desc;
            $param_stock = $stock;
            $param_id = $_POST['id'];
            
            if(mysqli_stmt_execute($stmt)){
                header("location: ../index_produits.php");
                exit();
            }else{ 
                echo "Erreur de modification";
            }
        }
    }
    mysqli_close($conn);

}else{
    if(isset($_GET['id']) && !empty($_GET['id'])){
        $id = trim($_GET['id']);

        $sql = "select * from produits where id=?";

        if($stmt= mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt,"i", $param_id);

            $param_id = $id;

            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result)==1){
                    $row=mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $ref = $row['reference'];
                    $cat = $row['categorie'];
                    $pht = $row['prixht'];
                    $tva = $row['tva'];
                    $desc = $row['description'];
                    $stock = $row['stock'];
                    $id = $row['id'];
                    }else{
                        header('Location: ../index_produits.php');
                        exit();
                    }  
            }else{
                echo "Erreur de modification"; 
            }
        }
    }else{
        header('location: ../index_produits.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour Produit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .wrapper {
        width: 600px;
        margin: 0 auto;
        text-align : center;
    }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Mise à jour du produit <?php echo $ref; ?></h2>
                </div>
                <p>Modifiez les valeurs : </p>
                <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
                    <div class="form-group"><br>
                        <label>Référence</label>
                        <input type="text" name="ref"
                            class="form-control <?php echo (!empty($ref_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $ref;?>">
                        <span class="invalid-feedback"><?php echo $ref_err; ?></span>
                    </div>
                    <div class="form-group"><br>
                        <label>Catégorie</label>
                        <input type="text" name="cat"
                            class="form-control <?php echo (!empty($cat_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $cat;?>">
                        <span class="invalid-feedback"><?php echo $cat_err; ?></span>
                    </div>
                    <div class="form-group"><br>
                        <label>Prix Hors Taxe</label>
                        <input type="text" name="pht"
                            class="form-control <?php echo (!empty($pht_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $pht;?>">
                        <span class="invalid-feedback"><?php echo $pht_err; ?></span>
                    </div>
                    <div class="form-group"><br>
                        <label>TVA</label>
                        <input type="number" name="tva"
                            class="form-control <?php echo (!empty($tva_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $tva;?>">
                        <span class="invalid-feedback"><?php echo $tva_err; ?></span>
                    </div>
                    <div class="form-group"><br>
                        <label>Description</label>
                        <textarea resize="none" rows="4" name="desc"
                            class="form-control <?php echo (!empty($desc_err)) ? 'is-invalid' : ''; ?>"
                            value="<php? echo $desc;?>"></textarea>
                        <span class="invalid-feedback"><?php echo $desc_err;?></span>
                    </div>
                    <div class="form-group"><br>
                        <label>Stock</label>
                        <input type="number" name="stock"
                            class="form-control <?php echo (!empty($stock_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $stock;?>">
                        <span class="invalid-feedback"><?php echo $stock_err; ?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <input type="submit" class="btn btn-primary" value="Enregistrer">
                    <a href="../index_produits.php" class="btn btn-secondary ml-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
