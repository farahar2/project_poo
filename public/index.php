<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?> !</h1>
    <p>Ton rôle : <?php echo htmlspecialchars($_SESSION['user_role']); ?></p>
    <a href="logout.php">Se déconnecter</a>
</body>
</html>