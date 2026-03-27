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
$message = "";

$categories = $category->getAll();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);
  $categoryId = $_POST['category_id'];

  $userId = $_SESSION['user_id'];

  if($prompt->create($title, $content, $userId, $categoryId)){
    $message = "✅  Prompt créé !";
  } else {
    $message = "❌  Erreur : titre ou contenu vide.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Créer un Prompt</title>
</head>
<body>
  <h1>Créer un nouveau Prompt</h1>
  <?php if(!empty($message)) { ?>
    <p><?php echo $message; ?></p>
  <?php } ?>
  <form method="POST">
    <label>Titre :</label><br>
    <input type="text" name="title" required placeholder="Ex: Générer du React"><br><br>

    <label>Catégorie :</label><br>
    <select name="category_id" required>
      <option value="">Sélectionnez une catégorie</option>
      <?php foreach($categories as $cat) { ?>
        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
      <?php } ?>
    </select><br><br>
    <label>Contenu du prompt :</label>
    <textarea name="content" rows="6" cols="50" required placeholder="Écris ton prompt ici.."></textarea><br><br>
    <button type="submit">Enregistrer le Prompt</button>
  </form>
  <a href="index.php">Retour à l'accueil</a>
</body>
</html>