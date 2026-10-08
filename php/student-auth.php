<?php
/**
 * StudentHub - Student Authentication Guard (Practical 10)
 */
require_once __DIR__ . '/auth.php';

if (!isAuthenticated()) {
    header("Location: login.html?error=session_expired");
    exit;
}

if ($_SESSION['user_role'] !== 'student') {
    header("Location: admin/index.php");
    exit;
}
?>
