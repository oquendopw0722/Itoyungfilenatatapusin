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

// Fetch parents for dropdown
$parents_query = "SELECT id, first_name, last_name FROM users WHERE role = 'parent'";
$parents_result = $conn->query($parents_query);
$parents = [];
while ($row = $parents_result->fetch_assoc()) {
    $parents[] = $row;
}

// Fetch teachers for dropdown
$teachers_query = "SELECT id, username FROM users WHERE role = 'teacher'";
$teachers_result = $conn->query($teachers_query);
$teachers = [];
while ($row = $teachers_result->fetch_assoc()) {
    $teachers[] = $row;
}

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $child_name = trim($_POST['child_name']);
    $parent_id = (int)$_POST['parent_id'];
    $selected_teacher_id = (int)$_POST['teacher_id'];
    $section = trim($_POST['section']);
    $school_year = trim($_POST['school_year']);
    $age = (int)$_POST['age'];
    $gender = $_POST['gender'];
    $domain = trim($_POST['domain']);
    $percentage = (int)$_POST['percentage'];
    $checklist = trim($_POST['checklist']);
    $report_text = trim($_POST['report_text']);

    if (empty($child_name) || empty($domain) || $percentage < 0 || $percentage > 100 || empty($section) || empty($school_year) || $age <= 0 || empty($gender)) {
        $message = 'Please fill all required fields correctly.';
    } else {
        // Insert child with selected teacher
        $child_query = "INSERT INTO children (name, parent_id, teacher_id, age, gender, section, school_year) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($child_query);
        $stmt->bind_param("siiisss", $child_name, $parent_id, $selected_teacher_id, $age, $gender, $section, $school_year);
        $stmt->execute();
        $child_id = $conn->insert_id;

        // Insert initial progress
        $progress_query = "INSERT INTO eccd_progress (child_id, domain, progress_percentage, checklist_items) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($progress_query);
        $stmt->bind_param("isss", $child_id, $domain, $percentage, $checklist);
        $stmt->execute();

        // Insert initial report
        if (!empty($report_text)) {
            $report_query = "INSERT INTO reports (child_id, teacher_id, report_text) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($report_query);
            $stmt->bind_param("iis", $child_id, $selected_teacher_id, $report_text);
            $stmt->execute();
        }

        $message = 'Child enrolled successfully with initial data!';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Enroll New Child - Teacher</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css2/dashboard.css">
    <link rel="stylesheet" href="css2/enroll_form.css">
    <style>
        .form-group {
            margin-bottom: 1rem;
        }

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

    <!-- Sidebar -->
    <?php include('includes/teacher_sidebar.php'); ?>

    <div class="Home_container">
        <div class="Home_content">
            <h2>Enroll New Child and Add Initial Data</h2>
            <?php if ($message): ?><p style="color: green;"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Child's Name:</label>
                    <input type="text" name="child_name" required>
                </div>
                <div style="display: flex; flex-direction:row; gap: 10px;">
                    <div class="form-group" style="flex: 1">
                        <label>Age:</label>
                        <input type="number" name="age" min="1" required>
                    </div>
                    <div class="form-group" style="flex: 1">
                        <label>Gender:</label>
                        <select name="gender" required>
                            <option value="" selected disabled>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-direction:row; gap: 10px;">
                    <div class="form-group" style="flex: 1">
                        <label>Section:</label>
                        <input type="text" name="section" required>
                    </div>
                    <div class="form-group" style="flex: 1">
                        <label>School Year:</label>
                        <input type="text" name="school_year" placeholder="e.g., 2026" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Select Parent:</label>
                    <select name="parent_id" required>
                        <option value="" selected disabled>Choose Parent</option>
                        <?php foreach ($parents as $parent): ?>
                            <option value="<?php echo $parent['id']; ?>">
                                <?php echo htmlspecialchars($parent['first_name'] . ' ' . $parent['last_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Select Teacher:</label>
                    <select name="teacher_id" required>
                        <option value="" selected disabled>Choose Teacher</option>
                        <?php foreach ($teachers as $teacher): ?>
                            <option value="<?php echo $teacher['id']; ?>"><?php echo htmlspecialchars($teacher['username']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Initial Domain (e.g., Gross Motor):</label>
                    <select name="gender" required>
                        <option value="" selected disabled>Select Domain</option>
                        <option value="Gross Motor">Gross Motor</option>
                        <option value="Fine Motor">Fine Motor</option>
                        <option value="Self Help">Self Help</option>
                        <option value="Receptive Language">Receptive Language</option>
                        <option value="Expressive Language">Expressive Language</option>
                        <option value="Cognitive">Cognitive</option>
                        <option value="Social-Emotional">Social-Emotional</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Initial Progress Percentage (0-100):</label>
                    <input type="number" name="percentage" min="0" max="100" required>
                </div>
                <div class="form-group">
                    <label>Initial Checklist Items (e.g., Can walk steadily:1, Climbs stairs:0):</label>
                    <textarea name="checklist" rows="4" placeholder="Enter items separated by commas"></textarea>
                </div>
                <div class="form-group">
                    <label>Initial Report/Notes:</label>
                    <textarea name="report_text" rows="4" placeholder="Add initial teacher notes..."></textarea>
                </div>
                <button type="submit">Enroll Child</button>
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