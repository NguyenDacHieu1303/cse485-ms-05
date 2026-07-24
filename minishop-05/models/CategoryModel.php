<?php
require_once __DIR__ . '/../config/database.php';

class CategoryModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function all(): array {
        $stmt =$this->db->query("SELECT * FROM categories ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt =$this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute([':id' =>$id]);
        $category =$stmt->fetch();
        return $category ?: null;
    }

    public function create(string $name, string$description): bool {
        $stmt =$this->db->prepare("INSERT INTO categories (name, description) VALUES (:name, :description)");
        return $stmt->execute([
            ':name'        => $name,
            ':description' => $description
        ]);
    }

    public function update(int $id, string $name, string$description): bool {
        $stmt =$this->db->prepare("UPDATE categories SET name = :name, description = :description WHERE id = :id");
        return $stmt->execute([
            ':name'        => $name,
            ':description' => $description,
            ':id'          => $id
        ]);
    }

    public function delete(int $id): bool {
        $stmt =$this->db->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute([':id' =>$id]);
    }

    public function existsByName(string $name, ?int $ignoreId = null): bool {
        if ($ignoreId) {
            $stmt =$this->db->prepare("SELECT COUNT(*) FROM categories WHERE name = :name AND id != :id");
            $stmt->execute([':name' =>$name, ':id' => $ignoreId]);
        } else {
            $stmt =$this->db->prepare("SELECT COUNT(*) FROM categories WHERE name = :name");
            $stmt->execute([':name' =>$name]);
        }
        return $stmt->fetchColumn() > 0;
    }
}