<?php
session_start();

require_once __DIR__ . '/auto-load.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userLoggedIn = isset($_SESSION['username']);

    if ($userLoggedIn) {
        $connection = new Connection();
        $pdo = $connection->connect();

        $registration = new Registration($pdo);

        $userId = $_SESSION['user_id'];
        $existingComment = $registration->getCommentsByUserId($userId);

        if (!$existingComment) {
            $newComment = $_POST['newComment'];
            $bookId = $_POST['bookId'];

            $registration->leaveComment($userId, $bookId, $newComment);

            $_SESSION['success_message'] = 'Comment added successfully.';
        } else {
            $_SESSION['error_message'] = 'You have already left a comment.';
        }

        header('Location: book-detail.php?id=' . $_POST['bookId']);
        exit();
    } else {
        $_SESSION['error_message'] = 'Please log in to leave a comment.';
        header('Location: homepage.php');
        exit();
    }
}
