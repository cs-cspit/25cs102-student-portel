<?php
/**
 * StudentHub - Unified Authentication & Role-Based Access Control Middleware (Practical 10)
 * Manages PHP Session lifecycle, session fixation defense, inactivity timeouts, and role checks.
 */

if (session_status() === PHP_SESSION_NONE) {
    // Secure session cookie settings
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Strict');
    session_start();
}

require_once __DIR__ . '/db.php';

// Session Inactivity Timeout Configuration (30 Minutes = 1800 Seconds)
define('SESSION_TIMEOUT', 1800);

/**
 * Check if the current user is authenticated
 */
function isAuthenticated() {
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        return false;
    }

    // Enforce Inactivity Timeout
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
        session_unset();
        session_destroy();
        return false;
    }

    // Refresh last activity timestamp
    $_SESSION['last_activity'] = time();
    return true;
}

/**
 * Get active user details array
 */
function getCurrentUser() {
    if (!isAuthenticated()) {
        return null;
    }

    return [
        'id' => $_SESSION['user_id'],
        'name' => $_SESSION['user_name'] ?? 'Student',
        'email' => $_SESSION['user_email'] ?? '',
        'role' => $_SESSION['user_role'] ?? 'student',
        'student_id' => $_SESSION['student_id'] ?? null
    ];
}

/**
 * Guard: Require Login (Redirect to login.html if not authenticated)
 */
function requireLogin($redirectPath = "../login.html") {
    if (!isAuthenticated()) {
        header("Location: " . $redirectPath . "?error=auth_required");
        exit;
    }
}

/**
 * Guard: Require Student Role
 */
function requireStudent($redirectPath = "../login.html") {
    requireLogin($redirectPath);
    if ($_SESSION['user_role'] !== 'student') {
        header("Location: " . $redirectPath . "?error=student_access_only");
        exit;
    }
}

/**
 * Guard: Require Administrator Role
 */
function requireAdmin($redirectPath = "../login.html") {
    requireLogin($redirectPath);
    if ($_SESSION['user_role'] !== 'admin') {
        header("Location: " . $redirectPath . "?error=admin_access_required");
        exit;
    }
}
?>
