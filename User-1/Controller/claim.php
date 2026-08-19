<?php
session_start();
require_once __DIR__ . '/../Model/AppData.php';
if (!AppData::getUser()) { header('Location: ../View/login.php'); exit; }
$_SESSION['flash']='Claim request submitted. We will review your information.';
header('Location: ../View/claim.php?success=1'); exit;
