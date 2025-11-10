<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Home</title>
		<link rel="stylesheet" href="capstonehome.css">
	</head>
		<body>
		
		<div class="Topbar">
			<div class = "LogonTitle">
				<a href="index.html">
				<img class="Antipolo" src="blue1.png"></a>
				<a style="text-decoration: none" href="index.html">
				<h1 class="TopbarTitle">CAPSTONE TRIAL</h1></a>
			</div>
		</div>
		
		<div class="sidebar">
			<a href="temporary.html"><img src="ICONs/red1.png" alt="marker"><span>Select Below</span></a>
			<a href="index.html"><img src="ICONs/Hicon.png" alt="Home"><span>Home</span></a>
			<a href="Dashboard.html"><img src="ICONs/Dicon.png" alt="Dashboard"><span>Dashboard</span></a>
			<a href="learning.html"><img src="ICONs/Licon.png" alt="Learnings"><span>Learnings</span></a>
			<a href="#"><img src="ICONs/LOicon.png" alt="Logout"><span>Logout</span></a>
			<a href="extra.html"><img src="ICONs/Dicon.png" alt="Extra Apps"><span>Extra Apps</span></a>
		</div>
			
			<div class="Home_container">
				<div class="Home_content">
					<p class="Text_title2">Welcome! Dear parent</p>
					<p class="Text_title"><b>HOME</b></p>

				</div>
				<div class="AnnouncementContainer">
					<p class="Text_announcement">Announcement:  0</p>
				</div>
			</div>
		</body>
</html>