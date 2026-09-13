<?php
session_start();
include "../Model/DatabaseConnection.php";
include "helpers.php";

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$confirm_password = $_POST["confirm_password"] ?? "";
$phone = trim($_POST["phone"] ?? "");

$_SESSION["old_name"] = $name;
$_SESSION["old_email"] = $email;
$_SESSION["old_phone"] = $phone;

$hasError = false;

if (!$name) {
    $_SESSION["nameError"] = "Name is required";
    $hasError = true;
} elseif (strlen($name) < 3) {
    $_SESSION["nameError"] = "Name must be at least 3 characters";
    $hasError = true;
} else {
    unset($_SESSION["nameError"]);
}

if (!$email) {
    $_SESSION["emailError"] = "Email is required";
    $hasError = true;
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["emailError"] = "Enter a valid email address";
    $hasError = true;
} else {
    unset($_SESSION["emailError"]);
}

if (!$password) {
    $_SESSION["passwordError"] = "Password is required";
    $hasError = true;
} elseif (strlen($password) < 6) {
    $_SESSION["passwordError"] = "Password must be at least 6 characters";
    $hasError = true;
} else {
    unset($_SESSION["passwordError"]);
}

if (!$confirm_password) {
    $_SESSION["confirmPasswordError"] = "Please confirm your password";
    $hasError = true;
} elseif ($password !== $confirm_password) {
    $_SESSION["confirmPasswordError"] = "Passwords do not match";
    $hasError = true;
} else {
    unset($_SESSION["confirmPasswordError"]);
}

if ($phone && !preg_match('/^[0-9+ -]{7,20}$/', $phone)) {
    $_SESSION["phoneError"] = "Enter a valid phone number";
    $hasError = true;
} else {
    unset($_SESSION["phoneError"]);
}

if ($hasError) {
    redirect("../View/registration.php");
}

$database = new DatabaseConnection();
$connection = $database->openConnection();

if ($database->emailExists($connection, $email)) {
    $_SESSION["emailError"] = "This email is already registered";
    redirect("../View/registration.php");
}

$result = $database->signup($connection, $name, $email, $password, $phone);

if ($result) {
    $_SESSION["successMessage"] = "Registration successful. Please login.";
    unset($_SESSION["old_name"], $_SESSION["old_email"], $_SESSION["old_phone"]);
    redirect("../View/login.php");
} else {
    $_SESSION["registerError"] = "Registration failed. Please try again.";
    redirect("../View/registration.php");
}
?>