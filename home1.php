<?php
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<link rel="stylesheet" href="css2/capstonehome.css">
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
		
		<section class="hero">
		<img src="pictures/classroom.jpg" alt="Kids learning in classroom">
		<div class="hero-text-box">
			<h1>TESTING TESTING <br> ewan pahhhhh....</h1>
			<p>Welcome to GOLD: DXXXX Daycare Center</p>
			<a href="#Learning" class="hero-btn">Start Learning</a>
		</div>
		</section>



		<div class="Home_container">
		<div class="Home_content">
			<p class="Text_title2">Welcome <?php echo $_SESSION['username']; ?>!</p>
			<p class="Text_title"><b>HOME</b></p>
		</div>
		<div class="AnnouncementContainer">
			<p class="Text_announcement">Announcement:  0</p>
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