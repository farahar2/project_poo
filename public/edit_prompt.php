<?php
$cssPath = "";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once "../classes/Prompt.php";
require_once "../classes/Category.php";

$promptObj = new Prompt();
$categoryObj = new Category();

$id = $_GET['id'] ?? null;

if (!$id) {
    die("❌ ID manquant");
}

$prompt = $promptObj->findById($id);

if (!$prompt) {
    die("❌ Prompt introuvable");
}

if ($prompt['user_id'] != $_SESSION['user_id']) {
    die("❌ Accès refusé : ce n'est pas ton prompt !");
}

$categories = $categoryObj->getAll();
$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title      = trim($_POST["title"] ?? "");
    $content    = trim($_POST["content"] ?? "");
    $categoryId = $_POST["category_id"] ?? "";

    if ($promptObj->update($id, $title, $content, $categoryId)) {
        $message = "Prompt modifié avec succès !";
        $messageType = "success";
        $prompt = $promptObj->findById($id);
    } else {
        $message = "Erreur lors de la modification.";
        $messageType = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Prompt — Prompt Manager</title>
    <?php include "includes/head.php"; ?>
</head>
<body>

<div class="main-container">
    
    <!-- HEADER -->
    <div class="header">
        <h1><i class="bi bi-braces-asterisk"></i> Prompt Manager</h1>
        <div class="header-links">
            <a href="index.php"><i class="bi bi-house"></i> Accueil</a>
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        </div>
    </div>

    <!-- FORMULAIRE -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-container">
                <h1><i class="bi bi-pencil"></i> Modifier le Prompt</h1>
                
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $messageType; ?>">
                        <i class="bi bi-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Titre du prompt</label>
                        <input type="text" name="title" class="form-control" required 
                               value="<?php echo htmlspecialchars($prompt['title']); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catégorie</label>
                        <select name="category_id" class="form-select" required>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>"
                                    <?php echo ($cat['id'] == $prompt['category_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Contenu du prompt</label>
                        <textarea name="content" class="form-control" rows="8" required><?php echo htmlspecialchars($prompt['content']); ?></textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Enregistrer les modifications
                        </button>
                        <a href="index.php" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include "includes/scripts.php"; ?>
</body>
</html>