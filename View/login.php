<?php
session_start();
if (($_SESSION["isLoggedIn"] ?? false) === true) { header("Location: dashboard.php"); exit(); }
$emailError = $_SESSION["loginEmailError"] ?? "";
$passwordError = $_SESSION["loginPasswordError"] ?? "";
$loginMessage = $_SESSION["loginFailMessage"] ?? "";
$success = $_SESSION["successMessage"] ?? "";
$email = $_SESSION["old_login_email"] ?? "";
unset($_SESSION["loginEmailError"], $_SESSION["loginPasswordError"], $_SESSION["loginFailMessage"], $_SESSION["old_login_email"], $_SESSION["successMessage"]);
include "header.php";
if ($success) echo '<div class="success">'.htmlspecialchars($success).'</div>';
if ($loginMessage) echo '<div class="fail">'.htmlspecialchars($loginMessage).'</div>';
?>
<div class="form-card">
<h2>Welcome Back</h2><p class="muted">Sign in to continue to Khoja-Khuji.</p>
<form action="../Controller/loginValidation.php" method="post">
<div class="field"><label>Email Address</label><input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><div class="error"><?php echo htmlspecialchars($emailError); ?></div></div>
<div class="field"><label>Password</label><input type="password" name="password"><div class="error"><?php echo htmlspecialchars($passwordError); ?></div></div>
<button class="btn">Sign In</button>
</form><p>Don't have an account? <a href="registration.php">Sign up</a></p>
</div>
<?php include "footer.php"; ?>
