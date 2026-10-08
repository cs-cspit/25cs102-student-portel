<?php
/**
 * StudentHub - Security & Activity Audit Log Explorer (Practical 14)
 * Real-time inspection of system events, authentication traces, and administrative mutations.
 */

require_once __DIR__ . '/../php/admin-auth.php';

$actionFilter = trim($_GET['action_filter'] ?? 'all');
$logs = [];

if ($db_connected && isset($conn)) {
    $sql = "SELECT a.id, a.user_id, a.action, a.entity, a.entity_id, a.ip_address, a.details, a.created_at, u.name as user_name 
            FROM audit_logs a 
            LEFT JOIN users u ON a.user_id = u.id 
            WHERE 1=1";
    
    if ($actionFilter !== 'all' && !empty($actionFilter)) {
        $sql .= " AND a.action = '" . $conn->real_escape_string($actionFilter) . "'";
    }

    $sql .= " ORDER BY a.created_at DESC LIMIT 50";
    $res = $conn->query($sql);
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $logs[] = $row;
        }
    }
}

// Fallback dummy records if database offline
if (empty($logs)) {
    $logs = [
        ["id" => 1, "action" => "USER_AUTHENTICATION", "entity" => "users", "entity_id" => 1, "ip_address" => "192.168.1.45", "user_name" => "Admin (Dhara Ma'am)", "details" => "Privileged admin login verified.", "created_at" => date("Y-m-d H:i:s")],
        ["id" => 2, "action" => "EVENT_CREATED", "entity" => "events", "entity_id" => 1, "ip_address" => "192.168.1.45", "user_name" => "Admin (Dhara Ma'am)", "details" => "Published event 'CodeSprint 2026 Hackathon'", "created_at" => date("Y-m-d H:i:s", strtotime("-1 hour"))],
        ["id" => 3, "action" => "USER_REGISTRATION", "entity" => "students", "entity_id" => 2, "ip_address" => "10.0.4.18", "user_name" => "Daksh Shah", "details" => "Student registered for portal.", "created_at" => date("Y-m-d H:i:s", strtotime("-2 hours"))]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Audit Logs | StudentHub Administration</title>
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
                    <li><a href="registrations.php" style="color: #cbd5e1;">Registrations</a></li>
                    <li><a href="audit-logs.php" class="active" style="color: #60a5fa;">Audit Logs</a></li>
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
                <h1>Security Audit Trail & Activity Logs</h1>
                <p>Forensic inspection of user authentications, student modifications, event publications, and IP origins.</p>
            </header>

            <section class="card" style="margin-bottom: 1.5rem;">
                <form action="audit-logs.php" method="GET" style="display:flex; gap:1rem; align-items:flex-end; flex-wrap:wrap;">
                    <div class="form-group" style="margin-bottom:0; flex:1; min-width:240px;">
                        <label for="action_filter">Filter by Action Event</label>
                        <select id="action_filter" name="action_filter" class="form-control">
                            <option value="all" <?php echo $actionFilter==='all'?'selected':''; ?>>All Actions</option>
                            <option value="USER_AUTHENTICATION" <?php echo $actionFilter==='USER_AUTHENTICATION'?'selected':''; ?>>USER_AUTHENTICATION</option>
                            <option value="USER_REGISTRATION" <?php echo $actionFilter==='USER_REGISTRATION'?'selected':''; ?>>USER_REGISTRATION</option>
                            <option value="STUDENT_CREATED" <?php echo $actionFilter==='STUDENT_CREATED'?'selected':''; ?>>STUDENT_CREATED</option>
                            <option value="STUDENT_UPDATED" <?php echo $actionFilter==='STUDENT_UPDATED'?'selected':''; ?>>STUDENT_UPDATED</option>
                            <option value="STUDENT_DELETED" <?php echo $actionFilter==='STUDENT_DELETED'?'selected':''; ?>>STUDENT_DELETED</option>
                            <option value="EVENT_CREATED" <?php echo $actionFilter==='EVENT_CREATED'?'selected':''; ?>>EVENT_CREATED</option>
                            <option value="EVENT_UPDATED" <?php echo $actionFilter==='EVENT_UPDATED'?'selected':''; ?>>EVENT_UPDATED</option>
                            <option value="EVENT_DELETED" <?php echo $actionFilter==='EVENT_DELETED'?'selected':''; ?>>EVENT_DELETED</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter Logs</button>
                    <a href="audit-logs.php" class="btn btn-secondary">Reset</a>
                </form>
            </section>

            <section class="card">
                <h2 style="font-size: 1.25rem; margin-bottom: 1rem;">Audit Trail Entries (<?php echo count($logs); ?> Events)</h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Log ID</th>
                                <th scope="col">Timestamp</th>
                                <th scope="col">Actor / User</th>
                                <th scope="col">Action Event</th>
                                <th scope="col">Target Entity</th>
                                <th scope="col">Client IP</th>
                                <th scope="col">Activity Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $l): ?>
                                <tr>
                                    <td>#<?php echo htmlspecialchars($l['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><small><?php echo htmlspecialchars($l['created_at'], ENT_QUOTES, 'UTF-8'); ?></small></td>
                                    <td><strong><?php echo htmlspecialchars($l['user_name'] ?? ('User #' . ($l['user_id'] ?? 'Guest')), ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                    <td><span class="status-badge status-confirmed"><?php echo htmlspecialchars($l['action'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                                    <td><code><?php echo htmlspecialchars($l['entity'] . ($l['entity_id'] ? (' #' . $l['entity_id']) : ''), ENT_QUOTES, 'UTF-8'); ?></code></td>
                                    <td><code><?php echo htmlspecialchars($l['ip_address'], ENT_QUOTES, 'UTF-8'); ?></code></td>
                                    <td><?php echo htmlspecialchars($l['details'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
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
                <p>&copy; 2026 StudentHub Administration Console. Privileged Access Only.</p>
            </div>
        </div>
    </footer>
</body>
</html>
