<?php

namespace App\Core;

use Smarty\Smarty;

class View
{
    private Smarty $smarty;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/config.php';

        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir($config['smarty']['templates']);
        $this->smarty->setCompileDir($config['smarty']['compiled']);
        $this->smarty->setCacheDir($config['smarty']['cache']);
        $this->smarty->caching = false;
    }

    public function render(string $template, array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display($template);
    }
}
