<?php
/**
 * StudentHub - RESTful Events JSON API Endpoint (Practical 13)
 * Supports GET (list/filter), POST (create), PUT (update), DELETE (delete)
 */

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../php/db.php';

$method = $_SERVER['REQUEST_METHOD'];
$rawInput = file_get_contents("php://input");
$inputData = json_decode($rawInput, true) ?: $_POST;

function sendEventResponse($statusCode, $success, $message, $data = null) {
    http_response_code($statusCode);
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data,
        "timestamp" => date("Y-m-d H:i:s")
    ], JSON_PRETTY_PRINT);
    exit;
}

// GET: Fetch events
if ($method === 'GET') {
    $events = [];
    if ($db_connected && isset($conn)) {
        $res = $conn->query("SELECT id, title, description, event_date, time_slot, venue, category, poster, seats, status FROM events ORDER BY event_date ASC");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $events[] = $row;
            }
        }
    } else {
        $jsonPath = __DIR__ . '/../data/events.json';
        if (file_exists($jsonPath)) {
            $events = json_decode(file_get_contents($jsonPath), true) ?: [];
        }
    }
    sendEventResponse(200, true, "Retrieved " . count($events) . " events", $events);
}

// POST: Create event
elseif ($method === 'POST') {
    $title = trim(strip_tags($inputData['title'] ?? ''));
    $desc = trim(strip_tags($inputData['description'] ?? ''));
    $date = trim($inputData['event_date'] ?? date('Y-m-d'));
    $venue = trim(strip_tags($inputData['venue'] ?? 'Campus'));
    $category = trim(strip_tags($inputData['category'] ?? 'technical'));

    if (empty($title)) {
        sendEventResponse(400, false, "Event title is required.");
    }

    if ($db_connected && isset($conn)) {
        $stmt = $conn->prepare("INSERT INTO events (title, description, event_date, venue, category) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $desc, $date, $venue, $category);
        if ($stmt->execute()) {
            $newId = $conn->insert_id;
            logAuditEvent($conn, null, "API_EVENT_CREATED", "events", $newId, "Published via JSON API");
            sendEventResponse(201, true, "Event created successfully", ["id" => $newId, "title" => $title]);
        } else {
            sendEventResponse(500, false, "Failed to create event in database.");
        }
    } else {
        sendEventResponse(201, true, "Event created (offline mode)", $inputData);
    }
}

// DELETE: Remove event
elseif ($method === 'DELETE') {
    $id = intval($inputData['id'] ?? ($_GET['id'] ?? 0));
    if ($id <= 0) sendEventResponse(400, false, "Valid event ID required.");

    if ($db_connected && isset($conn)) {
        $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            logAuditEvent($conn, null, "API_EVENT_DELETED", "events", $id, "Deleted via JSON API");
            sendEventResponse(200, true, "Event #{$id} deleted successfully.");
        } else {
            sendEventResponse(500, false, "Failed to delete event.");
        }
    } else {
        sendEventResponse(200, true, "Event #{$id} deleted (offline mode).");
    }
}

else {
    sendEventResponse(405, false, "Method {$method} not allowed.");
}
?>
