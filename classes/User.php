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
        if (empty($name) || empty($email) || empty($password)) {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $check = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetch()) {
            return false;
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')"
        );
        $result = $stmt->execute([$name, $email, $hashedPassword]);

        return $result;
    }
    public function login($email, $password){

        if (empty($email) || empty($password)) {
            return false;
        }

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        }
        return false;
    }

    public function countAll(){
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM users");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ;
    }

    public function getTopContributors($limit = 5){
        $limit = (int)$limit; // S'assurer que c'est un entier

        $sql = "SELECT 
        users.id, 
        users.name,
        users.email,
         COUNT(prompts.id) AS prompts_count 
        FROM users 
        INNER JOIN prompts ON users.id = prompts.user_id 
        GROUP BY users.id ORDER BY prompts_count DESC LIMIT $limit";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}