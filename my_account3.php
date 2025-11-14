<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "myfirstdatabase");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data
$query = "SELECT pwd FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user) {
    header("Location: unauthorized.php");
    exit();
}
$current_hash = $user['pwd'];

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_pwd = $_POST['current_pwd'];
    $new_pwd = $_POST['new_pwd'];
    $confirm_pwd = $_POST['confirm_pwd'];

    if (!password_verify($current_pwd, $current_hash)) {
        $message = 'Current password is incorrect.';
    } elseif ($new_pwd !== $confirm_pwd) {
        $message = 'New passwords do not match.';
    } elseif (strlen($new_pwd) < 8) {
        $message = 'New password must be at least 8 characters long.';
    } else {
        // Hash new password and update
        $new_hash = password_hash($new_pwd, PASSWORD_BCRYPT, ['cost' => 12]);
        $update_query = "UPDATE users SET pwd = ? WHERE username = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ss", $new_hash, $_SESSION['username']);
        $stmt->execute();
        $message = 'Password changed successfully!';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Account</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css2/dashboard.css">

    <style>
        /* ---------------------------------------------------- */
        /* 1. Base Layout & Sidebar Fixes */
        /* ---------------------------------------------------- */
        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }

        /* Apply the standard fixed sidebar position */
        .sidebar {
            position: fixed;
            top: 120px !important;
            height: calc(100vh - 120px) !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        /* Adjust main content to start below Topbar and next to sidebar */
        .Home_container {
            margin-left: 250px;
            /* Assuming sidebar width is 230px */
            padding: 2rem;
            /* Push content down below sticky Topbar */
            min-height: 100vh;
        }

        /* ---------------------------------------------------- */
        /* 2. Form Styling */
        /* ---------------------------------------------------- */

        h2 {
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 2rem;
            font-weight: 600;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: 600;
            color: #555;
            margin-top: 5px;
            display: block;
            /* Ensure label takes full width */
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input[type="password"]:focus {
            border-color: #4CAF50;
            /* Green focus color */
            outline: none;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        /* Submit Button */
        button[type="submit"] {
            background-color: #4CAF50;
            /* Green submit button */
            color: white;
            border: none;
            padding: 15px;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
            margin-top: 20px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
            transform: translateY(-1px);
        }

        /* ---------------------------------------------------- */
        /* 3. Message Display (Success/Error) */
        /* ---------------------------------------------------- */
        .success-message {
            background-color: #e6ffed;
            color: #2d6a4f;
            border: 1px solid #b7e4c7;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: 500;
            text-align: center;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: 500;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Reuse your topbar and sidebar -->
    <div class="Topbar">
        <img class="Antipolo" src="pictures/ANTIPOLO.png">
        <h1 class="TopbarTitle1">GOLD: &nbsp; </h1>
        <h1 class="TopbarTitle2"> DXXXX daycare center</h1>
        <nav class="navbar">
            <ul>
                <li><a href="home1.php">Home</a></li>
                <li><a href="dashboard3.php">Dashboard</a></li>
                <li><a href="extra.php">Old Website</a></li>
            </ul>
        </nav>
        <a href="learning.html" class="cta-btn">Learn</a>
    </div>
    <div class="Topbarline">
        <p class="TopbarLineText">Welcome, <?php echo $_SESSION['username']; ?></p>
    </div>


    <?php include('includes/parent_sidebar.php'); ?>

    <div class="Home_container">
        <div class="Home_content">
            <h2>Change Password</h2>
            <?php if ($message): ?>
                <?php
                $message_class = strpos($message, 'success') !== false ? 'success-message' : 'error-message';
                ?>
                <p class="<?php echo $message_class; ?>"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <form method="POST">
                <label>Current Password:</label>
                <input type="password" name="current_pwd" required><br>
                <label>New Password (min 8 chars):</label>
                <input type="password" name="new_pwd" required><br>
                <label>Confirm New Password:</label>
                <input type="password" name="confirm_pwd" required><br>
                <button type="submit">Change Password</button>
            </form>
        </div>
    </div>

    <img src="pictures/LOicon.png" alt="Logout" class="logout" onclick="confirmLogout()">
    <script>
        function confirmLogout() {
            const confirmAction = confirm("Are you sure you want to log out?");
            if (confirmAction) {
                window.location.href = "logout.php";
            }
        }
    </script>
</body>

</html>