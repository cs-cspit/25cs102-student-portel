<?php
/**
 * StudentHub - Local Test Session Initializer (For Automated QA & Screenshots)
 * Strictly restricted to localhost (127.0.0.1 / ::1)
 */

if (!in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'])) {
    http_response_code(403);
    die("Access denied: Local testing only.");
}

require_once __DIR__ . '/../php/auth.php';

$role = $_GET['role'] ?? 'admin';
$target = $_GET['target'] ?? '';

session_regenerate_id(true);

if ($role === 'admin') {
    $_SESSION['user_id'] = 1;
    $_SESSION['user_name'] = "Admin (Dhara Ma'am)";
    $_SESSION['user_email'] = "admin@studenthub.edu";
    $_SESSION['user_role'] = "admin";
    $_SESSION['last_activity'] = time();

    if ($target === 'students') {
        header("Location: ../admin/students.php");
    } elseif ($target === 'events') {
        header("Location: ../admin/events.php");
    } elseif ($target === 'registrations') {
        header("Location: ../admin/registrations.php");
    } elseif ($target === 'audit') {
        header("Location: ../admin/audit-logs.php");
    } else {
        header("Location: ../admin/index.php");
    }
    exit;
} elseif ($role === 'student') {
    $_SESSION['user_id'] = 2;
    $_SESSION['user_name'] = "Daksh Shah";
    $_SESSION['user_email'] = "25cs102@charusat.edu.in";
    $_SESSION['user_role'] = "student";
    $_SESSION['student_id'] = 1;
    $_SESSION['last_activity'] = time();

    if ($target === 'admin') {
        // Attempt forbidden access to trigger RBAC denial
        header("Location: ../admin/index.php");
    } elseif ($target === 'profile') {
        header("Location: ../profile.php");
    } else {
        header("Location: ../dashboard.php");
    }
    exit;
} else {
    header("Location: ../login.html");
    exit;
}
