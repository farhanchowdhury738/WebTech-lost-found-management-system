<?php
session_start();
include "../Model/DatabaseConnection.php";
include "helpers.php";
requireAdmin();

$action = $_POST["action"] ?? "status";
$database = new DatabaseConnection();
$connection = $database->openConnection();

if ($action === "add" || $action === "update") {
    $id = $_POST["id"] ?? "";
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $phone = trim($_POST["phone"] ?? "");
    $role = $_POST["role"] ?? "user";
    $status = $_POST["status"] ?? "active";
    $hasError = false;

    if (!$name) { $_SESSION["userError"] = "Name is required"; $hasError = true; }
    elseif (strlen($name) < 2) { $_SESSION["userError"] = "Name is too short"; $hasError = true; }

    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) { 
        $_SESSION["userError"] = "A valid email is required"; 
        $hasError = true; 
    }

    if ($action === "add" && !$password) { 
        $_SESSION["userError"] = "Password is required"; 
        $hasError = true; 
    }
    elseif ($password && strlen($password) < 6) { 
        $_SESSION["userError"] = "Password must be at least 6 characters"; 
        $hasError = true; 
    }

    if ($role !== "user" && $role !== "admin") { 
        $_SESSION["userError"] = "Invalid role"; 
        $hasError = true; 
    }

    if ($status !== "active" && $status !== "blocked") { 
        $_SESSION["userError"] = "Invalid status"; 
        $hasError = true; 
    }

    if ($action === "add" && $database->emailExists($connection, $email)) { 
        $_SESSION["userError"] = "Email already exists"; 
        $hasError = true; 
    }

    if ($hasError) redirect("../View/adminUsers.php");

    if ($action === "add") {
        if ($database->addUser($connection, $name, $email, $password, $phone, $role, $status)) {
            $_SESSION["successMessage"] = "User added successfully";
        }
        else {
            $_SESSION["userError"] = "Could not add user. Email may already exist";
        }
    } 
    else {
        if ($id == $_SESSION["loggedInUserId"] && $role !== "admin") {
            $_SESSION["userError"] = "You cannot remove your own admin role";
        } 
        elseif ($database->updateUser($connection, $id, $name, $email, $phone, $role, $status)) {
            $_SESSION["successMessage"] = "User updated successfully";
        } 
        else {
            $_SESSION["userError"] = "Could not update user";
        }
    }
} 
elseif ($action === "delete") {
    $id = $_POST["id"] ?? "";

    if (!$id || !is_numeric($id)) {
        $_SESSION["userError"] = "Invalid user";
    }
    elseif ((int)$id === (int)$_SESSION["loggedInUserId"]) {
        $_SESSION["userError"] = "You cannot delete your own account";
    }
    elseif ($database->deleteUser($connection, $id)) {
        $_SESSION["successMessage"] = "User deleted successfully";
    }
    else {
        $_SESSION["userError"] = "Could not delete user";
    }
} 
else {
    $id = $_POST["id"] ?? "";
    $status = $_POST["status"] ?? "";

    if (!$id || ($status !== "active" && $status !== "blocked")) {
        $_SESSION["userError"] = "Invalid user status update";
    }
    elseif ($database->updateUserStatus($connection, $id, $status)) {
        $_SESSION["successMessage"] = "User status updated";
    }
    else {
        $_SESSION["userError"] = "Could not update user status";
    }
}

redirect("../View/adminUsers.php");
?>