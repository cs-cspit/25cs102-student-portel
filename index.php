<?php
/**
 * StudentHub - Unified Campus Portal Entry Point (Practical 15 Final Integration)
 * Renders portal home with session awareness, dynamic role-based navigation,
 * live campus counts from MySQL database, and accessible semantic UI.
 */
require_once __DIR__ . '/php/auth.php';

$currentUser = getCurrentUser();
$totalStudents = 1248;
$totalEvents = 16;

if ($db_connected && isset($conn)) {
    $sRes = $conn->query("SELECT COUNT(*) as c FROM students");
    if ($sRes) $totalStudents = $sRes->fetch_assoc()['c'];

    $eRes = $conn->query("SELECT COUNT(*) as c FROM events WHERE status = 'Active' OR status = 'Upcoming'");
    if ($eRes) $totalEvents = $eRes->fetch_assoc()['c'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="StudentHub - Centralized student management and campus activity portal for CHARUSAT university students.">
    <title>StudentHub | Student Management & Campus Portal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <script src="js/main.js" defer></script>
</head>
<body>
    <!-- Accessible Skip Link -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Dismissible Notification Banner -->
    <div id="portal-announcement-banner" class="notification-banner" role="region" aria-label="Campus Announcement">
        <span>📢 Mid-Term Practical Evaluation Schedule and CodeSprint Hackathon 2026 are live!</span>
        <button type="button" id="banner-close-btn" class="banner-close-btn" aria-label="Dismiss Announcement">&times;</button>
    </div>

    <!-- Global Header & Navigation -->
    <header class="site-header">
        <div class="container header-inner">
            <a href="index.php" class="brand-logo" aria-label="StudentHub Home">
                🎓 StudentHub <span class="brand-badge">Campus Portal</span>
            </a>
            <nav class="main-nav" aria-label="Main Navigation">
                <ul>
                    <li><a href="index.php" class="active" aria-current="page">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="events.html">Events</a></li>
                    <?php if ($currentUser && $currentUser['role'] === 'student'): ?>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="profile.php">Profile</a></li>
                    <?php elseif ($currentUser && $currentUser['role'] === 'admin'): ?>
                        <li><a href="admin/index.php">Admin Console</a></li>
                    <?php endif; ?>
                    <li><a href="faq.html">FAQ</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </nav>
            <div class="nav-cta-group">
                <button type="button" id="theme-toggle-btn" class="theme-toggle-btn" aria-label="Toggle theme">🌙</button>
                <?php if ($currentUser): ?>
                    <span style="font-size: 0.85rem; font-weight: 600; color: var(--primary-600); display: flex; align-items: center; gap: 0.25rem;">
                        <?php echo $currentUser['role'] === 'admin' ? '🛡️' : '👤'; ?> <?php echo htmlspecialchars($currentUser['name'], ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                    <?php if ($currentUser['role'] === 'admin'): ?>
                        <a href="admin/index.php" class="btn btn-primary btn-sm">Admin Panel</a>
                    <?php else: ?>
                        <a href="dashboard.php" class="btn btn-primary btn-sm">My Dashboard</a>
                    <?php endif; ?>
                    <a href="php/logout.php" class="btn btn-secondary btn-sm">Sign Out</a>
                <?php else: ?>
                    <a href="login.html" class="btn btn-secondary btn-sm">Login</a>
                    <a href="register.html" class="btn btn-primary btn-sm">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main id="main-content">
        <div class="container">
            <!-- Content Slider / Carousel -->
            <section aria-label="Campus Announcements Slider" class="slider-container">
                <button type="button" class="slider-nav-btn slider-prev" aria-label="Previous Slide">&lsaquo;</button>
                <div class="slider-track">
                    <article class="slide">
                        <span class="slide-badge">Semester Update</span>
                        <h2>🚀 Semester 3 Final Practical Submissions</h2>
                        <p>Laboratory schedules, documentation, and evaluation guidelines for ITUE203 Web Development Frameworks are now published.</p>
                        <button type="button" class="btn btn-primary btn-sm" data-modal-target="info-modal" data-modal-title="Exam Schedule Notice" data-modal-body="Final practical examinations commence according to the CHARUSAT academic calendar. All students are required to verify their GitHub repository submission.">View Schedule</button>
                    </article>
                    <article class="slide">
                        <span class="slide-badge">Campus Hackathon</span>
                        <h2>⚡ CodeSprint 2026: 24-Hour Hackathon</h2>
                        <p>Join 150+ student developers at CSPIT for 24 hours of intense problem-solving in AI, Full-Stack Web, and Cloud Computing.</p>
                        <a href="events.html" class="btn btn-primary btn-sm">Browse Event Details</a>
                    </article>
                    <article class="slide">
                        <span class="slide-badge">Workshop</span>
                        <h2>💻 Full-Stack Web Dev Masterclass</h2>
                        <p>Hands-on sessions on PHP 8+, MySQL prepared statements, Fetch API CRUD, and responsive CSS Grid systems.</p>
                        <a href="events.html" class="btn btn-primary btn-sm">Reserve Seat</a>
                    </article>
                </div>
                <button type="button" class="slider-nav-btn slider-next" aria-label="Next Slide">&rsaquo;</button>
                <div class="slider-dots" role="tablist" aria-label="Slide Selection"></div>
            </section>

            <!-- Quick Access Metric Highlights -->
            <section aria-labelledby="highlights-heading" style="margin-bottom: 2.5rem;">
                <h2 id="highlights-heading" class="sr-only" style="display:none;">Campus Portal Highlights</h2>
                <div class="grid-3">
                    <div class="card highlight-card">
                        <div class="highlight-icon">👥</div>
                        <h3>Active Students</h3>
                        <p class="highlight-number"><?php echo number_format($totalStudents); ?>+</p>
                        <p>Enrolled across B.Tech CSE, IT, CE, EC, and ME departments.</p>
                        <a href="register.html" class="card-link">Join the Student Community &rarr;</a>
                    </div>
                    <div class="card highlight-card">
                        <div class="highlight-icon">📅</div>
                        <h3>Upcoming Events</h3>
                        <p class="highlight-number"><?php echo $totalEvents; ?></p>
                        <p>Technical hackathons, workshops, cultural festivals, and sports leagues.</p>
                        <a href="events.html" class="card-link">Explore Campus Calendar &rarr;</a>
                    </div>
                    <div class="card highlight-card">
                        <div class="highlight-icon">🔒</div>
                        <h3>Unified RBAC Portal</h3>
                        <p class="highlight-number">100%</p>
                        <p>Role-based access control with MySQL prepared statements and audit trail.</p>
                        <a href="login.html" class="card-link">Sign In to Workspace &rarr;</a>
                    </div>
                </div>
            </section>

            <!-- Feature Showcase -->
            <section class="card" aria-labelledby="portal-features-heading" style="margin-bottom: 2.5rem;">
                <h2 id="portal-features-heading">Comprehensive Campus Management Platform</h2>
                <p>Designed and built for CHARUSAT CSPIT under the course ITUE203 Web Development Frameworks.</p>
                <div class="grid-3" style="margin-top: 1.5rem;">
                    <div>
                        <h3>🛡️ Enterprise Security</h3>
                        <p>BCRYPT password hashing, parameterized queries, CSRF defenses, session fixation immunity, and tamper-evident audit logging.</p>
                    </div>
                    <div>
                        <h3>⚡ RESTful Fetch API</h3>
                        <p>Decoupled JSON API endpoints supporting asynchronous GET, POST, PUT, and DELETE operations without page reloads.</p>
                    </div>
                    <div>
                        <h3>📱 Responsive Accessibility</h3>
                        <p>WCAG 2.1 AA conforming contrast, keyboard navigability, semantic landmark elements, and mobile-first CSS architecture.</p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Accessible Modal Dialog -->
    <div id="info-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-box">
            <button type="button" class="modal-close-btn" data-modal-close aria-label="Close dialog">&times;</button>
            <h3 id="modal-title">Notice</h3>
            <div id="modal-body">
                <p>Modal content will be populated dynamically.</p>
            </div>
            <div style="text-align: right; margin-top: 1.5rem;">
                <button type="button" class="btn btn-primary" data-modal-close>Acknowledge</button>
            </div>
        </div>
    </div>

    <!-- Global Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>🎓 StudentHub</h4>
                    <p style="color: #94a3b8; font-size: 0.9rem;">The unified student management and campus activity portal for CHARUSAT University.</p>
                    <p style="color: #64748b; font-size: 0.8rem;">Subject: ITUE203 - Web Development Frameworks</p>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.html">About Portal</a></li>
                        <li><a href="events.html">Events Catalog</a></li>
                        <li><a href="faq.html">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Account</h4>
                    <ul>
                        <li><a href="login.html">Sign In</a></li>
                        <li><a href="register.html">Student Registration</a></li>
                        <li><a href="dashboard.php">Student Dashboard</a></li>
                        <li><a href="admin/index.php">Admin Console</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contact Support</h4>
                    <p style="color: #94a3b8; font-size: 0.85rem;">CSPIT Building, CHARUSAT Campus, Changa - 388421</p>
                    <p style="color: #94a3b8; font-size: 0.85rem;">Email: support@studenthub.edu</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 StudentHub - CHARUSAT CSPIT. Built for ITUE203 Practical Evaluation.</p>
            </div>
        </div>
    </footer>
</body>
</html>
