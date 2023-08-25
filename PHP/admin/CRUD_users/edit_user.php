<?php

session_start();

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    if ($role != 'ADMIN') {
        header('location: ../../../index.php');
    }
} else {
    $role = '';
    if ($role != 'ADMIN') {
        header('location: ../../../index.php');
    }
}

require '../../CRUD/connection.php';
require '../../CRUD/protected.php';

$login = $role = '';
$login_err = $role_err = '';

if (isset($_POST['id']) && !empty(trim($_POST['login']))) {

    $id = $_POST['id'];

    $input_login = trim($_POST['login']);

    if (empty($input_login)) {
        $login_err = 'Renseignez un login';
    } else {
        $login = $input_login;
    }

    $input_role = trim($_POST['role']);

    if (empty($input_role)) {
        $role_err = 'Renseignez un role';
    } else {
        $role = $input_role;
    }

    if (empty($login_err) && empty($role_err)) {

        $sql = 'UPDATE users SET login=?, role=? WHERE id=?';

        if ($stmt = mysqli_prepare($connection, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssi', $param_login, $param_role, $param_id);

            $param_login = $login;
            $param_role = $role;
            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                header("location: ./index_user.php");
                exit();
            } else {
                echo "Erreur de modification";
            }
        }
    }
    mysqli_close($connection);
} else {

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = trim($_GET['id']);

        $sql = "SELECT * FROM users WHERE id=?";
        if ($stmt = mysqli_prepare($connection, $sql)) {

            mysqli_stmt_bind_param($stmt, "i", $param_id);

            $param_id = $id;
            if (mysqli_stmt_execute($stmt)) {

                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $mail = $row['login'];
                    $_SESSION['userupdate'] = $mail;
                    $role = $row['role'];
                    $id = $row['id'];
                }
            } else {
                echo "Erreur de modification";
            }
        } else {
            header('location: ../index_admin.php');
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification d'un utilisateur</title>
</head>

<body>

    <div>
        <div>
            <h2>Modification de l'utilisateur <?php if (!empty($_SESSION['userupdate'])) {
                                                    echo $_SESSION['userupdate'];
                                                } ?></h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
            <div>
                <label>Login</label>
                <input type="email" name="login" <?php echo (!empty($login_err)) ? 'is-invalid' : ''; ?> value="<?php echo $_SESSION['userupdate']; ?>" required></input>
                <span class="invalid-feedback"><?php echo $login_err; ?></span>
            </div>
            <div class="form-group">
                <label>Role</label>
                <input type="text" name="role" minlength="4" <?php echo (!empty($role_err)) ? 'is-invalid' : ''; ?> value="<?php echo $role; ?>" required></input>
                <span><?php echo $role_err; ?></span>
            </div>
            <input type="hidden" name="rolebackup" value="<?php echo $role; ?>" />
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="submit" value="Enregistrer">
            <a href="./index_user.php">Annuler</a>
        </form>
    </div>

</body>

</html>