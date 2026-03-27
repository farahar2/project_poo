<?php
$cssPath = "../";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['user_role'] !== 'admin') {
    die("❌ Accès refusé");
}

require_once "../../classes/Category.php";

$categoryObj = new Category();
$message = "";
$messageType = "";

// CRÉER
if (isset($_POST['create'])) {
    $name = trim($_POST['name'] ?? "");
    if ($categoryObj->create($name)) {
        $message = "Catégorie créée !";
        $messageType = "success";
    } else {
        $message = "Erreur : nom vide ou catégorie déjà existante.";
        $messageType = "danger";
    }
}

// MODIFIER
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name'] ?? "");
    if ($categoryObj->update($id, $name)) {
        $message = "Catégorie modifiée !";
        $messageType = "success";
    } else {
        $message = "Erreur lors de la modification.";
        $messageType = "danger";
    }
}

// SUPPRIMER
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($categoryObj->delete($id)) {
        $message = "Catégorie supprimée !";
        $messageType = "success";
    } else {
        $message = "Erreur : impossible de supprimer.";
        $messageType = "danger";
    }
}

$categories = $categoryObj->getAll();
$editCategory = null;

if (isset($_GET['edit'])) {
    $editCategory = $categoryObj->findById($_GET['edit']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Catégories — Admin</title>
    <?php include "../../public/includes/head.php"; ?>
</head>
<body>

<div class="main-container">
    
    <!-- HEADER -->
    <div class="header" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
        <h1><i class="bi bi-gear"></i> Admin — Catégories</h1>
        <div class="header-links">
            <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="../index.php"><i class="bi bi-house"></i> Accueil</a>
            <a href="../logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        </div>
    </div>

    <!-- PAGE HEADER -->
    <div class="page-header">
        <h1><i class="bi bi-folder"></i> Gestion des Catégories</h1>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo $messageType; ?>">
            <i class="bi bi-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- FORMULAIRE CRÉER / MODIFIER -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST">
                <?php if ($editCategory): ?>
                    <h5 class="mb-3"><i class="bi bi-pencil"></i> Modifier la catégorie</h5>
                    <input type="hidden" name="id" value="<?php echo $editCategory['id']; ?>">
                    <div class="d-flex gap-2">
                        <input type="text" name="name" class="form-control" required
                               value="<?php echo htmlspecialchars($editCategory['name']); ?>">
                        <button type="submit" name="update" class="btn btn-primary">
                            <i class="bi bi-save"></i> Enregistrer
                        </button>
                        <a href="categories.php" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                <?php else: ?>
                    <h5 class="mb-3"><i class="bi bi-plus-circle"></i> Créer une nouvelle catégorie</h5>
                    <div class="d-flex gap-2">
                        <input type="text" name="name" class="form-control" 
                               required placeholder="Nom de la catégorie">
                        <button type="submit" name="create" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Créer
                        </button>
                    </div>
                <?php endif; ?>
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?php echo $cat['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($cat['name']); ?></strong></td>
                        <td><?php echo date('d/m/Y', strtotime($cat['created_at'])); ?></td>
                        <td>
                            <a href="?edit=<?php echo $cat['id']; ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Modifier
                            </a>
                            <a href="?delete=<?php echo $cat['id']; ?>" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Supprimer cette catégorie ?');">
                                <i class="bi bi-trash"></i> Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include "../../public/includes/scripts.php"; ?>
</body>
</html>