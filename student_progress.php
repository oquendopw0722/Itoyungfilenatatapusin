<?php
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myfirstdatabase";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all children for this parent
$parent_username = $_SESSION['username'];
$child_query = "SELECT c.id, c.name 
                FROM children c 
                JOIN users u ON c.parent_id = u.id 
                WHERE u.username = ?";
$stmt = $conn->prepare($child_query);
$stmt->bind_param("s", $parent_username);
$stmt->execute();
$child_result = $stmt->get_result();
$children = $child_result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Progress - Parent Dashboard</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css2/dashboard.css">
    <link rel="stylesheet" href="css2/student_progress.css">
</head>
<body>
    <!-- Topbar -->
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
    <?php include('includes/parent_sidebar.php'); ?>

    <div class="Home_container">
        <div class="Home_content">
            <h2>Student Progress Overview</h2>

            <!-- Dropdown for selecting child -->
            <div class="child-select">
                <label for="childDropdown">Select Student:</label>
                <select id="childDropdown">
                    <option value="">-- Choose Student --</option>
                    <?php foreach ($children as $child): ?>
                        <option value="<?php echo $child['id']; ?>">
                            <?php echo htmlspecialchars($child['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Dynamic progress data container -->
            <div id="progressContainer" class="progress-container">
                <p class="placeholder-text">Select a student to view their progress.</p>
            </div>
        </div>
    </div>

    <img src="pictures/LOicon.png" alt="Logout" class="logout" onclick="confirmLogout()">

    <script>
        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "logout.php";
            }
        }

        // Fetch student progress dynamically
        document.getElementById('childDropdown').addEventListener('change', function () {
            const childId = this.value;
            const container = document.getElementById('progressContainer');

            if (!childId) {
                container.innerHTML = '<p class="placeholder-text">Select a student to view their progress.</p>';
                return;
            }

            fetch(`student_progress_data.php?child_id=${childId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        container.innerHTML = '<p>No progress data available for this student.</p>';
                        return;
                    }

                    container.innerHTML = '';
                    data.forEach(domain => {
                        const checklistItems = domain.checklist_items.split(',').map(item => {
                            const [desc, checked] = item.trim().split(':');
                            const symbol = checked === '1' ? '✓' : '✗';
                            return `<li>${symbol} ${desc}</li>`;
                        }).join('');

                        const domainCard = `
                            <div class="domain-card">
                                <h3>${domain.domain}</h3>
                                <div class="progress-bar">
                                    <div class="progress" style="width:${domain.progress_percentage}%;">
                                        ${domain.progress_percentage}%
                                    </div>
                                </div>
                                <ul class="checklist">${checklistItems}</ul>
                            </div>
                        `;
                        container.innerHTML += domainCard;
                    });
                })
                .catch(err => {
                    container.innerHTML = '<p style="color:red;">Error loading data.</p>';
                    console.error(err);
                });
        });
    </script>
</body>
</html>
