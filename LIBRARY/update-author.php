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
                'first_name' => $_POST['authorFirstName'],
                'last_name' => $_POST['authorLastName'],
                'bio' => $_POST['authorBio']
            ];


            echo $registration->updateAuthor($params);

            header('Location: admin-dashboard.php');

            break;

        case 'delete':
            $id = $_POST['id'];

            echo $registration->softDeleteAuthor($id);

            header('Location: admin-dashboard.php');

            break;
    }
}
