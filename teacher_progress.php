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
$user_query = "SELECT id, role FROM users WHERE username = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
if (!$user || !in_array($user['role'], ['teacher', 'admin'])) {
    header("Location: unauthorized.php");
    exit();
}
$teacher_id = $user['id'];

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $child_id = (int)$_POST['child_id'];
    $domain = trim($_POST['domain']);
    $percentage = (int)$_POST['percentage'];
    $checklist = trim($_POST['checklist']);  // e.g., "Item1:1, Item2:0"
    $report_text = trim($_POST['report_text']);

    if (empty($domain) || $percentage < 0 || $percentage > 100) {
        $message = 'Invalid input.';
    } else {
        // Insert or update progress
        $progress_query = "INSERT INTO eccd_progress (child_id, domain, progress_percentage, checklist_items) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE progress_percentage = VALUES(progress_percentage), checklist_items = VALUES(checklist_items)";
        $stmt = $conn->prepare($progress_query);
        $stmt->bind_param("isss", $child_id, $domain, $percentage, $checklist);
        $stmt->execute();

        // Add report if provided
        if (!empty($report_text)) {
            $report_query = "INSERT INTO reports (child_id, teacher_id, report_text) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($report_query);
            $stmt->bind_param("iis", $child_id, $teacher_id, $report_text);
            $stmt->execute();
        }
        $message = 'Progress updated successfully!';
    }
}

// Fetch all children
$children_query = "SELECT id, name FROM children";
$children_result = $conn->query($children_query);
$children = [];
while ($row = $children_result->fetch_assoc()) {
    $children[] = $row;
}

// Fetch progress and reports for selected child
$selected_child_id = $_GET['child_id'] ?? ($children[0]['id'] ?? null);
$progress = [];
$reports = [];
if ($selected_child_id) {
    $progress_query = "SELECT * FROM eccd_progress WHERE child_id = ?";
    $stmt = $conn->prepare($progress_query);
    $stmt->bind_param("i", $selected_child_id);
    $stmt->execute();
    $progress_result = $stmt->get_result();
    while ($row = $progress_result->fetch_assoc()) {
        $progress[] = $row;
    }

    $reports_query = "SELECT r.report_text, r.created_at, u.username AS teacher FROM reports r JOIN users u ON r.teacher_id = u.id WHERE r.child_id = ? ORDER BY r.created_at DESC";
    $stmt = $conn->prepare($reports_query);
    $stmt->bind_param("i", $selected_child_id);
    $stmt->execute();
    $reports_result = $stmt->get_result();
    while ($row = $reports_result->fetch_assoc()) {
        $reports[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Student Progress - Teacher</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css2/dashboard.css">
    <style>
        .form-group { margin-bottom: 1rem; }
        .progress-container { display: flex; flex-wrap: wrap; gap: 1rem; }
        .domain-card { background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); flex: 1 1 45%; min-width: 300px; }

        .Home_container {
            margin-left: 240px;
        }
        .sidebar {
            margin-top: 102px;
            overflow-y: scroll;
        }
    </style>
</head>
<body>
    <!-- Reuse your topbar and sidebar from other pages -->
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
    <div class="sidebar">
        <h2>Teacher Panel</h2>
        <a href="teacherdashboard1.php">Dashboard</a>
        <a href="announcements_feed2.php">View Announcements</a>
        <a href="calendar2.php">Calendar</a>
        <a href="upload_materials2.php">Upload Learning Materials</a>
        <a href="view_materials2.php">View Learning Materials</a>
        <a href="teacher_progress.php">Student Progress</a>
        <a href="enroll_child.php">Enroll new KID</a>
        <a href="my_account2.php">My Account</a>
        <a href="#">Class Management</a>
        <a href="#">Assignment and Quizzes</a>
        <a href="#">Communication</a>
        <a href="#">Reports</a> 
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
    </div>

    <div class="Home_container">
        <div class="Home_content">
            <h2>Manage Student Progress</h2>
            <?php if ($message): ?><p style="color: green;"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>

            <form method="GET">
                <label for="child_id">Select Child:</label>
                <select name="child_id" id="child_id" onchange="this.form.submit()">
                    <?php foreach ($children as $child): ?>
                        <option value="<?php echo $child['id']; ?>" <?php echo ($child['id'] == $selected_child_id) ? 'selected' : ''; ?>><?php echo htmlspecialchars($child['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if ($selected_child_id): ?>
                <h3>Update Progress for <?php echo htmlspecialchars($children[array_search($selected_child_id, array_column($children, 'id'))]['name']); ?></h3>
                <form method="POST">
                    <input type="hidden" name="child_id" value="<?php echo $selected_child_id; ?>">
                    <div class="form-group">
                        <label>Domain (e.g., Gross Motor):</label>
                        <input type="text" name="domain" required>
                    </div>
                    <div class="form-group">
                        <label>Progress Percentage (0-100):</label>
                        <input type="number" name="percentage" min="0" max="100" required>
                    </div>
                    <div class="form-group">
                        <label>Checklist Items (e.g., Can walk steadily:1, Climbs stairs:0):</label>
                        <textarea name="checklist" rows="4" placeholder="Enter items separated by commas"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Report/Notes:</label>
                        <textarea name="report_text" rows="4" placeholder="Add teacher notes..."></textarea>
                    </div>
                    <button type="submit">Update Progress</button>
                </form>

                <h3>Existing Progress</h3>
                <div class="progress-container">
                    <?php foreach ($progress as $p): ?>
                        <div class="domain-card">
                            <h4><?php echo htmlspecialchars($p['domain']); ?> - <?php echo $p['progress_percentage']; ?>%</h4>
                            <ul>
                                <?php 
                                $items = explode(',', $p['checklist_items']);
                                foreach ($items as $item) {
                                    if (trim($item)) {
                                        list($desc, $checked) = explode(':', trim($item));
                                        $symbol = $checked == '1' ? '✓' : '✗';
                                        echo "<li>$symbol " . htmlspecialchars($desc) . "</li>";
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>

                <h3>Reports</h3>
                <?php foreach ($reports as $r): ?>
                    <div class="domain-card">
                        <p><strong><?php echo htmlspecialchars($r['teacher']); ?> (<?php echo $r['created_at']; ?>):</strong></p>
                        <p><?php echo htmlspecialchars($r['report_text']); ?></p>
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