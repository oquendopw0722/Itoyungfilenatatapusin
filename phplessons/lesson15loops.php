
<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lesson 15 LOOPS</title>
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
    $num1 = 2;
    $num2 = 30;
    $num3 = 5;
    
    ?>


    <?php

    	echo "<div class='Home_container'>";
				echo "<div class='Home_content'>";
          echo "<p style='font-size: 25px'><b>LOOPS IN PHP</b></p>";


          //for loop
          echo "<p><u>for loop 1</u></p>";
          for ($i = 0; $i <=10; $i++) { // (variable and starting point, stopping/running condition, increments)
            echo "This is iteration number " . $i . " hehe <br>";
          }

          echo "<p><u>for loop 2</u></p>";
          for ($i = 3; $i <=11; $i++) { // (variable and starting point, stopping/running condition, increments)
            echo "This is iteration number " . $i . " yahoo <br>";
          }
          
        echo "</div>";
      echo "</div>";

      //another home container

      echo "<div class='Home_container'>";
				echo "<div class='Home_content'>";

          echo "<p><u>for loop 3</u></p>";
          for ($i = 0; $i <= 49; $i = $i + 7) { // (variable and starting point, stopping condition, increments)
            echo "This is iteration number " . $i . " yeah <br>";
          }

          echo "<p><u>for loop 4</u></p>";
          for ($i = $num1; $i <= $num2; $i = $i + $num3) {
            echo "This is iteration number " . $i . " woah <br>";
          }
          
        echo "</div>";
      echo "</div>";

      echo "<div class='Home_container'>";
				echo "<div class='Home_content'>";

          echo "<p><u>while loop 1</u></p>";
          $boolean = true;
          while ($boolean) {
            echo $boolean;
            $boolean = false;
          }

          echo "<p><u>while loop 2</u></p>";
          $test = 5;
          while ($test < 10) {
            echo $test . "<br>";
            $test++;
          }

          //for loop is best for numbers and math
          //while loop is best for if statements


          echo "<p><u>DO-while loop 1</u></p>";
          $test2 = 10;
          do {
            echo $test2;
            $test2++;
          } while ($test2 < 10);
          
          //will loop it at least one time kapag ginamit ang do-while loop.


          //foreach loops

          $fruits = ["apple", "banana", "orange"];
          $fruits2 = [
            "apple" => "red",
            "banana" => "yellow",
            "orange"=> "orange",
          ];
          echo "<p><u>for each loop</u></p>";

          foreach ($fruits as $fruit) {
            echo "This is a/an " . $fruit . "<br>";

          }

          echo "<p><u>for each loop 2</u></p>";

          foreach ($fruits2 as $fruit2 => $color) {
            echo "This is a/an " . $fruit2 . " that has the color " . $color . ".<br>";
          }



        echo "</div>";
      echo "</div>";

      echo "<div class='Home_container'>";
				echo "<div class='Home_content'>";


          

        echo "</div>";
      echo "</div>";






    ?>
  </body>
</html>