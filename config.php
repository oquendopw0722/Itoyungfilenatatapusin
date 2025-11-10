<?php

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
  'lifetime' => 900, //900 seconds - 15 minutes
  'domain' => 'localhost', // change this to the domain, capstonebcgoscas26.online
  'path' => '/',
  'secure' => true,
  'httponly' => true

]);

session_start();


/*
// Check if the session has been marked as obsolete
if (isset($_SESSION['is_obsolete']) && $_SESSION['is_obsolete']) {
    // Save the active session data for investigation or logging purposes
    // All session data is stored as an array
    $activeSessionData = $_SESSION;

    // Destroy the session and create a new one
    session_destroy();
    session_start();

    // Clear any remaining session data
    session_unset();

    // Mark the new session as fresh and not obsolete
    $_SESSION['is_obsolete'] = false;

    // Forcefully log out the user from all sessions, requiring reauthentication
    // Perform any additional actions required in this scenario
}

// ---REGENERATE THE SESSION ID TO MAKE IT STRONGER---

// Generates a new session ID based on the existing one. It doesn't create a new session ID.

// To minimize the risk of session fixation attacks, it's recommended to regenerate session IDs periodically or whenever a user's privilege level changes. A session ID can be changed using session_regenerate_id(true), which also creates a stronger session ID than the default one.

// Here is a way to make sure the session ID gets updated automatically every 30min:

// Check if the last session regeneration timestamp exists
if (!isset($_SESSION['last_regeneration'])) {
    // First-time regenerating the session ID, to make it more secure
    session_regenerate_id(true);

    // First-time initialization of the last session regeneration timestamp
    $_SESSION['last_regeneration'] = time();
} else {
    // Check if the specified time interval has passed (e.g., 30 minutes)
    $interval = 60 * 30; // 30 minutes in seconds
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        // Regenerate the session ID
        session_regenerate_id(true);

        // Update the last session regeneration timestamp
        $_SESSION['last_regeneration'] = time();
    }
}
    */