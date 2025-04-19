<?php

namespace App\controllers;

use Config\DbConnect;

abstract class Controller{

    protected $db;

    public function __construct(DbConnect $db)
    {
        $this->db = $db;
    }

    protected function getDB()
    {
        return $this->db;
    }

    protected function render(string $view, string $layout = 'public', array $params = []): void
    {
        extract($params);

        ob_start();
        require_once dirname(__DIR__) . '/../app/views/' . $view . '.php';
        $content = ob_get_clean();
        extract(['content' => $content]);
        require_once dirname(__DIR__) . '/../app/views/layouts/' . $layout . '.php';
    }

}