<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header("Location: ../login.php");
  exit();
}
if($_SESSION['user_role'] !== 'admin'){
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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .header {
            background-color: #e74c3c;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .stat-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            margin: 0;
            font-size: 36px;
            color: #3498db;
        }
        .stat-card p {
            margin: 5px 0 0 0;
            color: #7f8c8d;
        }
        table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }
        th {
            background-color: #34495e;
            color: white;
        }
        tr:hover {
            background-color: #f8f9fa;
        }
        .nav {
            margin-bottom: 20px;
        }
        .nav a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }
        .nav a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
   <div class="header">
        <h1>🔧 Dashboard Administrateur</h1>
        <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?> !</p>
    </div>

    <div class="nav">
        <a href="../index.php">🏠 Accueil</a>
        <a href="categories.php">📁 Gérer les Catégories</a>
        <a href="../logout.php">🚪 Déconnexion</a>
    </div>

    <!-- STATISTIQUES -->
    <h2>📊 Statistiques</h2>
    <div class="stats">
        <div class="stat-card">
            <h3><?php echo $totalUsers; ?></h3>
            <p>Utilisateurs</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $totalCategories; ?></h3>
            <p>Catégories</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $totalPrompts; ?></h3>
            <p>Prompts</p>
        </div>
    </div>

    <!-- TOP CONTRIBUTEURS -->
    <h2>🏆 Top Contributeurs</h2>
    <table>
        <thead>
            <tr>
                <th>Rang</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Nombre de Prompts</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $rang = 1;
            foreach ($topContributors as $contributor): 
            ?>
                <tr>
                    <td><?php echo $rang++; ?></td>
                    <td><?php echo htmlspecialchars($contributor['name']); ?></td>
                    <td><?php echo htmlspecialchars($contributor['email']); ?></td>
                    <td><strong><?php echo $contributor['prompts_count']; ?></strong></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>