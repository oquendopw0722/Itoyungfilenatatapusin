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
$user_role = $user['role'] ?? null;

if ($user_role !== 'admin') {
    header("Location: unauthorized.php");
    exit();
}

// Handle deactivation
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deactivate'])) {
    $user_ids = $_POST['deactivate'];  // Array of user IDs
    if (!empty($user_ids)) {
        $placeholders = str_repeat('?,', count($user_ids) - 1) . '?';
        $update_query = "UPDATE users SET status = 'inactive' WHERE id IN ($placeholders)";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param(str_repeat('i', count($user_ids)), ...$user_ids);
        $stmt->execute();
        $message = 'Selected accounts deactivated successfully.';
    } else {
        $message = 'No accounts selected.';
    }
}

// Fetch parents and teachers
//$users_query = "SELECT id, username, role, status FROM users WHERE role IN ('parent', 'teacher') ORDER BY role, username";
$users_query = "SELECT id, username, role, status FROM users WHERE role IN ('parent', 'teacher') AND status = 'active' ORDER BY role, username";
$users_result = $conn->query($users_query);
$users = [];
while ($row = $users_result->fetch_assoc()) {
    $users[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Deactivate Accounts - Admin</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css2/dashboard.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.5rem; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        .inactive { color: red; }

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
        <p class="TopbarLineText">Welcome, <?php echo $_SESSION['username']; ?></p>
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
            <h2>Deactivate Parent and Teacher Accounts</h2>
            <?php if ($message): ?><p style="color: green;"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>

            <form method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <?php if ($user['status'] === 'active'): ?>
                                        <input type="checkbox" name="deactivate[]" value="<?php echo $user['id']; ?>">
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['role']); ?></td>
                                <td class="<?php echo $user['status'] === 'inactive' ? 'inactive' : ''; ?>"><?php echo htmlspecialchars($user['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" style="margin-top: 1rem;">Deactivate Selected</button>
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