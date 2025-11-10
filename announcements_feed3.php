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

// Role check (allow parent, teacher, admin)
$query = "SELECT role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$allowed_roles = ['parent', 'teacher', 'admin'];  // Updated: Include admin
if (!$user || !in_array($user['role'], $allowed_roles)) {
    header("Location: unauthorized.php");
    exit();
}

// Fetch announcements
$query = "SELECT a.title, a.content, a.posted_at, u.username AS posted_by FROM announcements a JOIN users u ON a.posted_by = u.id ORDER BY a.posted_at DESC";
$result = $conn->query($query);
$announcements = [];
while ($row = $result->fetch_assoc()) {
    $announcements[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Announcements Feed</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css2/dashboard.css">
    <style>
        .announcement { border: 1px solid #ddd; padding: 1rem; margin-bottom: 1rem; }

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
    <!-- Reuse your topbar and sidebar -->
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
			<p class = "TopbarLineText">Welcome, <?php echo $_SESSION['username']; ?></p>
		</div>

  <!-- Sidebar -->
    <div class="sidebar">
        <h2>Parent Panel</h2>
        <a href="parentdashboard1.php">Dashboard</a>
        <a href="announcements_feed3.php">View Announcements</a>
        <a href="calendar3.php">Calendar</a>
        <a href="student_progress.php">Student Progress</a>
        <a href="view_materials3.php">View Learning Materials</a>
        <a href="my_account3.php">My Account</a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
    </div>

    <div class="Home_container">
        <div class="Home_content">
            <h2>Announcements</h2>
            <?php if (empty($announcements)): ?>
                <p>No announcements yet.</p>
            <?php else: ?>
                <?php foreach ($announcements as $ann): ?>
                    <div class="announcement">
                        <h3><?php echo htmlspecialchars($ann['title']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($ann['content'])); ?></p>
                        <small>Posted by <?php echo htmlspecialchars($ann['posted_by']); ?> on <?php echo $ann['posted_at']; ?></small>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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