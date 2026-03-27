<?php

require_once __DIR__ . '/../config/Database.php';

class Prompt
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // --- CREATE ---
    public function create($title, $content, $userId, $categoryId)
    {
        if (empty($title) || empty($content) || empty($userId) || empty($categoryId)) {
            return false;
        }

        $sql = "INSERT INTO prompts (title, content, user_id, category_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $content, $userId, $categoryId]);
    }

    // --- READ ALL ---
    public function getAll()
    {
        $sql = "SELECT prompts.id, prompts.title, prompts.content, prompts.created_at, prompts.user_id, prompts.category_id, users.name
         AS author_name, categories.name 
         AS category_name 
         FROM prompts INNER JOIN users
         ON prompts.user_id = users.id 
         INNER JOIN categories 
         ON prompts.category_id = categories.id 
         ORDER BY prompts.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // --- READ BY CATEGORY ---
    public function getByCategory($categoryId)
    {
        $sql = "SELECT prompts.id, prompts.title, prompts.content, prompts.created_at, prompts.user_id, prompts.category_id, users.name 
        AS author_name, categories.name 
        AS category_name FROM prompts INNER JOIN users 
        ON prompts.user_id = users.id INNER JOIN categories 
        ON prompts.category_id = categories.id WHERE prompts.category_id = ? 
        ORDER BY prompts.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }

    // --- FIND BY ID ---
    public function findById($id)
    {
        $sql = "SELECT prompts.id, prompts.title, prompts.content, prompts.created_at, prompts.user_id, prompts.category_id, users.name AS author_name, categories.name AS category_name FROM prompts INNER JOIN users ON prompts.user_id = users.id INNER JOIN categories ON prompts.category_id = categories.id WHERE prompts.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
      public function countAll()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM prompts");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
}