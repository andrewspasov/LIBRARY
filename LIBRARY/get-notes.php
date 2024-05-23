<?php
session_start();

require_once __DIR__ . '/auto-load.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $userLoggedIn = isset($_SESSION['username']);

    if ($userLoggedIn) {
        $connection = new Connection();
        $pdo = $connection->connect();

        $note = new Note($pdo);

        $bookId = $_GET['bookId'];

        $userId = $_SESSION['user_id'];
        $notes = $note->getNotesByBookIdAndUserId($bookId, $userId);

        echo json_encode($notes);
        exit();
    } else {
        echo json_encode([]);
        exit();
    }
}
