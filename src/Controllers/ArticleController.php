<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Article;

class ArticleController
{
    public function __construct(private readonly View $view) {}

    public function show(string $id): void
    {
        $articleModel = new Article();

        $article = $articleModel->getById((int) $id);

        if (!$article) {
            http_response_code(404);
            echo '404 Not Found';
            return;
        }

        $viewedAt = $_SESSION['viewed'][$id] ?? 0;
        if (time() - $viewedAt > 86400) {
            $articleModel->incrementViews((int) $id);
            $_SESSION['viewed'][$id] = time();
            $article['views']++;
        }

        $categories = $articleModel->getCategoriesForArticle((int) $id);
        $similar    = $articleModel->getSimilar((int) $id, 4);

        $firstCat    = $categories[0] ?? null;
        $breadcrumbs = [['title' => 'Главная', 'url' => '/']];
        if ($firstCat) {
            $breadcrumbs[] = ['title' => $firstCat['name'], 'url' => '/category/' . $firstCat['id']];
        }
        $breadcrumbs[] = ['title' => $article['title'], 'url' => null];

        $this->view->render('article/show.tpl', [
            'title'       => $article['title'],
            'article'     => $article,
            'categories'  => $categories,
            'similar'     => $similar,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
