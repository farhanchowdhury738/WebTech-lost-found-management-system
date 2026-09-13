<?php
session_start();

if (($_SESSION["isLoggedIn"] ?? false) === true) {
    if (($_SESSION["role"] ?? "") === "admin") {
        header("Location: adminDashboard.php");
    } else {
        header("Location: dashboard.php");
    }
    exit();
}

$emailError = $_SESSION["loginEmailError"] ?? "";
$passwordError = $_SESSION["loginPasswordError"] ?? "";
$loginMessage = $_SESSION["loginFailMessage"] ?? "";
$success = $_SESSION["successMessage"] ?? "";
$email = $_SESSION["old_login_email"] ?? "";

unset(
    $_SESSION["loginEmailError"],
    $_SESSION["loginPasswordError"],
    $_SESSION["loginFailMessage"],
    $_SESSION["old_login_email"],
    $_SESSION["successMessage"]
);

include "header.php";
?>

<div class="login-container">

    <?php
    if ($success) {
        echo '<div class="success">' . htmlspecialchars($success) . '</div>';
    }

    if ($loginMessage) {
        echo '<div class="fail">' . htmlspecialchars($loginMessage) . '</div>';
    }
    ?>

    <fieldset class="login-box">

        <legend>Log In</legend>


        <form action="../Controller/loginValidation.php" method="post">

            <table class="login-table">

                <tr>
                    <td>
                        <label for="email">Email Address</label>
                    </td>

                    <td>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?php echo htmlspecialchars($email); ?>"
                        >

                        <?php
                        if ($emailError) {
                            echo '<span class="error">'
                                . htmlspecialchars($emailError)
                                . '</span>';
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="password">Password</label>
                    </td>

                    <td>
                        <input
                            type="password"
                            id="password"
                            name="password"
                        >

                        <?php
                        if ($passwordError) {
                            echo '<span class="error">'
                                . htmlspecialchars($passwordError)
                                . '</span>';
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td></td>

                    <td>
                        <input
                            type="submit"
                            value="Sign In"
                            class="login-button"
                        >
                    </td>
                </tr>

            </table>

        </form>

        <p class="register-text">
            Don't have an account?
            <a href="registration.php">Sign up</a>
        </p>

    </fieldset>

</div>

<?php include "footer.php"; ?>