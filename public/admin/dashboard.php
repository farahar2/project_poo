<?php
$cssPath = "../";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['user_role'] !== 'admin') {
    die("❌ Accès refusé : réservé aux administrateurs");
}

require_once "../../classes/User.php";
require_once "../../classes/Category.php";
require_once "../../classes/Prompt.php";

$user = new User();
$category = new Category();
$prompt = new Prompt();

$totalUsers = $user->countAll();
$totalCategories = $category->countAll();
$totalPrompts = $prompt->countAll();
$topContributors = $user->getTopContributors(5);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — Prompt Manager</title>
    <?php include "../../public/includes/head.php"; ?>
</head>
<body>

<div class="main-container">
    
    <!-- HEADER -->
    <div class="header" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
        <h1><i class="bi bi-gear"></i> Dashboard Admin</h1>
        <div class="header-links">
            <a href="../index.php"><i class="bi bi-house"></i> Accueil</a>
            <a href="categories.php"><i class="bi bi-folder"></i> Catégories</a>
            <a href="../logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        </div>
    </div>

    <!-- PAGE HEADER -->
    <div class="page-header">
        <div>
            <h1><i class="bi bi-speedometer2"></i> Vue d'ensemble</h1>
            <p class="subtitle">Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
        </div>
        <a href="categories.php" class="btn btn-primary">
            <i class="bi bi-folder-plus"></i> Gérer les catégories
        </a>
    </div>

    <!-- STATISTIQUES -->
    <div class="stats-grid">
        <div class="stat-card purple">
            <i class="bi bi-people" style="font-size: 2rem;"></i>
            <div class="stat-number"><?php echo $totalUsers; ?></div>
            <div class="stat-label">Utilisateurs</div>
        </div>
        <div class="stat-card green">
            <i class="bi bi-folder" style="font-size: 2rem;"></i>
            <div class="stat-number"><?php echo $totalCategories; ?></div>
            <div class="stat-label">Catégories</div>
        </div>
        <div class="stat-card pink">
            <i class="bi bi-file-text" style="font-size: 2rem;"></i>
            <div class="stat-number"><?php echo $totalPrompts; ?></div>
            <div class="stat-label">Prompts</div>
        </div>
    </div>

    <!-- TOP CONTRIBUTEURS -->
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4"><i class="bi bi-trophy"></i> Top 5 des Contributeurs</h4>
            
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Prompts créés</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $rang = 1;
                        foreach ($topContributors as $contributor): 
                        ?>
                            <tr>
                                <td>
                                    <?php if ($rang === 1): ?>
                                        <span class="rank-badge gold">🥇 1er</span>
                                    <?php elseif ($rang === 2): ?>
                                        <span class="rank-badge silver">🥈 2ème</span>
                                    <?php elseif ($rang === 3): ?>
                                        <span class="rank-badge bronze">🥉 3ème</span>
                                    <?php else: ?>
                                        <?php echo $rang; ?>ème
                                    <?php endif; ?>
                                </td>
                                <td><strong><?php echo htmlspecialchars($contributor['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($contributor['email']); ?></td>
                                <td>
                                    <span class="badge bg-primary"><?php echo $contributor['prompts_count']; ?></span>
                                </td>
                            </tr>
                        <?php 
                        $rang++;
                        endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include "../../public/includes/scripts.php"; ?>
</body>
</html>