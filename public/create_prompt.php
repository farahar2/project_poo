<?php
$cssPath = "";
session_start();
if(!isset($_SESSION['user_id'])){
  header("Location: login.php");
  exit();
}
require_once "../classes/Prompt.php";
require_once "../classes/Category.php";

$prompt = new Prompt();
$category = new Category();
$message = "";

$categories = $category->getAll();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);
  $categoryId = $_POST['category_id'];
  $userId = $_SESSION['user_id'];

  if($prompt->create($title, $content, $userId, $categoryId)){
    $message = "Prompt créé avec succès !";
  } else {
    $message = "Erreur : titre ou contenu vide.";
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Prompt — Prompt Manager</title>
    <?php include "includes/head.php"; ?>
</head>
<body>

<div class="main-container">
    
    <!-- HEADER -->
    <div class="header">
        <h1>Prompt Manager</h1>
        <div class="header-links">
            <a href="index.php"><i class="bi bi-house"></i> Accueil</a>
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        </div>
    </div>

    <!-- FORMULAIRE -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-container">
                <h1><i class="bi bi-plus-circle"></i> Créer un nouveau Prompt</h1>
                
                <?php if (!empty($message)): ?>
                    <?php $isError = stripos($message, 'erreur') !== false; ?>
                    <div class="alert alert-<?php echo $isError ? 'danger' : 'success'; ?>">
                        <i class="bi bi-<?php echo $isError ? 'exclamation-circle' : 'check-circle'; ?>"></i>
                        <?php echo $message; ?>
                        <?php if (!$isError): ?>
                            — <a href="index.php" class="alert-link">Voir tous les prompts</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Titre du prompt</label>
                        <input type="text" name="title" class="form-control" 
                               required placeholder="Ex: Générer une API REST en PHP">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catégorie</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Choisir une catégorie --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>">
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Contenu du prompt</label>
                        <textarea name="content" class="form-control" rows="8" required 
                                  placeholder="Écris ton prompt ici..."></textarea>
                        <small class="text-muted">
                            Sois précis et détaillé pour de meilleurs résultats avec les LLM.
                        </small>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Enregistrer
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