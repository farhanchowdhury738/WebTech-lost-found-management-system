<?php
session_start();
require_once __DIR__ . '/../Model/AppData.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';
$agree = isset($_POST['agree']);

$errors = [];
if ($name === '') $errors[] = 'Full name is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters long.';
if ($password !== $confirm) $errors[] = 'Passwords do not match.';
if (!$agree) $errors[] = 'Please agree to the Terms of Service and Privacy Policy.';

if ($errors) {
    $_SESSION['register_errors'] = $errors;
    $_SESSION['old_register'] = ['name'=>$name,'email'=>$email];
    header('Location: ../View/registration.php'); exit;
}

$user = [
    'name'=>$name,
    'email'=>$email,
    'phone'=>'',
    'password_hash'=>password_hash($password, PASSWORD_DEFAULT),
    'registered_at'=>time()
];
AppData::saveUser($user);
$_SESSION['flash'] = 'Account created successfully. You can log in for the next 30 minutes.';
header('Location: ../View/login.php'); exit;
