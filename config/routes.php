<?php

use App\controllers\AdminController;
use Config\DbConnect;
use App\controllers\AppController;
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

// Route Admin
$router->map('GET|POST', '/admin', function(){
    $auth = authGuard('admin');
    $controller = new AdminController(getDb());

    $error = null;
    $success = null;

    // Suppression user
    if(isset($_GET['delete'])){
        $controller->deleteUser((int) $_GET['delete']);
        header('location: /admin?deleted=1');
    }

    // Création user
    if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)){
        $result = $controller->createUser($_POST);

        $error = $result['error'] ?? null;
        $success = $result['success'] ?? null;

        header('Location: /admin?success=1');
        exit();
    }

    if(isset($_GET['success'])){
        $success = 'Utilisateur créé avec succès';
    }

    if(isset($_GET['delete'])){
        $success = 'Utilisateur supprimé avec succès';
    }

    $users = $controller->getAllUsers();

    render('dashboardAdmin', 'dashboard', compact('error', 'success', 'users'));
});

// Route edit user depuis admin
$router->map('GET|POST', '/admin/user/[i:id]/edit', function($id){
    $auth = authGuard('admin');

    $controller = new AdminController(getDb());
    $user = $controller->getUserById($id);

    if(!$user){
        echo "utilisateur non trouvé";
        exit;
    }

    $error = null;
    $success = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = $controller->updateUser($id, $_POST, $_FILES);
        $error = $result['error'] ?? null;
        $success = $result['success'] ?? null;
    }

    render('editUser', 'dashboard', compact('user', 'error', 'success'));
});

// Route user depuis admin
$router->map('GET', '/admin/user/[i:id]', function($id){
    $auth = authGuard('admin');

    $controller = new AdminController(getDb());
    $user = $controller->getUserById($id);

    if(!$user){
        echo "utilisateur non trouvé";
        exit;
    }

    $error = null;
    $success = null;

    render('clientProfile', 'dashboard', compact('user', 'error', 'success'));
});


// Route Dashboard user
$router->map('GET', '/user', function(){
    $auth = authGuard('user');
    render('dashboardUser', 'dashboard', [$auth->getUserId()]);
});

$router->map('GET', '/logout', function(){

    $auth = new Auth(getDb()->getPDO());
    $auth->logOut();

    $_SESSION = [];
    session_destroy();

    header('location: /login');
    exit();
});

$router->map('GET', '/politique-de-condidentialite', function(){
    render('politique-confidentialite');
});
