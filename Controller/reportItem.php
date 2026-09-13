<?php
session_start();
include "../Model/DatabaseConnection.php";
include "helpers.php";
requireLogin();

$type = $_POST["type"] ?? "";
$title = trim($_POST["title"] ?? "");
$category_id = $_POST["category_id"] ?? "";
$location = trim($_POST["location"] ?? "");
$date_lost_found = $_POST["date_lost_found"] ?? "";
$description = trim($_POST["description"] ?? "");
$contact_info = trim($_POST["contact_info"] ?? "");

$_SESSION["report_old"] = $_POST;
$hasError = false;

if ($type !== "Lost" && $type !== "Found") {
    $_SESSION["reportTypeError"] = "Please select Lost or Found";
    $hasError = true;
} else
    unset($_SESSION["reportTypeError"]);

if (!$title) {
    $_SESSION["reportTitleError"] = "Item name is required";
    $hasError = true;
} elseif (strlen($title) < 2) {
    $_SESSION["reportTitleError"] = "Item name is too short";
    $hasError = true;
} else
    unset($_SESSION["reportTitleError"]);

if (!$category_id || !is_numeric($category_id)) {
    $_SESSION["reportCategoryError"] = "Category is required";
    $hasError = true;
} else
    unset($_SESSION["reportCategoryError"]);

if (!$location) {
    $_SESSION["reportLocationError"] = "Location is required";
    $hasError = true;
} else
    unset($_SESSION["reportLocationError"]);

if (!$date_lost_found) {
    $_SESSION["reportDateError"] = "Date is required";
    $hasError = true;
} else
    unset($_SESSION["reportDateError"]);

if (!$description) {
    $_SESSION["reportDescriptionError"] = "Description is required";
    $hasError = true;
} elseif (strlen($description) < 10) {
    $_SESSION["reportDescriptionError"] = "Description must be at least 10 characters";
    $hasError = true;
} else
    unset($_SESSION["reportDescriptionError"]);

if (!$contact_info) {
    $_SESSION["reportContactError"] = "Contact information is required";
    $hasError = true;
} else
    unset($_SESSION["reportContactError"]);

$filePath = "";
if (isset($_FILES["image"]) && $_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {
    $filePath = saveUploadedFile($_FILES["image"], ["jpg", "jpeg", "png", "webp"]);
    if (strpos($filePath, "ERROR:") === 0) {
        $_SESSION["reportImageError"] = substr($filePath, 7);
        $hasError = true;
        $filePath = "";
    } else
        unset($_SESSION["reportImageError"]);
}

if ($hasError) {
    redirect("../View/reportItem.php");
}

$database = new DatabaseConnection();
$connection = $database->openConnection();
$result = $database->addItem($connection, $_SESSION["loggedInUserId"], $category_id, $title, $description, $type, $location, $date_lost_found, $filePath, $contact_info);

if ($result) {
    unset($_SESSION["report_old"]);
    $_SESSION["successMessage"] = "Item reported successfully";
    redirect("../View/myItems.php");
}

$_SESSION["reportError"] = "Could not report the item";
redirect("../View/reportItem.php");
?>