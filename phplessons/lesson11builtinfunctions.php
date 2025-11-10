<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lesson 11 Built-in Functions in PHP</title>
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
          <p style="font-size: 20px;"><b>BUILT-IN FUNCTIONS IN PHP</b></p>

          <?php 

          //for using string

          echo "</p>for strings</p>";
          $string1 = "Hello World";
          echo $string1;
          echo "<br>";
          echo strlen($string1);    //this is the function for string length in php   
          echo " --This is string length";  
          echo "<br>";
          echo strpos($string1, "o");   //this is string position, gives out position of a string within a string, o is at index 4(which starts at zero like an array)
          echo " --This is string position of letter o at index 4";  
          echo "<br>";
          echo strpos($string1, "Wor");     //case sensitive
          echo " --This is string position of 'wor'"; 
          echo "<br>";
          echo str_replace("World", "Christian", $string1);
          echo " --str replaced the word World";
          echo "<br>";
          echo strtolower($string1);
          echo " --eto naman ay to lowercase lahat";
          echo "<br>";
          $string2 = str_replace("World", "Christian", $string1);
          echo $string2;
          echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          echo $string1;
          echo "<br>";
          echo strtoupper($string1);
          echo " --eto naman ay to uppercase lahat";
          echo "<br>";
          echo substr($string1, 2, -2, );     //grabs a certain part of the string (the variable, where do you start, length of index affected, negative to start count until the end)
          echo "<br>";
          print_r(explode("o", $string1));       //breaks down (separator that you want, and then the variable), had to use print r since we are handling arrays
          echo "<br>";
          echo "<br>";
          
          //math built in funtions
          echo "</p>for Math</p>";
          $num1 = -5.5;
          echo $num1;
          echo "<br>";
          echo abs($num1);   //absolute value function
          echo "---to get absolute value";
          echo "<br>";
          echo round($num1);  // to round up
          echo "---to get rounded up to nearest whole number";
          echo "<br>";
          echo pow(2, 3); // to the power off
          echo "---to get exponents, to the power of";
          echo "<br>";
          echo pow($num1, 2);
          echo "<br>";
          echo sqrt(100);   //square root
          echo "---to get the square root of";
          echo "<br>";
          echo rand(1, 1000);  //to get random number from a range of numbers
          echo "---to get random numbers from a range you set, this case 1 to 1000";
          echo "<br>";
          echo "<br>";
          ?>
        </div>
      </div>

      <div class="Home_container">
				<div class="Home_content">
          <?php

          //for array functions
          echo "</p>for Arrays</p>";
          $array1 = ["apple", "banana", "orange"];
          $array2 = ["kiwi", "watermelon", "strawberry"];
          
          echo count($array1);  //to count entries in array
          echo "<br>";
          echo is_array($array1);  //confirming is variable is array
          echo "<br>";
          echo array_push($array1, "kiwi");   //another way to add
          echo "<br>";
          print_r($array1);
          echo "<br>";
          array_pop($array1);  //pops away the last element in the array
          print_r($array1);
          echo "<br>";
          print_r(array_reverse($array1));  // reverses the order
          echo "<br>";
          print_r($array1);
          echo "<br>";
          print_r(array_merge($array1, $array2)); // combines the arrays, array2 is going to be added at the end of array 1
          echo "<br>";
          print_r($array1);
          echo "<br>";
          print_r($array2);
          echo "<br>";
          echo "<br>";

          //date and time
          echo "</p>for date and time</p>";

          echo date("Y-m-d H:i:s");   // year-month-day -- hour-minutes-seconds
          echo "<br>";
          echo time();      //unix time stamp
          echo "---this is the unix timestamp - January 1 1970 00:00:00 GMT";
          echo "<br>";
          $date = "2023-04-11 12:00:00";
          echo strtotime($date);
          echo "---time from unix 1970 to the date specified in variable";
          echo "<br>";

          ?>
        </div>
      </div>
      
  </body>

</html>