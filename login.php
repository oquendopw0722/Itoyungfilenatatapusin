<?php
session_start();

// --- 1. Database Connection (Good for development, see note on error handling) ---
$conn = new mysqli("localhost", "root", "", "myfirstdatabase");

if ($conn->connect_error) {
    // In a production environment, you should log the error 
    // and show a generic message to the user for security.
    die("Connection failed: " . $conn->connect_error); 
}

// --- 2. Input Validation and Retrieval ---
// Ensure the inputs exist and sanitize them (though prepared statements are the main guard)
//if (!isset($_POST['username'], $_POST['pwd'])) {
   // echo "<script>alert('Please enter both username and password!'); window.location.href='index.html';</script>";
   // exit();
//}

$username = $_POST['username'];
$password = $_POST['pwd']; // The raw, plain-text password

// --- 3. Securely Fetch the Stored Password Hash and Role (Using Prepared Statements) ---
// Updated: Also fetch role and check status
$stmt = $conn->prepare("SELECT pwd, role FROM users WHERE username = ? AND status = 'active'");

if (!$stmt) {
    // Handle error in statement preparation
    die("Prepare failed: " . $conn->error);
}

// 's' means the variable is a string
$stmt->bind_param("s", $username); 
$stmt->execute();
$result = $stmt->get_result();

// --- 4. Password Verification ---
if ($result->num_rows === 1) {
    // Fetch the row
    $row = $result->fetch_assoc();
    // The stored hash is in $row['pwd'], role in $row['role']
    $stored_hash = $row['pwd']; 
    $user_role = $row['role'];

    // **CRITICAL:** Use password_verify() to compare the user's password 
    // against the stored hash.
    if (password_verify($password, $stored_hash)) {
        // Success! The password is correct
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user_role;  // Store role for role-based access
        // Check if the hash needs to be rehashed (e.g., if you change the cost)
        // This is a good practice for long-term security.
        if (password_needs_rehash($stored_hash, PASSWORD_BCRYPT, ['cost' => 12])) {
            $new_hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            // Update the user's password in the database with the new hash here
            // (You'd need another prepared statement for the UPDATE query)
        }
        
        header("Location: dashboard3.php");  // Updated: Redirect to the role-based dashboard page
        exit();
    } else {
        // Invalid password
        $login_success = false;
    }
} else {
    // Invalid username, password, or account inactive/deactivated
    $login_success = false;
}

// --- 5. Final Output and Cleanup ---
$stmt->close();
$conn->close();

if (!isset($login_success) || !$login_success) {
    // Use a generic error message for security (don't say 'username is fine, password is wrong' or 'account deactivated')
    echo "<script>alert('Invalid username or password!'); window.location.href='index.html';</script>";
    exit();
}

?>