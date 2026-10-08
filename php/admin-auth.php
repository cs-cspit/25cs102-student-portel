<?php
/**
 * StudentHub - Administrator Authentication Guard (Practical 10)
 */
require_once __DIR__ . '/auth.php';

if (!isAuthenticated()) {
    header("Location: ../login.html?error=admin_login_required");
    exit;
}

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: ../dashboard.php?error=forbidden_admin_access");
    exit;
}
?>
