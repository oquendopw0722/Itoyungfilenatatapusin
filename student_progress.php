<?php
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection (reuse from config.php or add here if needed)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myfirstdatabase";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assume child_id is tied to the logged-in parent (e.g., via session or a query)
// For now, hardcode or fetch based on parent_id. Replace with real logic.
$parent_username = $_SESSION['username'];
// Example: Fetch child_id for this parent (assuming a parents table exists)
//$child_query = "SELECT c.id, c.name FROM children c JOIN parents p ON c.parent_id = p.id WHERE p.username = ?";
$child_query = "SELECT c.id, c.name FROM children c JOIN users u ON c.parent_id = u.id WHERE u.username = ?";
$stmt = $conn->prepare($child_query);
$stmt->bind_param("s", $parent_username);
$stmt->execute();
$child_result = $stmt->get_result();
$child = $child_result->fetch_assoc();
$child_id = $child['id'] ?? 1;  // Fallback to 1 if no child found
$child_name = $child['name'] ?? 'Unknown Child';

// Fetch progress data
$progress_query = "SELECT domain, progress_percentage, checklist_items FROM eccd_progress WHERE child_id = ?";
$stmt = $conn->prepare($progress_query);
$stmt->bind_param("i", $child_id);
$stmt->execute();
$progress_result = $stmt->get_result();
$domains = [];
while ($row = $progress_result->fetch_assoc()) {
    $domains[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Progress - Dashboard</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css2/dashboard.css">
    <style>
        .sidebar {
            margin-top: 102px;
            overflow-y: scroll;
        }
        .Home_container {
            margin-left: 240px;
        }
        /* Add styles for progress elements */
        .progress-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .domain-card {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            flex: 1 1 45%;
            min-width: 300px;
        }
        .progress-bar {
            background-color: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            height: 20px;
            margin-bottom: 1rem;
        }
        .progress {
            background-color: #4CAF50;
            height: 100%;
            text-align: center;
            color: white;
            line-height: 20px;
            transition: width 0.3s;
        }
        .checklist {
            list-style: none;
            padding: 0;
        }
        .checklist li {
            padding: 0.5rem 0;
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
            <p class="Text_title"><b>Student Progress for <?php echo htmlspecialchars($child_name); ?></b></p>
            <div class="progress-container">
                <?php if (empty($domains)): ?>
                    <p>No progress data available yet.</p>
                <?php else: ?>
                    <?php foreach ($domains as $domain): ?>
                        <div class="domain-card">
                            <h3><?php echo htmlspecialchars($domain['domain']); ?></h3>
                            <div class="progress-bar">
                                <div class="progress" style="width: <?php echo $domain['progress_percentage']; ?>%;"><?php echo $domain['progress_percentage']; ?>%</div>
                            </div>
                            <ul class="checklist">
                                <?php 
                                $items = explode(',', $domain['checklist_items']);
                                foreach ($items as $item) {
                                    list($desc, $checked) = explode(':', trim($item));
                                    $symbol = $checked == '1' ? '✓' : '✗';
                                    echo "<li>$symbol " . htmlspecialchars($desc) . "</li>";
                                }
                                ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <!-- Optionally keep or remove Home_content2 if not needed -->
        <div class="Home_content2">
            <p class="Text_title2"><b>Additional Notes</b></p>
            <div class="Report_Container">
                <p>Teacher notes or updates can go here.</p>
            </div>
            <div class="MessageContainer">
                <p class="Text_Report">Messages: 0</p>
            </div>
        </div>
    </div>

    <img 
        src="pictures/LOicon.png" 
        alt="Logout" 
        class="logout" 
        onclick="confirmLogout()"
    >

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