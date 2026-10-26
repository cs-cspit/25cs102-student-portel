<?php
/**
 * StudentHub - Unified Authentication & Role-Based Access Control Middleware (Practical 10 & 15)
 * Manages PHP Session lifecycle, session fixation defense, inactivity timeouts,
 * CSRF token generation/verification, login rate limiting, and role checks.
 */

if (session_status() === PHP_SESSION_NONE) {
    // Secure session cookie settings (Practical 15 security hardening)
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

/**
 * CSRF Protection: Generate or return existing CSRF token
 */
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * CSRF Protection: Verify submitted CSRF token
 */
function verifyCsrfToken($token) {
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Login Throttling: Check rate limit for IP/email
 */
function checkLoginRateLimit($key, $maxAttempts = 5, $lockoutSeconds = 60) {
    $now = time();
    if (!isset($_SESSION['rate_limits'])) {
        $_SESSION['rate_limits'] = [];
    }

    if (isset($_SESSION['rate_limits'][$key])) {
        $data = $_SESSION['rate_limits'][$key];
        if ($data['attempts'] >= $maxAttempts) {
            $elapsed = $now - $data['last_attempt'];
            if ($elapsed < $lockoutSeconds) {
                return [
                    'allowed' => false,
                    'wait_seconds' => $lockoutSeconds - $elapsed
                ];
            } else {
                // Lockout period expired; reset counter
                $_SESSION['rate_limits'][$key] = ['attempts' => 0, 'last_attempt' => $now];
            }
        }
    }
    return ['allowed' => true, 'wait_seconds' => 0];
}

/**
 * Login Throttling: Record failed attempt
 */
function recordFailedLoginAttempt($key) {
    $now = time();
    if (!isset($_SESSION['rate_limits'])) {
        $_SESSION['rate_limits'] = [];
    }
    if (!isset($_SESSION['rate_limits'][$key])) {
        $_SESSION['rate_limits'][$key] = ['attempts' => 1, 'last_attempt' => $now];
    } else {
        $_SESSION['rate_limits'][$key]['attempts']++;
        $_SESSION['rate_limits'][$key]['last_attempt'] = $now;
    }
}

/**
 * Login Throttling: Clear attempts on successful authentication
 */
function resetLoginRateLimit($key) {
    if (isset($_SESSION['rate_limits'][$key])) {
        unset($_SESSION['rate_limits'][$key]);
    }
}
?>
