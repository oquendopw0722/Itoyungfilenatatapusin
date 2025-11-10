<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../capstonedashboard.css">
    <link rel="stylesheet" href="../css/cssreset2.css">
    <link rel="stylesheet" href="../css/cssmain2.css">
    <title>Update and Delete Test</title>
</head>

<body>

    <div class="Topbar">
        <div class = "LogonTitle">
            <a href="../index.html">
            <img class="Antipolo" src="../blue1.png"></a>
            <h1 class="TopbarTitle"><a style="text-decoration: none" href="../index.html">CAPSTONE TRIAL</a></h1>
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

    <h3>Change account</h3>

    <form action="../includes/userupdate.inc.php" method="post">
        <input required type="text" name="username" placeholder="Username">
        <input required type="password" name="pwd" placeholder="Password">
        <input required type="text" name="email" placeholder="E-Mail">
        <button>Update</button>
    </form>

    <h3>Delete account</h3>

    <form action="../includes/userdelete.inc.php" method="post">
        <input required type="text" name="username" placeholder="Username">
        <input required type="password" name="pwd" placeholder="Password">
        <button>Delete</button>
    </form>

</body>

</html>