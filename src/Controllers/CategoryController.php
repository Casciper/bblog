<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Article;
use App\Models\Category;

class CategoryController
{
    public function __construct(private readonly View $view) {}

    public function show(string $id, int $page): void
    {
        $config   = require __DIR__ . '/../../config/config.php';
        $perPage  = $config['pagination']['per_page'];
        $sort     = in_array($_GET['sort'] ?? '', ['views', 'title', 'date']) ? $_GET['sort'] : 'date';

        $categoryModel = new Category();
        $articleModel  = new Article();

        $category = $categoryModel->getById((int) $id);

        if (!$category) {
            http_response_code(404);
            echo '404 Not Found';
            return;
        }

        $total    = $categoryModel->countArticles((int) $id);
        $pages    = (int) ceil($total / $perPage);
        $page     = max(1, min($page, $pages ?: 1));
        $articles = $articleModel->getByCategory((int) $id, $page, $perPage, $sort);

        $breadcrumbs = [
            ['title' => 'Главная',          'url' => '/'],
            ['title' => $category['name'],  'url' => '/category/' . $id],
        ];
        if ($page > 1) {
            $breadcrumbs[] = ['title' => 'Страница ' . $page, 'url' => null];
        }

        $this->view->render('category/show.tpl', [
            'title'       => $category['name'],
            'category'    => $category,
            'articles'    => $articles,
            'sort'        => $sort,
            'page'        => $page,
            'pages'       => $pages,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
