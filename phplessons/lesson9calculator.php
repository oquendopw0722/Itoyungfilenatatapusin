<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>CALCULATORS</title>
		<link rel="stylesheet" href="../capstonedashboard.css">
		<link rel="stylesheet" href="../css/mainform6.css">
		<link rel="stylesheet" href="../css/resetform6.css">
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
				<h3><b>CALCULATOR</b></h3>  
				<main>
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> 
						<input type="number" name="num1" placeholder="enter your 1st input...">
						<select name="operator">
							<option value="add">+</option>
							<option value="subtract">-</option>
							<option value="multiply">*</option>
							<option value="divide">/</option>
						</select>
						<input type="number" name="num2" placeholder="enter your 2nd input...">
						<button>CALCULATE</button>
					</form>
				</main>

					<?php 
					if ($_SERVER["REQUEST_METHOD"] == "POST") {
						//grab data to process to php
						$num1 = filter_input(INPUT_POST, "num1", FILTER_SANITIZE_NUMBER_FLOAT); //data sanitation
						$num2 = filter_input(INPUT_POST, "num2", FILTER_SANITIZE_NUMBER_FLOAT); //data sanitation
						$operator = htmlspecialchars($_POST["operator"]);   //data sanitation for string

						//ERROR HANDLERS
						$errors = false;

						if (empty($num1) || empty($num2) || empty($operator)) {
							echo "<p class='calc-error'> fill in all fields!</p>";
							$errors = true;
						}

						if (!is_numeric($num1) || !is_numeric($num2)) {
							echo "<p class='calc-error'> Can't calculate that! Please enter numbers only</p>";
							$errors = true;
						}

						//CALCULATION PART
						if (!$errors) {
							$value = 0;
							switch ($operator) {
								case "add":
									$value = $num1 + $num2;
									break;
								case "subtract":
									$value = $num1 - $num2;
									break;
								case "multiply":
									$value = $num1 * $num2;
									break;
								case "divide":
									$value = $num1 / $num2;
									break;
								default: 
									echo "<p class='calc-error'> Something Went Wrong! try again or refresh</p>";
							}

						echo "<p class='calc-result'>Result = " . $value . " </p>";
						}

					}

					?>
			</div>
		</div>
			

  </body>

</html>