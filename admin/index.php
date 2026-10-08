<?php
/**
 * StudentHub - Authenticated Administrator Console (Practical 10)
 */
require_once __DIR__ . '/../php/admin-auth.php';

$currentUser = getCurrentUser();
$adminName = $currentUser['name'];

// Default aggregate metrics
$totalStudents = 1248;
$totalEvents = 16;
$totalRegistrations = 482;
$totalUsers = 1250;

if ($db_connected && isset($conn)) {
    $res = $conn->query("SELECT COUNT(*) as c FROM students");
    if ($res) $totalStudents = $res->fetch_assoc()['c'];

    $res = $conn->query("SELECT COUNT(*) as c FROM events");
    if ($res) $totalEvents = $res->fetch_assoc()['c'];

    $res = $conn->query("SELECT COUNT(*) as c FROM registrations");
    if ($res) $totalRegistrations = $res->fetch_assoc()['c'];

    $res = $conn->query("SELECT COUNT(*) as c FROM users");
    if ($res) $totalUsers = $res->fetch_assoc()['c'];
}

// Fetch recent audit logs
$auditLogs = [];
if ($db_connected && isset($conn)) {
    $res = $conn->query("SELECT action, entity, ip_address, details, created_at FROM audit_logs ORDER BY created_at DESC LIMIT 5");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $auditLogs[] = $row;
        }
    }
}

if (empty($auditLogs)) {
    $auditLogs = [
        ["action" => "USER_AUTHENTICATION", "entity" => "users", "ip_address" => "192.168.1.45", "details" => "Admin session established.", "created_at" => date("Y-m-d H:i:s")],
        ["action" => "USER_REGISTRATION", "entity" => "students", "ip_address" => "10.0.4.18", "details" => "Student registered.", "created_at" => date("Y-m-d H:i:s", strtotime("-1 hour"))]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | StudentHub Administration</title>
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
                    <li><a href="index.php" class="active" style="color: #60a5fa;">Dashboard</a></li>
                    <li><a href="students.php" style="color: #cbd5e1;">Students</a></li>
                    <li><a href="events.php" style="color: #cbd5e1;">Events</a></li>
                    <li><a href="registrations.php" style="color: #cbd5e1;">Registrations</a></li>
                    <li><a href="audit-logs.php" style="color: #cbd5e1;">Audit Logs</a></li>
                </ul>
            </nav>
            <div class="nav-cta-group">
                <span style="font-size: 0.85rem; color: #cbd5e1; display: flex; align-items: center; gap: 0.35rem;">
                    🛡️ <?php echo htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8'); ?>
                </span>
                <a href="../php/logout.php" class="btn btn-secondary btn-sm">Sign Out</a>
            </div>
        </div>
    </header>

    <main id="main-content">
        <div class="container">
            <header style="margin-bottom: 2rem;">
                <h1>Administration & System Analytics</h1>
                <p>Real-time campus metrics, student management overview, and security audit logs.</p>
            </header>

            <!-- Metrics Summary Cards -->
            <section style="margin-bottom: 2rem;">
                <div class="grid-4">
                    <article class="card" style="border-left: 4px solid var(--primary-600);">
                        <h3 style="font-size: 0.9rem; color: var(--text-muted);">Total Enrolled Students</h3>
                        <p style="font-size: 2.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 0;"><?php echo $totalStudents; ?></p>
                        <small style="color: #15803d;">↑ Active Relational Records</small>
                    </article>
                    <article class="card" style="border-left: 4px solid #0d9488;">
                        <h3 style="font-size: 0.9rem; color: var(--text-muted);">Active Campus Events</h3>
                        <p style="font-size: 2.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 0;"><?php echo $totalEvents; ?></p>
                        <small style="color: var(--text-muted);">4 upcoming this month</small>
                    </article>
                    <article class="card" style="border-left: 4px solid #854d0e;">
                        <h3 style="font-size: 0.9rem; color: var(--text-muted);">Total Registrations</h3>
                        <p style="font-size: 2.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 0;"><?php echo $totalRegistrations; ?></p>
                        <small style="color: #15803d;">94% Confirmation Rate</small>
                    </article>
                    <article class="card" style="border-left: 4px solid #2563eb;">
                        <h3 style="font-size: 0.9rem; color: var(--text-muted);">Total User Accounts</h3>
                        <p style="font-size: 2.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 0;"><?php echo $totalUsers; ?></p>
                        <small style="color: #15803d;">RBAC Protected</small>
                    </article>
                </div>
            </section>

            <!-- Audit Logs Section -->
            <section class="card">
                <h2 style="font-size: 1.35rem; margin-bottom: 1.25rem;">Security & Activity Audit Logs</h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Timestamp</th>
                                <th scope="col">Action</th>
                                <th scope="col">Entity</th>
                                <th scope="col">Client IP</th>
                                <th scope="col">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($auditLogs as $log): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($log['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><strong><?php echo htmlspecialchars($log['action'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                    <td><?php echo htmlspecialchars($log['entity'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($log['ip_address'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($log['details'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
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
