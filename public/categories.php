<?php 
$cssPath = "";
session_start();
if(!isset($_SESSION['user_id'])){
  header("Location: login.php");
  exit();
}
require_once "../classes/Category.php";
$category = new Category();
$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");

    if ($category->create($name)) {
        $message = "Catégorie ajoutée !";
        $messageType = "success";
    } else {
        $message = "Erreur : nom vide ou catégorie déjà existante.";
        $messageType = "danger";
    }
}
$categories = $category->getAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories — Prompt Manager</title>
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

    <!-- PAGE HEADER -->
    <div class="page-header">
        <h1><i class="bi bi-folder"></i> Catégories</h1>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo $messageType; ?>">
            <i class="bi bi-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- FORMULAIRE D'AJOUT -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-3">Ajouter une catégorie</h5>
            <form method="POST" class="d-flex gap-2">
                <input type="text" name="name" class="form-control" 
                       required placeholder="Nom de la catégorie">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Ajouter
                </button>
            </form>
        </div>
    </div>

    <!-- LISTE DES CATÉGORIES -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Date de création</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?php echo $cat['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($cat['name']); ?></strong></td>
                        <td><?php echo date('d/m/Y', strtotime($cat['created_at'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include "includes/scripts.php"; ?>
</body>
</html>