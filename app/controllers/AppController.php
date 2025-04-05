<?php

namespace App\controllers;

use Delight\Auth\Auth;
use Delight\Auth\EmailNotVerifiedException;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\TooManyRequestsException;

class AppController extends Controller{

    public function login(string $email, string $password): array
    {
        $auth = new Auth($this->getDB()->getPDO());

        try{
            $auth->login($email, $password, null, null, false);

            $stmt = $this->getDB()->getPDO()->prepare('SELECT role FROM users WHERE id = :id');
            $stmt->execute(['id' => $auth->getUserId()]);
            $user = $stmt->fetch();

            if ($user){
                if($user['role'] === 'admin'){
                header('location: /admin');
                exit();
                } elseif($user['role'] === 'user'){
                    header('location: /user');
                    exit();
                }
            }

            return ['error' => 'Rôle utilisateur non reconnu'];

        } catch (InvalidEmailException){
            return ['error' => 'Adresse e-mail invalide'];
        } catch (InvalidPasswordException){
            return ['error' => 'Mot de passe invalide'];
        } catch (EmailNotVerifiedException){
            return ['error' => 'E-mail non vérifié'];
        } catch (TooManyRequestsException){
            return ['error' => 'Trop de tentatives, réessaie plus tard'];
        }
    }

}