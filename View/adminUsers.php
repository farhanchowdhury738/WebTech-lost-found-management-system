<?php
session_start();
include "../Controller/helpers.php";
requireAdmin();
include "../Model/DatabaseConnection.php";
$db=new DatabaseConnection();
$con=$db->openConnection();
$users=$db->getUsers($con);
$error=$_SESSION["userError"]??"";
unset($_SESSION["userError"]);
include "header.php";
if($error) echo '<div class="fail">'.htmlspecialchars($error).'</div>';
?>
<h1>Manage Users</h1>
<div class="form-card" style="margin-left:0;max-width:100%">
<h3>Add User</h3>
<form action="../Controller/adminUser.php" method="post">
<input type="hidden" name="action" value="add">
<div class="grid">
<div class="field"><label>Name</label><input name="name"></div>
<div class="field"><label>Email</label><input type="email" name="email"></div>
<div class="field"><label>Password</label><input type="password" name="password"></div>
<div class="field"><label>Phone</label><input name="phone"></div>
<div class="field"><label>Role</label><select name="role"><option value="user">User</option><option value="admin">Admin</option></select></div>
<div class="field"><label>Status</label><select name="status"><option value="active">Active</option><option value="blocked">Blocked</option></select></div>
</div><button class="btn">Add User</button>
</form></div>
<div class="table-wrap"><table class="table"><tr><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Status</th><th>Actions</th></tr>
<?php while($u=$users->fetch_assoc()): ?>
<tr><td><?php echo htmlspecialchars($u["name"]); ?></td><td><?php echo htmlspecialchars($u["email"]); ?></td><td><?php echo htmlspecialchars($u["phone"]); ?></td><td><?php echo htmlspecialchars($u["role"]); ?></td><td><?php echo htmlspecialchars($u["status"]); ?></td><td>
<details><summary>Edit</summary>
<form action="../Controller/adminUser.php" method="post" style="min-width:250px;margin-top:8px">
<input type="hidden" name="action" value="update"><input type="hidden" name="id" value="<?php echo $u['id']; ?>">
<div class="field"><label>Name</label><input name="name" value="<?php echo htmlspecialchars($u['name']); ?>"></div>
<div class="field"><label>Email</label><input type="email" name="email" value="<?php echo htmlspecialchars($u['email']); ?>"></div>
<div class="field"><label>Phone</label><input name="phone" value="<?php echo htmlspecialchars($u['phone']); ?>"></div>
<div class="field"><label>Role</label><select name="role"><option value="user" <?php echo $u['role']==='user'?'selected':''; ?>>User</option><option value="admin" <?php echo $u['role']==='admin'?'selected':''; ?>>Admin</option></select></div>
<div class="field"><label>Status</label><select name="status"><option value="active" <?php echo $u['status']==='active'?'selected':''; ?>>Active</option><option value="blocked" <?php echo $u['status']==='blocked'?'selected':''; ?>>Blocked</option></select></div>
<button class="btn small">Update</button></form></details>
<?php if($u['id'] != $_SESSION['loggedInUserId']): ?><form action="../Controller/adminUser.php" method="post" style="margin-top:8px"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?php echo $u['id']; ?>"><button class="btn danger small" onclick="return confirm('Delete this user? Their items and claims will also be removed.')">Delete</button></form><?php else: ?><span class="muted">Current admin</span><?php endif; ?>
</td></tr>
<?php endwhile; ?></table></div>
<?php include "footer.php"; ?>
