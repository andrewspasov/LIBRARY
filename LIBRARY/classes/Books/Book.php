<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Book extends Connection
{
    public $table = 'books';

    public function getBooks($pdo = null)
    {
        return $this->select($this->table, null, $pdo);
    }
}
