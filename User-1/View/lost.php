<?php session_start();
require_once __DIR__ . '/../Model/AppData.php';
$items = AppData::lostItems(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lost Items</title>
    <link rel="stylesheet" href="style.css">
</head>

<body><?php include 'header.php'; ?>
    <main class="page">
        <div class="page-top">
            <h1 class="section-title">Lost Items</h1><a class="btn btn-primary" href="submit.php">＋ &nbsp;Report Lost
                Item</a>
        </div>
        <div class="search"><input placeholder="Search lost items..."><span>⌕</span></div>
        <div class="item-grid"><?php foreach ($items as $item): ?>
                <article>
                    <div class="item-img">400 × 300</div>
                    <div class="item-name-row"><span
                            class="item-name"><?php echo htmlspecialchars($item['name']); ?></span><span
                            class="date"><?php echo $item['date']; ?></span></div>
                    <div class="item-location"><?php echo htmlspecialchars($item['location']); ?></div>
                    <div class="item-description"><?php echo htmlspecialchars($item['description']); ?></div><a
                        class="item-action" href="contact.php?id=<?php echo $item['id']; ?>">Contact Owner</a>
                </article><?php endforeach; ?>
        </div>
    </main><?php include 'footer.php'; ?>
</body>

</html>