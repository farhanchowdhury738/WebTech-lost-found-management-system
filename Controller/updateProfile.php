
// test for push live branch is it push or not

<?php

session_start();

if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: ../View/profile.php");
    exit();
}

include "../Model/DatabaseConnection.php";

$db = new DatabaseConnection();
$con = $db->openConnection();

$id = $_SESSION["loggedInUserId"];

$name = $_POST["name"] ?? "";

$hasError = false;


if ($name == "") {

    $_SESSION["profileNameError"] = "Name is required";

    $hasError = true;

}


if ($hasError) {

    header("Location: ../View/profile.php");
    exit();

}


$result = $db->updateProfile($con, $id, $name);


if ($result) {

    $_SESSION["profileMessage"] = "Name updated successfully";

} else {

    $_SESSION["profileError"] = "Name update failed";

}


header("Location: ../View/profile.php");
exit();

?>