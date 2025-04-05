<?php

use Config\DbConnect;
use Delight\Auth\Auth;

function detectBasePath(): string {
    return str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
}

function render(string $view, string $layout = 'public', array $params = []): void
{
    extract($params);

    ob_start();
    require_once __DIR__ . '/../app/views/' . $view . '.php';
    $content = ob_get_clean();
    extract(['content' => $content]);
    require_once __DIR__ . '/../app/views/layouts/' . $layout . '.php';
}

function authGuard(string $expectedRole): Auth
{
    $auth = new Auth(getDb()->getPDO());

    if(!$auth->isLoggedIn()){
        header('location: /login');
        exit();
    }

    $stmt = getDb()->getPDO()->prepare('SELECT role FROM users WHERE id = :id');
    $stmt->execute(['id' => $auth->getUserId()]);
    $user = $stmt->fetch();

    if(!$user || $user['role'] !== $expectedRole){
        echo "Accès non autorisé à cette page.";
        exit();
    }

    return $auth;
}

function getDb(): DbConnect{
    static $db = null;

    if ($db === null){
        $db = new DbConnect(
            $_ENV['DB_HOST'],
            $_ENV['DB_NAME'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD']
        );
    }
    return $db;
}
