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
        <h1>Prompt Manager</h1>
        <div class="header-links">
            <a href="index.php"><i class="bi bi-house"></i> Accueil</a>
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        </div>
    </div>

    <!-- PAGE HEADER -->
    <div class="page-header">
        <h1><i class="bi bi-folder"></i> Catégories</h1>
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