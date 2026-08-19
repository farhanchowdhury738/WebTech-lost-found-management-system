<?php session_start(); require_once __DIR__.'/../Model/AppData.php'; ?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Khoja-Khuji</title><link rel="stylesheet" href="style.css"></head><body>
<?php include 'header.php'; ?>
<main class="home-hero">
  <?php if(!empty($_SESSION['flash'])){echo '<div class="flash" style="max-width:700px;margin:20px auto 0">'.htmlspecialchars($_SESSION['flash']).'</div>';unset($_SESSION['flash']);} ?>
  <h1>Khoja-Khuji</h1>
  <p>We provide a secure, transparent, and reliable platform dedicated to solving<br>everyday losses. Whether you’ve lost a valuable item or found something that<br>belongs to someone else, our mission is to make the recovery process fast,<br>safe, and effortless for everyone.</p>
  <div class="hero-buttons"><a class="hero-btn btn btn-primary" href="submit.php">＋ &nbsp; Report an Item</a><a class="hero-btn btn btn-outline" href="lost.php">⌕ &nbsp; Search Lost Items</a></div>
  <div class="feature-grid">
    <a class="feature-card" href="submit.php"><div class="feature-icon">＋</div><h3>Report Lost Items</h3><p>Quickly report your lost items with details and images to increase your chances of finding them.</p></a>
    <a class="feature-card" href="lost.php"><div class="feature-icon">⌕</div><h3>Find Items</h3><p>Search your items</p></a>
  </div>
</main>
</body></html>
