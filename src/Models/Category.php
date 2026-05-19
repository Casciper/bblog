<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Category
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM categories ORDER BY name ASC');
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getWithArticles(int $limit = 3): array
    {
        $categories = $this->getAll();

        foreach ($categories as &$category) {
            $stmt = $this->db->prepare(
                'SELECT a.id, a.title, a.description, a.image, a.views, a.created_at
                 FROM articles a
                 JOIN article_categories ac ON ac.article_id = a.id
                 WHERE ac.category_id = ?
                 ORDER BY a.created_at DESC
                 LIMIT ?'
            );
            $stmt->execute([$category['id'], $limit]);
            $category['articles'] = $stmt->fetchAll();
        }

        return $categories;
    }

    public function countArticles(int $categoryId): int
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM article_categories WHERE category_id = ?'
        );
        $stmt->execute([$categoryId]);
        return (int) $stmt->fetchColumn();
    }
}
