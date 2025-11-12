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

// Fetch user role and id
$user_query = "SELECT id, role FROM users WHERE username = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$stmt->close();

if (!$user || !in_array($user['role'], ['teacher', 'admin'])) {
    header("Location: unauthorized.php");
    exit();
}
$teacher_id = (int)$user['id'];

// Save teacher id in session for any other code that expects it
$_SESSION['teacher_id'] = $teacher_id;

// Handle progress submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $child_id = (int)($_POST['child_id'] ?? 0);
    $domain = trim($_POST['domain'] ?? '');
    $percentage = (int)($_POST['percentage'] ?? -1);
    $checklist = trim($_POST['checklist'] ?? '');
    $report_text = trim($_POST['report_text'] ?? '');

    if (empty($domain) || $percentage < 0 || $percentage > 100 || $child_id <= 0) {
        $message = '⚠️ Invalid input. Please check your entries.';
    } else {
        // Insert or update progress (ON DUPLICATE KEY requires UNIQUE key on child_id+domain or similar)
        $progress_query = "INSERT INTO eccd_progress (child_id, domain, progress_percentage, checklist_items)
                           VALUES (?, ?, ?, ?)
                           ON DUPLICATE KEY UPDATE 
                             progress_percentage = VALUES(progress_percentage),
                             checklist_items = VALUES(checklist_items)";
        $stmt = $conn->prepare($progress_query);
        $stmt->bind_param("isss", $child_id, $domain, $percentage, $checklist);
        $stmt->execute();
        $stmt->close();

        // Insert report if any
        if (!empty($report_text)) {
            $report_query = "INSERT INTO reports (child_id, teacher_id, report_text) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($report_query);
            $stmt->bind_param("iis", $child_id, $teacher_id, $report_text);
            $stmt->execute();
            $stmt->close();
        }

        $message = '✅ Progress updated successfully!';
    }
}

// Fetch children for this teacher only
$children = [];
$children_query = "SELECT id, name FROM children WHERE teacher_id = ? ORDER BY name ASC";
$stmt = $conn->prepare($children_query);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $children[] = $row;
}
$stmt->close();

// Determine selected child id (GET param takes precedence)
$selected_child_id = null;
if (isset($_GET['child_id']) && is_numeric($_GET['child_id'])) {
    $selected_child_id = (int)$_GET['child_id'];
} elseif (!empty($children)) {
    // default to first child in the teacher's list
    $selected_child_id = (int)$children[0]['id'];
}

// If selected_child_id is not in this teacher's children, unset it (security)
$child_ids = array_column($children, 'id');
if ($selected_child_id && !in_array($selected_child_id, $child_ids, true)) {
    $selected_child_id = null;
}

