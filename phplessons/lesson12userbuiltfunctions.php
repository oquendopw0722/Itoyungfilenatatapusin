<?php
declare(strict_types=1); // this is to set the webpage with a strict rules on data types that will pass through
?>
<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lesson 12 User Built Functions in PHP</title>
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
          <p style="font-size: 20px;"><b>USER BUILT FUNCTIONS IN PHP</b></p>

          <?php
          //functions should have mostly just one job that is usually repeated, will be called upon repeatedly

          function sayHello() {
            echo "Hello World!";
          }

          sayHello();

          echo "<br>";

          //lets say we just want to return a value and not really display it on the webpage

          function say1(){
            return "hello functions";
          }

          say1();
          $test1 = say1(); //this returns back the value then saves it to the variable $test1
          echo $test1;
          echo "<br>";


          //lets then say we want to pass a parameter

          function say2($name1){
            return "Hello " . $name1 . "!";
          }

          $test2 = say2("Christian James"); //this returns with the parameter
          echo $test2;
          echo "<br>";


          //we can also have a default value on the parameter

          function say3($name2 = "DID NOT PUT NAME") {
            return "Hello " . $name2 . "!";
          }
          $test3 = say3(); 
          echo $test3;
          echo "<br>";


          //we can also set strict limitation on data types for parameter

          function say4(string $name3) {
            return "Hello " . $name3 . "!";
          }
          // $test4 = say4(123);  ---- this will cause error because parameter is a number not a string
          $test4 = say4("Joanna");
          echo $test4;
          echo "<br>";
          echo "<br>";

          //function calculator

          function calculator(int $num1, int $num2) {
            $result = $num1 + $num2;
            return $result;
          }

          $test5 = calculator(11, 9);
          echo $test5;
          echo "<br>";
          echo "<br>";

          //in case we want to use a variable declared outside the scope of the function

          $num3 = 45;
          $num4 = 55;
          $num5 = 10;

          function calc2(int $num3, int $num4) {
            global $num5;
            $result1 = $num3 + $num4 + $num5;
            return $result1;
          }

          $test6 = calc2($num3, $num4);
          echo $test6;
          echo "<br>";

          // I do not understand this that much




          ?>

        </div>
      </div>
  </body>
</html>