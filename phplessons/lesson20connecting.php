
<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Connecting Database?</title>
		<link rel="stylesheet" href="../capstonedashboard.css">
	</head>
	<body>
		<div class="Topbar">
			<div class = "LogonTitle">
				<a href="../index.html">
				<img class="Antipolo" src="../blue1.png"></a>
				<a style="text-decoration: none" href="../index.html">
				<h1 class="TopbarTitle">CAPSTONE TRIAL</h1></a>
			</div>
		</div>
		
		<div class="sidebar">
      <a href="../temporary.html"><img src="../ICONs/red1.png" alt="marker"><span>Select Below</span></a>
			<a href="../index.html"><img src="../ICONs/Hicon.png" alt="Home"><span>Home</span></a>
			<a href="../Dashboard.html"><img src="../ICONs/Dicon.png" alt="Dashboard"><span>Dashboard</span></a>
			<a href="../learning.html"><img src="../ICONs/Licon.png" alt="Learnings"><span>Learnings</span></a>
			<a href="#"><img src="../ICONs/LOicon.png" alt="Logout"><span>Logout</span></a>
      <a href="../extra.html"><img src="../ICONs/Dicon.png" alt="Extra Apps"><span>Extra Apps</span></a>
		</div>



    <?php

    	echo "<div class='Home_container'>";
				echo "<div class='Home_content'>";
          echo "<p style='font-size: 25px'><b>Lesson 20-21</b></p>";

					echo "<p>===<u>Lesson 20</u>===</p>";

					echo "mysql:host = the host name<br>";
					echo "dbname = name of the database being connected<br>";

					echo "3 ways to connect database<br>";

					echo "mysql - considered bad and obsolete, considered outdated<br>";

					echo "mysqli - mysql improved - the new way<br>";

					echo "pdo - php data objects<br>";
					echo "-another way to connect to database, more flexible<br>";
					echo "can apply sql lite or other database<br>";

					echo "TRY CATCH - running PDO<br>";

					echo "<p>===<u>Lesson 21</u>===</p>";

					echo "Change Username & Password in MySQL Database<br>";

					echo "you may change username on the login information tab in phpmyadmin<br>";

					echo "but for the password, recommended to do it on the change password tab<br>";

					echo "if you do it on login information, there was a bug and may encounter error <br>";

					echo "ERROR CODE 1034: <br>";
					echo "check the query string following the error - trace which database corruption is coming form <br>";
					echo "you can right click check tables on the affected database<br>";
					echo "if the affected table is found, you can right click - repair table <br>";

					echo "<p>===<u>Lesson 22</u>===</p>";

					echo "in this lesson, we use the sign-up to learn inserting data using PHP, not just database<br>";
					echo "check out the sign up<br>";
					echo "<br>";
					echo "PREPARED STATEMENTS<br>";


			
				echo "</div>";
			echo "</div>";


    ?>
  </body>
</html>