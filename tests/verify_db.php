<?php
require_once __DIR__ . '/../php/db.php';

echo "=== DATABASE & AUTH VERIFICATION ===" . PHP_EOL;
echo "Connection Status: " . ($db_connected ? "CONNECTED" : "FAILED") . PHP_EOL;

if (!$db_connected) {
    exit(1);
}

// 1. Verify Admin Auth
$stmt = $conn->prepare("SELECT email, password, role FROM users WHERE email = ? LIMIT 1");
$adminEmail = "admin@studenthub.edu";
$stmt->bind_param("s", $adminEmail);
$stmt->execute();
$adminUser = $stmt->get_result()->fetch_assoc();

if ($adminUser && password_verify("Admin@123", $adminUser['password'])) {
    echo "Admin Authentication (admin@studenthub.edu / Admin@123): PASS" . PHP_EOL;
} else {
    echo "Admin Authentication: FAIL" . PHP_EOL;
}

// 2. Verify Student Auth
$studentEmail = "25cs102@charusat.edu.in";
$stmt->bind_param("s", $studentEmail);
$stmt->execute();
$studentUser = $stmt->get_result()->fetch_assoc();

if ($studentUser && password_verify("Student@123", $studentUser['password'])) {
    echo "Student Authentication (25cs102@charusat.edu.in / Student@123): PASS" . PHP_EOL;
} else {
    echo "Student Authentication: FAIL" . PHP_EOL;
}

// 3. Verify Counts
$stCount = $conn->query("SELECT COUNT(*) as c FROM students")->fetch_assoc()['c'];
$evCount = $conn->query("SELECT COUNT(*) as c FROM events")->fetch_assoc()['c'];
$rgCount = $conn->query("SELECT COUNT(*) as c FROM registrations")->fetch_assoc()['c'];
$lgCount = $conn->query("SELECT COUNT(*) as c FROM audit_logs")->fetch_assoc()['c'];

echo "Students Count in DB: " . $stCount . " (>= 20 Required: " . ($stCount >= 20 ? "PASS" : "FAIL") . ")" . PHP_EOL;
echo "Events Count in DB: " . $evCount . " (>= 16 Required: " . ($evCount >= 16 ? "PASS" : "FAIL") . ")" . PHP_EOL;
echo "Registrations Count in DB: " . $rgCount . PHP_EOL;
echo "Audit Logs Count in DB: " . $lgCount . PHP_EOL;
echo "=====================================" . PHP_EOL;
