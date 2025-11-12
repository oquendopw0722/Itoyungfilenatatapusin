<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "myfirstdatabase");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Role check
$query = "SELECT id, role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user || !in_array($user['role'], ['teacher', 'admin'])) {
    header("Location: unauthorized.php");
    exit();
}
$uploaded_by = $user['id'];

// Handle upload
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $file = $_FILES['file'];

    // Validate
    $allowed_types = ['pdf' => 'application/pdf', 'mp4' => 'video/mp4', 'avi' => 'video/x-msvideo'];
    $file_type = array_search($file['type'], $allowed_types);
    if (!$file_type || $file['size'] > 100 * 1024 * 1024) {  // 100MB limit
        $message = 'Invalid file type or size.';
    } elseif (empty($title)) {
        $message = 'Title is required.';
    } else {
        // Save file
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        $file_path = $upload_dir . uniqid() . '_' . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            // Save to DB
            $stmt = $conn->prepare("INSERT INTO learning_materials (title, description, file_path, file_type, uploaded_by) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $title, $description, $file_path, $file_type, $uploaded_by);
            $stmt->execute();
            $message = 'Material uploaded successfully!';
        } else {
            $message = 'Upload failed.';
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Upload Learning Materials</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css2/dashboard.css">
    <style>
        .Home_container {
            margin-left: 240px;
        }

        .sidebar {
            margin-top: 102px;
            margin-bottom: 100px;
            overflow-y: scroll
        }
    </style>
</head>

<body>
    <div class="Topbar">
        <img class="Antipolo" src="pictures/ANTIPOLO.png">
        <h1 class="TopbarTitle1">GOLD: &nbsp; </h1>
        <h1 class="TopbarTitle2"> DXXXX daycare center</h1>
        <nav class="navbar">
            <ul>
                <li><a href="home1.php">Home</a></li>
                <li><a href="dashboard3.php">Dashboard</a></li>
                <li><a href="extra.php">Old Website</a></li>
            </ul>
        </nav>
        <a href="learning.html" class="cta-btn">Learn</a>
    </div>
    <div class="Topbarline">
        <p class="TopbarLineText">Welcome, <?php echo $_SESSION['username']; ?></p>
    </div>

    <!-- Sidebar -->
    <?php include('includes/teacher_sidebar.php'); ?>

    <div class="Home_container">
        <div class="Home_content">
            <h2>Upload Learning Materials</h2>
            <?php if ($message): ?><p><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <label>Title:</label><input type="text" name="title" required><br>
                <label>Description:</label><textarea name="description"></textarea><br>
                <label>File (PDF or Video):</label><input type="file" name="file" accept=".pdf,.mp4,.avi" required><br>
                <button type="submit">Upload</button>
            </form>
        </div>
    </div>

    <img src="pictures/LOicon.png" alt="Logout" class="logout" onclick="confirmLogout()">
    <script>
        function confirmLogout() {
            const confirmAction = confirm("Are you sure you want to log out?");
            if (confirmAction) {
                window.location.href = "logout.php";
            }
        }
    </script>
</body>

</html>