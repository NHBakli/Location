<?php
require_once "../../../php/crud/config.php";

$ref = $cat = $pht = $tva = $desc = $stock = '';
$ref_err = $cat_err = $pht_err = $tva_err = $desc_err = $stock_err = '';
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_ref = trim($_POST["ref"]);
    if(empty($input_ref)){
        $ref_err = "entrer une ref"; 
    } else{
        $ref = $input_ref;
    }
    
    $input_cat = trim($_POST["cat"]);
    if(empty($input_cat)){
        $cat_err = "entrer une catégorie";     
    } else{
        $cat = $input_cat;
    }

    $input_pht = trim($_POST["pht"]);
    if(empty($input_pht)){
        $pht_err = "entrer un prix unitaire";
    } else{
        $pu = $input_pht;
    }
    
    $input_tva = trim($_POST["tva"]);
    if(empty($input_tva)){
        $tva_err = "entrer une tva";     
    } else{
        $tva = $input_tva;
    }

    $input_desc = trim($_POST["desc"]);
    if(empty($input_desc)){
        $desc_err = "entrer la description";     
    } else{
        $desc = $input_desc;
    }

    $input_stock = trim($_POST["stock"]);
    if(empty($input_stock)){
        $stock_err = "entrer le stock";     
    } else{
        $stock = $input_stock;
    }
    
    if(empty($ref_err) && empty($cat_err) && empty($pht_err) && empty($tva_err) && empty($desc_err) && empty($stock_err)){
        
            $param_ref = $ref;
            $param_cat = $cat;
            $param_pht = $pht;
            $param_tva = $tva;
            $param_desc = $desc;
            $param_stock = $stock;

            $sql = "INSERT INTO produits (reference, categorie, prixht, tva, description, stock) VALUES ( '$param_ref', '$param_cat', '$param_pht', '$param_tva', '$param_desc', '$param_stock')";
            
            $result = mysqli_query($conn, $sql);
            
            if($result){
                mysqli_close($conn);
                header("location: ../index_produits.php");
                exit();
            } else{
                echo "Erreur de création";
            }
        }
    
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
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
                    <h2 class="mt-5">Création d'un produit</h2><br>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post">
                        <div class="form-group">
                            <label>Référence</label>
                            <input type="text" name="ref" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Catégorie</label>
                            <input type="text" name="cat" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>P.U. HT</label>
                            <input type="text" name="pht" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>TVA</label>
                            <input type="text" name="tva" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="desc" class="form-control">
                        </div>

                        <!-- <div class="form-group">
                            <label>Description</label>
                            <textarea style="resize: none" name="desc" class="form-control" rows="5"></textarea>
                        </div> -->

                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" name="stock" class="form-control">
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary" value="Enregistrer">
                        <a href="../index_produits.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>