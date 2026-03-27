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
        $error = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Prompt Manager</title>
    <?php include "includes/head.php"; ?>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <i class="bi bi-braces-asterisk" style="font-size: 3rem;"></i>
                <h1>Connexion</h1>
                <p>Accédez à votre bibliothèque de prompts</p>
            </div>
            
            <div class="auth-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
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
                               required placeholder="••••••••">
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Se connecter
                    </button>
                </form>
                
                <hr class="my-4">
                
                <p class="text-center mb-0">
                    Pas encore de compte ? 
                    <a href="register.php" class="text-decoration-none fw-bold">S'inscrire</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include "includes/scripts.php"; ?>
</body>
</html>
