<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
$isLoggedIn = $_SESSION["isLoggedIn"] ?? false;
$isAdmin = ($_SESSION["role"] ?? "user") === "admin";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khoja-Khuji</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <div class="nav">
        <a class="brand" href="home.php">Khoja-Khuji</a>
        <div class="navlinks">
            <a href="home.php">Home</a>
            <a href="lostItems.php">Lost Items</a>
            <a href="foundItems.php">Found Items</a>
            <?php if ($isLoggedIn): ?>
                <?php if ($isAdmin): ?>
                    <a href="adminDashboard.php">Dashboard</a>
                <?php else: ?>
                    <a href="dashboard.php">Dashboard</a>
                <?php endif; ?>
                <a href="reportItem.php">Report Item</a>
                <a href="profile.php">Profile</a>
                <a href="../Controller/logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Log in</a>
                <a class="btn small" href="registration.php">Sign up</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="container">
        <?php
        $successMessage = $_SESSION["successMessage"] ?? "";
        if ($successMessage) {
            echo '<p class="success-message">' . htmlspecialchars($successMessage) . '</p>';
            unset($_SESSION["successMessage"]);
        }
        ?>