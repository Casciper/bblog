<?php

namespace App\Controllers;

use App\Core\View;

class ArticleController
{
    public function __construct(private readonly View $view) {}

    public function show(string $id): void
    {
        $this->view->render('article/show.tpl', [
            'title' => 'Статья',
        ]);
    }
}
