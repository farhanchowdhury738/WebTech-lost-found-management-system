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

$oldName = $_SESSION["old_name"] ?? "";
$oldEmail = $_SESSION["old_email"] ?? "";
$oldPhone = $_SESSION["old_phone"] ?? "";

$errors = [
    "nameError" => $_SESSION["nameError"] ?? "",
    "emailError" => $_SESSION["emailError"] ?? "",
    "passwordError" => $_SESSION["passwordError"] ?? "",
    "confirmPasswordError" => $_SESSION["confirmPasswordError"] ?? "",
    "phoneError" => $_SESSION["phoneError"] ?? ""
];

$registerError = $_SESSION["registerError"] ?? "";

unset(
    $_SESSION["nameError"],
    $_SESSION["emailError"],
    $_SESSION["passwordError"],
    $_SESSION["confirmPasswordError"],
    $_SESSION["phoneError"],
    $_SESSION["registerError"]
);

include "header.php";
?>

<div class="register-container">

    <?php
    if ($registerError) {
        echo '<div class="fail">' . htmlspecialchars($registerError) . '</div>';
    }
    ?>

    <fieldset class="register-box">

        <legend>Create Account</legend>

        <p class="register-text">
            Create your Khoja-Khuji account
        </p>

        <form action="../Controller/registrationValidation.php" method="post">

            <table class="register-table">

                <tr>
                    <td>
                        <label for="name">Full Name</label>
                    </td>

                    <td>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?php echo htmlspecialchars($oldName); ?>"
                        >

                        <?php
                        if ($errors["nameError"]) {
                            echo '<span class="error">'
                                . htmlspecialchars($errors["nameError"])
                                . '</span>';
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="email">Email Address</label>
                    </td>

                    <td>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?php echo htmlspecialchars($oldEmail); ?>"
                        >

                        <?php
                        if ($errors["emailError"]) {
                            echo '<span class="error">'
                                . htmlspecialchars($errors["emailError"])
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
                        if ($errors["passwordError"]) {
                            echo '<span class="error">'
                                . htmlspecialchars($errors["passwordError"])
                                . '</span>';
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="confirm_password">
                            Confirm Password
                        </label>
                    </td>

                    <td>
                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                        >

                        <?php
                        if ($errors["confirmPasswordError"]) {
                            echo '<span class="error">'
                                . htmlspecialchars($errors["confirmPasswordError"])
                                . '</span>';
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="phone">
                            Phone Number
                        </label>
                        <br>
                        <small>(optional)</small>
                    </td>

                    <td>
                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="<?php echo htmlspecialchars($oldPhone); ?>"
                        >

                        <?php
                        if ($errors["phoneError"]) {
                            echo '<span class="error">'
                                . htmlspecialchars($errors["phoneError"])
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
                            value="Create Account"
                            class="login-button"
                        >
                    </td>
                </tr>

            </table>

        </form>

        <p class="register-text">
            Already have an account?
            <a href="login.php">Sign in</a>
        </p>

    </fieldset>

</div>

<?php include "footer.php"; ?>