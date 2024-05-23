<?php

session_start();

require_once __DIR__ . '/auto-load.php';

$connection = new Connection();
$pdo = $connection->connect();
$note = new Note($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $noteContent = htmlspecialchars($_POST['noteContent'], ENT_QUOTES, 'UTF-8');
    $bookId = (int)$_POST['bookId'];

    if (empty($noteContent)) {
        echo json_encode(['success' => false, 'message' => 'Please enter a note.']);
        exit();
    }

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        $noteData = [
            'note' => $noteContent,
            'user_id' => $userId,
            'book_id' => $bookId
        ];

        $result = $note->addNote($noteData);

        if ($result) {
            $newNote = $note->getNoteById($result);
            echo json_encode(['success' => true, 'message' => 'Note added successfully.', 'note' => $newNote]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add note.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
