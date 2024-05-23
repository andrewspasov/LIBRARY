<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/auto-load.php';

$pdo = new PDO('mysql:host=localhost;dbname=brainster_library', 'root', '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["newAuthorName"]) && isset($_POST["newAuthorSurname"]) && isset($_POST["newAuthorBio"])) {

        $authorName = $_POST["newAuthorName"];
        $authorSurname = $_POST["newAuthorSurname"];
        $authorBio = $_POST["newAuthorBio"];

        $sql = "SELECT * FROM authors WHERE first_name = :first_name AND last_name = :last_name AND deleted_at IS NULL";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":first_name", $authorName, PDO::PARAM_STR);
        $stmt->bindParam(":last_name", $authorSurname, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['error_message'] = "Error: This author already exists in the database and is not deleted.";
            header('Location: admin-dashboard.php');
            exit();
        } else {
            $sqlInsert = "INSERT INTO authors (first_name, last_name, bio) VALUES (:first_name, :last_name, :bio)";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->bindParam(":first_name", $authorName, PDO::PARAM_STR);
            $stmtInsert->bindParam(":last_name", $authorSurname, PDO::PARAM_STR);
            $stmtInsert->bindParam(":bio", $authorBio, PDO::PARAM_STR);

            if ($stmtInsert->execute()) {
                $_SESSION['success_message'] = "Author has been added successfully";
                header('Location: admin-dashboard.php');
                exit();
            } else {
                $_SESSION['error_message'] = "Error: Failed to add author";
                header('Location: admin-dashboard.php');
                exit();
            }
        }
    } else {
        $_SESSION['error_message'] = "Author name, surname, and bio are required.";
        header('Location: admin-dashboard.php');
        exit();
    }
}
