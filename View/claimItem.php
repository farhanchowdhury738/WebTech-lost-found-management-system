<?php
session_start();

if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: login.php");
    exit();
}

include "../Model/DatabaseConnection.php";

$database = new DatabaseConnection();
$connection = $database->openConnection();

$itemId = $_GET["id"] ?? ($_SESSION["claim_item_id"] ?? 0);
$item = $database->getItemById($connection, $itemId);

if (!$item || $item["type"] !== "Found") {
    header("Location: foundItems.php");
    exit();
}

$old = $_SESSION["claim_old"] ?? [];

include "header.php";
?>
<<<<<<< Updated upstream
<div class="form-card">
    <h2>Claim Item</h2>
    <div class="card"><b><?php echo htmlspecialchars($item["title"]); ?></b>
        <p class="meta">Found by: <?php echo htmlspecialchars($item["reporter_name"]); ?><br>Contact:
            <?php echo htmlspecialchars($item["contact_info"]); ?><br>Location:
            <?php echo htmlspecialchars($item["location"]); ?>
        </p>
    </div>
    <form action="../Controller/submitClaim.php" method="post" enctype="multipart/form-data"><input type="hidden"
            name="item_id" value="<?php echo $item["id"]; ?>">
        <div class="field"><label>Your Name</label><input type="text" name="name"
                value="<?php echo htmlspecialchars($old["name"] ?? $_SESSION["loggedInUsername"] ?? ""); ?>">
            <div class="error"><?php echo htmlspecialchars($_SESSION["claimNameError"] ?? ""); ?></div>
        </div>
        <div class="field"><label>Email Address</label><input type="email" name="email"
                value="<?php echo htmlspecialchars($old["email"] ?? $_SESSION["loggedInEmail"] ?? ""); ?>">
            <div class="error"><?php echo htmlspecialchars($_SESSION["claimEmailError"] ?? ""); ?></div>
        </div>
        <div class="field"><label>Phone Number</label><input type="text" name="phone"
                value="<?php echo htmlspecialchars($old["phone"] ?? ""); ?>">
            <div class="error"><?php echo htmlspecialchars($_SESSION["claimPhoneError"] ?? ""); ?></div>
        </div>
        <div class="field"><label>Describe the Item / Proof of Ownership</label><textarea
                name="description"><?php echo htmlspecialchars($old["description"] ?? ""); ?></textarea>
            <div class="error"><?php echo htmlspecialchars($_SESSION["claimDescriptionError"] ?? ""); ?></div>
        </div>
        <div class="field"><label>Upload Proof of Ownership (optional)</label><input type="file" name="proof"
                accept=".jpg,.jpeg,.png,.pdf,.webp">
            <div class="error"><?php echo htmlspecialchars($_SESSION["claimProofError"] ?? ""); ?></div>
        </div>
        <div class="field"><label>Additional Information (optional)</label><textarea
                name="additional_info"><?php echo htmlspecialchars($old["additional_info"] ?? ""); ?></textarea></div>
        <button class="btn">Submit Claim</button>
=======

<fieldset class="claim-box">
    <legend>Claim Item</legend>
    <p>
        <b><?php echo htmlspecialchars($item["title"]); ?></b>
    </p>

    <p>
        Found by: <?php echo htmlspecialchars($item["reporter_name"]); ?><br>
        Contact: <?php echo htmlspecialchars($item["contact_info"]); ?><br>
        Location: <?php echo htmlspecialchars($item["location"]); ?>
    </p>

    <form action="../Controller/submitClaim.php" method="post" enctype="multipart/form-data">

        <input type="hidden" name="item_id" value="<?php echo $item["id"]; ?>">

        <table>

            <tr>
                <td>
                    <label>Your Name:</label>
                </td>
                <td>
                    <input
                        type="text"
                        name="name"
                        value="<?php echo htmlspecialchars($old["name"] ?? $_SESSION["loggedInUsername"] ?? ""); ?>">
                    <span class="error">
                        <?php echo htmlspecialchars($_SESSION["claimNameError"] ?? ""); ?>
                    </span>
                </td>
            </tr>

            <tr>
                <td>
                    <label>Email Address:</label>
                </td>
                <td>
                    <input
                        type="email"
                        name="email"
                        value="<?php echo htmlspecialchars($old["email"] ?? $_SESSION["loggedInEmail"] ?? ""); ?>">
                    <span class="error">
                        <?php echo htmlspecialchars($_SESSION["claimEmailError"] ?? ""); ?>
                    </span>
                </td>
            </tr>

            <tr>
                <td>
                    <label>Phone Number:</label>
                </td>
                <td>
                    <input
                        type="text"
                        name="phone"
                        value="<?php echo htmlspecialchars($old["phone"] ?? ""); ?>">
                    <span class="error">
                        <?php echo htmlspecialchars($_SESSION["claimPhoneError"] ?? ""); ?>
                    </span>
                </td>
            </tr>

            <tr>
                <td>
                    <label>Describe the Item / Proof of Ownership:</label>
                </td>
                <td>
                    <textarea name="description"><?php echo htmlspecialchars($old["description"] ?? ""); ?></textarea>
                    <span class="error">
                        <?php echo htmlspecialchars($_SESSION["claimDescriptionError"] ?? ""); ?>
                    </span>
                </td>
            </tr>

            <tr>
                <td>
                    <label>Upload Proof of Ownership:</label>
                </td>
                <td>
                    <input
                        type="file"
                        name="proof"
                        accept=".jpg,.jpeg,.png,.pdf,.webp">
                    <span class="error">
                        <?php echo htmlspecialchars($_SESSION["claimProofError"] ?? ""); ?>
                    </span>
                    <br>
                    <small>(optional)</small>
                </td>
            </tr>

            <tr>
                <td>
                    <label>Additional Information:</label>
                </td>
                <td>
                    <textarea name="additional_info"><?php echo htmlspecialchars($old["additional_info"] ?? ""); ?></textarea>
                    <br>
                    <small>(optional)</small>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Submit Claim" class="form-button">
                </td>
            </tr>

        </table>

>>>>>>> Stashed changes
    </form>

</fieldset>

<?php
foreach (
    [
        "claimNameError",
        "claimEmailError",
        "claimPhoneError",
        "claimDescriptionError",
        "claimProofError"
    ] as $key
) {
    unset($_SESSION[$key]);
}

include "footer.php";
?>