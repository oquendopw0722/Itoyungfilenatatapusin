<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>CALCULATORS</title>
		<link rel="stylesheet" href="../capstonedashboard.css">
	</head>
  <body>
    <main>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
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
  </body>
</html>