<?php

use App\controllers\AdminController;
use Config\DbConnect;
use App\controllers\AppController;
use App\controllers\UserController;
use Delight\Auth\Auth;

// Création du contrôleur principal
$db = new DbConnect(
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'],
    );
    
    $appController = new AppController($db);

// Déclaration des routes
$router->map('GET', '/', function(){
    render('home');
});
    
$router->map('GET|POST', '/login', function () use ($appController) {
    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $result = $appController->login($email, $password);
        $error = $result['error'] ?? null;
    }

    render('login', 'public', compact('error'));
});

// Accueil du dashboard admin
$router->map('GET|POST', '/admin', function(){
    $auth = authGuard('admin');
    $controller = new AdminController(getDb());
    $controller->dashboard();
});

// Route edit user depuis admin
$router->map('GET|POST', '/admin/user/[i:id]/edit', function($id){
    $auth = authGuard('admin');
    $controller = new AdminController(getDb());
    $controller->editUser($id);
});

// Route user depuis admin
$router->map('GET', '/admin/user/[i:id]', function($id){
    $auth = authGuard('admin');
    $controller = new AdminController(getDb());
    $controller->viewClientProfile($id);
});

// Liste des clients
$router->map('GET', '/admin/clients', function(){
    $auth = authGuard('admin');
    $controller = new AdminController(getDb());
    $controller->clients();
});

// Route programme d'entaînement
$router->map('GET', '/admin/training', function(){
    $auth = authGuard('admin');
    $controller = new AdminController(getDb());
    $controller->training();
});


// Route Dashboard user
$router->map('GET', '/user', function(){
    $auth = authGuard('user');
    $controller = new UserController(getDb());
    $controller->dashboard($auth->getUserId());
});

$router->map('GET', '/logout', function(){

    $auth = new Auth(getDb()->getPDO());
    $auth->logOut();

    $_SESSION = [];
    session_destroy();

    header('location: /login');
    exit();
});

// Route Politique de confidentialité
$router->map('GET', '/politique-confidentialite', function(){
    header('location: /politique-confidentialite');
    exit();
});
