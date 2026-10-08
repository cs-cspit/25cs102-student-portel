<?php
/**
 * StudentHub - Administrative Event Management CRUD & Secure Poster Upload (Practical 12)
 * Full CRUD, MIME validation, extension whitelisting, size limits, and safe storage in uploads/events/
 */

require_once __DIR__ . '/../php/admin-auth.php';

$successMsg = "";
$errorMsg = "";

// Ensure upload directory exists
$uploadDir = __DIR__ . "/../uploads/events/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// 1. Handle Event CRUD Actions
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    // CREATE EVENT WITH POSTER UPLOAD
    if ($action === "create") {
        $title = trim(strip_tags($_POST['title'] ?? ''));
        $description = trim(strip_tags($_POST['description'] ?? ''));
        $event_date = trim($_POST['event_date'] ?? '');
        $time_slot = trim(strip_tags($_POST['time_slot'] ?? '10:00 AM - 04:00 PM'));
        $venue = trim(strip_tags($_POST['venue'] ?? ''));
        $category = trim(strip_tags($_POST['category'] ?? 'technical'));
        $seats = intval($_POST['seats'] ?? 100);
        $status = trim(strip_tags($_POST['status'] ?? 'Active'));

        $posterPath = "uploads/events/default.jpg";

        // File Upload Processing
        if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['poster'];
            $fileName = $file['name'];
            $fileTmp = $file['tmp_name'];
            $fileSize = $file['size'];

            // 1. Max Size Check (2MB)
            if ($fileSize > 2097152) {
                $errorMsg = "Poster file size exceeds the 2MB limit.";
            } else {
                // 2. Extension Whitelist
                $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedExts = ['jpg', 'jpeg', 'png'];

                if (!in_array($ext, $allowedExts)) {
                    $errorMsg = "Invalid file extension. Only JPG, JPEG, and PNG images are permitted.";
                } else {
                    // 3. MIME-Type Verification via finfo
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType = finfo_file($finfo, $fileTmp);
                    finfo_close($finfo);

                    $allowedMimes = ['image/jpeg', 'image/png'];
                    if (!in_array($mimeType, $allowedMimes)) {
                        $errorMsg = "File is not a valid image. Upload rejected.";
                    } else {
                        // 4. Generate Safe Sanitized Filename
                        $newFileName = "event_" . time() . "_" . bin2hex(random_bytes(6)) . "." . $ext;
                        $destination = $uploadDir . $newFileName;

                        if (move_uploaded_file($fileTmp, $destination)) {
                            $posterPath = "uploads/events/" . $newFileName;
                        } else {
                            $errorMsg = "Failed to save uploaded poster file.";
                        }
                    }
                }
            }
        }

        if (empty($errorMsg)) {
            if (empty($title) || empty($event_date) || empty($venue)) {
                $errorMsg = "Event title, date, and venue are required.";
            } else {
                if ($db_connected && isset($conn)) {
                    $stmt = $conn->prepare("INSERT INTO events (title, description, event_date, time_slot, venue, category, poster, seats, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssssis", $title, $description, $event_date, $time_slot, $venue, $category, $posterPath, $seats, $status);
                    if ($stmt->execute()) {
                        $newEventId = $conn->insert_id;
                        logAuditEvent($conn, $_SESSION['user_id'], "EVENT_CREATED", "events", $newEventId, "Published event: " . $title);
                        $successMsg = "Event '{$title}' (#{$newEventId}) published successfully.";
                    } else {
                        $errorMsg = "Database error inserting event.";
                    }
                }
            }
        }
    }

    // UPDATE EVENT
    elseif ($action === "update") {
        $eventId = intval($_POST['event_id'] ?? 0);
        $title = trim(strip_tags($_POST['title'] ?? ''));
        $description = trim(strip_tags($_POST['description'] ?? ''));
        $event_date = trim($_POST['event_date'] ?? '');
        $venue = trim(strip_tags($_POST['venue'] ?? ''));
        $category = trim(strip_tags($_POST['category'] ?? 'technical'));
        $status = trim(strip_tags($_POST['status'] ?? 'Active'));

        if ($eventId > 0 && !empty($title) && !empty($event_date)) {
            if ($db_connected && isset($conn)) {
                $stmt = $conn->prepare("UPDATE events SET title=?, description=?, event_date=?, venue=?, category=?, status=? WHERE id=?");
                $stmt->bind_param("ssssssi", $title, $description, $event_date, $venue, $category, $status, $eventId);
                if ($stmt->execute()) {
                    logAuditEvent($conn, $_SESSION['user_id'], "EVENT_UPDATED", "events", $eventId, "Updated event ID: " . $eventId);
                    $successMsg = "Event #{$eventId} updated successfully.";
                } else {
                    $errorMsg = "Update failed.";
                }
            }
        }
    }

    // DELETE EVENT
    elseif ($action === "delete") {
        $eventId = intval($_POST['event_id'] ?? 0);
        if ($eventId > 0 && $db_connected && isset($conn)) {
            $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
            $stmt->bind_param("i", $eventId);
            if ($stmt->execute()) {
                logAuditEvent($conn, $_SESSION['user_id'], "EVENT_DELETED", "events", $eventId, "Deleted event ID: " . $eventId);
                $successMsg = "Event #{$eventId} deleted successfully.";
            }
        }
    }
}

