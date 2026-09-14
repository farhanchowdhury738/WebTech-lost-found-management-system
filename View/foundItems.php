<?php

session_start();

include "../Model/DatabaseConnection.php";

$database = new DatabaseConnection();
$connection = $database->openConnection();

$search = $_POST["search"] ?? "";
$category = $_POST["category"] ?? "";

$items = $database->getItems(
    $connection,
    "Found",
    $search,
    $category
);

$categories = $database->getCategories($connection);

$claimError = $_SESSION["claimError"] ?? "";
unset($_SESSION["claimError"]);

include "header.php";

?>

<h1>Found Items</h1>

<?php

if ($claimError) {
    echo '<p>' . htmlspecialchars($claimError) . '</p>';
}

if ($_SESSION["isLoggedIn"] ?? false) {
?>
    <p>
        <a href="reportItem.php" class="btn">
            Report Found Item
        </a>
    </p>
<?php
}
?>

<!-- Search Found Items -->
<fieldset>
    <legend>Search Found Items</legend>
    <form method="post">
        <table>
            <tr>
                <td>
                    <label>Search:</label>
                </td>
                <td>
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>">
                </td>
            </tr>

            <tr>
                <td>
                    <label>Category:</label>
                </td>
                <td>
                    <select name="category">
                        <option value=""> All Categories </option>
                        <?php
                        while ($cat = $categories->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $cat["id"]; ?>" <?php if ($category == $cat["id"]) {
                                                                            echo "selected";
                                                                        } ?>>
                                <?php echo htmlspecialchars($cat["name"]); ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Search">
                </td>
            </tr>
        </table>
    </form>
</fieldset>
<br>

<!-- Found Items List -->
<fieldset>
    <legend>Found Items</legend>
    <table class="table">
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Category</th>
            <th>Location</th>
            <th>Date Found</th>
            <th>Status</th>
            <th>Action</th>

        </tr>


        <?php if ($items && $items->num_rows > 0): ?>
            <?php while ($item = $items->fetch_assoc()): ?>
                <tr>
                    <!-- Image -->
                    <td>
                        <?php if ($item["image_path"]): ?>
                            <img src="<?php echo htmlspecialchars($item["image_path"]); ?>" width="80" height="60">
                        <?php else: ?> No Image <?php endif; ?>
                    </td>

                    <!-- Title -->
                    <td>
                        <?php echo htmlspecialchars($item["title"]); ?>
                    </td>

                    <!-- Category -->
                    <td>
                        <?php echo htmlspecialchars($item["category_name"]); ?>
                    </td>

                    <!-- Location -->
                    <td>
                        <?php echo htmlspecialchars($item["location"]); ?>
                    </td>

                    <!-- Date -->
                    <td>
                        <?php echo htmlspecialchars($item["date_lost_found"]); ?>
                    </td>

                    <!-- Status -->
                    <td>
                        <?php echo htmlspecialchars($item["status"]); ?>
                    </td>

                    <!-- Action -->
                    <td>
                        <a href="itemDetails.php?id=<?php echo $item["id"]; ?>">
                            View Details
                        </a>

                        <?php
                        if (
                            ($_SESSION["isLoggedIn"] ?? false) &&
                            $item["status"] === "Open" &&
                            (int) $item["user_id"] !==
                            (int) $_SESSION["loggedInUserId"]
                        ):

                        ?>

                            <br>
                            <a href="claimItem.php?id=<?php echo $item["id"]; ?>">
                                Claim Item
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr>
                <td colspan="7"> No found items found. </td>
            </tr>
        <?php endif; ?>
    </table>
</fieldset>


<?php include "footer.php"; ?>