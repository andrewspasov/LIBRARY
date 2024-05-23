<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pdo = new PDO('mysql:host=localhost;dbname=brainster_library', 'root', '');

$newName = $_POST['newCategory'];

$sql = "SELECT * FROM categories WHERE category = :newName AND deleted_at IS NULL";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":newName", $newName);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $_SESSION['error_message'] = "Error: This category already exists in the database and is not deleted.";
    header('Location: admin-dashboard.php');
    exit();
} else {
    $sqlInsert = "INSERT INTO categories (category) VALUES (:category)";
    $stmtInsert = $pdo->prepare($sqlInsert);
    $stmtInsert->bindParam(":category", $newName);

    if ($stmtInsert->execute()) {
        echo "Category added successfully.";
        header('Location: admin-dashboard.php');
        exit();
    } else {
        echo "Failed to add the category.";
        header('Location: admin-dashboard.php');
        exit();
    }
}
