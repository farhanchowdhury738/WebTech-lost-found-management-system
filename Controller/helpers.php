<?php
function redirect($path)
{
    header("Location: " . $path);
    exit();
}

function requireLogin($redirectPath = "../View/login.php")
{
    if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
        redirect($redirectPath);
    }
}

function requireAdmin($redirectPath = "../View/login.php")
{
    requireLogin($redirectPath);
    if (($_SESSION["role"] ?? "user") !== "admin") {
        redirect("../View/dashboard.php");
    }
}

function saveUploadedFile($file, $allowedExtensions, $maxSize = 5242880)
{
    if (!$file || !isset($file["name"]) || $file["error"] === UPLOAD_ERR_NO_FILE) {
        return "";
    }
    if ($file["error"] !== UPLOAD_ERR_OK) {
        return "ERROR: File upload failed";
    }
    if ($file["size"] > $maxSize) {
        return "ERROR: File size must be less than 5MB";
    }
    $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions)) {
        return "ERROR: Invalid file type";
    }
    $newName = time() . "_" . preg_replace('/[^A-Za-z0-9._-]/', '_', basename($file["name"]));
    $directory = "../uploads/";
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
    $path = $directory . $newName;
    if (!move_uploaded_file($file["tmp_name"], $path)) {
        return "ERROR: Could not save uploaded file";
    }
    return $path;
}
?>