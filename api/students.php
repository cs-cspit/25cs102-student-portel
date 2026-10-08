<?php
/**
 * StudentHub - RESTful Students JSON API Endpoint (Practical 13)
 * Supports GET (list/search), POST (create), PUT (update), DELETE (delete)
 * Returns strict application/json with standard HTTP status codes.
 */

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../php/db.php';

$method = $_SERVER['REQUEST_METHOD'];

// Parse input payload for PUT/DELETE/POST JSON body
$rawInput = file_get_contents("php://input");
$inputData = json_decode($rawInput, true) ?: $_POST;

/**
 * Standard JSON Response Helper
 */
function sendJsonResponse($statusCode, $success, $message, $data = null, $errors = null) {
    http_response_code($statusCode);
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data,
        "errors" => $errors,
        "timestamp" => date("Y-m-d H:i:s")
    ], JSON_PRETTY_PRINT);
    exit;
}

// -------------------------------------------------------------
// GET: Retrieve all or single student with query filtering
// -------------------------------------------------------------
if ($method === 'GET') {
    $search = trim($_GET['q'] ?? '');
    $course = trim($_GET['course'] ?? '');
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;

    if ($id) {
        if ($db_connected && isset($conn)) {
            $stmt = $conn->prepare("SELECT id, name, email, mobile, course, year, gender, status, created_at FROM students WHERE id = ? LIMIT 1");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($row = $res->fetch_assoc()) {
                sendJsonResponse(200, true, "Student record retrieved successfully", $row);
            } else {
                sendJsonResponse(404, false, "Student record not found with ID #{$id}");
            }
        }
    }

    $students = [];
    if ($db_connected && isset($conn)) {
        $sql = "SELECT id, name, email, mobile, course, year, gender, status, created_at FROM students WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($search)) {
            $sql .= " AND (name LIKE ? OR email LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $types .= "ss";
        }

        if (!empty($course) && $course !== 'all') {
            $sql .= " AND course = ?";
            $params[] = $course;
            $types .= "s";
        }

        $sql .= " ORDER BY id ASC";

        if (!empty($params)) {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $res = $stmt->get_result();
        } else {
            $res = $conn->query($sql);
        }

        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $students[] = $row;
            }
        }
    } else {
        // Fallback JSON data
        $jsonFile = __DIR__ . '/../data/students.json';
        if (file_exists($jsonFile)) {
            $students = json_decode(file_get_contents($jsonFile), true) ?: [];
        }
    }

    sendJsonResponse(200, true, "Retrieved " . count($students) . " student records", $students);
}

// -------------------------------------------------------------
// POST: Create a new student record
// -------------------------------------------------------------
elseif ($method === 'POST') {
    $name = trim(strip_tags($inputData['name'] ?? ''));
    $email = trim(filter_var($inputData['email'] ?? '', FILTER_SANITIZE_EMAIL));
    $mobile = trim(strip_tags($inputData['mobile'] ?? ''));
    $course = trim(strip_tags($inputData['course'] ?? ''));
    $year = trim(strip_tags($inputData['year'] ?? '1st Year'));
    $gender = trim(strip_tags($inputData['gender'] ?? 'Male'));

    $errors = [];
    if (empty($name)) $errors['name'] = "Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Valid email is required.";
    if (empty($mobile) || !preg_match("/^[6-9]\d{9}$/", $mobile)) $errors['mobile'] = "10-digit Indian phone required.";
    if (empty($course)) $errors['course'] = "Department is required.";

    if (!empty($errors)) {
        sendJsonResponse(400, false, "Validation failed", null, $errors);
    }

    if ($db_connected && isset($conn)) {
        $check = executeQuery($conn, "SELECT id FROM users WHERE email = ? LIMIT 1", "s", [$email]);
        if ($check && $check->num_rows > 0) {
            sendJsonResponse(409, false, "Duplicate email error", null, ["email" => "Account with this email already exists"]);
        }

        $conn->begin_transaction();
        try {
            $passHash = password_hash("Student@123", PASSWORD_DEFAULT);
            $uStmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'student')");
            $uStmt->bind_param("sss", $name, $email, $passHash);
            $uStmt->execute();
            $userId = $conn->insert_id;

            $sStmt = $conn->prepare("INSERT INTO students (user_id, name, email, mobile, course, year, gender, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Active')");
            $sStmt->bind_param("issssss", $userId, $name, $email, $mobile, $course, $year, $gender);
            $sStmt->execute();
            $studentId = $conn->insert_id;

            logAuditEvent($conn, $userId, "API_STUDENT_CREATED", "students", $studentId, "Created via JSON API");
            $conn->commit();

            sendJsonResponse(201, true, "Student created successfully", [
                "id" => $studentId,
                "name" => $name,
                "email" => $email,
                "course" => $course,
                "year" => $year
            ]);
        } catch (Exception $e) {
            $conn->rollback();
            sendJsonResponse(500, false, "Database transaction failed: " . $e->getMessage());
        }
    } else {
        sendJsonResponse(201, true, "Student record received (offline mode)", $inputData);
    }
}

