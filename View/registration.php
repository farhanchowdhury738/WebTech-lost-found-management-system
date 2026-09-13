<?php
session_start();
if (($_SESSION["isLoggedIn"] ?? false) === true) { header("Location: dashboard.php"); exit(); }
$oldName = $_SESSION["old_name"] ?? ""; $oldEmail = $_SESSION["old_email"] ?? ""; $oldPhone = $_SESSION["old_phone"] ?? "";
$errors = ["nameError"=>$_SESSION["nameError"]??"","emailError"=>$_SESSION["emailError"]??"","passwordError"=>$_SESSION["passwordError"]??"","confirmPasswordError"=>$_SESSION["confirmPasswordError"]??"","phoneError"=>$_SESSION["phoneError"]??""];
$registerError = $_SESSION["registerError"] ?? "";
unset($_SESSION["nameError"],$_SESSION["emailError"],$_SESSION["passwordError"],$_SESSION["confirmPasswordError"],$_SESSION["phoneError"],$_SESSION["registerError"]);
include "header.php";
if ($registerError) echo '<div class="fail">'.htmlspecialchars($registerError).'</div>';
?>
<div class="form-card"><h2>Create Account</h2>
<form action="../Controller/registrationValidation.php" method="post">
<div class="field"><label>Full Name</label><input type="text" name="name" value="<?php echo htmlspecialchars($oldName); ?>"><div class="error"><?php echo htmlspecialchars($errors["nameError"]); ?></div></div>
<div class="field"><label>Email Address</label><input type="email" name="email" value="<?php echo htmlspecialchars($oldEmail); ?>"><div class="error"><?php echo htmlspecialchars($errors["emailError"]); ?></div></div>
<div class="field"><label>Password</label><input type="password" name="password"><div class="error"><?php echo htmlspecialchars($errors["passwordError"]); ?></div></div>
<div class="field"><label>Confirm Password</label><input type="password" name="confirm_password"><div class="error"><?php echo htmlspecialchars($errors["confirmPasswordError"]); ?></div></div>
<div class="field"><label>Phone Number (optional)</label><input type="text" name="phone" value="<?php echo htmlspecialchars($oldPhone); ?>"><div class="error"><?php echo htmlspecialchars($errors["phoneError"]); ?></div></div>
<button class="btn">Create Account</button></form><p>Already have an account? <a href="login.php">Sign in</a></p></div>
<?php include "footer.php"; ?>
