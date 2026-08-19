<?php
session_start();
require_once __DIR__ . '/../Model/AppData.php';
$user = AppData::getUser();
if (!$user) { header('Location: ../View/login.php'); exit; }
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$errors=[];
if ($name==='') $errors[]='Full name is required.';
if (!filter_var($email,FILTER_VALIDATE_EMAIL)) $errors[]='Please enter a valid email address.';
if ($errors) {
    $_SESSION['profile_errors']=$errors;
    header('Location: ../View/settings.php'); exit;
}
$user['name']=$name; $user['email']=$email; $user['phone']=$phone;
AppData::saveUser($user);
$_SESSION['flash']='Profile updated successfully.';
header('Location: ../View/settings.php'); exit;
