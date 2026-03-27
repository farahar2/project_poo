<?php
session_start();
session_destroy(); // On détruit la session pour déconnecter l'utilisateur
header("Location: login.php");
exit();
?>