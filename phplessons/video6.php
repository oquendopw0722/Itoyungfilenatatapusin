<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lesson 6</title>
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
          <main>
            <form action="formhandler.php" method="post">
              <label for="firstname">Firstname?</label>
              <input required id="firstname" type="text" name="firstname" placeholder="Firstname...">

              <label for="lastname">Lastname?</label>
              <input required id="lastname" type="text" name="lastname" placeholder="Lastname...">

              <label for="favouritepet">Favourite Pet?</label>
              <select id="favouritepet" name="favouritepet">
                <option value="none">None</option>
                <option value="dog">Dog</option>
                <option value="cat">Cat</option>
                <option value="bird">Bird</option>
              </select>

              <button type="submit">Submit</button>
            </form>
          </main>
        </div>
      </div>

</body>

</html>