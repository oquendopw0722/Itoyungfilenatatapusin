
<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lesson 16 Database</title>
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

    	echo "<div class='Home_container'>";
				echo "<div class='Home_content'>";
          echo "<p style='font-size: 25px'><b>DATABASES?</b></p>";

					echo "<p>Lesson 16 introduction....DONE</p>";
					echo "localhost/phpmyadmin <br>";

					echo "<p>Lesson 17......DONE</p>";
					echo "INT(11) ---  4,294,967,295 unsigned <br>";
					echo "BIGINT --- 18,446,744,073,709,551,615 unsigned <br>";
					echo "FLOAT <br>";
					echo "DOUBLE <br>";
					echo "<br>";
					echo "VARCHAR(10) --- set number of characters <br>";
					echo "VARCHAR(255) - max? <br>";
					echo "TEXT <br>";
					echo "<br>";
					echo "DATE  2023-05-14 ----year, month, day is the default <br>";
					echo "DATETIME  2023-05-14 17:30:00----date plus hour-minute-second and also in 24 hour format<br>";
					echo "<br>";
					echo "signed and unsigned <br>";
					echo "INT(11) UNSIGNED will only be positive numbers <br>";
					echo "INT(11) SIGNED will have both negative to positive <br>";

					/*
					CREATE TABLE users (
					id INT(11) NOT NULL AUTO_INCREMENT,
					username VARCHAR(30) NOT NULL,
					pwd VARCHAR(255) NOT NULL,
					email VARCHAR(100) NOT NULL,
					created_at DATE NOT NULL DEFAULT CURRENT_TIME,
					PRIMARY KEY (id)
					);
					
					*/ 

					/* another sample- 2nd table
					CREATE TABLE comments (
						id INT(11) NOT NULL AUTO_INCREMENT,
						username VARCHAR(30) NOT NULL,
						comment_text TEXT NOT NULL,
						created_at DATETIME NOT NULL DEFAULT CURRENT_TIME,
						users_id INT(11),
						PRIMARY KEY (id),
						FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE SET NULL
					); 

					*/

					echo "<p>CREATE TABLE</p>";
					echo "PRIMARY KEY<br>";
					echo "FOREIGN KEY<br>";
				echo "</div>";
			echo "</div>";

			echo "<div class='Home_container'>";
				echo "<div class='Home_content'>";
					echo "<p>Lesson 18......DONE</p>";
					echo "INSERTING, DELETING AND UPDATING DATA<br>";
					echo "<br>";

					echo "'INSERT INTO'<br>";
					echo "<br>";

					//insert into the 1st table
					// INSERT INTO users (username, pwd, email)VALUES('cajachan', 'pass1234', 'johndoe1@kmail.com');

					//insert into the 2nd table
					//INSERT INTO comments (username, comment_text, users_id)VALUES('cajachan', 'Hello, this is okay, the website is still in progress', 1);

					echo "'UPDATE'<br>";
					echo "<br>";

					// UPDATE users SET username = 'BasseIsCool', pwd = 'basse456' WHERE id = 2

					//another example:
					// UPDATE users SET username = 'BasseIsCool', pwd = 'basse456' WHERE username = 'BasseIs' OR email ='sample@sample.com'

					echo "DELETING <br>";
					echo "<br>";

					//DELETE FROM users WHERE id = 3;

					echo "<p>====================================================</p>";
					echo "<p>Lesson 19......DONE</p>";

					echo "SELECTING <br>";
					echo "<br>";

					//1st example
					//SELECT username, email FROM users WHERE id = 4;   //select columns from table_name where condition for picking/selecting

					//2nd example
					//SELECT * FROM users;   //for all related
					//SELECT * FROM users WHERE id = 2;    // all related to that id.

					echo "JOINING <br>";
					echo "<br>";

					//1st example
					//SELECT * FROM users INNER JOIN comments ON users.id = comments.users_id;

					//2nd example -- selecting specific data
					//SELECT users.username, comments.comment_text, comments.created_at FROM users INNER JOIN comments on users.id = comments.users_id;

					//3rd example - left join
					//kapag left join, kahit walang laman yung nagjjoin, lalabas siya
					//SELECT * FROM users LEFT JOIN comments ON users.id = comments.users_id;

					//4th example - right join
					//ang mag gogovern is yung right which on this case is si comments table
					//SELECT * FROM users RIGHT JOIN comments ON users.id = comments.users_id;


					echo "<p>====================================================</p>";
					echo "<p>Lesson 20......in progress</p>";

					echo "CONNECTING <br>";
					echo "<br>";


				echo "</div>";
			echo "</div>";

    ?>
  </body>
</html>