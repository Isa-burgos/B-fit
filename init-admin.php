<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/DbConnect.php';

use Dotenv\Dotenv;
use Config\DbConnect;
use Delight\Auth\Auth;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$dbInstance = new DbConnect('DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD');

$db = $dbInstance->getPDO();

$auth = new Auth($db);

try {
    $userId = $auth->register('admin@bfit.local', 'password123', 'Coach Admin', function ($selector, $token) {
        // Pas besoin d'email de vérif ici
    });

    $db->prepare("UPDATE users SET status = 'admin' WHERE id = ?")->execute([$userId]);

    echo "✅ Admin créé avec succès (ID: $userId)";
}
catch (\Delight\Auth\InvalidEmailException $e) {
    echo 'Email invalide';
}
catch (\Delight\Auth\UserAlreadyExistsException $e) {
    echo 'Utilisateur existe déjà';
}