// 2. Fetch Events List
$events = [];
if ($db_connected && isset($conn)) {
    $res = $conn->query("SELECT id, title, description, event_date, time_slot, venue, category, poster, seats, status FROM events ORDER BY event_date ASC");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $events[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management & Poster Upload | StudentHub</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/admin.css">
    <script src="../js/main.js" defer></script>
</head>
<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <header class="site-header" style="background-color: var(--secondary-900); border-bottom: 1px solid var(--secondary-800);">
        <div class="container header-inner">
            <a href="index.php" class="brand-logo" style="color: #ffffff;">
                ⚙️ StudentHub <span class="brand-badge" style="background-color: #dc2626; color: #ffffff;">Admin Console</span>
            </a>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php" style="color: #cbd5e1;">Dashboard</a></li>
                    <li><a href="students.php" style="color: #cbd5e1;">Students</a></li>
                    <li><a href="events.php" class="active" style="color: #60a5fa;">Events</a></li>
                    <li><a href="registrations.php" style="color: #cbd5e1;">Registrations</a></li>
                    <li><a href="audit-logs.php" style="color: #cbd5e1;">Audit Logs</a></li>
                </ul>
            </nav>
            <div class="nav-cta-group">
                <a href="../php/logout.php" class="btn btn-secondary btn-sm">Sign Out</a>
            </div>
        </div>
    </header>

    <main id="main-content">
        <div class="container">
            <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h1>Campus Events & Poster Management</h1>
                    <p>Publish workshops, configure seating capacities, and upload verified poster assets.</p>
                </div>
                <button type="button" class="btn btn-primary" data-modal-target="add-event-modal">+ Publish New Event</button>
            </header>

            <?php if (!empty($successMsg)): ?>
                <div class="alert alert-success" role="alert"><?php echo htmlspecialchars($successMsg, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <?php if (!empty($errorMsg)): ?>
                <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($errorMsg, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <!-- Events Table -->
            <section class="card">
                <h2 style="font-size: 1.25rem; margin-bottom: 1rem;">Published Events (<?php echo count($events); ?> Total)</h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Poster</th>
                                <th scope="col">Event Title</th>
                                <th scope="col">Category</th>
                                <th scope="col">Date & Time</th>
                                <th scope="col">Venue</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($events)): ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 2rem;">No campus events found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($events as $ev): ?>
                                    <tr>
                                        <td><strong>#<?php echo htmlspecialchars($ev['id'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                        <td>
                                            <img src="../<?php echo htmlspecialchars($ev['poster'], ENT_QUOTES, 'UTF-8'); ?>" onerror="this.src='../pr2/html/assets/images/event1.jpg'" alt="Poster" style="width: 50px; height: 35px; object-fit: cover; border-radius: 4px;">
                                        </td>
                                        <td><strong><?php echo htmlspecialchars($ev['title'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                        <td><span class="event-badge"><?php echo htmlspecialchars($ev['category'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                                        <td><?php echo htmlspecialchars($ev['event_date'], ENT_QUOTES, 'UTF-8'); ?><br><small style="color: var(--text-muted);"><?php echo htmlspecialchars($ev['time_slot'], ENT_QUOTES, 'UTF-8'); ?></small></td>
                                        <td><?php echo htmlspecialchars($ev['venue'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><span class="status-badge status-confirmed"><?php echo htmlspecialchars($ev['status'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                                        <td>
                                            <div style="display: flex; gap: 0.35rem;">
                                                <button type="button" class="btn btn-secondary btn-sm" onclick="openEditEventModal(<?php echo htmlspecialchars(json_encode($ev), ENT_QUOTES, 'UTF-8'); ?>)">Edit</button>
                                                <form action="events.php" method="POST" onsubmit="return confirm('Delete event #<?php echo $ev['id']; ?>? This will cancel all student registrations for this event.');" style="display:inline;">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="event_id" value="<?php echo $ev['id']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

    <!-- Modal: Add New Event -->
    <div id="add-event-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="modal-box" style="max-width: 650px;">
            <button type="button" class="modal-close-btn" data-modal-close aria-label="Close dialog">&times;</button>
            <h2 style="color: var(--primary-600); margin-bottom: 1rem;">Publish New Campus Event</h2>
            <form action="events.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create">
                <div class="form-group">
                    <label for="ev-title">Event Title *</label>
                    <input type="text" id="ev-title" name="title" class="form-control" required placeholder="e.g. AI & Cloud Hackathon 2026">
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label for="ev-date">Event Date *</label>
                        <input type="date" id="ev-date" name="event_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ev-time">Time Slot</label>
                        <input type="text" id="ev-time" name="time_slot" class="form-control" value="10:00 AM - 04:00 PM">
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label for="ev-category">Category *</label>
                        <select id="ev-category" name="category" class="form-control" required>
                            <option value="technical">Technical</option>
                            <option value="workshop">Workshop</option>
                            <option value="cultural">Cultural</option>
                            <option value="sports">Sports</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ev-seats">Seating Capacity</label>
                        <input type="number" id="ev-seats" name="seats" class="form-control" value="100" min="10">
                    </div>
                </div>
                <div class="form-group">
                    <label for="ev-venue">Venue / Location *</label>
                    <input type="text" id="ev-venue" name="venue" class="form-control" required placeholder="e.g. CSPIT Seminar Hall B">
                </div>
                <div class="form-group">
                    <label for="ev-poster">Upload Event Poster (JPG / PNG, Max 2MB)</label>
                    <input type="file" id="ev-poster" name="poster" class="form-control" accept=".jpg,.jpeg,.png">
                </div>
                <div class="form-group">
                    <label for="ev-desc">Event Description</label>
                    <textarea id="ev-desc" name="description" class="form-control" rows="3" placeholder="Overview, agenda, and requirements..."></textarea>
                </div>
                <div style="margin-top: 1.5rem; text-align: right;">
                    <button type="button" class="btn btn-secondary" data-modal-close>Cancel</button>
                    <button type="submit" class="btn btn-primary">Publish Event</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Edit Event -->
    <div id="edit-event-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="modal-box" style="max-width: 600px;">
            <button type="button" class="modal-close-btn" onclick="closeEditEventModal()" aria-label="Close dialog">&times;</button>
            <h2 style="color: var(--primary-600); margin-bottom: 1rem;">Edit Event Details</h2>
            <form action="events.php" method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" id="edit-ev-id" name="event_id" value="">
                <div class="form-group">
                    <label for="edit-ev-title">Event Title</label>
                    <input type="text" id="edit-ev-title" name="title" class="form-control" required>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label for="edit-ev-date">Date</label>
                        <input type="date" id="edit-ev-date" name="event_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-ev-category">Category</label>
                        <select id="edit-ev-category" name="category" class="form-control">
                            <option value="technical">Technical</option>
                            <option value="workshop">Workshop</option>
                            <option value="cultural">Cultural</option>
                            <option value="sports">Sports</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit-ev-venue">Venue</label>
                    <input type="text" id="edit-ev-venue" name="venue" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit-ev-status">Status</label>
                    <select id="edit-ev-status" name="status" class="form-control">
                        <option value="Active">Active</option>
                        <option value="Upcoming">Upcoming</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div style="margin-top: 1.5rem; text-align: right;">
                    <button type="button" class="btn btn-secondary" onclick="closeEditEventModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditEventModal(ev) {
            document.getElementById('edit-ev-id').value = ev.id;
            document.getElementById('edit-ev-title').value = ev.title;
            document.getElementById('edit-ev-date').value = ev.event_date;
            document.getElementById('edit-ev-category').value = ev.category;
            document.getElementById('edit-ev-venue').value = ev.venue;
            document.getElementById('edit-ev-status').value = ev.status;
            
            const modal = document.getElementById('edit-event-modal');
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
        }
        function closeEditEventModal() {
            const modal = document.getElementById('edit-event-modal');
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
        }
    </script>
</body>
</html>
