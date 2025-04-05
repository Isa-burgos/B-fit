<?php

namespace Config;

use PDO;

class DbConnect{

    private string $dbHost;
    private string $dbName;
    private string $dbUser;
    private string $dbPassword;
    private ?PDO $pdo = null;

    public function __construct(string $dbHost, string $dbName, string $dbUser, string $dbPassword)
    {
        $this->dbHost = $dbHost;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
    }

    public function getPDO(): PDO
    {
        return $this->pdo ?? $this->pdo = new PDO("mysql:host={$this->dbHost}; dbname={$this->dbName}; charset=utf8mb4", $this->dbUser, $this->dbPassword, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

}