<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/auto-load.php';

$connection = new Connection();
$pdo = $connection->connect();

$userLogin = new UserLogin($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($userLogin->verifyLogin($username, $password)) {
        exit();
    } else {
        $_SESSION['error_message'] = 'Invalid username or password.';
        header('Location: login-form.php');
        exit();
    }
}
