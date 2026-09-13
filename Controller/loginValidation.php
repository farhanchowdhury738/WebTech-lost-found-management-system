<?php
session_start();
include "../Model/DatabaseConnection.php";
include "helpers.php";

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

$_SESSION["old_login_email"] = $email;
$hasEmailError = false;
$hasPasswordError = false;

if (!$email) {
    $_SESSION["loginEmailError"] = "Email is required";
    $hasEmailError = true;
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["loginEmailError"] = "Enter a valid email address";
    $hasEmailError = true;
} else {
    unset($_SESSION["loginEmailError"]);
}

if (!$password) {
    $_SESSION["loginPasswordError"] = "Password is required";
    $hasPasswordError = true;
} else {
    unset($_SESSION["loginPasswordError"]);
}

if ($hasEmailError || $hasPasswordError) {
    redirect("../View/login.php");
}

$database = new DatabaseConnection();
$connection = $database->openConnection();
$result = $database->signin($connection, $email, $password);

if ($result && $result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION["loggedInUserId"] = $row["id"];
    $_SESSION["loggedInUsername"] = $row["name"];
    $_SESSION["loggedInEmail"] = $row["email"];
    $_SESSION["role"] = $row["role"];
    $_SESSION["isLoggedIn"] = true;
    unset($_SESSION["old_login_email"], $_SESSION["successMessage"]);
    if ($row["role"] === "admin") {
        redirect("../View/adminDashboard.php");
    }
    redirect("../View/dashboard.php");
}

$_SESSION["loginFailMessage"] = "Email or password is incorrect";
redirect("../View/login.php");
?>