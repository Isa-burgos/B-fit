<?php

namespace App\controllers;

class UserController extends Controller{

    public function dashboard(int $userId): void
    {
        $this->render('dashboardUser', 'dashboard', compact('userId'));
    }


}