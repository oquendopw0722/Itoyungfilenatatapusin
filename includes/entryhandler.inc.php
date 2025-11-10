<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entry1 = $_POST['entry1'];

    try {
        require_once "dhc.inc.php";

        $query = "INSERT INTO test1 (user_entry) VALUES (:entry1)";

        // Prepare the statement
        $stmt = $pdo->prepare($query);

        // Bind values to placeholders
        $stmt->bindParam(':entry1', $entry1);

        // Execute the statement
        $stmt->execute();

        /*
        // Not using named parameters

        $query = "INSERT INTO users (username, pwd, email) VALUES (?, ?, ?)";

        $stmt = $pdo->prepare($query);

        $stmt->execute([$username, $pwd, $email]);
        */

        // Send the user back to the front page
        header("Location: ../phplessons/afterentry1.html");

        // Close the connection and statement
        $pdo = null;
        $statement = null;

        die();
    } catch (PDOException $e) {
        die('Query failed: ' . $e->getMessage());
    }
}
