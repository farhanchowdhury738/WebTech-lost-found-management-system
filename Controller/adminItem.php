<?php
session_start();
include "../Model/DatabaseConnection.php";
include "helpers.php";
requireAdmin();

$action = $_POST["action"] ?? "";
$database = new DatabaseConnection();
$connection = $database->openConnection();

if ($action === "add" || $action === "update") {
    $id = $_POST["id"] ?? "";
    $type = $_POST["type"] ?? "";
    $title = trim($_POST["title"] ?? "");
    $category_id = $_POST["category_id"] ?? "";
    $location = trim($_POST["location"] ?? "");
    $date_lost_found = $_POST["date_lost_found"] ?? "";
    $description = trim($_POST["description"] ?? "");
    $contact_info = trim($_POST["contact_info"] ?? "");
    $status = $_POST["status"] ?? "Open";
    $hasError = false;

    if ($type !== "Lost" && $type !== "Found") {
        $_SESSION["adminItemError"] = "Please select Lost or Found";
        $hasError = true;
    }
    if (!$title) {
        $_SESSION["adminItemError"] = "Item name is required";
        $hasError = true;
    } elseif (strlen($title) < 2) {
        $_SESSION["adminItemError"] = "Item name is too short";
        $hasError = true;
    }
    if (!$category_id || !is_numeric($category_id)) {
        $_SESSION["adminItemError"] = "Category is required";
        $hasError = true;
    }
    if (!$location) {
        $_SESSION["adminItemError"] = "Location is required";
        $hasError = true;
    }
    if (!$date_lost_found) {
        $_SESSION["adminItemError"] = "Date is required";
        $hasError = true;
    }
    if (!$description) {
        $_SESSION["adminItemError"] = "Description is required";
        $hasError = true;
    } elseif (strlen($description) < 10) {
        $_SESSION["adminItemError"] = "Description must be at least 10 characters";
        $hasError = true;
    }
    if (!$contact_info) {
        $_SESSION["adminItemError"] = "Contact information is required";
        $hasError = true;
    }

    $filePath = trim($_POST["old_image"] ?? "");
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {
        $uploaded = saveUploadedFile($_FILES["image"], ["jpg", "jpeg", "png", "webp"]);
        if (strpos($uploaded, "ERROR:") === 0) {
            $_SESSION["adminItemError"] = substr($uploaded, 7);
            $hasError = true;
        } else {
            $filePath = $uploaded;
        }
    }

    $allowedStatuses = ["Open", "Claimed", "Found", "Returned", "Closed"];
    if (!in_array($status, $allowedStatuses)) {
        $_SESSION["adminItemError"] = "Invalid item status";
        $hasError = true;
    }

    if ($hasError) {
        redirect("../View/adminItems.php");
    }

    if ($action === "add") {
        if ($database->addItem($connection, $_SESSION["loggedInUserId"], $category_id, $title, $description, $type, $location, $date_lost_found, $filePath, $contact_info)) {
            $_SESSION["successMessage"] = "Item added successfully";
        } else {
            $_SESSION["adminItemError"] = "Could not add item";
        }
    } else {
        if ($database->updateItem($connection, $id, $category_id, $title, $description, $type, $location, $date_lost_found, $filePath, $contact_info, $status)) {
            $_SESSION["successMessage"] = "Item updated successfully";
        } else {
            $_SESSION["adminItemError"] = "Could not update item";
        }
    }
} elseif ($action === "delete") {
    $id = $_POST["id"] ?? "";
    if (!$id || !is_numeric($id)) {
        $_SESSION["adminItemError"] = "Invalid item";
    } elseif ($database->deleteItem($connection, $id)) {
        $_SESSION["successMessage"] = "Item deleted successfully";
    } else {
        $_SESSION["adminItemError"] = "Could not delete item";
    }
}

redirect("../View/adminItems.php");
?>
