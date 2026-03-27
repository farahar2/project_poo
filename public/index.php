<?php
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
$categoryId = $_GET['category_id'] ?? null;

if($categoryId){
    $prompts = $prompt->getByCategory($categoryId);
} else {
    $prompts = $prompt->getAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
     <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2c3e50;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .header a {
            color: #ecf0f1;
            text-decoration: none;
            margin-left: 15px;
        }
        .header a:hover {
            text-decoration: underline;
        }
        .filters {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .filters a {
            display: inline-block;
            padding: 6px 14px;
            margin: 4px;
            background-color: #ecf0f1;
            color: #2c3e50;
            text-decoration: none;
            border-radius: 20px;
            font-size: 14px;
        }
        .filters a:hover {
            background-color: #3498db;
            color: white;
        }
        .filters a.active {
            background-color: #3498db;
            color: white;
        }
        .prompt-card {
            background-color: white;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .prompt-card h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        .prompt-card .meta {
            font-size: 13px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }
        .prompt-card .content {
            background-color: #f8f9fa;
            padding: 12px;
            border-radius: 5px;
            border-left: 4px solid #3498db;
            white-space: pre-wrap;
        }
        .no-results {
            text-align: center;
            color: #7f8c8d;
            padding: 40px;
        }
    </style>
    <title>Accueil</title>
</head>
<body>
  
    <!-- EN-TÊTE -->
    <div class="header">
        <div>
            <strong>🧠 Prompt Manager</strong> — 
            Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?> !
        </div>
        <div>
            <a href="create_prompt.php">➕ Nouveau Prompt</a>
            <a href="categories.php">📁 Catégories</a>
            <a href="logout.php">🚪 Déconnexion</a>
        </div>
    </div>

    <!-- FILTRES PAR CATÉGORIE -->
    <div class="filters">
        <strong>Filtrer par :</strong>

        <!-- Lien "Tous" -->
        <a href="index.php" class="<?php echo !$categoryId ? 'active' : ''; ?>">
            Tous
        </a>

        <!-- Un lien par catégorie -->
        <?php foreach ($categories as $cat): ?>
            <a href="index.php?category_id=<?php echo $cat['id']; ?>"
               class="<?php echo ($categoryId == $cat['id']) ? 'active' : ''; ?>">
                <?php echo htmlspecialchars($cat['name']); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- LISTE DES PROMPTS -->
    <h2>
        <?php if ($categoryId): ?>
            Prompts filtrés
        <?php else: ?>
            Tous les prompts
        <?php endif; ?>
        (<?php echo count($prompts); ?> résultat<?php echo count($prompts) > 1 ? 's' : ''; ?>)
    </h2>

    <?php if (empty($prompts)): ?>
        <div class="no-results">
            <p>Aucun prompt trouvé.</p>
            <a href="create_prompt.php">Créer le premier !</a>
        </div>
    <?php else: ?>
        <?php foreach ($prompts as $p): ?>
            <div class="prompt-card">
                <h3><?php echo htmlspecialchars($p['title']); ?></h3>
                <div class="meta">
                    👤 <?php echo htmlspecialchars($p['author_name']); ?> | 
                    📁 <?php echo htmlspecialchars($p['category_name']); ?> | 
                    📅 <?php echo date('d/m/Y H:i', strtotime($p['created_at'])); ?>
                </div>
                <div class="content"><?php echo htmlspecialchars($p['content']); ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>