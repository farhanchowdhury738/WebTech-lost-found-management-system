<?php
session_start();

include "../Model/DatabaseConnection.php";

$database = new DatabaseConnection();
$connection = $database->openConnection();

$search = $_GET["search"] ?? "";
$category = $_GET["category"] ?? "";

$items = $database->getItems(
    $connection,
    "Lost",
    $search,
    $category
);

$categories = $database->getCategories($connection);

include "header.php";
?>

<h1>Lost Items</h1>

<?php
if ($_SESSION["isLoggedIn"] ?? false) {
?>
    <p>
        <a href="reportItem.php" class="btn">Report Lost Item</a>
    </p>
<?php
}
?>







<fieldset>
    <legend>Search Lost Items</legend>

    <form method="get">

        <table>

            <tr>
                <td>
                    <label>Search:</label>
                </td>

                <td>
                    <input
                        type="text"
                        name="search"
                        value="<?php echo htmlspecialchars($search); ?>">
                </td>
            </tr>



            <tr>
                <td>
                    <label>Category:</label>
                </td>

                <td>
                    <select name="category">

                        <option value="">All Categories</option>

                        <?php
                        while ($cat = $categories->fetch_assoc()) {
                        ?>
                            <option
                                value="<?php echo $cat["id"]; ?>"
                                <?php
                                if ($category == $cat["id"]) {
                                    echo "selected";
                                }
                                ?>>
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

<fieldset>
    <legend>Lost Items</legend>

    <table class="table">
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Category</th>
            <th>Location</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        <?php if ($items && $items->num_rows > 0): ?>

            <?php while ($item = $items->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?php if ($item["image_path"]): ?>
                            <img
                                src="<?php echo htmlspecialchars($item["image_path"]); ?>"
                                width="80"
                                height="60">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>

                    <td><?php echo htmlspecialchars($item["title"]); ?></td>
                    <td><?php echo htmlspecialchars($item["category_name"]); ?></td>
                    <td><?php echo htmlspecialchars($item["location"]); ?></td>
                    <td><?php echo htmlspecialchars($item["date_lost_found"]); ?></td>

                    <td>
                        <a href="itemDetails.php?id=<?php echo $item["id"]; ?>">
                            View Details
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="6">No lost items found.</td>
            </tr>

        <?php endif; ?>
    </table>
</fieldset>

<?php include "footer.php"; ?>