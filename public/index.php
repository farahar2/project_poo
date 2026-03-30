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

$categories = $category->getAll();
$categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    $prompts = $prompt->search($search, $categoryId);
} elseif($categoryId){
    $prompts = $prompt->getByCategory($categoryId);
} else {
    $prompts = $prompt->getAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil — Prompt Manager</title>
    <?php include "includes/head.php"; ?>
</head>
<body>

<div class="main-container">
    
    <!-- HEADER -->
    <div class="header">
        <h1>Prompt Manager</h1>
        <div class="header-links">
            <span class="user-info">
                <i class="bi bi-person-circle"></i> 
                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
            </span>
            <a href="create_prompt.php"><i class="bi bi-plus-lg"></i> Nouveau</a>
            <a href="categories.php"><i class="bi bi-folder"></i> Catégories</a>
            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <a href="admin/dashboard.php"><i class="bi bi-gear"></i> Admin</a>
            <?php endif; ?>
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        </div>
    </div>

    <!-- PAGE HEADER -->
    <div class="page-header">
        <div>
            <h1><i class="bi bi-collection"></i> Bibliothèque de Prompts</h1>
            <p class="subtitle">
                <?php echo count($prompts); ?> prompt<?php echo count($prompts) > 1 ? 's' : ''; ?> disponible<?php echo count($prompts) > 1 ? 's' : ''; ?>
            </p>
        </div>
        <a href="create_prompt.php" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouveau Prompt
        </a>
    </div>

    <!-- FILTRES ET RECHERCHE -->
    <div class="filters d-flex justify-content-between align-items-center" style="gap: 20px;">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="filters-title"><i class="bi bi-funnel"></i> Filtrer :</div>
            <div>
                <a href="index.php<?php echo !empty($search) ? '?search=' . urlencode($search) : ''; ?>" class="filter-btn <?php echo !$categoryId ? 'active' : ''; ?>">
                    Tous
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="index.php?category_id=<?php echo $cat['id']; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                       class="filter-btn <?php echo ($categoryId == $cat['id']) ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <form action="index.php" method="GET" class="d-flex gap-2" style="max-width: 300px; flex: 1; margin: 0;">
            <?php if ($categoryId): ?>
                <input type="hidden" name="category_id" value="<?php echo $categoryId; ?>">
            <?php endif; ?>
            <input type="text" name="search" class="form-control mb-0" 
                   placeholder="Rechercher un prompt..." 
                   value="<?php echo htmlspecialchars($search); ?>" style="padding: 7px 14px; font-size: 0.8125rem;">
            <button class="btn btn-primary" type="submit" style="padding: 7px 14px;">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <!-- LISTE DES PROMPTS -->
    <?php if (empty($prompts)): ?>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h3>Aucun prompt trouvé</h3>
            <p>Commencez par créer votre premier prompt !</p>
            <a href="create_prompt.php" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Créer un prompt
            </a>
        </div>
    <?php else: ?>
        <div class="prompts-grid">
        <?php foreach ($prompts as $p): ?>
            <div class="card prompt-card">
                <div class="card-body">
                    <div class="prompt-card-header">
                        <span class="badge-category">
                            <?php echo htmlspecialchars($p['category_name']); ?>
                        </span>
                    </div>
                    
                    <h5 class="card-title">
                        <?php echo htmlspecialchars($p['title']); ?>
                    </h5>
                    
                    <div class="content"><?php echo htmlspecialchars($p['content']); ?></div>
                    
                    <div class="prompt-card-footer">
                        <div class="meta">
                            <i class="bi bi-person"></i> <?php echo htmlspecialchars($p['author_name']); ?>
                            &nbsp;•&nbsp;
                            <i class="bi bi-calendar"></i> <?php echo date('d/m/Y', strtotime($p['created_at'])); ?>
                        </div>
                        
                        <?php if ($p['user_id'] == $_SESSION['user_id']): ?>
                            <div class="actions">
                                <a href="edit_prompt.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="delete_prompt.php?id=<?php echo $p['id']; ?>" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Supprimer ce prompt ?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php include "includes/scripts.php"; ?>
</body>
</html>