$progress = [];
$reports = [];
if ($selected_child_id) {
    // Fetch progress data for selected child
    $progress_query = "SELECT domain, progress_percentage, checklist_items FROM eccd_progress WHERE child_id = ?";
    $stmt = $conn->prepare($progress_query);
    $stmt->bind_param("i", $selected_child_id);
    $stmt->execute();
    $progress_result = $stmt->get_result();
    while ($row = $progress_result->fetch_assoc()) {
        $progress[] = $row;
    }
    $stmt->close();

    // Fetch reports (with teacher username)
    $reports_query = "SELECT r.report_text, r.created_at, u.username AS teacher
                      FROM reports r
                      JOIN users u ON r.teacher_id = u.id
                      WHERE r.child_id = ?
                      ORDER BY r.created_at DESC";
    $stmt = $conn->prepare($reports_query);
    $stmt->bind_param("i", $selected_child_id);
    $stmt->execute();
    $reports_result = $stmt->get_result();
    while ($row = $reports_result->fetch_assoc()) {
        $reports[] = $row;
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard - Student Progress</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css2/dashboard.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Poppins', sans-serif; }
        .sidebar { margin-top: 102px; overflow-y: auto; }
        .Home_container { margin-left: 250px; padding: 2rem; }
        form.card { background: white; padding: 1.2rem; border-radius: 10px; margin-bottom: 1.2rem; box-shadow: 0 2px 6px rgba(0,0,0,0.06); }
        label { font-weight: 600; display:block; margin-bottom:6px; color:#333; }
        select, input, textarea, button { width:100%; padding:0.6rem; margin-top:0.4rem; border:1px solid #d0d5dd; border-radius:8px; font-size:0.95rem; }
        button { background:#343bc9; color:#fff; border:none; font-weight:600; padding:10px; border-radius:8px; cursor:pointer; }
        button:hover { background:#2a2fb0; }
        .progress-container { display:flex; flex-wrap:wrap; gap:1rem; margin-top:1rem; }
        .domain-card { background:#fff; padding:1rem; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.06); width:320px; }
        .progress-bar { background:#e8eefc; height:22px; border-radius:12px; overflow:hidden; margin-bottom:8px; }
        .progress { background:#4CAF50; height:100%; color:#fff; text-align:center; line-height:22px; font-weight:600; }
        .placeholder { color:#666; text-align:center; padding:20px 0; }
        .report-card { background:#fff; padding:1rem; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.06); margin-top:12px; }
    </style>
</head>
<body>
    <div class="Topbar">
        <img class="Antipolo" src="pictures/ANTIPOLO.png">
        <h1 class="TopbarTitle1">GOLD:</h1>
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
        <p class="TopbarLineText">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
    </div>

    <?php include('includes/teacher_sidebar.php'); ?>

    <div class="Home_container">
        <div class="Home_content">
            <h2>Manage Student Progress</h2>
            <?php if ($message): ?>
                <p style="color:green;font-weight:bold;"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>

            <form method="GET" class="card">
                <label for="child_id">Select Student:</label>
                <select name="child_id" id="child_id" onchange="this.form.submit()">
                    <option value="">-- Select Student --</option>
                    <?php foreach ($children as $child): ?>
                        <option value="<?php echo (int)$child['id']; ?>" <?php echo ($selected_child_id === (int)$child['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($child['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if ($selected_child_id): ?>
                <?php
                $child_name = '';
                foreach ($children as $c) {
                    if ((int)$c['id'] === $selected_child_id) {
                        $child_name = $c['name'];
                        break;
                    }
                }
                ?>
                <h3>Update Progress for <?php echo htmlspecialchars($child_name ?: 'Student'); ?></h3>

                <form method="POST" class="card">
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
                        <textarea name="checklist" rows="3" placeholder="Enter items separated by commas"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Report / Notes:</label>
                        <textarea name="report_text" rows="3" placeholder="Add teacher notes..."></textarea>
                    </div>
                    <button type="submit">Save Progress</button>
                </form>

                <h3>Existing Progress</h3>
                <div class="progress-container">
                    <?php if (empty($progress)): ?>
                        <div class="placeholder">No progress data available yet.</div>
                    <?php else: ?>
                        <?php foreach ($progress as $p): ?>
                            <div class="domain-card">
                                <strong><?php echo htmlspecialchars($p['domain']); ?> (<?php echo (int)$p['progress_percentage']; ?>%)</strong>
                                <div class="progress-bar">
                                    <div class="progress" style="width: <?php echo (int)$p['progress_percentage']; ?>%;">
                                        <?php echo (int)$p['progress_percentage']; ?>%
                                    </div>
                                </div>
                                <ul class="checklist">
                                    <?php
                                    $items = array_filter(array_map('trim', explode(',', $p['checklist_items'])));
                                    foreach ($items as $item) {
                                        $parts = explode(':', $item);
                                        if (count($parts) >= 2) {
                                            $desc = $parts[0];
                                            $checked = $parts[1];
                                            $symbol = (trim($checked) === '1') ? '✓' : '✗';
                                            echo '<li>' . $symbol . ' ' . htmlspecialchars($desc) . '</li>';
                                        } else {
                                            // If no colon, just print the item
                                            echo '<li>' . htmlspecialchars($item) . '</li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <h3>Reports</h3>
                <?php if (empty($reports)): ?>
                    <div class="placeholder">No reports yet.</div>
                <?php else: ?>
                    <?php foreach ($reports as $r): ?>
                        <div class="report-card">
                            <p><strong><?php echo htmlspecialchars($r['teacher']); ?></strong> — <small><?php echo htmlspecialchars($r['created_at']); ?></small></p>
                            <p><?php echo nl2br(htmlspecialchars($r['report_text'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php else: ?>
                <p class="placeholder">No student selected or you have no students assigned.</p>
            <?php endif; ?>
        </div>
    </div>

    <img src="pictures/LOicon.png" alt="Logout" class="logout" onclick="confirmLogout()">

    <script>
    function confirmLogout() {
        if (confirm("Are you sure you want to log out?")) {
            window.location.href = "logout.php";
        }
    }
    </script>
</body>
</html>