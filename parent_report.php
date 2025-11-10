<?php
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

//if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher' || $_SESSION['role'] !== 'admin') {
    //header("Location: unauthorized.php");
    //exit;
//}

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
      overflow-y: scroll
	  }
    .Home_container {
      margin-left: 240px;
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
        <a href="student_progress.php">Student Progress</a>
        <a href="view_materials3.php">View Learning Materials</a>
        <a href="parent_calendar.php">Calendar</a>
        <a href="parent_report.php">Reports</a>
        <a href="parent_announcement.php">Announcements</a>
        <a href="my_account3.php">My Account</a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
  </div>

  <div class="Home_container">
    <div class="Home_content">
      <!-- Main Content -->
      <div class="main-content">
          <header>
              <h1>Welcome, <?php echo $_SESSION['username'] ?>!</h1>
              <p>Monitor your child's learning progress and stay updated with school activities.</p>
          </header>

          <div class="main-content">
        <header>
            <h1>Reports</h1>
            <p>Download or view your child’s academic and attendance reports.</p>
        </header>

        <section class="cards">
            <div class="card">
                <h3>Quarter 1 Report</h3>
                <button>Download PDF</button>
            </div>
            <div class="card">
                <h3>Attendance Summary</h3>
                <button>View Details</button>
            </div>
        </section>

        <footer>
            <p>© 2025 School Management System | Developed by BSIT 4th Year</p>
        </footer>
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
