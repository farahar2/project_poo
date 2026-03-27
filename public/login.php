<?php
require_once "../classes/User.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $user = new User();
    $success = $user->login($email, $password);

    if ($success) {
        header("Location: index.php");
        exit;
    } else {
        $error = "❌ Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Email :</label><br>
        <input type="email" name="email" required placeholder="ton@email.com"><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required placeholder="Mot de passe"><br><br>

        <button type="submit">Se connecter</button>
    </form>

    <p>Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
</body>
</html>