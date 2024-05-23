<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/auto-load.php';

$connection = new Connection();

$pdo = $connection->connect();

$registration = new Registration($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch ($_POST['action']) {
        case 'edit':

            $params = [
                'id' => $_POST['id'],
                'title' => $_POST['bookTitle'],
                'author_id' => $_POST['selectNewAuthor'],
                'year_published' => $_POST['yearPublished'],
                'number_of_pages' => $_POST['numberOfPages'],
                'img_url' => $_POST['bookImageUrl'],
                'category_id' => $_POST['selectNewCategory']
            ];


            echo $registration->updateBook($params);

            header('Location: admin-dashboard.php');

            break;

        case 'delete':

            $id = $_POST['id'];

            echo $registration->deleteBook($id);

            header('Location: admin-dashboard.php');

            break;
    }
}
