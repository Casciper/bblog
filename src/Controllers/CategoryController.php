<?php

namespace App\Controllers;

use App\Core\View;

class CategoryController
{
    public function __construct(private readonly View $view) {}

    public function show(string $id, int $page): void
    {
        $this->view->render('category/show.tpl', [
            'title' => 'Категория',
        ]);
    }
}
