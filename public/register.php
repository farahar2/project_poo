<?php
session_start();
require_once "../classes/User.php";

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = $_POST["name"] ?? "";
    $email    = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $user = new User();
    $success = $user->register($name, $email, $password);

    if ($success) {
        $message = "Inscription réussie ! Tu peux maintenant te connecter.";
    } else {
        $message = "Échec : champ vide, email invalide, ou déjà utilisé.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — Prompt Manager</title>
    <?php include "includes/head.php"; ?>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <i class="bi bi-person-plus" style="font-size: 3rem;"></i>
                <h1>Inscription</h1>
                <p>Rejoignez la communauté DevGenius</p>
            </div>
            
            <div class="auth-body">
                <?php if (!empty($message)): ?>
                    <?php $isError = stripos($message, 'échec') !== false || stripos($message, 'erreur') !== false; ?>
                    <div class="alert alert-<?php echo $isError ? 'danger' : 'success'; ?>">
                        <i class="bi bi-<?php echo $isError ? 'exclamation-circle' : 'check-circle'; ?>"></i>
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-person"></i> Nom complet
                        </label>
                        <input type="text" name="name" class="form-control" 
                               required placeholder="John Doe"
                               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-envelope"></i> Email
                        </label>
                        <input type="email" name="email" class="form-control" 
                               required placeholder="ton@email.com"
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-lock"></i> Mot de passe
                        </label>
                        <input type="password" name="password" class="form-control" 
                               required placeholder="••••••••" minlength="6">
                        <small class="text-muted">Minimum 6 caractères</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-person-plus"></i> S'inscrire
                    </button>
                </form>
                
                <hr class="my-4">
                
                <p class="text-center mb-0">
                    Déjà un compte ? 
                    <a href="login.php" class="text-decoration-none fw-bold">Se connecter</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include "includes/scripts.php"; ?>
</body>
</html>