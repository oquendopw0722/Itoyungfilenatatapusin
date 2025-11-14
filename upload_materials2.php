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

// Role check
$query = "SELECT id, role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user || !in_array($user['role'], ['teacher', 'admin'])) {
    header("Location: unauthorized.php");
    exit();
}
$uploaded_by = $user['id'];

// Handle upload
$message = '';
$message_type = ''; // 'success' or 'error'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $file = $_FILES['file'];

    // Validate file type based on MIME (better than extension check)
    $allowed_types = [
        'application/pdf' => 'pdf',
        'video/mp4' => 'mp4',
        'video/x-msvideo' => 'avi'
    ];
    $file_mime = $file['type'];
    $file_ext = $allowed_types[$file_mime] ?? false;

    // Validate
    if (!$file_ext || $file['size'] > 100 * 1024 * 1024) {  // 100MB limit
        $message = 'Invalid file type or the file size exceeds 100MB. Only PDF, MP4, and AVI are allowed.';
        $message_type = 'error';
    } elseif (empty($title)) {
        $message = 'Title is required.';
        $message_type = 'error';
    } else {
        // Save file
        $upload_dir = 'uploads/';
        // Ensure the directory exists
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        // Generate a unique, safe filename using uniqid and sanitizing the original name
        $original_filename = pathinfo($file['name'], PATHINFO_FILENAME);
        $safe_filename = preg_replace("/[^a-zA-Z0-9\-\.]/", "_", $original_filename);
        $file_path = $upload_dir . uniqid() . '_' . $safe_filename . '.' . $file_ext;

        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            // Save to DB
            // NOTE: The stored file_path includes 'uploads/'
            $stmt = $conn->prepare("INSERT INTO learning_materials (title, description, file_path, file_type, uploaded_by) VALUES (?, ?, ?, ?, ?)");
            // Use the file extension ($file_ext) for the file_type column
            $stmt->bind_param("ssssi", $title, $description, $file_path, $file_ext, $uploaded_by);

            if ($stmt->execute()) {
                $message = 'Material uploaded successfully! You can view it now in the View Learning Materials section.';
                $message_type = 'success';
            } else {
                // File uploaded but DB insert failed
                unlink($file_path); // Clean up the uploaded file
                $message = 'Database error: Could not record the upload.';
                $message_type = 'error';
            }
        } else {
            $message = 'Upload failed. Check server permissions.';
            $message_type = 'error';
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Upload Learning Materials</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css2/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General Layout */
        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }

        .Home_container {
            margin-left: 250px;
            padding: 2rem;
        }

        .sidebar {
            top: 120px !important;
            height: calc(100vh - 120px) !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        /* Form Container Styles */
        .upload-form-container {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            max-width: 600px;
            /* Keep the form manageable */
        }

        h2 {
            padding-bottom: 5px;
        }

        /* Form Elements */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* File Input Styling (needs specific styling for browser compatibility) */
        input[type="file"] {
            padding: 8px;
            /* Slightly less padding */
            border: 1px dashed #4CAF50;
            background-color: #f9fff9;
        }

        /* Button Styling */
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Message Styling */
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .message.success {
            background-color: #e6ffe6;
            /* Light Green */
            color: #28a745;
            /* Dark Green Text */
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            /* Light Red */
            color: #dc3545;
            /* Dark Red Text */
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
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
        <p class="TopbarLineText">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
    </div>

    <?php include('includes/teacher_sidebar.php'); ?>

    <div class="Home_container">
        <div class="upload-form-container">
            <h2><i class="fas fa-cloud-upload-alt"></i> Upload Learning Materials</h2>

            <?php if ($message): ?>
                <p class="message <?php echo $message_type; ?>">
                    <?php if ($message_type == 'success'): ?>
                        <i class="fas fa-check-circle"></i>
                    <?php else: ?>
                        <i class="fas fa-exclamation-triangle"></i>
                    <?php endif; ?>
                    <?php echo htmlspecialchars($message); ?>
                </p>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Title <span style="color:red">*</span></label>
                    <input type="text" id="title" name="title" required placeholder="e.g., Week 1 Reading Comprehension" maxlength="255">
                </div>

                <div class="form-group">
                    <label for="description">Description (Optional)</label>
                    <textarea id="description" name="description" placeholder="A brief summary of the material content."></textarea>
                </div>

                <div class="form-group">
                    <label for="file">File (PDF, MP4, or AVI) <span style="color:red">*</span></label>
                    <input type="file" id="file" name="file" accept=".pdf, .mp4, .avi" required>
                    <small style="color:#777; margin-top:5px;">Max file size: 100MB</small>
                </div>

                <button type="submit">
                    <i class="fas fa-upload"></i> Upload Material
                </button>
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