<?php
session_start();
include "../Model/DatabaseConnection.php";
$database = new DatabaseConnection();
$connection = $database->openConnection();
$item = $database->getItemById($connection, $_GET["id"] ?? 0);
include "header.php";
if (!$item) {
    echo '<div class="fail">Item not found.</div>';
    include "footer.php";
    exit();
}
?>
<div class="card">
    <h1><?php echo htmlspecialchars($item["title"]); ?></h1>
    <p><span class="badge"><?php echo htmlspecialchars($item["type"]); ?></span> <span
            class="badge"><?php echo htmlspecialchars($item["status"]); ?></span></p>
    <div class="grid">
        <div><?php if ($item["image_path"]): ?><img class="item-img"
                    src="<?php echo htmlspecialchars($item["image_path"]); ?>"><?php endif; ?></div>
        <div>
            <h3>Item Details</h3>
            <p class="meta">
                Category: <?php echo htmlspecialchars($item["category_name"]); ?><br>
                Location: <?php echo htmlspecialchars($item["location"]); ?><br>
                Date: <?php echo htmlspecialchars($item["date_lost_found"]); ?><br>
                Reported by: <?php echo htmlspecialchars($item["reporter_name"]); ?><br>
                Contact: <?php echo htmlspecialchars($item["contact_info"]); ?>
            </p>

            <h3>Description</h3>
            <p><?php echo nl2br(htmlspecialchars($item["description"])); ?></p>

            <?php if (
                $item["type"] === "Found" &&
                ($_SESSION["isLoggedIn"] ?? false) &&
                $item["status"] === "Open" &&
                (int) $item["user_id"] !== (int) $_SESSION["loggedInUserId"]
            ): ?>
                <a class="btn" href="claimItem.php?id=<?php echo $item["id"]; ?>">
                    Claim This Item
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php include "footer.php"; ?>