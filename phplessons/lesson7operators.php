<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lesson 7 Operators</title>
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
          <h3>Lesson 7: OPERATORS IN PHP</h3>
          <br>

          <?php
          //string operators

          $a = "Hello";
          $b = "World";
          $c = $a . "      " . $b;
          echo "// string operators";
          echo "<br>";
          echo $c;
          echo "<br>";
          echo $a;
          echo "<br>";
          echo $b;
          echo "<br>";
          echo $b . $a . $b . "   " . $c;
          echo "<br>";
          echo "<br>";

          //arithmetic operators

          echo "//arithmetic operators";
          echo "<br>";
          echo 1 + 2;
          echo "<br>";
          echo 10 % 3; //% is modulo
          echo "<br>";
          echo 10 ** 5; // double * is "to the power of"
          echo "<br>";
          echo 2 ** 10; 
          echo "<br>";
          //precedence in php - it seems standard
          echo (1 + 2) * 4;
          echo "<br>";
          echo 1 + 2 * 4;
          echo "<br>";
          echo "<br>";

          //assignment operators

          echo "//assignment operators";

          $a = 2;
          $a = $a + 4;
          //same as $a += 4;
          echo "<br>";
          echo $a;
          echo "<br>";
          echo "<br>";

          //comparison operator

          echo "//comparison operators";
          echo "<br>";
          $d = 2;
          $e = 4;
          if ($d == $e){
            echo "This statement is true";
          }
          else {
            echo "The statement is false";
          }
          echo "<br>";
          echo "<br>";

          // kapag == kapag equal kahit string ung isa, === kapag pati data type ay tinetest, != for "not true", !== not equal and not same datatype
          //standard greater than and less than > <

          //logical operators
          echo "//logical operators";
          echo "<br>";

          $f = 4;
          $g = 4;
          $h = 7;
          $i = 6;
          if ($f == $g and $h == $i){
            echo "They are equal, logical operators";
          }
          else {
            echo "They are NOT equal, logical operators";
          }

          echo "<br>";

          if ($f == $g or $h == $i){
            echo "We are using the OR OPERATOR, one of them is equal";
          }
          else {
            echo "we are using or operator";
          }
          echo "<br>";
          // can also use || for OR and && for and just like C# and javascript

          //incrementing and decrementing operators

          echo "<br>";
          echo "incrementing and decrementing operators";
          echo "<br>";
          $j = 5;
          $k = 5;
          echo "From base of 5";
          echo "<br>";
          echo "This is for ++ : ";
          echo ++$j;
          echo "<br>";
          echo "This is for -- : ";
          echo --$k;
          echo "<br>";
          //if we do $j++, and we echo, we output the original first then add increment as it goes in back 





          ?>

          <script>
            alert('EXPERIMENT IN COMBINATION WITH JAVA');

          </script>
        </div>
        </div>
    
  </body>

</html>