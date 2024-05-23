<?php

class Note extends Connection
{
    public $table = 'notes';
    public $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addNote($noteData)
    {
        $sql = 'INSERT INTO ' . $this->table . ' (note, user_id, book_id) VALUES (:note, :user_id, :book_id)';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($noteData);
    }

    public function getNoteById($noteId)
    {
        $sql = 'SELECT * FROM notes WHERE id = :note_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':note_id', $noteId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updateNoteContent($noteId, $newNoteContent)
    {
        $sql = 'UPDATE notes SET note = :new_note_content WHERE id = :note_id AND user_id = :user_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':new_note_content', $newNoteContent, PDO::PARAM_STR);
        $stmt->bindParam(':note_id', $noteId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getNotesByBookIdAndUserId($bookId, $userId)
    {
        $sql = 'SELECT * FROM notes WHERE book_id = :book_id AND user_id = :user_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function editNote($noteId, $newNoteContent)
    {
        $sql = 'UPDATE notes SET note = :new_note_content WHERE id = :note_id AND user_id = :user_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':new_note_content', $newNoteContent, PDO::PARAM_STR);
        $stmt->bindParam(':note_id', $noteId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $updatedNotes = $this->getNotesByUserId($_SESSION['user_id']);
        } else {
            return false;
        }
    }


    public function getNotesByUserId($userId)
    {
        $sql = 'SELECT * FROM notes WHERE user_id = :user_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function deleteNoteById($noteId)
    {
        $sql = 'DELETE FROM notes WHERE id = :note_id AND user_id = :user_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':note_id', $noteId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $updatedNotes = $this->getNotesByUserId($_SESSION['user_id']);
            return $updatedNotes;
        } else {
            return false;
        }
    }
}
