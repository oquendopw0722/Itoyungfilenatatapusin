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

// --- Define the base path for your files here ---
// **IMPORTANT**: Change 'uploads/' to your actual storage directory name if different.
$file_base_path = 'uploads/';

while ($row = $result->fetch_assoc()) {
    // Append the file type to help users identify the material
    $file_extension = pathinfo($row['file_path'], PATHINFO_EXTENSION);
    $row['file_type_display'] = strtoupper($file_extension);

    // FIX IMPLEMENTATION: Use the file_path directly as it already contains the folder path
    $row['full_file_path'] = $row['file_path'];

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles for the main content container */
        .Home_container {
            /* Adjusted margin for layout consistency */
            margin-left: 250px;
            padding: 2rem;
            /* Push content down below sticky Topbar */
            background-color: #f4f6f9;
        }

        .sidebar {
            /* Fixed sidebar position for consistency */
            position: fixed;
            top: 120px !important;
            height: calc(100vh - 120px) !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        /* New: Styles for the card layout */
        .materials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .material-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 25px;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
        }

        .material-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .material-card h3 {
            color: #4CAF50;
            /* Green primary color */
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.25rem;
        }

        .material-card p {
            color: #555;
            margin-bottom: 10px;
            flex-grow: 1;
            /* Allows description to take up available space */
        }

        .material-info {
            font-size: 0.85rem;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .file-tag {
            background: #f0f0f0;
            color: #333;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.8rem;
        }

        /* Action buttons container */
        .material-actions {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }

        .material-actions a {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 15px;
            text-align: center;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.2s;
            font-size: 0.9rem;
        }

        .view-btn {
            background-color: #343bc9;
            /* Use a secondary color like blue for view */
            color: white;
        }

        .view-btn:hover {
            background-color: #2a31a9;
        }

        .download-btn {
            background-color: #4CAF50;
            /* Green for download */
            color: white;
        }

        .download-btn:hover {
            background-color: #45a049;
        }

        .no-materials {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            text-align: center;
            font-style: italic;
            color: #777;
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

    <?php include('includes/parent_sidebar.php'); ?>

    <div class="Home_container">
    <h2>📚 Learning Materials</h2>
    <p>Access and download educational resources uploaded for your child's class.</p>

    <?php if (empty($materials)): ?>
        <div class="no-materials">No materials available.</div>
    <?php else: ?>
        <div class="materials-grid">
            <?php foreach ($materials as $mat): ?>
                <div class="material-card">
                    <h3><?php echo htmlspecialchars($mat['title']); ?></h3>
                    <p><?php echo htmlspecialchars($mat['description']); ?></p>

                    <div class="material-info">
                        <span><i class="fas fa-upload"></i> Uploaded: <?php echo date("M d, Y", strtotime($mat['uploaded_at'])); ?></span>
                        <span class="file-tag"><?php echo htmlspecialchars($mat['file_type_display']); ?></span>
                    </div>

                    <div class="material-actions">
                        <a href="<?php echo htmlspecialchars($mat['full_file_path']); ?>" target="_blank" class="action-btn view-btn">
                            <i class="fas fa-eye"></i> View
                        </a>

                        <a href="<?php echo htmlspecialchars($mat['full_file_path']); ?>" download class="action-btn download-btn">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
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