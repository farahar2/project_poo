<?php

require_once __DIR__ . '/../config/Database.php';

class User
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function register($name, $email, $password)
    {
        $name  = trim($name);
        $email = trim($email);

        if (empty($name) || empty($email) || empty($password)) {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $check = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetch(PDO::FETCH_ASSOC)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'developer')";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([$name, $email, $hashedPassword]);
    }

    public function login($email, $password)
    {
        $email = trim($email);

        if (empty($email) || empty($password)) {
            return false;
        }

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        // Verify password
        if (password_verify($password, $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            session_regenerate_id(true);

            $_SESSION['user_id']   = (int)$user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            
            return true;
        }

        return false;
    }

    public function countAll()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM users");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return (int)$result['total'];
    }

    public function getTopContributors($limit = 5)
    {
        $limit = (int)$limit;

        $sql = "SELECT u.id, u.name, u.email, COUNT(p.id) AS prompts_count 
                FROM users u
                INNER JOIN prompts p ON u.id = p.user_id 
                GROUP BY u.id, u.name, u.email 
                ORDER BY prompts_count DESC 
                LIMIT " . $limit;

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}