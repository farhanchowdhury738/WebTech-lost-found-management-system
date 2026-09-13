<?php

session_start();

if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: login.php");
    exit();
}

include "../Model/DatabaseConnection.php";

$db = new DatabaseConnection();
$con = $db->openConnection();

$user = $db->getUserById($con, $_SESSION["loggedInUserId"]);

$err = function ($k) {
    return htmlspecialchars($_SESSION[$k] ?? "");
};

include "header.php";

?>

<link rel="stylesheet" href="../assets/style.css">

<div class="profile-page">

    <div class="profile-title">
        <h1>Profile Update</h1>
    </div>


    <!-- Update Name -->

    <div class="profile-box">

        <h3>Update Name</h3>

        <form action="../Controller/updateProfile.php" method="post">

            <div class="field">

                <label>Full Name</label>

                <input type="text" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>">

                <div class="error">
                    <?php echo $err("profileNameError"); ?>
                </div>

            </div>

            <button type="submit" class="profile-btn">
                Save Changes
            </button>

        </form>

    </div>


    <!-- Change Password -->

    <div class="profile-box">

        <h3>Change Password</h3>

        <form action="../Controller/changePassword.php" method="post">

            <div class="field">

                <label>Current Password</label>

                <input type="password" name="current_password">

                <div class="error">
                    <?php echo $err("currentPasswordError"); ?>
                </div>

            </div>


            <div class="field">

                <label>New Password</label>

                <input type="password" name="new_password">

                <div class="error">
                    <?php echo $err("newPasswordError"); ?>
                </div>

            </div>


            <div class="field">

                <label>Confirm New Password</label>

                <input type="password" name="confirm_password">

                <div class="error">
                    <?php echo $err("confirmNewPasswordError"); ?>
                </div>

            </div>


            <button type="submit" class="profile-btn">
                Change Password
            </button>

        </form>

    </div>

</div>


<?php

unset($_SESSION["profileNameError"]);
unset($_SESSION["profileError"]);
unset($_SESSION["currentPasswordError"]);
unset($_SESSION["newPasswordError"]);
unset($_SESSION["confirmNewPasswordError"]);

include "footer.php";

?>