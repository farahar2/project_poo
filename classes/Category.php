<?php
require_once __DIR__ .'/../config/Database.php';
class Category
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
        return $stmt->fetchAll;
    }
    public function create($name){
        if(empty($name)){
            return false;
        }
        $check = $this->db->prepare("SELECT id FROM category WHERE name = ?");
        $check->execute([$name]);
        if($check->fetch()){
          return false;
        }
        $stmt = $this->db->prepare("INSERT INTO category (name) VALUES (?)");
        return $stmt->execute([$name]);
    }
    }
?>