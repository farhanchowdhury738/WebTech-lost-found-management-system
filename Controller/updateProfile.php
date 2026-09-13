<?php
session_start();
include "../Model/DatabaseConnection.php";
include "helpers.php";
requireLogin();

$id = $_SESSION["loggedInUserId"];
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");

$hasError = false;

if (!$name) {
    $_SESSION["profileNameError"] = "Name is required";
    $hasError = true;
} elseif (strlen($name) < 3) {
    $_SESSION["profileNameError"] = "Name must be at least 3 characters";
    $hasError = true;
} else unset($_SESSION["profileNameError"]);

if (!$email) {
    $_SESSION["profileEmailError"] = "Email is required";
    $hasError = true;
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["profileEmailError"] = "Enter a valid email";
    $hasError = true;
} else unset($_SESSION["profileEmailError"]);

if ($phone && !preg_match('/^[0-9+ -]{7,20}$/', $phone)) {
    $_SESSION["profilePhoneError"] = "Enter a valid phone number";
    $hasError = true;
} else unset($_SESSION["profilePhoneError"]);

$database = new DatabaseConnection();
$connection = $database->openConnection();

$current = $database->getUserById($connection, $id);
if ($email !== $current["email"] && $database->emailExists($connection, $email)) {
    $_SESSION["profileEmailError"] = "This email is already used";
    $hasError = true;
}

$photoPath = "";
if (isset($_FILES["profile_photo"]) && $_FILES["profile_photo"]["error"] !== UPLOAD_ERR_NO_FILE) {
    $photoPath = saveUploadedFile($_FILES["profile_photo"], ["jpg", "jpeg", "png", "webp"]);
    if (strpos($photoPath, "ERROR:") === 0) {
        $_SESSION["profilePhotoError"] = substr($photoPath, 7);
        $hasError = true;
        $photoPath = "";
    }
}

if ($hasError) redirect("../View/profile.php");

$result = $database->updateProfile($connection, $id, $name, $email, $phone, $photoPath);
if ($result) {
    $_SESSION["loggedInUsername"] = $name;
    $_SESSION["loggedInEmail"] = $email;
    $_SESSION["successMessage"] = "Profile updated successfully";
    redirect("../View/profile.php");
}

$_SESSION["profileError"] = "Profile update failed";
redirect("../View/profile.php");
?>
