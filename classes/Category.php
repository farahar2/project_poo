<?php

require_once __DIR__ . '/../config/Database.php';

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

    public function create($name)
    {
        $name = trim($name);

        if (empty($name)) {
            return false;
        }

        // Check if category already exists
        $check = $this->db->prepare("SELECT id FROM categories WHERE name = ?");
        $check->execute([$name]);
        if ($check->fetch()) {
            return false;
        }

        $stmt = $this->db->prepare("INSERT INTO categories (name) VALUES (?)");
        return $stmt->execute([$name]);
    }

    public function countAll()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM categories");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function update($id, $name)
    {
        $name = trim($name);

        if ($id <= 0 || $name === '') {
            return false;
        }

        $stmt = $this->db->prepare("UPDATE categories SET name = ? WHERE id = ?");
        return $stmt->execute([$name, $id]);
    }

    public function delete($id)
    {
        if ($id <= 0) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function findById($id)
    {
        if ($id <= 0) {
            return null;
        }

        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result !== false ? $result : null;
    }
}