<?php

namespace App\controllers;

use Delight\Auth\Auth;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UserAlreadyExistsException;

class AdminController extends Controller{

    public function createUser(array $data): array
    {
        $auth = new Auth($this->getDB()->getPDO());

        try{
            $filename = null;

            if(!empty($_FILES['profile_picture']['tmp_name'])){
                $extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;

                move_uploaded_file(
                    $_FILES['profile_picture']['tmp_name'],
                    __DIR__ . '/../../public/uploads/' . $filename
                );
            }
            $userId = $auth->admin()->createUser(
                $data['email'],
                $data['password'],
                $data['firstname']. ' ' . $data['name'],
            );
            
            $stmt =$this->getDB()->getPDO()->prepare(
                'UPDATE users SET
                    role = "user",
                    firstname = :firstname,
                    name = :name,
                    phone = :phone,
                    address = :address,
                    profile_picture = :profile_picture,
                    created_at = NOW()
                WHERE id = :id
            ');

            $stmt->execute([
                'firstname' => $data['firstname'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'profile_picture' => $filename,
                'id' => $userId
            ]);

            return ['success' => 'Utilisateur créé avec succès'];

        } catch (InvalidEmailException){
            return ['error' => 'E-mail invalide'];
        } catch (UserAlreadyExistsException){
            return ['error' => 'Cet utilisateur existe déjà'];
        } catch (TooManyRequestsException){
            return ['error' => 'Trop de tentatives, réessayez plus tard'];
        }
    }

    public function getAllUsers(): array
    {
        $stmt = $this->getDB()->getPDO()->query("
            SELECT id, firstname, name, email, profile_picture
            FROM users
            WHERE role = 'user' AND status = 'active'
            ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getUserById(int $id): ?array
    {
        $stmt = $this->getDB()->getPDO()->prepare("
            SELECT id, firstname, name, address, email, phone, profile_picture, created_at
            FROM users
            WHERE id = :id
        ");

        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function updateUser(int $id, array $data, array $files): array
    {
        $pdo = $this->getDB()->getPDO();

        try{
            $filename = $data['current_picture'] ?? null;

            if(!empty($files['profile_picture']['tmp_name'])){
                $ext = pathinfo($files['profile_picture']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;

                move_uploaded_file(
                    $files['profile_picture']['tmp_name'],
                    __DIR__ . '/../../public/uploads/' . $filename
                );
            }

            $stmt = $pdo->prepare(
                "UPDATE users SET
                    firstname = :firstname,
                    name = :name,
                    address = :address,
                    email = :email,
                    phone = :phone,
                    profile_picture = :profile_picture
                WHERE id = :id
            ");

            $stmt->execute([
                'firstname' => $data['firstname'],
                'name' => $data['name'],
                'address' => $data['address'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'profile_picture' => $filename,
                'id' => $id
            ]);

            return ['success' => 'Profil mis à jour avec succès'];
        } catch (\Exception $e){
            return ['error' => 'Erreur : ' . $e->getMessage()];
        }
    }

    public function deleteUser(int $id) : void
    {
        $stmt =$this->getDB()->getPDO()->prepare("DELETE FROM users WHERE id = :id AND role = 'user'");
        $stmt->execute(['id' => $id]);
    }
}