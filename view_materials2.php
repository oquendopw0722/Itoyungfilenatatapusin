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
$allowed_roles = ['parent', 'teacher', 'admin'];
if (!$user || !in_array($user['role'], $allowed_roles)) {
    header("Location: unauthorized.php");
    exit();
}

// Fetch materials
$query = "SELECT title, description, file_path, file_type, uploaded_at FROM learning_materials ORDER BY uploaded_at DESC";
$result = $conn->query($query);
$materials = [];
while ($row = $result->fetch_assoc()) {
    $materials[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Learning Materials</title>
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
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="extra.php">Old Website</a></li>
            </ul>
        </nav>
        <a href="learning.html" class="cta-btn">Learn</a>
    </div>
    <div class="Topbarline">
        <p class="TopbarLineText">Welcome, <?php echo $_SESSION['username']; ?></p>
    </div>

    <?php include('includes/teacher_sidebar.php'); ?>

    <div class="Home_container">
        <div class="Home_content">
            <h2>Learning Materials</h2>
            <?php if (empty($materials)): ?>
                <p>No materials available.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($materials as $mat): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($mat['title']); ?></h3>
                            <p><?php echo htmlspecialchars($mat['description']); ?></p>
                            <p>Uploaded: <?php echo $mat['uploaded_at']; ?></p>
                            <a href="<?php echo htmlspecialchars($mat['file_path']); ?>" target="_blank">View/Download</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
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