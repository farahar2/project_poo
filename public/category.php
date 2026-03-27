<?php 
session_start();
if(!isset($_SESSION['user_id'])){
  header("Location: login.php");
  exit();
}
require_once "../classes/Category.php";
$category = new Category();
$message = "";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $name = trim($_POST['name']);
  if($category->create($name)){
    $message = "✅  Catégorie ajoutée !";
  } else {
    $message = "❌  Erreur : nom vide ou catégorie existe déjà.";
  }
}
$categories = $category->getAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Catégories</title>
</head>
<body>
  <h1>Gérer les catégories</h1>
  <?php if(!empty($message)) { ?>
    <p><?php echo $message; ?></p>
  <?php } ?>
  <form method="POST">
    <label for="name">Nom de la catégorie :</label>
    <input type="text" id="name" name="name" required>
    <button type="submit">Ajouter</button>
  </form>
  <h2>Liste catégories</h2>
  <ul>
    <?php foreach($categories as $cat): ?>
      <li><?php echo htmlspecialchars($cat['name']); ?></li>
    <?php endforeach; ?>
  </ul>
  <a href="index.php">Retour à l'accueil</a>
</body>
</html>