<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ApprovedComment extends Connection
{
    public function getAllApprovedComments($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT comments.id, comment, title, username, is_approved FROM comments
            JOIN books ON books.id = comments.book_id
            JOIN users ON users.id = comments.user_id WHERE is_approved = 1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
