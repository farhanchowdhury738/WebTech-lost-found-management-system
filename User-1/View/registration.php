<?php session_start();
$errors = $_SESSION['register_errors'] ?? [];
$old = $_SESSION['old_register'] ?? ['name' => '', 'email' => ''];
unset($_SESSION['register_errors'], $_SESSION['old_register']); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign up</title>
    <link rel="stylesheet" href="style.css">
</head>

<body><?php include 'header.php'; ?>
    <main class="auth-page">
        <div class="register-box">
            <h1>Create Account</h1><?php if ($errors): ?>
                <div class="error-box"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
            <?php endif; ?>
            <form action="../Controller/register.php" method="post">
                <div class="field"><label>Full Name</label><input name="name" placeholder="Enter your full name"
                        value="<?php echo htmlspecialchars($old['name']); ?>" required></div>
                <div class="field"><label>Email Address</label><input type="email" name="email"
                        placeholder="Enter your email" value="<?php echo htmlspecialchars($old['email']); ?>" required>
                </div>
                <div class="field"><label>Password</label>
                    <div class="password-wrap"><input type="password" name="password" placeholder="Create a password"
                            required><span class="eye">◉</span></div><small>Must be at least 8 characters long</small>
                </div>
                <div class="field"><label>Confirm Password</label>
                    <div class="password-wrap"><input type="password" name="confirm_password"
                            placeholder="Confirm your password" required><span class="eye">◉</span></div>
                </div><label class="terms-agreement" style="line-height:1.45"><input type="checkbox" name="agree" required> I
                    agree to the <a href="#" style="color:#347df2">Terms of Service</a> and <a href="#"
                        style="color:#347df2">Privacy Policy</a></label><button class="full-btn" style="margin-top:25px"
                    type="submit">Create Account</button>
            </form>
            <p class="auth-note">Already have an account? <a href="login.php">Sign in</a></p>
        </div>
    </main>
</body>

</html>