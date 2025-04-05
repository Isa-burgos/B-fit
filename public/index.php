<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

require_once __DIR__ . '/../config/session.php';

require_once __DIR__ . '/../config/DbConnect.php';
require_once __DIR__ . '/../config/helpers.php';

$router = new AltoRouter();
$router->setBasePath(detectBasePath());

require_once __DIR__ . '/../config/routes.php';

$match = $router->match();
// var_dump($_SERVER['REQUEST_URI']);
// var_dump($match);


if( is_array($match) && is_callable( $match['target'] ) ) {
  call_user_func_array( $match['target'], $match['params'] );
} else {
  echo '404 - Page not found';
}
require_once __DIR__ . '/../app/views/partials/header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])){
  $result = $appController->login($_POST['email'], $_POST['password']);
  $error = $result['error'] ?? null;
}