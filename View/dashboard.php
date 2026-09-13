<?php
session_start();
if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: login.php");
    exit();
}
include "header.php";
?>
<h1>Welcome, <?php echo htmlspecialchars($_SESSION["loggedInUsername"]); ?>!</h1>




<a class="btn" href="reportItem.php">Report Item</a>

    <a class="btn" href="myItems.php">View My Items</a>

    <a class="btn" href="myClaims.php">View My Claims</a>


<?php include "footer.php"; ?>