<?php
session_start();
include "../Model/DatabaseConnection.php";
$database = new DatabaseConnection();
$connection = $database->openConnection();
$search = trim($_GET["search"] ?? "");
$category = $_GET["category"] ?? "";
$items = $database->getItems($connection, "Lost", $search, $category);
$categories = $database->getCategories($connection);
include "header.php";
?>

<div class="top-actions">
    <h1>Lost Items</h1><?php if ($_SESSION["isLoggedIn"] ?? false): ?><a class="btn" href="reportItem.php">+ Report Lost
            Item</a><?php endif; ?>
</div>
<form class="card" method="get">
    <div class="grid">
        <div class="field"><label>Search</label><input type="text" name="search"
                value="<?php echo htmlspecialchars($search); ?>" placeholder="Search item, description or location">
        </div>
        <div class="field"><label>Category</label><select name="category">
                <option value="">All Categories</option><?php while ($cat = $categories->fetch_assoc()): ?>
                    <option value="<?php echo $cat["id"]; ?>" <?php echo ($category == $cat["id"] ? 'selected' : ''); ?>>
                        <?php echo htmlspecialchars($cat["name"]); ?>
                    </option><?php endwhile; ?>
            </select></div>
    </div><button class="btn">Search</button>
</form>

<div class="grid"><?php if ($items && $items->num_rows):
    while ($item = $items->fetch_assoc()): ?>
            <div class="card"><?php if ($item["image_path"]): ?><img class="item-img"
                        src="<?php echo htmlspecialchars($item["image_path"]); ?>"><?php else: ?>
                    <div class="item-img"></div><?php endif; ?>
                <h3><?php echo htmlspecialchars($item["title"]); ?></h3><span class="badge">Lost</span>
                <p class="meta">Category: <?php echo htmlspecialchars($item["category_name"]); ?><br>Location:
                    <?php echo htmlspecialchars($item["location"]); ?><br>Date:
                    <?php echo htmlspecialchars($item["date_lost_found"]); ?>
                </p><a href="itemDetails.php?id=<?php echo $item["id"]; ?>">View Details</a>
            </div><?php endwhile; else: ?>
        <p>No lost items found.</p><?php endif; ?>
</div>
<?php include "footer.php"; ?>