// -------------------------------------------------------------
// PUT: Update an existing student record
// -------------------------------------------------------------
elseif ($method === 'PUT') {
    $id = intval($inputData['id'] ?? 0);
    $name = trim(strip_tags($inputData['name'] ?? ''));
    $mobile = trim(strip_tags($inputData['mobile'] ?? ''));
    $course = trim(strip_tags($inputData['course'] ?? ''));
    $year = trim(strip_tags($inputData['year'] ?? ''));
    $status = trim(strip_tags($inputData['status'] ?? 'Active'));

    if ($id <= 0 || empty($name) || empty($mobile)) {
        sendJsonResponse(400, false, "Student ID, Name, and Mobile are required for update.");
    }

    if ($db_connected && isset($conn)) {
        $stmt = $conn->prepare("UPDATE students SET name = ?, mobile = ?, course = ?, year = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $mobile, $course, $year, $status, $id);
        if ($stmt->execute()) {
            logAuditEvent($conn, null, "API_STUDENT_UPDATED", "students", $id, "Updated via JSON API");
            sendJsonResponse(200, true, "Student ID #{$id} updated successfully", $inputData);
        } else {
            sendJsonResponse(500, false, "Failed to update database record.");
        }
    } else {
        sendJsonResponse(200, true, "Student ID #{$id} updated (offline mock)", $inputData);
    }
}

// -------------------------------------------------------------
// DELETE: Remove a student record
// -------------------------------------------------------------
elseif ($method === 'DELETE') {
    $id = intval($inputData['id'] ?? ($_GET['id'] ?? 0));

    if ($id <= 0) {
        sendJsonResponse(400, false, "Valid Student ID required for deletion.");
    }

    if ($db_connected && isset($conn)) {
        $res = executeQuery($conn, "SELECT user_id, name FROM students WHERE id = ? LIMIT 1", "i", [$id]);
        if ($res && $row = $res->fetch_assoc()) {
            $userId = $row['user_id'];
            if ($userId) {
                $del = $conn->prepare("DELETE FROM users WHERE id = ?");
                $del->bind_param("i", $userId);
                $del->execute();
            } else {
                $del = $conn->prepare("DELETE FROM students WHERE id = ?");
                $del->bind_param("i", $id);
                $del->execute();
            }
            logAuditEvent($conn, null, "API_STUDENT_DELETED", "students", $id, "Deleted via JSON API");
            sendJsonResponse(200, true, "Student ID #{$id} deleted successfully.");
        } else {
            sendJsonResponse(404, false, "Student ID #{$id} not found.");
        }
    } else {
        sendJsonResponse(200, true, "Student ID #{$id} deleted (offline mock).");
    }
}

// Fallback for unsupported methods
else {
    sendJsonResponse(405, false, "HTTP Method {$method} Not Allowed.");
}
?>
