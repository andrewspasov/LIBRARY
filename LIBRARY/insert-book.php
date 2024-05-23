<?php

session_start();

require_once __DIR__ . '/auto-load.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $connection = new Connection();

    $pdo = $connection->connect();


    $params = [
        'title' => $_POST['newBookTitle'],
        'author_id' => $_POST['selectAuthor'],
        'year_published' => $_POST['newBookYearPublished'],
        'number_of_pages' => $_POST['newBookNumberOfPages'],
        'img_url' => $_POST['newBookImage'],
        'category_id' => $_POST['selectCategory'],
    ];

    $registration = new Registration($pdo);
    $registration->createNewBook($params);

    header('Location: admin-dashboard.php');
}
