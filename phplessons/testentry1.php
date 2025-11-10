
<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>TEST ENTRY PAGE</title>
		<link rel="stylesheet" href="../capstonedashboard.css">
    <link rel="stylesheet" href="../css/cssmain4.css"> 
    <!--<link rel="stylesheet" href="css/cssreset4.css">-->
		<!--removed temporarily the cssreset4.css as it is destroying something-->
		
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

    <div class='Home_container'>
				<div class='Home_content'>

          <h3>TEST ENTRY</h3>

          <form action="../includes/entryhandler.inc.php" method="post">
              <textarea name="entry1" placeholder="Type your entry here..." required>
							</textarea>
              <button>Submit Entry</button>
          </form>

        </div>
      </div>

    <?php

    ?>

  </body>
</html>