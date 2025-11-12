<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myfirstdatabase";
$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_GET['id'])) {
    $child_id = intval($_GET['id']);
    $query = "DELETE FROM children WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $child_id);
    $stmt->execute();
}

$conn->close();
header("Location: class_management.php");
exit();
