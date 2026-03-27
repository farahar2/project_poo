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
        return $stmt->fetchAll();
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
    public function countAll(){
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM categories");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    public function update($id, $name){
        if(empty($name)){
            return false;
        }
        $sql = "UPDATE categories SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $id]);
    }
    public function delete($id){
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function findById($id){
        $sql = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]); 
        return $stmt->fetch();
        }

    }
?>