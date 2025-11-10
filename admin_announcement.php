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
if (!$user || $user['role'] !== 'admin') {
    header("Location: unauthorized.php");
    exit();
}
$posted_by = $user['id'];

// Handle post
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    if (empty($title) || empty($content)) {
        $message = 'Title and content are required.';
    } else {
        $stmt = $conn->prepare("INSERT INTO announcements (title, content, posted_by) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $content, $posted_by);
        $stmt->execute();
        $message = 'Announcement posted successfully!';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Announcements - Admin</title>
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
    <!-- Topbar and sidebar -->
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


    <div class="sidebar">
      <h2>Admin Panel</h2>
      <a href="admindashboard1.php">Dashboard</a>
      <a href="admin_announcement.php">Post Announcement</a>
      <a href="announcements_feed1.php">View Announcements</a>
      <a href="calendar1.php">Calendar</a>
      <a href="phplessons/signup1.php">Create Account</a>
      <a href="upload_materials1.php">Upload Learning Materials</a>
      <a href="view_materials1.php">View Learning Materials</a>
      <a href="admin_deactivate.php">Account Deactivation</a>
      <a href="archived_accounts.php">Archived Accounts</a>
      <a href="my_account1.php">My Account</a>
      <a href="#"></a>
      <a href="#"></a>
      <a href="#"></a>
      <a href="#"></a>
      <a href="#"></a>
      <a href="#"></a>
    </div>



    <div class="Home_container">
        <div class="Home_content">
            <h2>Post Announcement</h2>
            <?php if ($message): ?><p><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
            <form method="POST">
                <label>Title:</label><input type="text" name="title" required><br>
                <label>Content:</label><textarea name="content" rows="5" required></textarea><br>
                <button type="submit">Post</button>
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