<?php
require_once "../classes/User.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = $_POST["name"] ?? "";
    $email    = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $user = new User();
    $success = $user->register($name, $email, $password);

    if ($success) {
        $message = "✅ Inscription réussie ! Tu peux maintenant te connecter.";
    } else {
        $message = "❌ Échec : champ vide, email invalide, ou déjà utilisé.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nom :</label><br>
        <input type="text" name="name" required placeholder="Ton nom"><br><br>

        <label>Email :</label><br>
        <input type="email" name="email" required placeholder="ton@email.com"><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required placeholder="Mot de passe"><br><br>

        <button type="submit">S'inscrire</button>
    </form>

    <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
</body>
</html>