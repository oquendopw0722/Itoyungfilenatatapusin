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

// Get teacher ID
$user_query = "SELECT id, role FROM users WHERE username = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

if (!$user || $user['role'] !== 'teacher') {
    header("Location: unauthorized.php");
    exit();
}

$teacher_id = $user['id'];

// --- NEW: Fetch distinct school years for the dropdown ---
$year_query = "SELECT DISTINCT school_year FROM children WHERE teacher_id = ? ORDER BY school_year DESC";
$stmt_year = $conn->prepare($year_query);
$stmt_year->bind_param("i", $teacher_id);
$stmt_year->execute();
$year_result = $stmt_year->get_result();
$school_years = [];
while ($row = $year_result->fetch_assoc()) {
    // Only include non-NULL and non-empty years
    if (!empty($row['school_year'])) {
        $school_years[] = $row['school_year'];
    }
}
$stmt_year->close();


// --- NEW: Get selected school year from GET parameter ---
$selected_year = isset($_GET['school_year']) && in_array($_GET['school_year'], $school_years) ? $_GET['school_year'] : (empty($school_years) ? null : $school_years[0]);


// --- MODIFIED: Fetch students assigned to this teacher, filtered by school year ---
$query = "SELECT c.id, c.name AS child_name, c.age, c.section, c.school_year, 
              CONCAT(u.first_name, ' ', u.last_name) AS parent_name
           FROM children c
           LEFT JOIN users u ON c.parent_id = u.id AND u.role = 'parent'
           WHERE c.teacher_id = ?";

$params = [$teacher_id];
$types = "i";

if ($selected_year) {
    // Add school_year filter to the query
    $query .= " AND c.school_year = ?";
    $params[] = $selected_year;
    $types .= "s"; // Assuming school_year is a string/varchar
}

$query .= " ORDER BY c.name ASC"; // Optional: sort by name

$stmt = $conn->prepare($query);
if ($selected_year) {
    // Dynamically bind parameters (more complex, but needed for variable argument count)
    $stmt->bind_param($types, ...$params);
} else {
    $stmt->bind_param($types, $teacher_id);
}

$stmt->execute();
$result = $stmt->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Class Management</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css2/dashboard.css">
    <style>
        /* ... existing styles ... */
        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            top: 120px !important;
            height: calc(100vh - 120px) !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        .Home_container {
            margin-left: 250px;
            padding: 2rem;
        }

        h2 {
            margin-bottom: 1rem;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #4CAF50;
            color: white;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        tr:hover {
            background: #f1f1f1;
        }

        .actions button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
        }

        .actions button.remove {
            background: #e74c3c;
        }

        .add-btn {
            width: fit-content;
            background: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 1rem;
            transition: background 0.3s;
        }

        .add-btn:hover {
            background: #45a049;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            font-style: italic;
        }

        .logout {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            cursor: pointer;
        }

        /* --- NEW: Style for filter/dropdown container --- */
        .filter-container {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .filter-container label {
            font-weight: bold;
            color: #333;
        }

        .filter-container select {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="Topbar">
        <img class="Antipolo" src="pictures/ANTIPOLO.png">
        <h1 class="TopbarTitle1">GOLD:</h1>
        <h1 class="TopbarTitle2">DXXXX daycare center</h1>
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
        <h2>Class Management</h2>

        <div class="filter-container">
            <label for="school_year_filter">School Year:</label>
            <select id="school_year_filter" onchange="filterStudents(this.value)">
                <?php if (!empty($school_years)): ?>
                    <?php foreach ($school_years as $year): ?>
                        <option value="<?php echo htmlspecialchars($year); ?>"
                            <?php echo ($year == $selected_year) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($year); ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="" disabled>No Years Found</option>
                <?php endif; ?>
            </select>
            <a href="enroll_child.php" class="add-btn" style="margin-left: auto;">+ Add New Student</a>
        </div>
        <div class="table-container">
            <?php if (empty($students)): ?>
                <p class="no-data">No students enrolled for the selected school year (<?php echo htmlspecialchars($selected_year); ?>).</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Age</th>
                            <th>Parent</th>
                            <th>Section</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['child_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['age']); ?></td>
                                <td><?php echo htmlspecialchars($student['parent_name'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($student['section'] ?? 'N/A'); ?></td>
                                <td class="actions">
                                    <button onclick="window.location.href='teacher_progress.php?child_id=<?php echo $student['id']; ?>'">View Progress</button>
                                    <button class="remove" onclick="confirmRemove(<?php echo $student['id']; ?>)">Remove</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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

        function confirmRemove(childId) {
            if (confirm("Are you sure you want to remove this student from your class?")) {
                window.location.href = "remove_student.php?id=" + childId;
            }
        }

        // --- NEW: JavaScript function to filter students by school year ---
        function filterStudents(selectedYear) {
            // Reloads the page with the selected school year as a URL parameter
            window.location.href = `class_management.php?school_year=${selectedYear}`;
        }
    </script>

</body>

</html>