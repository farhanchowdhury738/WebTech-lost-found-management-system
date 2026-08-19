<?php
session_start();
require_once __DIR__ . '/../Model/AppData.php';
AppData::clearLoginOnly();
$_SESSION['flash'] = 'You have been logged out. Your account is still available until the 30-minute registration period ends.';
header('Location: ../View/home.php'); exit;
