<?php
require_once "../classes/User.php";

$message = "";
$messageType = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = $_POST["name"] ?? "";
    $email    = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $user = new User();
    $success = $user->register($name, $email, $password);

    if ($success) {
        $message = "Inscription réussie ! Tu peux maintenant te connecter.";
        $messageType = "success";

    } else {
        $message = "Échec : champ vide, email invalide, ou déjà utilisé.";
        $messageType = "danger";
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
                    <div class="alert alert-<?php echo $messageType; ?>">
                        <i class="bi bi-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-person"></i> Nom complet
                        </label>
                        <input type="text" name="name" class="form-control" 
                               required placeholder="John Doe">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-envelope"></i> Email
                        </label>
                        <input type="email" name="email" class="form-control" 
                               required placeholder="ton@email.com">
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