<?php
session_start();
//Nayem: Admin Dashboard
include "../Controller/helpers.php";
requireAdmin();

include "header.php";
?>

<fieldset>
    <legend>Admin Dashboard</legend>

    <table align="center">
        <tr>
            <td>
                <a href="adminUsers.php">
                    <button type="button" class="admin-button">Manage Users</button>
                </a>
            </td>

            <td>
                <a href="adminItems.php">
                    <button type="button" class="admin-button">Manage Items</button>
                </a>
            </td>

            <td>
                <a href="adminCategories.php">
                    <button type="button" class="admin-button">Manage Categories</button>
                </a>
            </td>

            <td>
                <a href="adminClaims.php">
                    <button type="button" class="admin-button">Manage Claims</button>
                </a>
            </td>
        </tr>
    </table>

</fieldset>

<?php include "footer.php"; ?>