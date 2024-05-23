<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Category extends Connection
{
    public $table = 'categories';

    public function getCategories($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT category, id, deleted_at FROM categories WHERE deleted_at IS NULL");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}

