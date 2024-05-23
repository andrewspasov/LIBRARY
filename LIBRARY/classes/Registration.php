<?php

class Registration extends Connection
{


    public $table1 = 'categories';
    public $table2 = 'authors';
    public $table3 = 'books';
    public $table4 = 'comments';


    public $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllBooks($pdo = null)
    {
        $sql = 'SELECT books.id AS id, title, authors.first_name, authors.last_name, year_published, number_of_pages, img_url, categories.category FROM ' . $this->table3 . '
        JOIN ' . $this->table1 . ' ON categories.id = books.category_id
        JOIN ' . $this->table2 . ' ON authors.id = books.author_id';

        $req = ['sql' => $sql, 'data' => []];

        return $this->select($this->table3, $req);
    }

    public function getSingleBook($id, $pdo = null)
    {
        $sql = 'SELECT books.id AS id, title, authors.first_name, authors.last_name, year_published, number_of_pages, img_url, categories.category FROM ' . $this->table3 . '
        JOIN ' . $this->table1 . ' ON categories.id = books.category_id
        JOIN ' . $this->table2 . ' ON authors.id = books.author_id WHERE books.id = :id';

        $req = ['sql' => $sql, 'data' => ['id' => $id]];

        return $this->select1($this->table3, $req)->fetch(PDO::FETCH_ASSOC);
    }

    public function createNewBook($params)
    {
        $sql = 'INSERT INTO ' . $this->table3 . ' (title, author_id, year_published, number_of_pages, img_url, category_id) VALUES (:title, :author_id, :year_published, :number_of_pages, :img_url, :category_id)';

        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute($params)) {
            return 'New registration created';
        } else {
            return 'Something went wrong';
        }
    }

    public function updateBook($params)
    {
        $sql = 'UPDATE ' . $this->table3 . ' SET title=:title, author_id=:author_id, year_published=:year_published, number_of_pages=:number_of_pages, img_url=:img_url, category_id=:category_id WHERE id=:id';

        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute($params)) {
            return 'New registration created';
        } else {
            return 'Something went wrong';
        }
    }

    public function updateCategory($params)
    {
        $sql = 'UPDATE ' . $this->table1 . ' SET category=:category WHERE id=:id';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);
    }
    public function softDeleteCategory($id)
    {
        $sql = 'UPDATE ' . $this->table1 . ' SET deleted_at=now() WHERE id=:id';

        $stmt = $this->pdo->prepare($sql);

        $req = ['sql' => $sql, 'data' => ['id' => $id]];

        return $this->select1($this->table1, $req)->fetch(PDO::FETCH_ASSOC);
    }
    public function approveComment($id)
    {
        $sql = 'UPDATE ' . $this->table4 . ' SET is_approved = 1 WHERE id=:id';

        $stmt = $this->pdo->prepare($sql);

        $req = ['sql' => $sql, 'data' => ['id' => $id]];

        return $this->select1($this->table4, $req)->fetch(PDO::FETCH_ASSOC);
    }
    public function updateAuthor($params)
    {
        $existingAuthor = $this->getAuthorByName($params['first_name'], $params['last_name']);

        if ($existingAuthor && $existingAuthor['id'] !== $params['id'] && !$existingAuthor['deleted_at']) {
            $_SESSION['error_message'] = 'Error: This author already exists in the database.';
        } else {
            $sql = 'UPDATE ' . $this->table2 . ' SET first_name=:first_name, last_name=:last_name, bio=:bio WHERE id=:id';

            $stmt = $this->pdo->prepare($sql);

            if ($stmt->execute($params)) {
                $_SESSION['success_message'] = 'Author updated successfully.';
            } else {
                $_SESSION['error_message'] = 'Failed to update the author.';
            }
        }
    }


    public function softDeleteAuthor($id)
    {
        $sql = 'UPDATE authors SET deleted_at=now() WHERE id=:id';

        $stmt = $this->pdo->prepare($sql);

        $req = ['sql' => $sql, 'data' => ['id' => $id]];

        return $this->select1($this->table2, $req)->fetch(PDO::FETCH_ASSOC);
    }

    public function getAuthorByName($firstName, $lastName)
    {
        $sql = 'SELECT * FROM authors WHERE first_name = :first_name AND last_name = :last_name AND (deleted_at IS NULL OR deleted_at = "0000-00-00 00:00:00")';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function deleteBook($id)
    {
        $sql = 'DELETE FROM books WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute(['id' => $id])) {
            return 'Book deleted.';
        } else {
            return 'Something went wrong';
        }
    }

    public function leaveComment($userId, $bookId, $comment)
    {
        $isApproved = false;

        $sql = 'INSERT INTO comments (user_id, book_id, comment, is_approved) VALUES (:user_id, :book_id, :comment, :is_approved)';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':book_id', $bookId);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':is_approved', $isApproved, PDO::PARAM_BOOL);

        return $stmt->execute();
    }
    public function getCommentsByUserId($userId)
    {
        $sql = 'SELECT * FROM comments WHERE user_id = :user_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getCommentsByUserIdAndBookId($userId, $bookId)
    {
        $sql = 'SELECT * FROM comments WHERE user_id = :user_id AND book_id = :book_id AND is_approved = 0';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteComment($id)
    {
        $sql = 'DELETE FROM comments WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute(['id' => $id])) {
            return 'Book deleted.';
        } else {
            return 'Something went wrong';
        }
    }


    public function getApprovedCommentsByBookId($bookId)
    {
        $sql = 'SELECT comments.*, users.username
                FROM comments
                JOIN users ON comments.user_id = users.id
                WHERE comments.book_id = :book_id AND comments.is_approved = 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getAllUsers()
    {
        $sql = 'SELECT id, name, surname, email, username, role FROM users WHERE role = :role';
        $stmt = $this->pdo->prepare($sql);
        $role = 'user';
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUserRole($userId)
    {
        $sql = 'UPDATE users SET role = :role WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['role' => 'admin', 'id' => $userId]);
    }
}
