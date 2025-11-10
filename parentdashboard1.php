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
$allowed_roles = ['parent'];
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
  <title>Parent Dashboard | School System</title>
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

  <!-- Main Content -->
  <div class="main-content">
      <header>
          <h1>Welcome, <?php echo $_SESSION['username'] ?>!</h1>
          <p>Monitor your child's learning progress and stay updated with school activities.</p>
      </header>

      <!--Temporary placeholder on variables-->
      <?php
        $averageGrade = 90;
        $attendance = 90;
        $upcomingExams = 'TBA';
        $newAnnouncements = 'Walang pasok dahil kay bagyong Ramil';
      ?>

      <!-- Dashboard Cards -->
      <section class="cards">
          <div class="card">
              <h3>Child's Average Grade</h3>
              <p><?= $averageGrade ?>%</p>
          </div>
          <div class="card">
              <h3>Attendance Record</h3>
              <p><?= $attendance ?>%</p>
          </div>
          <div class="card">
              <h3>Upcoming Exams</h3>
              <p><?= $upcomingExams ?></p>
          </div>
          <!--
          <div class="card">
              <h3>New Announcements</h3>
              <p><?= $newAnnouncements ?></p>
          </div>-->
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