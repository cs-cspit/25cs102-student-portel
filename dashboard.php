<?php
/**
 * StudentHub - Authenticated Student Dashboard (Practical 10)
 */
require_once __DIR__ . '/php/student-auth.php';

$currentUser = getCurrentUser();
$studentName = $currentUser['name'];
$studentEmail = $currentUser['email'];

// Query active registrations for this student
$enrolledEvents = [];
if ($db_connected && isset($conn) && isset($_SESSION['student_id'])) {
    $sql = "SELECT e.title, e.event_date, e.category, r.status, e.venue 
            FROM registrations r 
            JOIN events e ON r.event_id = e.id 
            WHERE r.student_id = ? 
            ORDER BY e.event_date ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['student_id']);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $enrolledEvents[] = $row;
    }
}

// Fallback dummy events if none enrolled
if (empty($enrolledEvents)) {
    $enrolledEvents = [
        ["title" => "CodeSprint 2026: 24-Hour Hackathon", "event_date" => "2026-10-15", "status" => "Confirmed"],
        ["title" => "Full-Stack Web Dev Masterclass", "event_date" => "2026-10-22", "status" => "Confirmed"]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | StudentHub Portal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <script src="js/main.js" defer></script>
</head>
<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Global Header -->
    <header class="site-header">
        <div class="container header-inner">
            <a href="index.html" class="brand-logo" aria-label="StudentHub Home">
                🎓 StudentHub <span class="brand-badge">Campus Portal</span>
            </a>
            <nav class="main-nav" aria-label="Main Navigation">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="dashboard.php" class="active" aria-current="page">Dashboard</a></li>
                    <li><a href="events.html">Events</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="faq.html">FAQ</a></li>
                    <li><a href="feedback.html">Feedback</a></li>
                </ul>
            </nav>
            <div class="nav-cta-group">
                <button type="button" id="theme-toggle-btn" class="theme-toggle-btn" aria-label="Toggle theme">🌙</button>
                <span style="font-size: 0.9rem; font-weight: 600; color: var(--primary-600); display: flex; align-items: center; gap: 0.35rem;">
                    👤 <?php echo htmlspecialchars($studentName, ENT_QUOTES, 'UTF-8'); ?>
                </span>
                <a href="php/logout.php" class="btn btn-secondary btn-sm">Sign Out</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main id="main-content">
        <div class="container">
            <!-- Breadcrumbs -->
            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Student Dashboard</li>
                </ol>
            </nav>

            <!-- Welcome Greeting Banner -->
            <section class="card" aria-labelledby="welcome-heading" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: #ffffff; margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h1 id="welcome-heading" style="color: #ffffff; font-size: 1.85rem; margin-bottom: 0.25rem;">Welcome back, <?php echo htmlspecialchars($studentName, ENT_QUOTES, 'UTF-8'); ?>!</h1>
                        <p style="color: #e2e8f0; margin-bottom: 0;">Verified University Account: <strong><?php echo htmlspecialchars($studentEmail, ENT_QUOTES, 'UTF-8'); ?></strong></p>
                    </div>
                    <div>
                        <a href="events.html" class="btn btn-light btn-sm">Browse Campus Events</a>
                        <a href="profile.php" class="btn btn-outline btn-sm">Edit Profile</a>
                    </div>
                </div>
            </section>

            <!-- Metrics Summary Cards -->
            <section aria-labelledby="metrics-heading" style="margin-bottom: 2rem;">
                <h2 id="metrics-heading" class="sr-only" style="display: none;">Engagement Summary</h2>
                <div class="grid-4">
                    <article class="card" style="text-align: center;">
                        <h3 style="font-size: 0.95rem; color: var(--text-muted);">Enrolled Events</h3>
                        <p style="font-size: 2rem; font-weight: 700; color: var(--primary-600); margin-bottom: 0;"><?php echo count($enrolledEvents); ?></p>
                    </article>
                    <article class="card" style="text-align: center;">
                        <h3 style="font-size: 0.95rem; color: var(--text-muted);">Upcoming Events</h3>
                        <p style="font-size: 2rem; font-weight: 700; color: #0d9488; margin-bottom: 0;">16</p>
                    </article>
                    <article class="card" style="text-align: center;">
                        <h3 style="font-size: 0.95rem; color: var(--text-muted);">Certificates Earned</h3>
                        <p style="font-size: 2rem; font-weight: 700; color: #854d0e; margin-bottom: 0;">2</p>
                    </article>
                    <article class="card" style="text-align: center;">
                        <h3 style="font-size: 0.95rem; color: var(--text-muted);">Account Security</h3>
                        <p style="font-size: 2rem; font-weight: 700; color: #15803d; margin-bottom: 0;">100%</p>
                    </article>
                </div>
            </section>

            <div class="grid-2">
                <!-- Enrolled Events Table Section -->
                <section class="card" aria-labelledby="enrolled-title">
                    <h2 id="enrolled-title" style="font-size: 1.35rem; margin-bottom: 1rem;">My Enrolled Campus Events</h2>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">Event Title</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($enrolledEvents as $event): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                        <td><?php echo htmlspecialchars($event['event_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><span class="status-badge status-confirmed"><?php echo htmlspecialchars($event['status'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                                        <td><a href="events.html" class="btn btn-secondary btn-sm">Details</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Recent Activity & Notices Section -->
                <section class="card" aria-labelledby="activity-title">
                    <h2 id="activity-title" style="font-size: 1.35rem; margin-bottom: 1rem;">Campus Notices & Updates</h2>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <article style="border-left: 4px solid var(--primary-600); padding-left: 1rem;">
                            <h3 style="font-size: 1rem; margin-bottom: 0.25rem;">📢 Mid-Term Exam Lab Schedule Released</h3>
                            <p style="font-size: 0.85rem; margin-bottom: 0.25rem;">The laboratory schedule for ITUE203 Web Development Frameworks has been published.</p>
                            <small style="color: var(--text-muted);">Posted by Department of CSE</small>
                        </article>
                        <article style="border-left: 4px solid #0d9488; padding-left: 1rem;">
                            <h3 style="font-size: 1rem; margin-bottom: 0.25rem;">🚀 CodeSprint Hackathon Problem Statements</h3>
                            <p style="font-size: 0.85rem; margin-bottom: 0.25rem;">Problem statements in Web3 and AI in Education will be unveiled on event day.</p>
                            <small style="color: var(--text-muted);">Posted by Student Council</small>
                        </article>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <!-- Global Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2026 StudentHub - CHARUSAT CSPIT. All rights reserved. Built for ITUE203 Web Development Frameworks.</p>
            </div>
        </div>
    </footer>
</body>
</html>
