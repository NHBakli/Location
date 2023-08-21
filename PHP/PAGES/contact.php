<?php
require_once "../CRUD/connection.php";

$nom = $pre = $mail = $mess ="";
$nom_err = $pre_err = $mail_err 
= $err_mess ="";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_nom = trim($_POST["nom"]);
    if(empty($input_nom)){
        $nom_err = "entrer un nom"; 
    } else{
        $nom = $input_nom;
    }
    
    $input_pre = trim($_POST["pre"]);
    if(empty($input_pre)){
        $pre_err = "entrer un prénom";     
    } else{
        $pre = $input_pre;
    }

    $input_mail = trim($_POST["mail"]);
    if(empty($input_mail)){
        $mail_err = "entrer un mail";
    } else{
        $mail = $input_mail;
    }
    

    $input_mess = trim($_POST["mess"]);
    if(empty($input_mess)){
        $mess_err = "entrer un message";     
    } else{
        $mess = $input_mess;
    }

    if(empty($nom_err) && empty($pre_err) && empty($mail_err) && empty($mess_err)){

        $param_nom = $nom;
        $param_pre = $pre;
        $param_mail = $mail;
        $param_mess = $mess;

        $sql = "INSERT INTO contact (nom, prenom, mail, message) VALUES ('$param_nom', '$param_pre', '$param_mail', '$param_mess')";
        
        $result = mysqli_query($connection, $sql);
        
        
        if($result){
            //envoie mail
            // ini_set('display_errors', 1);
            // error_reporting(E_ALL);
            // $from = $mail;
            // $to = 'destinataire@domaine.com';
            // $message = $mess;
            // $header = "De :" . $from;
            // mail($to, $subject, $message, $header);
            //fin mail

            mysqli_close($connection);
            header("location: ../PAGES/accueil.php");
            exit();
        } else{
            echo "Oops! erreur inattendu, rééssayez ultérieurement";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/contact.css">
    <?php include '../COMPONENTS/important_link.php' ?>
    <title>Contact</title>
</head>
<body>
<?php include '../COMPONENTS/header.php' ?>


<main>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post" class="contact">
            <div class="container_top">
                <div class="firstname_container">
                    <input type="text" placeholder="Nom" name="nom">
                </div>
                <div class="lastname_container">
                    <input type="text" placeholder="Prénom" name="pre">
                </div> 
            </div>
            <div class="mail_container">
                <input type="text" placeholder="Email" name="mail">
            </div>
            <div class="message_container">
                <textarea name="mess" placeholder="Message" cols="150" rows="5"></textarea>
            </div>
            <div class="button_container">
                <button type="submit" name="submit" value="Enregistrer">ENVOYER</button>
            </div>
        </form>
    </div>
</main>

<?php include '../COMPONENTS/footer.php' ?>
</body>
</html>