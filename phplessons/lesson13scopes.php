<?php
declare(strict_types=1); // this is to set the webpage with a strict rules on data types that will pass through
?>
<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lesson 13 SCOPES</title>
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
          <p style="font-size: 25px"><b>SCOPES IN PHP</b></p>

          <?php 
          //this is on global scope
          $test = "stringov";
          echo $test;
          echo "--this is global";
          echo "<br>";

          //scope with functions

          function myFunction1() {
            //define local variable
            $localvar1 = "Hello World!";

            //use of local variable
            return $localvar1;  //usually outputs "Hello World!"
          }

          echo myFunction1();
          echo "<br>";
          echo "<br>";
          // echo $localvar1  -- this will result in error as variable $localvar1 only exist inside the function at this point

          //another example

          $test2 = "stringovski";

          function myFunction2() {
            //define local variable
            $localvar = "Hello World!";
            global $test2;
            
            //use of local variable
            return $test2;  
          }

          echo myFunction2();
          echo "<br>";

          //you could also pass in/through a variable without using global
          
          $test3 = "stringorov";

          function myFunction3($test3) {
            //define local variable
            $localvar = "Hello World!";
            
            //use of local variable
            return $test3;  
          }

          echo myFunction3($test3);
          echo "<br>";

          //Another example using GLOBALS

          $test4 = "stringski";

          function myFunction4() {
            //define local variable
            $localvar = "Hello World!";
            
            //use of local variable
            return $GLOBALS["test4"];  
          }

          echo myFunction4();
          echo "<br>";

          //static scope - statically declared variable
          //static variable is not reset every time the function is used

          echo "<p>static variable: </p>";

          function myFunction5() {
            //declare a static variable
            static $staticvar1 = 0;

            //incrementing the static variable
            $staticvar1++;

            //use of the static variable
            return $staticvar1;
          }
          echo myFunction5();
          echo "<br>";
          echo myFunction5();
          echo "<br>";
          echo myFunction5();
          echo "<br>";

          //scopes in Class

          echo "<p>scope in class: </p>";

          class myClass
          {
            //defining a class variable
            static public $classvar1 = "Wassup World!";

            //defining a class method
            public function MyMethod()
            {
              //use the class variable
              echo $this->classvar1; // outputs Wassup World!
            }
          }

          echo myClass::$classvar1;
          
          
          ?>

        

        </div>
      </div>
  </body>
</html>