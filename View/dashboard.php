<?php
session_start();
if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: login.php");
    exit();
}
include "header.php";
?>
<h1>Welcome, <?php echo htmlspecialchars($_SESSION["loggedInUsername"]); ?>!</h1>
<p class="muted">Use your dashboard to report items, track your reports and check your claims.</p>
<div class="grid">
    <div class="card">
        <div class="stat">Report</div>
        <p>Report a lost or found item.</p><a class="btn" href="reportItem.php">Report Item</a>
    </div>
    <div class="card">
        <div class="stat">My Items</div>
        <p>View your reported items and their status.</p><a class="btn" href="myItems.php">View My Items</a>
    </div>
    <div class="card">
        <div class="stat">My Claims</div>
        <p>Track submitted claims.</p><a class="btn" href="myClaims.php">View My Claims</a>
    </div>
</div>
<?php include "footer.php"; ?>