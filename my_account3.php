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

// Fetch user data
$query = "SELECT pwd FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user) {
    header("Location: unauthorized.php");
    exit();
}
$current_hash = $user['pwd'];

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_pwd = $_POST['current_pwd'];
    $new_pwd = $_POST['new_pwd'];
    $confirm_pwd = $_POST['confirm_pwd'];

    if (!password_verify($current_pwd, $current_hash)) {
        $message = 'Current password is incorrect.';
    } elseif ($new_pwd !== $confirm_pwd) {
        $message = 'New passwords do not match.';
    } elseif (strlen($new_pwd) < 8) {
        $message = 'New password must be at least 8 characters long.';
    } else {
        // Hash new password and update
        $new_hash = password_hash($new_pwd, PASSWORD_BCRYPT, ['cost' => 12]);
        $update_query = "UPDATE users SET pwd = ? WHERE username = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ss", $new_hash, $_SESSION['username']);
        $stmt->execute();
        $message = 'Password changed successfully!';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Account</title>
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
            <h2>Change Password</h2>
            <?php if ($message): ?><p style="color: <?php echo strpos($message, 'success') !== false ? 'green' : 'red'; ?>;"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
            <form method="POST">
                <label>Current Password:</label>
                <input type="password" name="current_pwd" required><br>
                <label>New Password (min 8 chars):</label>
                <input type="password" name="new_pwd" required><br>
                <label>Confirm New Password:</label>
                <input type="password" name="confirm_pwd" required><br>
                <button type="submit">Change Password</button>
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