<?php session_start();
include "../Controller/helpers.php";
requireAdmin();
include "header.php"; ?>
<h1>Admin Dashboard</h1>
<p class="muted">Manage users, lost and found items, categories and claims.</p>
<div class="grid">
    <div class="card">
        <h3>Users</h3>
        <p>View, add, edit, block/activate and delete users.</p><a class="btn" href="adminUsers.php">Manage Users</a>
    </div>
    <div class="card">
        <h3>Items</h3>
        <p>Manage all lost and found item reports.</p><a class="btn" href="adminItems.php">Manage Items</a>
    </div>
    <div class="card">
        <h3>Categories</h3>
        <p>Add, update or delete item categories.</p><a class="btn" href="adminCategories.php">Manage Categories</a>
    </div>
    <div class="card">
        <h3>Claims</h3>
        <p>Review ownership claims and update their status.</p><a class="btn" href="adminClaims.php">Manage Claims</a>
    </div>
</div>
<?php include "footer.php"; ?>