<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Form Handler</title>
		<link rel="stylesheet" href="../capstonedashboard.css">
	</head>
	<body>
		<div class="Topbar">
			<div class = "LogonTitle">
				<img class="Antipolo" src="../blue1.png">
				<h1 class="TopbarTitle">CAPSTONE TRIAL</h1>
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
        <?php

        //var_dump($_SERVER["REQUEST_METHOD"]);

        if ($_SERVER["REQUEST_METHOD"] == "POST"){

          $firstname = htmlspecialchars($_POST["firstname"]);  //htmlspecialchars is to sanitize user input, to avoid code injection
          $lastname = htmlspecialchars($_POST["lastname"]); 
          $favouritepet = htmlspecialchars($_POST["favouritepet"]); 

          if (empty($firstname)){
            exit();
            header("Location: ../index.html");
          }

          echo "These are the data, that the user submitted:";
          echo "<br>";
          echo $firstname;
          echo "<br>";
          echo $lastname;
          echo "<br>";
          echo $favouritepet;

        }
        else {
          header("Location: ../index.html"); //fail safe
        }
        ?>
      </div>
    </div>
  </body>

</html>