<?php
class UserLogin extends Connection
{
    public $table = 'users';
    public $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function verifyLogin($username, $password)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE username = :username';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header('Location: admin-dashboard.php');
            } else {
                header('Location: user-dashboard.php');
            }
            exit();
        }
        return false;
    }
}
