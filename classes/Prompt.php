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

    public function create($title, $content, $userId, $categoryId)
    {
        $title = trim($title);
        $content = trim($content);
        $userId = (int)$userId;
        $categoryId = (int)$categoryId;

        if (empty($title) || empty($content) || $userId <= 0 || $categoryId <= 0) {
            return false;
        }

        $sql = "INSERT INTO prompts (title, content, user_id, category_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $content, $userId, $categoryId]);
    }

    public function getAll()
    {
        $sql = "SELECT p.id, p.title, p.content, p.created_at, p.user_id, p.category_id, 
                       u.name AS author_name, c.name AS category_name 
                FROM prompts p
                INNER JOIN users u ON p.user_id = u.id 
                INNER JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC";
                
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCategory($categoryId)
    {
        $categoryId = (int)$categoryId;
        
        $sql = "SELECT p.id, p.title, p.content, p.created_at, p.user_id, p.category_id, 
                       u.name AS author_name, c.name AS category_name 
                FROM prompts p 
                INNER JOIN users u ON p.user_id = u.id 
                INNER JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = ? 
                ORDER BY p.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $id = (int)$id;
        
        $sql = "SELECT p.id, p.title, p.content, p.created_at, p.user_id, p.category_id, 
                       u.name AS author_name, c.name AS category_name 
                FROM prompts p 
                INNER JOIN users u ON p.user_id = u.id 
                INNER JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ?";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ?: null;
    }

    public function search($keyword, $categoryId = null)
    {
        $keyword = '%' . trim($keyword) . '%';
        $params = [];
        
        $sql = "SELECT p.id, p.title, p.content, p.created_at, p.user_id, p.category_id, 
                       u.name AS author_name, c.name AS category_name 
                FROM prompts p 
                INNER JOIN users u ON p.user_id = u.id 
                INNER JOIN categories c ON p.category_id = c.id ";
                
        if ($categoryId) {
            $sql .= "WHERE p.category_id = ? AND (p.title LIKE ? OR p.content LIKE ?) ";
            $params = [(int)$categoryId, $keyword, $keyword];
        } else {
            $sql .= "WHERE p.title LIKE ? OR p.content LIKE ? ";
            $params = [$keyword, $keyword];
        }
        $sql .= "ORDER BY p.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $content, $categoryId)
    {
        $id = (int)$id;
        $title = trim($title);
        $content = trim($content);
        $categoryId = (int)$categoryId;

        if ($id <= 0 || empty($title) || empty($content) || $categoryId <= 0) {
            return false;
        }

        $sql = "UPDATE prompts SET title = ?, content = ?, category_id = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $content, $categoryId, $id]);
    }

    public function delete($id)
    {
        $id = (int)$id;

        if ($id <= 0) {
            return false;
        }

        $sql = "DELETE FROM prompts WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function countAll()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM prompts");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }
}