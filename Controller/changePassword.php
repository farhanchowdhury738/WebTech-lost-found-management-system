<?php
session_start();
include "../Model/DatabaseConnection.php";
include "helpers.php";
requireLogin();

$current_password = $_POST["current_password"] ?? "";
$new_password = $_POST["new_password"] ?? "";
$confirm_password = $_POST["confirm_password"] ?? "";
$hasError = false;

$database = new DatabaseConnection();
$connection = $database->openConnection();
$user = $database->getUserById($connection, $_SESSION["loggedInUserId"]);

if (!$current_password) {
    $_SESSION["currentPasswordError"] = "Current password is required";
    $hasError = true;
} elseif ($user["password_hash"] !== $current_password) {
    $_SESSION["currentPasswordError"] = "Current password is incorrect";
    $hasError = true;
} else unset($_SESSION["currentPasswordError"]);

if (!$new_password) {
    $_SESSION["newPasswordError"] = "New password is required";
    $hasError = true;
} elseif (strlen($new_password) < 6) {
    $_SESSION["newPasswordError"] = "New password must be at least 6 characters";
    $hasError = true;
} else unset($_SESSION["newPasswordError"]);

if (!$confirm_password) {
    $_SESSION["confirmNewPasswordError"] = "Please confirm the new password";
    $hasError = true;
} elseif ($new_password !== $confirm_password) {
    $_SESSION["confirmNewPasswordError"] = "Passwords do not match";
    $hasError = true;
} else unset($_SESSION["confirmNewPasswordError"]);

if ($hasError) redirect("../View/profile.php");

if ($database->changePassword($connection, $_SESSION["loggedInUserId"], $new_password)) {
    $_SESSION["successMessage"] = "Password changed successfully";
} else {
    $_SESSION["profileError"] = "Password change failed";
}
redirect("../View/profile.php");
?>



/* comment */