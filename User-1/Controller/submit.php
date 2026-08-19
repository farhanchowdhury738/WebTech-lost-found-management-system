<?php
session_start();
require_once __DIR__ . '/../Model/AppData.php';
if (!AppData::getUser()) { header('Location: ../View/login.php'); exit; }
$_SESSION['flash']='Your report has been submitted successfully.';
header('Location: ../View/submit.php?success=1'); exit;
