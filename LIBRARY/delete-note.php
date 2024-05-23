<?php
session_start();

require_once __DIR__ . '/auto-load.php';

$noteId = $_POST['noteId'];

$connection = new Connection();
$pdo = $connection->connect();
$note = new Note($pdo);

$success = $note->deleteNoteById($noteId);

if ($success) {
    $bookId = $_POST['bookId'];
    $updatedNotes = $note->getNotesByBookIdAndUserId($bookId, $_SESSION['user_id']);
    echo json_encode(['success' => 'Note deleted successfully.', 'notes' => $updatedNotes]);
} else {
    echo json_encode(['error' => 'Error deleting note.']);
}

