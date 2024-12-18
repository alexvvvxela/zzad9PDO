<?php

namespace Alexv\Zad10p;

use PDO;
use PDOException;

class User
{
    private PDO $pdo;
    private string $host = '127.0.0.1';
    private string $db   = 'npp';
    private string $user = 'root';
    private string $pass = 'root';
    private string $charset = 'utf8';

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    public function fetchAll(string $sql): array
    {
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById(int $id): ?array
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user === false ? null : $user;
    }

    public function updateUser(int $id, array $data): bool
    {
        if (!$this->getUserById($id)) {
            return false;
        }

        $setParts = [];
        foreach ($data as $key => $value) {
            $setParts[] = "$key = :$key";
        }

        $setClause = implode(', ', $setParts);

        $sql = "UPDATE users SET $setClause WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $data['id'] = $id;

        try {
            $stmt->execute($data);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {

            return false;
        }
    }
}
