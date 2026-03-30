<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once "../classes/Prompt.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$promptObj = new Prompt();
$prompt = $promptObj->findById($id);

// Ensure the prompt exists and the user is either the author or an admin
if (!$prompt || ($prompt['user_id'] != $_SESSION['user_id'] && $_SESSION['user_role'] !== 'admin')) {
    die("❌ Accès refusé : vous n'avez pas l'autorisation de supprimer ce prompt.");
}

$promptObj->delete($id);

header("Location: index.php");
exit;
