<?php
include "env.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Add a new user to the database (including Summernote rich-text description)
 */
function addUser($name, $email, $password, $description = '') {
    global $conn;
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $description = mysqli_real_escape_string($conn, $description);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO loginn (name, email, password, description) VALUES ('$name', '$email', '$hashed_password', '$description')";
    return mysqli_query($conn, $query);
}

/**
 * Get all users from the database
 */
function getUsers() {
    global $conn;
    $query = "SELECT * FROM loginn ORDER BY Id DESC";
    $result = mysqli_query($conn, $query);
    $users = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    return $users;
}

/**
 * Get a user by ID
 */
function getUserById($id) {
    global $conn;
    $id = intval($id);
    $query = "SELECT * FROM loginn WHERE Id = $id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

/**
 * Update user details
 */
function updateUser($id, $name, $email, $password = null, $description = '') {
    global $conn;
    $id = intval($id);
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $description = mysqli_real_escape_string($conn, $description);
    
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE loginn SET name = '$name', email = '$email', password = '$hashed_password', description = '$description' WHERE Id = $id";
    } else {
        $query = "UPDATE loginn SET name = '$name', email = '$email', description = '$description' WHERE Id = $id";
    }
    
    return mysqli_query($conn, $query);
}

/**
 * Delete a user
 */
function deleteUser($id) {
    global $conn;
    $id = intval($id);
    $query = "DELETE FROM loginn WHERE Id = $id";
    return mysqli_query($conn, $query);
}

/**
 * Check if email already exists (except for current user)
 */
function emailExists($email, $exclude_id = null) {
    global $conn;
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM loginn WHERE email = '$email'";
    if ($exclude_id !== null) {
        $exclude_id = intval($exclude_id);
        $query .= " AND Id != $exclude_id";
    }
    $result = mysqli_query($conn, $query);
    return ($result && mysqli_num_rows($result) > 0);
}
?>
