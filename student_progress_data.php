<?php
require_once 'config.php';

if (!isset($_GET['child_id'])) {
    echo json_encode([]);
    exit();
}

$child_id = intval($_GET['child_id']);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myfirstdatabase";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode([]));
}

$query = "SELECT domain, progress_percentage, checklist_items 
          FROM eccd_progress WHERE child_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $child_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$stmt->close();
$conn->close();
