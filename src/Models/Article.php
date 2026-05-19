<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Article
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByCategory(int $categoryId, int $page, int $perPage, string $sort = 'date'): array
    {
        $orderBy = match ($sort) {
            'views' => 'a.views DESC',
            'title' => 'a.title ASC',
            default => 'a.created_at DESC',
        };

        $offset = ($page - 1) * $perPage;

        $stmt = $this->db->prepare(
            "SELECT a.id, a.title, a.description, a.image, a.views, a.created_at
             FROM articles a
             JOIN article_categories ac ON ac.article_id = a.id
             WHERE ac.category_id = ?
             ORDER BY {$orderBy}
             LIMIT ? OFFSET ?"
        );
        $stmt->execute([$categoryId, $perPage, $offset]);
        return $stmt->fetchAll();
    }

    public function getSimilar(int $articleId, int $limit = 4): array
    {
        $stmt = $this->db->prepare(
            'SELECT DISTINCT a.id, a.title, a.description, a.image, a.views, a.created_at
             FROM articles a
             JOIN article_categories ac ON ac.article_id = a.id
             WHERE ac.category_id IN (
                 SELECT category_id FROM article_categories WHERE article_id = ?
             )
             AND a.id != ?
             ORDER BY a.created_at DESC
             LIMIT ?'
        );
        $stmt->execute([$articleId, $articleId, $limit]);
        return $stmt->fetchAll();
    }

    public function getCategoriesForArticle(int $articleId): array
    {
        $stmt = $this->db->prepare(
            'SELECT c.id, c.name
             FROM categories c
             JOIN article_categories ac ON ac.category_id = c.id
             WHERE ac.article_id = ?'
        );
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }

    public function incrementViews(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE articles SET views = views + 1 WHERE id = ?');
        $stmt->execute([$id]);
    }
}
