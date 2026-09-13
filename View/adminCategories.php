<?php session_start();
include "../Controller/helpers.php";
requireAdmin();
include "../Model/DatabaseConnection.php";
$db = new DatabaseConnection();
$con = $db->openConnection();
$cats = $db->getCategories($con);
$error = $_SESSION["categoryError"] ?? "";
unset($_SESSION["categoryError"]);
include "header.php";
if ($error)
    echo '<div class="fail">' . htmlspecialchars($error) . '</div>'; ?>
<h1>Manage Categories</h1>
<div class="form-card" style="margin-left:0">
    <h3>Add Category</h3>
    <form action="../Controller/adminCategory.php" method="post"><input type="hidden" name="action" value="add">
        <div class="field"><label>Name</label><input name="name"></div>
        <div class="field"><label>Description</label><textarea name="description"></textarea></div><button
            class="btn">Add Category</button>
    </form>
</div>
<div class="grid"><?php while ($c = $cats->fetch_assoc()): ?>
        <div class="card">
            <form action="../Controller/adminCategory.php" method="post"><input type="hidden" name="action"
                    value="update"><input type="hidden" name="id" value="<?php echo $c["id"]; ?>">
                <div class="field"><label>Name</label><input name="name"
                        value="<?php echo htmlspecialchars($c["name"]); ?>"></div>
                <div class="field"><label>Description</label><textarea
                        name="description"><?php echo htmlspecialchars($c["description"]); ?></textarea></div><button
                    class="btn small">Update</button>
            </form>
            <form action="../Controller/adminCategory.php" method="post" style="margin-top:8px"><input type="hidden"
                    name="action" value="delete"><input type="hidden" name="id" value="<?php echo $c["id"]; ?>"><button
                    class="btn danger small">Delete</button></form>
        </div><?php endwhile; ?>
</div>
<?php include "footer.php"; ?>