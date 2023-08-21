<?php
session_start();

unset($_SESSION['users']);
unset($_SESSION['role']);
unset($_SESSION['email']);

header('Location: ../../index.php');
exit();

?>