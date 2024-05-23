<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/auto-load.php';

$connection = new Connection();

$pdo = $connection->connect();

$registration = new Registration($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];

    $registration->approveComment($id);

    header('Location: admin-dashboard.php');
}
