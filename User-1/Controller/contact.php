<?php
session_start();
$_SESSION['flash']='Contact request sent successfully.';
header('Location: ../View/contact.php'); exit;
