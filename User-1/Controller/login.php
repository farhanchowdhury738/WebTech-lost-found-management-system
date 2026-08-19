<?php
session_start();
require_once __DIR__ . '/../Model/AppData.php';

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$user = AppData::getUser();

if (!$user || empty($user['registered_at']) || time() > ((int)$user['registered_at'] + 1800)) {
    setcookie('kk_user', '', time()-3600, '/');
    $_SESSION['login_error'] = 'Your 30-minute registration period has expired. Please register again.';
    header('Location: ../View/login.php'); exit;
}

if (strcasecmp($user['email'], $email) !== 0 || !password_verify($password, $user['password_hash'])) {
    $_SESSION['login_error'] = 'Invalid email or password.';
    $_SESSION['login_email'] = $email;
    header('Location: ../View/login.php'); exit;
}

$_SESSION['user'] = $user;
$_SESSION['isLoggedIn'] = true;
header('Location: ../View/profile.php'); exit;
