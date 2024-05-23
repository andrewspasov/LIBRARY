<?php

session_start();

require_once __DIR__ . '/auto-load.php';

$connection = new Connection();
$pdo = $connection->connect();
$note = new Note($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $noteId = (int)$_POST['noteId'];
    $newNoteContent = htmlspecialchars($_POST['newNoteContent'], ENT_QUOTES, 'UTF-8');
    $bookId = isset($_POST['bookId']) ? (int)$_POST['bookId'] : null;

    if (empty($newNoteContent)) {
        echo json_encode(['error' => 'Please enter a note.']);
        exit();
    }

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        $result = $note->editNote($noteId, $newNoteContent);

        if ($result) {
            $updatedNotes = $note->getNotesByBookIdAndUserId($bookId, $userId);

            echo json_encode(['success' => 'Note edited successfully.', 'notes' => $updatedNotes]);
        } else {
            echo json_encode(['error' => 'Failed to edit note.']);
        }
    } else {
        echo json_encode(['error' => 'User not logged in.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}

