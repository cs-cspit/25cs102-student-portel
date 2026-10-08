<?php
/**
 * StudentHub - Secure MySQL Database Connection & Query Helpers (Practical 08)
 * Configures MySQLi connection with utf8mb4 charset and prepared statement helper.
 */

// Database Credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'studenthub');
define('DB_PORT', 3306);

// Enable mysqli exceptions for clean error handling
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    // Log error internally; do NOT expose sensitive database passwords to end-users
    error_log("Database Connection Error: " . $e->getMessage());
    
    // In production/academic demo, define a safe fallback
    $db_connected = false;
    $db_error = "Unable to connect to the database. Please ensure MySQL is running in XAMPP.";
}

if (!isset($db_connected)) {
    $db_connected = true;
    $db_error = null;
}

/**
 * Execute a secure Prepared Statement query
 * @param mysqli $conn Active database connection
 * @param string $sql Parameterized SQL query with '?' placeholders
 * @param string $types Data types string ('s', 'i', 'd', 'b')
 * @param array $params Array of parameters to bind
 * @return mysqli_result|bool
 */
function executeQuery($conn, $sql, $types = "", $params = []) {
    try {
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Query preparation failed: " . $conn->error);
        }

        if (!empty($types) && !empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result !== false ? $result : true;
    } catch (Exception $e) {
        error_log("SQL Execution Exception: " . $e->getMessage());
        return false;
    }
}

/**
 * Audit log helper function
 */
function logAuditEvent($conn, $userId, $action, $entity, $entityId, $details = "") {
    if (!$conn) return false;
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $sql = "INSERT INTO audit_logs (user_id, action, entity, entity_id, ip_address, details) VALUES (?, ?, ?, ?, ?, ?)";
    return executeQuery($conn, $sql, "ississ", [$userId, $action, $entity, $entityId, $ip, $details]);
}
?>
