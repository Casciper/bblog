<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Category;

class HomeController
{
    public function __construct(private readonly View $view) {}

    public function index(): void
    {
        $category = new Category();

        $this->view->render('home/index.tpl', [
            'title'      => 'Главная',
            'categories' => $category->getWithArticles(),
        ]);
    }
}
