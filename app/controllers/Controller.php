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


}