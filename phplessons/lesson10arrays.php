<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lesson 10 Arrays</title>
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
          <h3>ARRAYS</h3>
          <br>

          <?php 
          //$fruits = array("apple", "banana", "cherry", "grapes",);  ---- long way to do arrays --- the comma at the end is a trailing comma
          $fruits = [
            "apple", //0 --- meaning 1st entry has index 0
            "banana", //1 --- 2nd entry index 1 and so on...
            "cherry",
            "grapes",
            "watermelon",
          ];
          echo "<p>we have fruits variable in an array, below is value at index[3]</p>";
          echo $fruits[3];
          $fruits[] = "orange";
          echo "<br>";
          echo "<p>display a newly added entry with the index at 5</p>";
          echo $fruits[5];
          $fruits[] = "HINDI ITO FRUIT";
          echo "<br>";
          echo $fruits[6];
          echo "<br>";
          echo "<p>will replace HINDI ITO FRUIT with a real entry</p>";
          $fruits[6] = "rambutan"; //index 6 is replaced at this point, pero before this point, HINDI ITO FRUIT pa rin ang laman ng index 6.
          echo $fruits[6];
          echo "<br>";

          //unset($fruits[3]);   //unsets index 3, walang laman - unset is a built in function in php
          echo $fruits[3];
          echo "<br>";
          echo "<br>";

          echo "<p>below is result of array splice</p>";
          //array splice sort of deletes 
          array_splice($fruits, 0, 1);
          echo $fruits[0];
          echo "<br>";
          echo $fruits[1];
          echo "<br>";
          echo $fruits[2];
          ?>
        </div>
      </div>

      <div class="Home_container">
				<div class="Home_content">
          <p>Separate topic -- Associative array?</p> 

          <?php 
          //topic on "associative array - medyo di ko gets
          //yung laundry, trash - siya pumalit sa index 0, index 1, index 2 --- yung kabila yung value lalabas pag kin-call
          $tasks = [
            "laundry" => "Christian",
            "trash" => "Sanny",
            "vacuum" => "Edith",
            "Dishes" => "Chloe",
          ];

          echo $tasks["laundry"];
          echo "<br>";
          print_r($tasks); // to print and check contents of array
          echo "<br>";
          echo count($tasks); //to count elements in array
          echo "<br>";
          echo count($fruits);
          echo "<br>";
          sort($tasks);     //this sorts in alphabetical order
          print_r($tasks);
          echo "<br>";

          //additional ways to add

          $tasks["dusting"] = "chanchan";
          print_r($tasks);
          echo "<br>";
          array_push($fruits, "kalamansi");
          print_r($fruits);
          echo "<br>";
          echo count($fruits);
          echo "<br>";
          echo "<p>we are using array splice again, but this time we are not deleting</p>";
          array_splice($fruits, 2, 0, "MANGO");  
          //0 on third slot means, we are not deleting, from index 2, it will move, new entry is inserted there.
          print_r($fruits);
          echo "<br>";

          $carbrands = ["toyota", "ford", "mitsubishi", "volkswagen", "peugeot"];
          echo "<p>this time we are using splice to insert another array within the array</p>";
          array_splice($fruits, 4, 0, $carbrands); 
          print_r($fruits);
          echo "<br>";
          echo count($fruits);
          echo "<br>";
          ?>
        </div>
      </div>

      <div class="Home_container">
				<div class="Home_content">
          <p>Multidimensional Arrays</p>

          <?php
          //arrays within an array

          $food = [
            array("rice", "wheat", "potato", "corn"),
            array("fish", "chicken", "pork", "beef"),
            array("leafy greens", "root crops", "overhangs", "others"),
            "ice cream",
            "fasting"
          ];

          echo $food[0][1];
          echo "<br>";
          echo $food[2][3];
          echo "<br>";
          echo $food[1][1];
          echo "<br>";
          echo $food[3];
          echo "<br>";
          echo $food[4];
          echo "<br>";
          echo "<br>";

          echo "<p>Can also apply to associative becoming multidimensional</p>";

          $food2 = [
            "fruits" => array("apple", "banana", "cherry"),
            "meat" => array("chicken", "fish"),
            "vegetables" => array("cucumber", "carrots"),
          ];

          echo $food2["meat"][0]; echo "<br>";
          echo $food2["fruits"][2]; echo "<br>";
          echo $food2["fruits"][0]; echo "<br>";
          echo $food2["vegetables"][1]; echo "<br>";



          ?>

        </div>
      </div>
      


  </body>

</html>