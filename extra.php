<?php
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Extras and Sides</title>
		<link rel="stylesheet" href="capstonedashboard.css">
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
            <a href="extra.php"><img src="ICONs/Dicon.png" alt="Extra Apps"><span>Extra Apps</span></a>
		</div>


    
			
			<div class="Home_container">
				<div class="Home_content">
          <h1>Extra Apps</h1>
					<!--line 1-->
					<br>
					<a href="searchpractice.php"><img src="ICONs/Dicon4.png" width="20" height="20"><span>SEARCH PRACTICE</span> </a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="phplessons/testentry1.php"><img src="ICONs/Dicon4.png" width="20" height="20"><span>TESTING ENTRY</span> </a>
          <br><br>
					<!--line 2-->
					<a href="phplessons/lesson9calculator.php"><img src="ICONs/Dicon4.png" width="20" height="20"><span>CALCULATOR</span> </a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="phplessons/signup1.php"><img src="ICONs/Dicon4.png" width="20" height="20"><span>SIGN UP</span></a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="phplessons/updatedelete.php"><img src="ICONs/Dicon4.png" width="20" height="20"><span>update/delete</span></a>
					<br><br>
					<!--line 3-->
					<a href="phplessons/video6.php"><img src="ICONs/Dicon3.png" width="20" height="20"><span>video6</span></a>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="phplessons/lesson11builtinfunctions.php"><img src="ICONs/Dicon3.png" width="20" height="20"><span>Lesson 11 Built-in Functions</span></a>
					&nbsp;&nbsp;
					<a href="phplessons/lesson15loops.php"><img src="ICONs/Dicon3.png" width="20" height="20"><span>Lesson 15 Loops</span></a>
          <br><br>
					<!--line 4-->
          <a href="phplessons/lesson7operators.php"><img src="ICONs/Dicon4.png" width="20" height="20"><span>lesson7operators</span></a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="phplessons/lesson12userbuiltfunctions.php"><img src="ICONs/Dicon3.png" width="20" height="20"><span>Lesson12 UserFunc</span></a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="phplessons/lesson16database.php"><img src="ICONs/Dicon3.png" width="20" height="20"><span>Lesson 16 database?</span></a>
					<br><br>
					<!--line 5-->
					<a href="phplessons/lesson8controlstructures.php"><img src="ICONs/Dicon4.png" width="20" height="20"><span>Lesson 8 Control Structures</span> </a>
					&nbsp;
					<a href="phplessons/lesson13scopes.php"><img src="ICONs/Dicon3.png" width="20" height="20"><span>Lesson13 Scopes</span></a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="phplessons/testpage1.php"><img src="ICONs/Dicon3.png" width="20" height="20"><span>test page 1</span></a>
					<br><br>
					<a href="phplessons/lesson10arrays.php"><img src="ICONs/Dicon4.png" width="20" height="20"><span>Lesson 10 Arrays</span> </a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="phplessons/lesson14constants.php"><img src="ICONs/Dicon4.png" width="20" height="20"><span>Lesson 14 Constants</span> </a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="phplessons/extracopy.php"><img src="ICONs/Dicon2.png" width="20" height="20"><span>extracopy</span></a>
					<br><br>
					<p>==================================================================================</p>
					<h3>------->></h3>
					<!--line 6-->
					<a href="phplessons/lesson20connecting.php"><img src="ICONs/Dicon2.png" width="20" height="20"><span>LESSON 20</span></a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="phplessons/lesson25sessions.php"><img src="ICONs/Dicon2.png" width="20" height="20"><span>LESSON 25 Sessions</span></a>

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
