<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header("Location: ../login.php");
  exit();
}
if($_SESSION['user_role'] !== 'admin'){
  die("❌ Accès refusé");
}

require_once "../classes/Category.php";

$categoryObj = new Category();
$message = "";

if(isset($_POST['create'])){
  $name = trim($_POST['name'] ?? "");
  if($categoryObj->create($name)){
    $message = "✅  Catégorie créée !";
  } else {
    $message = "❌  Erreur : nom vide ou catégorie existe déjà.";
  }

  if(isset($_POST['update'])){
    $id = $_POST['id'] ?? "";
    $name = trim($_POST['name'] ?? "");
    if($categoryObj->update($id, $name)){
      $message = "✅  Catégorie modifiée !";
    } else {
      $message = "❌  Erreur lors de la modification.";
    }
  }
  
  if(isset($_POST['delete'])){
    $id = $_POST['id'] ?? "";
    if($categoryObj->delete($id)){
      $message = "✅  Catégorie supprimée !";
    } else {
      $message = "❌  Erreur : impossible de supprimer une catégorie liée à des prompts.";
}
}

$categories = $categoryObj->getAll();
$editCategory = null;

if(isset($_GET['edit'])){
  $editCategory = $categoryObj->findById($_GET['edit']);
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Gestion des Catégories</title>
   <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; background-color: #f5f5f5; }
        .header { background-color: #e74c3c; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        form { background-color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        input[type="text"] { width: 70%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #2980b9; }
        table { width: 100%; background-color: white; border-collapse: collapse; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ecf0f1; }
        th { background-color: #34495e; color: white; }
        a { color: #3498db; text-decoration: none; margin-right: 10px; }
        a:hover { text-decoration: underline; }
        .delete { color: #e74c3c; }
    </style>
</head>
<body>
   <div class="header">
        <h1>📁 Gestion des Catégories</h1>
    </div>

    <a href="dashboard.php">← Retour au Dashboard</a>

    <?php if (!empty($message)): ?>
        <p><strong><?php echo $message; ?></strong></p>
    <?php endif; ?>

    <!-- FORMULAIRE CRÉER / MODIFIER -->
    <form method="POST">
        <?php if ($editCategory): ?>
            <h2>Modifier la catégorie</h2>
            <input type="hidden" name="id" value="<?php echo $editCategory['id']; ?>">
            <input type="text" name="name" value="<?php echo htmlspecialchars($editCategory['name']); ?>" required>
            <button type="submit" name="update">Enregistrer</button>
            <a href="categories.php">Annuler</a>
        <?php else: ?>
            <h2>Créer une nouvelle catégorie</h2>
            <input type="text" name="name" placeholder="Nom de la catégorie" required>
            <button type="submit" name="create">Créer</button>
        <?php endif; ?>
    </form>

    <!-- LISTE DES CATÉGORIES -->
    <h2>Liste des catégories</h2>
    <table>
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
                    <td><?php echo htmlspecialchars($cat['name']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($cat['created_at'])); ?></td>
                    <td>
                        <a href="?edit=<?php echo $cat['id']; ?>">✏️ Modifier</a>
                        <a href="?delete=<?php echo $cat['id']; ?>" 
                           class="delete"
                           onclick="return confirm('Supprimer cette catégorie ?');">
                            🗑️ Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>