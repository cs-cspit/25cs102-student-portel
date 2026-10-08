<?php
/**
 * StudentHub - Administrative Event Registrations Management (Practical 14)
 * View, filter, approve, waitlist, or cancel student event enrollments.
 */

require_once __DIR__ . '/../php/admin-auth.php';

$successMsg = "";
$errorMsg = "";

// 1. Handle Status Update / Deletion
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === "update_status") {
        $regId = intval($_POST['reg_id'] ?? 0);
        $newStatus = trim($_POST['status'] ?? 'Confirmed');

        if ($regId > 0 && $db_connected && isset($conn)) {
            $stmt = $conn->prepare("UPDATE registrations SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $newStatus, $regId);
            if ($stmt->execute()) {
                logAuditEvent($conn, $_SESSION['user_id'], "REGISTRATION_STATUS_UPDATED", "registrations", $regId, "Status changed to: " . $newStatus);
                $successMsg = "Registration #{$regId} status updated to {$newStatus}.";
            }
        }
    } elseif ($action === "delete_reg") {
        $regId = intval($_POST['reg_id'] ?? 0);
        if ($regId > 0 && $db_connected && isset($conn)) {
            $stmt = $conn->prepare("DELETE FROM registrations WHERE id = ?");
            $stmt->bind_param("i", $regId);
            if ($stmt->execute()) {
                logAuditEvent($conn, $_SESSION['user_id'], "REGISTRATION_DELETED", "registrations", $regId, "Registration canceled.");
                $successMsg = "Registration #{$regId} deleted.";
            }
        }
    }
}

// 2. Fetch Registrations
$registrations = [];
if ($db_connected && isset($conn)) {
    $sql = "SELECT r.id, r.registration_date, r.status, s.name as student_name, s.email as student_email, s.course, e.title as event_title, e.event_date 
            FROM registrations r 
            JOIN students s ON r.student_id = s.id 
            JOIN events e ON r.event_id = e.id 
            ORDER BY r.registration_date DESC";
    $res = $conn->query($sql);
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $registrations[] = $row;
        }
    }
}

// Fallback dummy records
if (empty($registrations)) {
    $registrations = [
        ["id" => 1, "student_name" => "Daksh Shah", "student_email" => "25cs102@charusat.edu.in", "course" => "B.Tech CSE", "event_title" => "CodeSprint 2026 Hackathon", "event_date" => "2026-10-15", "status" => "Confirmed", "registration_date" => date("Y-m-d H:i:s")],
        ["id" => 2, "student_name" => "Aarav Patel", "student_email" => "aarav.ce@charusat.edu.in", "course" => "B.Tech CE", "event_title" => "Full-Stack Web Dev Masterclass", "event_date" => "2026-10-22", "status" => "Confirmed", "registration_date" => date("Y-m-d H:i:s", strtotime("-2 hours"))],
        ["id" => 3, "student_name" => "Diya Sharma", "student_email" => "diya.it@charusat.edu.in", "course" => "B.Tech IT", "event_title" => "Spandan 2026 Youth Festival", "event_date" => "2026-11-05", "status" => "Waitlisted", "registration_date" => date("Y-m-d H:i:s", strtotime("-5 hours"))]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Management | StudentHub Administration</title>
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
                    <li><a href="events.php" style="color: #cbd5e1;">Events</a></li>
                    <li><a href="registrations.php" class="active" style="color: #60a5fa;">Registrations</a></li>
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
            <header style="margin-bottom: 1.5rem;">
                <h1>Participant Registrations Management</h1>
                <p>Track student event enrollments, confirm attendance, manage waitlists, and audit rosters.</p>
            </header>

            <?php if (!empty($successMsg)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMsg, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <section class="card">
                <h2 style="font-size: 1.25rem; margin-bottom: 1rem;">All Event Enrollments (<?php echo count($registrations); ?> Records)</h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Email / Course</th>
                                <th scope="col">Event Title</th>
                                <th scope="col">Event Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Update Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registrations as $r): ?>
                                <tr>
                                    <td><strong>#<?php echo htmlspecialchars($r['id'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                    <td><strong><?php echo htmlspecialchars($r['student_name'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                    <td><?php echo htmlspecialchars($r['student_email'], ENT_QUOTES, 'UTF-8'); ?><br><small style="color: var(--text-muted);"><?php echo htmlspecialchars($r['course'], ENT_QUOTES, 'UTF-8'); ?></small></td>
                                    <td><?php echo htmlspecialchars($r['event_title'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($r['event_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $r['status']==='Confirmed'?'status-confirmed':($r['status']==='Waitlisted'?'status-pending':'status-badge'); ?>">
                                            <?php echo htmlspecialchars($r['status'], ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form action="registrations.php" method="POST" style="display:flex; gap:0.25rem; align-items:center;">
                                            <input type="hidden" name="action" value="update_status">
                                            <input type="hidden" name="reg_id" value="<?php echo $r['id']; ?>">
                                            <select name="status" class="form-control" style="padding:0.25rem 0.5rem; font-size:0.8rem; width:auto;">
                                                <option value="Confirmed" <?php echo $r['status']==='Confirmed'?'selected':''; ?>>Confirmed</option>
                                                <option value="Waitlisted" <?php echo $r['status']==='Waitlisted'?'selected':''; ?>>Waitlisted</option>
                                                <option value="Cancelled" <?php echo $r['status']==='Cancelled'?'selected':''; ?>>Cancelled</option>
                                            </select>
                                            <button type="submit" class="btn btn-secondary btn-sm" style="padding:0.25rem 0.5rem;">Save</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="registrations.php" method="POST" onsubmit="return confirm('Cancel registration #<?php echo $r['id']; ?>?');" style="display:inline;">
                                            <input type="hidden" name="action" value="delete_reg">
                                            <input type="hidden" name="reg_id" value="<?php echo $r['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" style="padding:0.25rem 0.5rem;">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2026 StudentHub Administration Console.</p>
            </div>
        </div>
    </footer>
</body>
</html>
