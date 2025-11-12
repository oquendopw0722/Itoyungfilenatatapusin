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

// Fetch students assigned to this teacher
$query = "SELECT c.id, c.name AS child_name, c.age, 
                 CONCAT(u.first_name, ' ', u.last_name) AS parent_name
          FROM children c
          LEFT JOIN users u ON c.parent_id = u.id AND u.role = 'parent'
          WHERE c.teacher_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $teacher_id);
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
        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }

        .Home_container {
            margin-left: 250px;
            padding: 2rem;
        }

        h2 {
            color: #333;
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

        <a href="enroll_child.php" class="add-btn">+ Add New Student</a>

        <div class="table-container">
            <?php if (empty($students)): ?>
                <p class="no-data">No students enrolled yet.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Age</th>
                            <th>Parent</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['child_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['age']); ?></td>
                                <td><?php echo htmlspecialchars($student['parent_name'] ?? 'N/A'); ?></td>
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
    </script>

</body>

</html>