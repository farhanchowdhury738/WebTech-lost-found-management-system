<?php
session_start();
if (!($_SESSION["isLoggedIn"] ?? false)) { header("Location: login.php"); exit(); }
include "../Model/DatabaseConnection.php";
$database = new DatabaseConnection(); $connection = $database->openConnection(); $categories = $database->getCategories($connection);
$old = $_SESSION["report_old"] ?? [];
$err = function($key){ return htmlspecialchars($_SESSION[$key] ?? ""); };
$reportError = $_SESSION["reportError"] ?? "";
unset($_SESSION["reportError"]);
include "header.php";
if ($reportError) echo '<div class="fail">'.htmlspecialchars($reportError).'</div>';
?>
<div class="form-card"><h2>Report an Item</h2><p class="muted">Please provide as much detail as possible.</p>
<form action="../Controller/reportItem.php" method="post" enctype="multipart/form-data">
<div class="field"><label>Type</label><select name="type"><option value="">Select</option><option value="Lost" <?php echo (($old["type"]??"")==="Lost"?'selected':''); ?>>I Lost an Item</option><option value="Found" <?php echo (($old["type"]??"")==="Found"?'selected':''); ?>>I Found an Item</option></select><div class="error"><?php echo $err("reportTypeError"); ?></div></div>
<div class="field"><label>Item Name</label><input type="text" name="title" value="<?php echo htmlspecialchars($old["title"]??""); ?>"><div class="error"><?php echo $err("reportTitleError"); ?></div></div>
<div class="field"><label>Category</label><select name="category_id"><option value="">Select category</option><?php while($cat=$categories->fetch_assoc()): ?><option value="<?php echo $cat["id"]; ?>" <?php echo (($old["category_id"]??"")==$cat["id"]?'selected':''); ?>><?php echo htmlspecialchars($cat["name"]); ?></option><?php endwhile; ?></select><div class="error"><?php echo $err("reportCategoryError"); ?></div></div>
<div class="field"><label>Location</label><input type="text" name="location" value="<?php echo htmlspecialchars($old["location"]??""); ?>"><div class="error"><?php echo $err("reportLocationError"); ?></div></div>
<div class="field"><label>Date</label><input type="date" name="date_lost_found" value="<?php echo htmlspecialchars($old["date_lost_found"]??""); ?>"><div class="error"><?php echo $err("reportDateError"); ?></div></div>
<div class="field"><label>Description</label><textarea name="description"><?php echo htmlspecialchars($old["description"]??""); ?></textarea><div class="error"><?php echo $err("reportDescriptionError"); ?></div></div>
<div class="field"><label>Contact Information</label><input type="text" name="contact_info" value="<?php echo htmlspecialchars($old["contact_info"]??""); ?>"><div class="error"><?php echo $err("reportContactError"); ?></div></div>
<div class="field"><label>Item Image (optional)</label><input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"><div class="error"><?php echo $err("reportImageError"); ?></div></div>
<button class="btn">Submit Report</button></form></div>
<?php include "footer.php"; ?>
