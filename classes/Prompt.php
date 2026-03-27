<?php
require_once __DIR__ . '/../config/Database.php';
class Prompt
{
    private $db;

    public function __construct(){
        $database = new Database();
        $this->db = $database->getConnection();
    }
    public function create($title, $content, $userId, $categoryId){
        if(empty($title) || empty($content)){
            return false;
            }
        $stmt = $this->db->prepare("INSERT INTO prompts (title, content, user_id, category_id) 
        VALUES (?, ?, ?, ?)");
    return $stmt->execute([$title, $content, $userId, $categoryId]);
      }
      public function getAll(){
        $stmt = $this->db->query("SELECT prompts.*,
        users.name AS author_name
        categories.name AS category_name
        FROM prompts
        INNER JOIN users ON prompts.user_id = users.id
        INNER JOIN categories ON promts.category = categories.id
        WHERE prompts.is_deleted = ?
        ORDER BY prompts.created_at DESC");
        $stmt->execute([CategoryId]);
        return $stmt->fetchAll();
      }
      public function getBycategory($categoryId){
        $stmt = $this->db->prepare("SELECT prompts.*,
        users.name AS author_name
        categories.name AS category_name
        FROM prompts
        INNER JOIN users ON prompts.user_id = users.id
        INNER JOIN categories ON promts.category_id = categories.id
        WHERE prompts.category_id = ?
        ORDER BY prompts.created_at DESC");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
      }
      public function findById($id){
        $stmt = $this->db->prepare(
        "SELECT prompts.*,
        users.name AS author_name
        categories.name AS category_name
        FROM prompts
        INNER JOIN users ON prompts.user_id = users.id
        INNER JOIN categories ON prompts.category_id = categories.id
        WHERE prompts.id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
      }
      }
      ?>