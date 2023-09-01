<?php

session_start();

// unset($_SESSION['id']);
// unset($_SESSION['email']);
// unset($_SESSION['role']);
// unset($_SESSION['connect']);
// Utilité à retrouver
// unset($_SESSION['users']);
// Utilité à retrouver
session_destroy();

header('Location: ../../index.php');
exit();

?>