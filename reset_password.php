<?php
// 1. Connect to database
$conn = new mysqli("localhost", "root", "", "myfirstdatabase");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Define the username and new password
$username = "Admin1"; // Change this to the actual username
$newPassword = "123"; // The new password you want to set

// 3. Hash the new password
$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

// 4. Update in the database
$stmt = $conn->prepare("UPDATE users SET pwd = ? WHERE username = ?");
$stmt->bind_param("ss", $hashedPassword, $username);

if ($stmt->execute()) {
    echo "Password reset successfully for user: $username";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>