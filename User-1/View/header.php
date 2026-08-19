<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../Model/AppData.php';
$current = basename($_SERVER['PHP_SELF']);
$user = AppData::getUser();
$logged = !empty($_SESSION['isLoggedIn']) && $user;
?>
<header class="site-header">
  <div class="header-inner">
    <a class="brand" href="home.php"><strong>Khoja-Khuji</strong><span>You lost it, I'll find it for you</span></a>
    <nav class="main-nav">
      <a class="<?php echo $current==='home.php'?'active':''; ?>" href="home.php">Home</a>
      <a class="<?php echo $current==='lost.php'?'active':''; ?>" href="lost.php">Lost Items</a>
      <a class="<?php echo $current==='found.php'?'active':''; ?>" href="found.php">Found Items</a>
      <a class="<?php echo $current==='submit.php'?'active':''; ?>" href="submit.php">Report Item</a>
      <?php if ($logged): ?>
        <a class="profile-icon <?php echo ($current==='profile.php'||$current==='settings.php')?'active':''; ?>" href="profile.php" title="Profile">◎</a>
      <?php else: ?>
        <a class="login-pill" href="login.php">Log in</a>
        <a class="signup-pill" href="registration.php">Sign up</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
