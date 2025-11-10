<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myfirstdatabase";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user role
$query = "SELECT role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$role = $user['role'] ?? null;

$conn->close();

// Redirect based on role
if ($role === 'parent') {
    header("Location: parentdashboard1.php");
    exit();
} elseif ($role === 'teacher') {
    header("Location: teacherdashboard1.php");
    exit();
} elseif ($role === 'admin') {
    header("Location: admindashboard1.php");
    exit();
} else {
    // Invalid or missing role
    header("Location: unauthorized.php");  // Create this page with an error message like "Invalid role. Contact admin."
    exit();
}
?>