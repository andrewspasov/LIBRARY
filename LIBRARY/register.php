<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/auto-load.php';

$connection = new Connection();
$pdo = $connection->connect();

$registration = new UserRegistration($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $surname = htmlspecialchars($_POST['surname'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (empty($name) || empty($surname) || empty($email) || empty($username) || empty($password)) {
        $_SESSION['error_message'] = 'All fields are required.';
        header('Location: register-form.php');
        exit();
    }

    if ($registration->isEmailExists($email) || $registration->isUsernameExists($username)) {
        $_SESSION['error_message'] = 'Email or username already exists.';
        header('Location: register-form.php');
        exit();
    }

    $userData = [
        'name' => $name,
        'surname' => $surname,
        'email' => $email,
        'username' => $username,
        'password' => $password,
        'role' => 'user'
    ];

    if ($registration->addUser($userData)) {
        $_SESSION['success_message'] = 'User registration successful.';
        header('Location: register-form.php');
        exit();
    } else {
        $_SESSION['error_message'] = 'Failed to register user.';
        header('Location: register-form.php');
        exit();
    }
}
