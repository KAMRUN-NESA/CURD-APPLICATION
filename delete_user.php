<?php
include "function.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message']  = "Invalid request — no user ID provided.";
    $_SESSION['msg_type'] = "danger";
    header("Location: view_users.php"); exit();
}

$id   = intval($_GET['id']);
$user = getUserById($id);

if (!$user) {
    $_SESSION['message']  = "User not found.";
    $_SESSION['msg_type'] = "danger";
    header("Location: view_users.php"); exit();
}

if (deleteUser($id)) {
    $_SESSION['message']  = "✅ User <strong>" . htmlspecialchars($user['name']) . "</strong> deleted successfully.";
    $_SESSION['msg_type'] = "success";
} else {
    $_SESSION['message']  = "❌ Failed to delete user. Please try again.";
    $_SESSION['msg_type'] = "danger";
}

header("Location: view_users.php"); exit();
?>
