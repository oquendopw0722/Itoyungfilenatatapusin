
<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lesson 14 CONSTANTS</title>
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

    
    	<div class="Home_container">
				<div class="Home_content">
          <p style="font-size: 25px"><b>Constants IN PHP</b></p>

          <?php
          //help create data that stays the same -- constants

          define("PI", 3.14);   //common convention with programmers to capitalize all for constants
          define("NAME", "Daniel");
          define("IS_ADMIN", true);
          echo PI;
          echo "<br>";
          echo NAME;
          echo "<br>";
          echo IS_ADMIN;
          echo "<br>";

          function test() {
            echo PI;
            echo "<br>";
            echo NAME;
            echo "<br>";
            echo IS_ADMIN;
          }

          test();
          
          //tutorial tip is to define constants at the top or start of your page, good programming practice



          ?>

        

        </div>
      </div>
  </body>
</html>