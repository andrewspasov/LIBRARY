<?php

class UserRegistration extends Connection
{
    public $table = 'users';
    public $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function isEmailExists($email)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function isUsernameExists($username)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE username = :username';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function addUser($userData)
    {
        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);

        $sql = 'INSERT INTO ' . $this->table . ' (name, surname, email, username, password, role) VALUES (:name, :surname, :email, :username, :password, :role)';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($userData);
    }
}
