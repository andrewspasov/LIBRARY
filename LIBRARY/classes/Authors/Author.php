<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Author extends Connection
{
    public $table = 'authors';


    public function getAuthors($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT id, first_name, last_name, bio, deleted_at FROM authors WHERE deleted_at IS NULL");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
