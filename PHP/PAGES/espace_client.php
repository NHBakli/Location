<?php session_start();?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/espace_clients.css">
    <script src="../../JS/script.js" defer></script>
    <?php include '../COMPONENTS/important_link.php' ?>
    <title>Espace Client</title>
</head>
<body>

<!--  Affichage des informations  -->
<?php include '../COMPONENTS/header.php' ?>

<?php

require '../CRUD/connection.php';
require '../CRUD/protected.php';

$query = "SELECT * FROM users
        JOIN clients ON users.id = clients.user_id
        WHERE user_id = ?";

if(isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $stmt = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param($stmt, "i", $id); 

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);

        ?>
        <main>
            <div class="container_p">
                <div class="container_img">
                    <h2>Informations</h2>
                    <img src="../../IMG/user.png" alt="user">
                </div>
                <div class="name_container">
                    <p>Nom : <?php echo $user_data['lastname'];?></span></p>
                    <p>Prénom : <?php echo $user_data['firstname'];?></p>
                </div>
                <div class="container_information">
                    <p>Adresse : <?php echo $user_data['address'];?></p>
                    <p>Ville : <?php echo $user_data['city'];?></p>
                    <p>Code postal : <?php echo $user_data['postal_code'];?></p>
                    <p>Email : <?php echo $user_data['login'];?></p">
                </div>
                <div class="button_modified">
                <button type="submit" class="modified" name="modified" value="Enregistrer">Modifier</button>
                </div>
            </div>
        </main>
        <?php
    }
}
?>


<!-- Modification des informations -->
<?php
$id = $_SESSION['id']; 
$user_id = $id; 
$nom = $prenom = $mail = $address = $cp = $ville = $userid = '';
$nom_err = $prenom_err = $mail_err = $adres_err = $cp_err = $ville_err = $userid_err = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_nom = trim($_POST["nom"]);
    if(!empty($input_nom)){
        $nom = $input_nom;
    }
    
    $input_prenom = trim($_POST["prenom"]);
    if(!empty($input_prenom)){
        $prenom = $input_prenom;
    }

    $input_address = trim($_POST["address"]);
    if(!empty($input_address)){
        $address = $input_address;
    }else{
        $address = '';
    }

    $input_mail = trim($_POST["adress"]);
    if(!empty($input_mail)){
        $mail = $input_mail;
    }else{
        $mail = '';
    }

    $input_cp = trim($_POST["code"]);
    if(!empty($input_cp)){
        $cp = $input_cp;
    }

    $input_ville = trim($_POST["city"]);
    if(!empty($input_ville)){
        $ville = $input_ville;
    }

    $recup = $_SESSION['id'];
    $sql = "UPDATE clients SET firstname=?, lastname=?, Address=?, postal_code=?, city=?, user_id=? WHERE id=?";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssii", $param_nom, $param_prenom, $param_address, $param_cp, $param_ville, $param_user_id, $param_id);
    
        $param_nom = $nom;
        $param_prenom = $prenom;
        $param_address = $address;
        $param_cp = $cp;
        $param_ville = $ville;
        $param_user_id = $_SESSION['id'];
        $param_id = $recup;


            if(mysqli_stmt_execute($stmt)){
                $_SESSION['id']='';
                header("location: ./espace_client.php");
                exit();
            }else{ 
                echo "Oops ! erreur inattendu, rééssayez plus tard !!!";
            }
        }

    mysqli_close($connection);
    }

?>

<div class="main2">
    <div class="container_input">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post" class="update">
            <div class="container_top">
                <div class="firstname_container">
                    <input type="text" placeholder="Nom" name="nom" >
                </div>
                <div class="lastname_container">
                    <input type="text" placeholder="Prénom" name="prenom" >
                </div> 
            </div>
            <div class="mail_container">
                <input type="email" placeholder="Email" name="adress" >
            </div>
            <div class="container_item_adress">
                <div class="country_container">
                    <input type="text" placeholder="Pays" name="country" >
                </div>
                <div class="city_container">
                    <input type="text" placeholder="Ville" name="city" >
                </div>
                <div class="adress_code_container">
                    <input type="text" placeholder="Code postal" name="code" >
                </div> 
            </div> 
            <div class="address_container">
                <input type="text" placeholder="Adresse" name="address" >
            </div>
            <div class="button_container">
                <div class="button_valid">
                    <button class="valid" type="submit" name="modified" value="Enregistrer">Valider</button>
                </div>
            </div>
            </form>
            <div class="button_cancel">
                <button class="cancel" type="submit" name="cancel" value="cancel">Annuler</button>
            </div>
    </div>
</div>
<?php include '../COMPONENTS/footer.php' ?>

</body>
</html>