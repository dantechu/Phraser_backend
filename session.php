<?php
// Start output buffering
ob_start();

// Define custom session directory
$customSessionPath = __DIR__ . '/sessions';
if (!is_dir($customSessionPath)) {
    mkdir($customSessionPath, 0777, true);
}
ini_set('session.save_path', $customSessionPath);

// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set time for session timeout
$currentTime = time() + 25200; // GMT +7 offset (adjust if needed)
$expired = 86400; // 24 hours

// If session not set, go to login page
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// If current time is more than session timeout, back to login page
if ($currentTime > ($_SESSION['timeout'] ?? 0)) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Refresh session timeout
$_SESSION['timeout'] = $currentTime + $expired;
?>
