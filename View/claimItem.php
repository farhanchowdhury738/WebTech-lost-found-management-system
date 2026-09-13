<?php
session_start(); if(!($_SESSION["isLoggedIn"]??false)){header("Location: login.php");exit();}
include "../Model/DatabaseConnection.php"; $database=new DatabaseConnection(); $connection=$database->openConnection(); $item=$database->getItemById($connection,$_GET["id"]??($_SESSION["claim_item_id"]??0));
if(!$item || $item["type"]!=="Found"){header("Location: foundItems.php");exit();}
$old=$_SESSION["claim_old"]??[]; include "header.php";
?>
<div class="form-card"><h2>Claim Item</h2><div class="card"><b><?php echo htmlspecialchars($item["title"]); ?></b><p class="meta">Found by: <?php echo htmlspecialchars($item["reporter_name"]); ?><br>Contact: <?php echo htmlspecialchars($item["contact_info"]); ?><br>Location: <?php echo htmlspecialchars($item["location"]); ?></p></div><form action="../Controller/submitClaim.php" method="post" enctype="multipart/form-data"><input type="hidden" name="item_id" value="<?php echo $item["id"]; ?>">
<div class="field"><label>Your Name</label><input type="text" name="name" value="<?php echo htmlspecialchars($old["name"]??$_SESSION["loggedInUsername"]??""); ?>"><div class="error"><?php echo htmlspecialchars($_SESSION["claimNameError"]??""); ?></div></div>
<div class="field"><label>Email Address</label><input type="email" name="email" value="<?php echo htmlspecialchars($old["email"]??$_SESSION["loggedInEmail"]??""); ?>"><div class="error"><?php echo htmlspecialchars($_SESSION["claimEmailError"]??""); ?></div></div>
<div class="field"><label>Phone Number</label><input type="text" name="phone" value="<?php echo htmlspecialchars($old["phone"]??""); ?>"><div class="error"><?php echo htmlspecialchars($_SESSION["claimPhoneError"]??""); ?></div></div>
<div class="field"><label>Describe the Item / Proof of Ownership</label><textarea name="description"><?php echo htmlspecialchars($old["description"]??""); ?></textarea><div class="error"><?php echo htmlspecialchars($_SESSION["claimDescriptionError"]??""); ?></div></div>
<div class="field"><label>Upload Proof of Ownership (optional)</label><input type="file" name="proof" accept=".jpg,.jpeg,.png,.pdf,.webp"><div class="error"><?php echo htmlspecialchars($_SESSION["claimProofError"]??""); ?></div></div>
<div class="field"><label>Additional Information (optional)</label><textarea name="additional_info"><?php echo htmlspecialchars($old["additional_info"]??""); ?></textarea></div>
<button class="btn">Submit Claim</button></form></div>
<?php foreach(["claimNameError","claimEmailError","claimPhoneError","claimDescriptionError","claimProofError"] as $k) unset($_SESSION[$k]); include "footer.php"; ?>
