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

// Fetch user role
$query = "SELECT role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_role = $user['role'] ?? null;

// Define allowed roles for this page
$allowed_roles = ['teacher'];
if (!$user_role || !in_array($user_role, $allowed_roles)) {
    header("Location: unauthorized.php");
    exit();
}

// Fetch latest 2 announcements
$ann_query = "SELECT title, content, posted_at FROM announcements ORDER BY posted_at DESC LIMIT 2";
$ann_result = $conn->query($ann_query);
$announcements = [];
while ($row = $ann_result->fetch_assoc()) {
    $announcements[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Teacher Dashboard | School System</title>
  <link rel="stylesheet" href="css2/dashboard.css">
  <link rel="stylesheet" href="css/style1.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    .logout {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      transition: filter 0.3s ease;
      cursor: pointer;
    }

    .logout:hover {
      filter: brightness(70%);
    }

    .sidebar {
        margin-top: 102px;
        margin-bottom: 100px;
        overflow-y: scroll;
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
            <p class = "TopbarLineText">Welcome, <?php echo $_SESSION['username']; ?></p>
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

  <!-- Main Content -->
  <div class="main-content">
      <header>
          <h1>Welcome Teacher, <?php echo $_SESSION['username'] ?>!</h1>
          <p>Here's your overview for today</p>
      </header>

      <!--Temporary placeholder on variables-->
      <?php
        $numberofstudents = 35;
        $assignmentDue = 3;
        $messages = 5;
        $attendancerate = '95%';
      ?>

      <!-- Dashboard Cards -->
      <section class="cards">
          <div class="card">
              <h3>Students</h3>
              <p><?= $numberofstudents ?></p>
          </div>
          <div class="card">
              <h3>Assignments Due</h3>
              <p><?= $assignmentDue ?>%</p>
          </div>
          <div class="card">
              <h3>Messages</h3>
              <p><?= $messages ?></p>
          </div>
          <div class="card">
              <h3>Current Attendance Rate</h3>
              <p><?= $attendancerate ?></p>
          </div>
      </section>

      <!-- Announcements Section -->
      <section class="announcement">
          <h2>Latest Announcements</h2>
          <?php if (empty($announcements)): ?>
              <p>No announcements available.</p>
          <?php else: ?>
              <ul>
                  <?php foreach ($announcements as $ann): ?>
                      <li>
                          <strong><?php echo htmlspecialchars($ann['title']); ?></strong> - 
                          <?php echo htmlspecialchars(substr($ann['content'], 0, 100)); ?>... 
                          <em>(Posted on <?php echo date('M d, Y', strtotime($ann['posted_at'])); ?>)</em>
                      </li>
                  <?php endforeach; ?>
              </ul>
          <?php endif; ?>
      </section>

      <footer>
          <p>© 2025 School Management System | Developed by BSIT 4th Year</p>
      </footer>
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