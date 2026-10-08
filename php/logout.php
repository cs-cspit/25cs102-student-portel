<?php
/**
 * StudentHub - Secure Session Destruction & Logout Handler (Practical 10)
 */

require_once __DIR__ . '/auth.php';

if (isset($_SESSION['user_id']) && $db_connected && isset($conn)) {
    logAuditEvent($conn, $_SESSION['user_id'], "USER_LOGOUT", "users", $_SESSION['user_id'], "User signed out successfully.");
}

// Unset all session variables
$_SESSION = [];

// Delete session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Clear remember me cookie
setcookie("studenthub_remember", "", time() - 3600, "/");

// Destroy session
session_destroy();

// Redirect to login with status
header("Location: ../login.html?status=logged_out");
exit;
?>
