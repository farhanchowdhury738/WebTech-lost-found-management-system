<?php
class DatabaseConnection
{
    function openConnection()
    {
        $db_host = "localhost";
        $db_user = "root";
        $db_password = ""; // XAMPP default. Change if your MySQL has a password.
        $db_name = "khoja_khuji";

        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);
        if ($connection->connect_error) {
            die("Can not connect to the database, please try again. " . $connection->connect_error);
        }
        $connection->set_charset("utf8mb4");
        return $connection;
    }

    function signup($connection, $name, $email, $password, $phone, $role = "user")
    {
        $name = $connection->real_escape_string($name);
        $email = $connection->real_escape_string($email);
        $password = $connection->real_escape_string($password);
        $phone = $connection->real_escape_string($phone);
        $role = $connection->real_escape_string($role);

        $sql = "INSERT INTO users (name, email, password_hash, phone, role) VALUES ('" . $name . "', '" . $email . "', '" . $password . "', '" . $phone . "', '" . $role . "')";
        return $connection->query($sql);
    }

    function signin($connection, $email, $password)
    {
        $email = $connection->real_escape_string($email);
        $password = $connection->real_escape_string($password);
        $sql = "SELECT * FROM users WHERE email='" . $email . "' AND password_hash='" . $password . "' AND status='active'";
        return $connection->query($sql);
    }

    function emailExists($connection, $email)
    {
        $email = $connection->real_escape_string($email);
        $sql = "SELECT id FROM users WHERE email='" . $email . "'";
        $result = $connection->query($sql);
        return $result && $result->num_rows > 0;
    }

    function getCategories($connection)
    {
        return $connection->query("SELECT * FROM categories ORDER BY name ASC");
    }

    function addCategory($connection, $name, $description)
    {
        $name = $connection->real_escape_string($name);
        $description = $connection->real_escape_string($description);
        return $connection->query("INSERT INTO categories (name, description) VALUES ('" . $name . "', '" . $description . "')");
    }

    function updateCategory($connection, $id, $name, $description)
    {
        $id = (int)$id;
        $name = $connection->real_escape_string($name);
        $description = $connection->real_escape_string($description);
        return $connection->query("UPDATE categories SET name='" . $name . "', description='" . $description . "' WHERE id=" . $id);
    }

    function deleteCategory($connection, $id)
    {
        $id = (int)$id;
        return $connection->query("DELETE FROM categories WHERE id=" . $id);
    }

    function addItem($connection, $user_id, $category_id, $title, $description, $type, $location, $date_lost_found, $image_path, $contact_info)
    {
        $user_id = (int)$user_id;
        $category_id = (int)$category_id;
        $title = $connection->real_escape_string($title);
        $description = $connection->real_escape_string($description);
        $type = $connection->real_escape_string($type);
        $location = $connection->real_escape_string($location);
        $date_lost_found = $connection->real_escape_string($date_lost_found);
        $image_path = $connection->real_escape_string($image_path);
        $contact_info = $connection->real_escape_string($contact_info);

        $sql = "INSERT INTO items (user_id, category_id, title, description, type, location, date_lost_found, image_path, contact_info, status) VALUES (" . $user_id . ", " . $category_id . ", '" . $title . "', '" . $description . "', '" . $type . "', '" . $location . "', '" . $date_lost_found . "', '" . $image_path . "', '" . $contact_info . "', 'Open')";
        return $connection->query($sql);
    }

    function getItems($connection, $type = "", $search = "", $category_id = "")
    {
        $conditions = [];
        if ($type !== "") {
            $type = $connection->real_escape_string($type);
            $conditions[] = "i.type='" . $type . "'";
        }
        if ($search !== "") {
            $search = $connection->real_escape_string($search);
            $conditions[] = "(i.title LIKE '%" . $search . "%' OR i.description LIKE '%" . $search . "%' OR i.location LIKE '%" . $search . "%')";
        }
        if ($category_id !== "") {
            $category_id = (int)$category_id;
            $conditions[] = "i.category_id=" . $category_id;
        }

        $where = count($conditions) > 0 ? " WHERE " . implode(" AND ", $conditions) : "";
        $sql = "SELECT i.*, c.name AS category_name, u.name AS reporter_name, u.email AS reporter_email, u.phone AS reporter_phone FROM items i INNER JOIN categories c ON i.category_id=c.id INNER JOIN users u ON i.user_id=u.id" . $where . " ORDER BY i.created_at DESC";
        return $connection->query($sql);
    }

    function getItemById($connection, $id)
    {
        $id = (int)$id;
        $sql = "SELECT i.*, c.name AS category_name, u.name AS reporter_name, u.email AS reporter_email, u.phone AS reporter_phone FROM items i INNER JOIN categories c ON i.category_id=c.id INNER JOIN users u ON i.user_id=u.id WHERE i.id=" . $id;
        $result = $connection->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    function getUserItems($connection, $user_id)
    {
        $user_id = (int)$user_id;
        return $connection->query("SELECT i.*, c.name AS category_name FROM items i INNER JOIN categories c ON i.category_id=c.id WHERE i.user_id=" . $user_id . " ORDER BY i.created_at DESC");
    }


    function updateItem($connection, $id, $category_id, $title, $description, $type, $location, $date_lost_found, $image_path, $contact_info, $status)
    {
        $id = (int)$id;
        $category_id = (int)$category_id;
        $title = $connection->real_escape_string($title);
        $description = $connection->real_escape_string($description);
        $type = $connection->real_escape_string($type);
        $location = $connection->real_escape_string($location);
        $date_lost_found = $connection->real_escape_string($date_lost_found);
        $image_path = $connection->real_escape_string($image_path);
        $contact_info = $connection->real_escape_string($contact_info);
        $status = $connection->real_escape_string($status);

        $sql = "UPDATE items SET category_id=" . $category_id . ", title='" . $title . "', description='" . $description . "', type='" . $type . "', location='" . $location . "', date_lost_found='" . $date_lost_found . "', image_path='" . $image_path . "', contact_info='" . $contact_info . "', status='" . $status . "' WHERE id=" . $id;
        return $connection->query($sql);
    }

    function deleteItem($connection, $id)
    {
        $id = (int)$id;
        return $connection->query("DELETE FROM items WHERE id=" . $id);
    }

    function updateItemStatus($connection, $item_id, $status)
    {
        $item_id = (int)$item_id;
        $status = $connection->real_escape_string($status);
        return $connection->query("UPDATE items SET status='" . $status . "' WHERE id=" . $item_id);
    }

    function addClaim($connection, $item_id, $user_id, $name, $email, $phone, $description, $proof_path, $additional_info)
    {
        $item_id = (int)$item_id;
        $user_id = (int)$user_id;
        $name = $connection->real_escape_string($name);
        $email = $connection->real_escape_string($email);
        $phone = $connection->real_escape_string($phone);
        $description = $connection->real_escape_string($description);
        $proof_path = $connection->real_escape_string($proof_path);
        $additional_info = $connection->real_escape_string($additional_info);

        $sql = "INSERT INTO claims (item_id, user_id, claimant_name, claimant_email, claimant_phone, description, proof_path, additional_info, status) VALUES (" . $item_id . ", " . $user_id . ", '" . $name . "', '" . $email . "', '" . $phone . "', '" . $description . "', '" . $proof_path . "', '" . $additional_info . "', 'Pending')";
        return $connection->query($sql);
    }

    function getUserClaims($connection, $user_id)
    {
        $user_id = (int)$user_id;
        return $connection->query("SELECT cl.*, i.title AS item_title, i.type AS item_type FROM claims cl INNER JOIN items i ON cl.item_id=i.id WHERE cl.user_id=" . $user_id . " ORDER BY cl.created_at DESC");
    }

    function getClaims($connection)
    {
        return $connection->query("SELECT cl.*, i.title AS item_title, u.name AS user_name, u.email AS user_email FROM claims cl INNER JOIN items i ON cl.item_id=i.id INNER JOIN users u ON cl.user_id=u.id ORDER BY cl.created_at DESC");
    }

    function updateClaimStatus($connection, $claim_id, $status)
    {
        $claim_id = (int)$claim_id;
        $status = $connection->real_escape_string($status);
        return $connection->query("UPDATE claims SET status='" . $status . "', returned_at=" . ($status === "Returned" ? "NOW()" : "NULL") . " WHERE id=" . $claim_id);
    }

    function updateProfile($connection, $id, $name, $email, $phone, $photo_path = "")
    {
        $id = (int)$id;
        $name = $connection->real_escape_string($name);
        $email = $connection->real_escape_string($email);
        $phone = $connection->real_escape_string($phone);
        $sql = "UPDATE users SET name='" . $name . "', email='" . $email . "', phone='" . $phone . "'";
        if ($photo_path !== "") {
            $photo_path = $connection->real_escape_string($photo_path);
            $sql .= ", profile_photo='" . $photo_path . "'";
        }
        $sql .= " WHERE id=" . $id;
        return $connection->query($sql);
    }

    function changePassword($connection, $id, $password)
    {
        $id = (int)$id;
        $password = $connection->real_escape_string($password);
        return $connection->query("UPDATE users SET password_hash='" . $password . "' WHERE id=" . $id);
    }

    function getUserById($connection, $id)
    {
        $id = (int)$id;
        $result = $connection->query("SELECT * FROM users WHERE id=" . $id);
        return $result ? $result->fetch_assoc() : null;
    }

    function getUsers($connection)
    {
        return $connection->query("SELECT id, name, email, phone, role, status, created_at FROM users ORDER BY created_at DESC");
    }


    function addUser($connection, $name, $email, $password, $phone, $role = "user", $status = "active")
    {
        $name = $connection->real_escape_string($name);
        $email = $connection->real_escape_string($email);
        $password = $connection->real_escape_string($password);
        $phone = $connection->real_escape_string($phone);
        $role = $connection->real_escape_string($role);
        $status = $connection->real_escape_string($status);
        return $connection->query("INSERT INTO users (name, email, password_hash, phone, role, status) VALUES ('" . $name . "', '" . $email . "', '" . $password . "', '" . $phone . "', '" . $role . "', '" . $status . "')");
    }

    function updateUser($connection, $id, $name, $email, $phone, $role, $status)
    {
        $id = (int)$id;
        $name = $connection->real_escape_string($name);
        $email = $connection->real_escape_string($email);
        $phone = $connection->real_escape_string($phone);
        $role = $connection->real_escape_string($role);
        $status = $connection->real_escape_string($status);
        return $connection->query("UPDATE users SET name='" . $name . "', email='" . $email . "', phone='" . $phone . "', role='" . $role . "', status='" . $status . "' WHERE id=" . $id);
    }

    function deleteUser($connection, $id)
    {
        $id = (int)$id;
        return $connection->query("DELETE FROM users WHERE id=" . $id);
    }

    function updateUserStatus($connection, $id, $status)
    {
        $id = (int)$id;
        $status = $connection->real_escape_string($status);
        return $connection->query("UPDATE users SET status='" . $status . "' WHERE id=" . $id);
    }
}
?>
