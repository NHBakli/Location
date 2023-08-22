<?php
session_start();

unset($_SESSION['users']);
unset($_SESSION['role']);
unset($_SESSION['email']);
unset($_SESSION['connect']);

header('Location: ../../index.php');
exit();

?>