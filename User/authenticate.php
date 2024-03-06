<?php

// Start at the top of each page
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if authenticated
if (!isset($_SESSION['user_id']) && !in_array(basename($_SERVER['PHP_SELF']), ['login.php', 'registration.php'])) {
    // Redirect to the login page
    header("Location: /index.php");
    exit;
}
