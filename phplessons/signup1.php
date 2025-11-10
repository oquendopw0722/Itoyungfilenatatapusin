<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    
    <link rel="stylesheet" href="../css/cssmain1.css"> 
    <!--<link rel="stylesheet" href="../css/cssreset1.css">-->
    <!--<link rel="stylesheet" href="../capstonedashboard.css">-->
    <link rel="stylesheet" href="../css2/dashboard.css">
    <link rel="stylesheet" href="../css/style1.css">

    <style>

      .Home_container {
        margin-left: 240px;
      }

      .sidebar {
      margin-top: 102px;
      margin-bottom: 100px;
      overflow-y: scroll
      }

    </style>
      
</head>
<body>

    <div class="Topbar">
				<img class="Antipolo" src="../pictures/ANTIPOLO.png">
				<h1 class="TopbarTitle1">GOLD: &nbsp; </h1>
				<h1 class="TopbarTitle2"> DXXXX daycare center</h1>
				<nav class="navbar">
				<ul>
					<li><a href="../home1.php">Home</a></li>
					<li><a href="../dashboard3.php">Dashboard</a></li>
					<li><a href="../extra.php">Old Website</a></li>
				</ul>
      			</nav>
				<a href="../learning.html" class="cta-btn">Learn</a>
		</div>
        <!--
		<div class="Topbarline">
			<p class = "TopbarLineText">Welcome, <?php echo $_SESSION['username']; ?></p>
		</div>
        -->


    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="../admindashboard1.php">Dashboard</a>
        <a href="../admin_announcement.php">Post Announcement</a>
        <a href="../announcements_feed1.php">View Announcements</a>
        <a href="../calendar1.php">Calendar</a>
        <a href="../phplessons/signup1.php">Create Account</a>
        <a href="../upload_materials1.php">Upload Learning Materials</a>
        <a href="../view_materials1.php">View Learning Materials</a>
        <a href="../admin_deactivate.php">Account Deactivation</a>
        <a href="../archived_accounts.php">Archived Accounts</a>
        <a href="../my_account1.php">My Account</a>
        <a href="#">Class Management</a>
        <a href="#">Assignment and Quizzes</a>
        <a href="#">Student Progress</a>
        <a href="#">Communication</a>
        <a href="#">Calendar</a>
        <a href="#">Reports</a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
    </div>

    <div class='Home_container'>
        <div class='Home_content'>
            <h3>Create New Account</h3>
            <br>
            <br>
            <?php
            session_start();  // Start session for messages
            if (isset($_SESSION['signup_message'])) {
                echo '<p style="color: red;">' . htmlspecialchars($_SESSION['signup_message']) . '</p>';
                unset($_SESSION['signup_message']);
            }
            ?>
            <form action="../includes/formhandler2.inc.php" method="post">
                <input required type="text" name="first_name" placeholder="First Name">
                <input required type="text" name="last_name" placeholder="Last Name">
                <input required type="text" name="username" placeholder="Username">
                <input required type="password" name="pwd" placeholder="Password (min 8 chars)">
                <input required type="password" name="confirm_pwd" placeholder="Confirm Password">
                <input required type="email" name="email" placeholder="E-Mail">
                <label for="role">Role</label>
                <select required id="role" name="role">
                    <option value="">Select Role</option>
                    <option value="parent">Parent</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Admin</option>
                </select>
                <input type="tel" name="phone" placeholder="Phone (optional)">
                <button>Signup</button>
            </form>
            <br>
            <br>
            <p><a href="../index.html">Go Back To Login</a></p>
        </div>
    </div>

    <img src="../pictures/LOicon.png" alt="Logout" class="logout" onclick="confirmLogout()">
    <script>
        function confirmLogout() {
            const confirmAction = confirm("Are you sure you want to log out?");
            if (confirmAction) {
                window.location.href = "../logout.php";
            }
        }
    </script>
</body>
</html>