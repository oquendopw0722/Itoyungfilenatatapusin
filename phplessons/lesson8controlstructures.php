<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lesson 8 Control Structures</title>
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
          <h2>Lesson 8: PHP CONTROL STRUCTURES</h2>
          <br>
          <h3>Condition If Else</h3>
          <h3>Switch</h3>
          <h3>Match</h3>

          <p><u><i>If else statements</i></u></p>
          <p>a = to something, can change in the code <br>
          b = to something, can change in the code <br>
          is variable a less than variable b?
          </p>

          <?php

          $bool = true;
          $a = 4;
          $b = 7;
          echo "I am echoing out variable a =" . $a;
          echo "<br>";
          echo "I am echoing out variable b =" . $b;
          echo "<br>";
          echo "<br>";

          if ($a < $b && !$bool) {
            echo "first condition is true!";  
          }
          else if ($a < $b && $bool) {
            echo "second condition is true!";
          }
          else if ($a == $b && $bool) {
            echo "Third condition is true!";
          }
          else {
            echo "None of the conditions were true"; //fail safe, like a defaul behavior
          }
          echo "<br>";
          echo "<p>Testing html text inside PHP TAG</p>";
          echo "<br>";

          echo "<p><u><i>SWITCH</i></u></p>";

          switch ($a) { //the case actually check the value already, not numbering the cases
            case "Daniel": 
              echo "The first case is correct, we have a string Daniel";
              break;
            case 1:
              echo "variable a contains number 1";
              break;
            case 2: 
              echo "variable a contains number 2";
              break;
            case 3: 
              echo "variable a contains number 3";
              break;
            case 4: 
              echo "variable a contains number 4";
              break;
            default: 
              echo "None of the cases were true!"; // fail safe ng switch case, default
          }


          echo "<br>";
          echo "<br>";
          echo "<p><u><i>MATCH</i></u></p>";

          $result1 = match ($a){
            1, 5, 6 => "this is in match...variable a is equal to one!", //can have multiple
            2 => "this is in match...variable a is equal to two!",
            3 => "this is in match...variable a is equal to three!",
            4 => "this is in match...variable a is equal to four!",
            default => "There are no matches",

          }; // we added ; at the end of } because match is like creating a variable

          echo $result1;
          ?>

        </div>
      </div>


  </body>

</html>