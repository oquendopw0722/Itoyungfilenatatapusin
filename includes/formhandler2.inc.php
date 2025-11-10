<?php
session_start();  // For storing messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get inputs
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $pwd = $_POST['pwd'] ?? '';
    $confirm_pwd = $_POST['confirm_pwd'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $role = trim($_POST['role'] ?? '');  // Get from form

    // Validation
    $errors = [];
    if (empty($first_name) || empty($last_name) || empty($username) || empty($pwd) || empty($email) || empty($role)) {
        $errors[] = 'All required fields must be filled.';
    }
    if ($pwd !== $confirm_pwd) {
        $errors[] = 'Passwords do not match.';
    }
    if (strlen($pwd) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }
    $allowed_roles = ['parent', 'teacher', 'admin'];
    if (!in_array($role, $allowed_roles)) {
        $errors[] = 'Invalid role selected.';
    }

    if (!empty($errors)) {
        $_SESSION['signup_message'] = implode(' ', $errors);
        header("Location: ../phplessons/signup1.php");
        exit();
    }



    try {
        require_once "dhc.inc.php";  // Assumes this sets up $pdo

        // Check for duplicate username or email
        $checkQuery = "SELECT id FROM users WHERE username = :username OR email = :email";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindParam(':username', $username);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();
        if ($checkStmt->rowCount() > 0) {
            $_SESSION['signup_message'] = 'Username or email already exists.';
            header("Location: ../phplessons/signup1.php");
            exit();
        }

        // Hash password
        $options = ['cost' => 12];
        $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

        // Insert into updated table (note: column is 'password', not 'pwd')
        $query = "INSERT INTO users (username, pwd, email, role, first_name, last_name, phone) VALUES (:username, :pwd, :email, :role, :first_name, :last_name, :phone)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':pwd', $hashedPwd);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);

        $stmt->execute();

        // Success: Redirect to login
        $_SESSION['signup_message'] = 'Signup successful! You can now log in.';
        header("Location: ../phplessons/signup1.php");
        exit();

    } catch (PDOException $e) {
        // Log error internally and show user-friendly message
        error_log('Signup error: ' . $e->getMessage());
        $_SESSION['signup_message'] = 'Signup failed due to a server error. Please try again.';
        header("Location: ../phplessons/signup1.php");
        exit();
    }

    /*catch (PDOException $e) {
    $_SESSION['signup_message'] = 'Debug: ' . $e->getMessage();  // Remove after fixing
    header("Location: ../signup1.php");
    exit();
}*/


}
?>

