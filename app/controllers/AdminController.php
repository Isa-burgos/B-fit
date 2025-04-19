<?php

namespace App\controllers;

use App\models\UserModel;
use App\repositories\UserRepository;
use Config\DbConnect;
use Delight\Auth\Auth;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UserAlreadyExistsException;

class AdminController extends Controller{

    private UserRepository $repo;

    public function __construct(DbConnect $db)
    {
        parent::__construct($db);
        $this->repo = new UserRepository($db);
    }

    public function dashboard(): void
    {
        $users = $this->getAllUsers();

        $this->render('dashboardAdmin', 'dashboard', compact('users'));
    }

    public function clients(): void
    {
        $error = null;
        $success = null;

        // Suppression user
        $userRepo = new UserRepository($this->getDB());

        if(isset($_GET['delete'])){
            $userRepo->deleteUser((int) $_GET['delete']);
            header('location: /admin?deleted=1');
            exit();
        }

        // Création user
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)){
            $result = $userRepo->createUser($_POST);
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

        $users = $this->getAllUsers();

        $this->render('admin/clients', 'dashboard', compact('users', 'error', 'success'));
    }

    public function training()
        {
            $this->render('admin/training', 'dashboard');
        }

    public function getAllUsers(): array
    {
        return $this->repo->findAll('user', 'active');
    }

    public function getUserById(int $id): ?UserModel
    {
        return $this->repo->find($id);
    }

    public function viewClientProfile(int $id)
    {
        $user = $this->getUserById($id);

        if(!$user){
            echo "utilisateur non trouvé";
            exit;
        }
    
        $error = null;
        $success = null;
    
        render('clientProfile', 'dashboard', compact('user', 'error', 'success'));
    }

    public function editUser(int $id)
    {
        $user = $this->getUserById($id);

        if(!$user){
            echo "utilisateur non trouvé";
            exit;
        }
    
        $error = null;
        $success = null;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->updateUser($id, $_POST, $_FILES);
            $error = $result['error'] ?? null;
            $success = $result['success'] ?? null;
        }
    
        render('editUser', 'dashboard', compact('user', 'error', 'success'));
    }

    public function updateUser($id, $data, $files): array
    {
        return $this->repo->updateUser($id, $data, $files);
    }

    public function getRepo(): UserRepository
{
    return $this->repo;
}


    
}