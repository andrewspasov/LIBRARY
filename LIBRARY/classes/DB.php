<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


class Connection
{
    public $instance = null;

    public $connection;

    public $pdo;

    protected const DB_HOST = 'localhost';
    protected const DB_NAME = 'brainster_library';
    protected const DB_USER = 'root';
    protected const DB_PASSWORD = '';

    public function connect()
    {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO(
                    'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME,
                    self::DB_USER,
                    self::DB_PASSWORD,
                    [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
                );
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        return $this->pdo;
    }


    public function select1($table, $req = null, $pdo = null)
    {
        if (is_null($pdo)) {
            $pdo = $this->connect();
        }

        $data = [];
        if (is_null($req)) {
            $sql = "SELECT * FROM {$table}";
        } else {
            $sql = $req['sql'];
            $data = $req['data'];
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

        return $stmt;
    }


    public function select($table, $req = null, $pdo = null)
    {
        if (is_null($pdo)) {
            $pdo = $this->connect();
        }

        $data = [];
        if (is_null($req)) {
            $sql = "SELECT * FROM {$table}";
        } else {
            $sql = $req['sql'];
            $data = $req['data'];
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

        return $stmt->fetchAll();
    }




    public function getConnection()
    {
        return $this->connection;
    }

    public function destroy()
    {
        $this->connection = null;
    }
}

