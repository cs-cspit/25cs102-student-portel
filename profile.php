<?php
/**
 * StudentHub - Authenticated Student Profile (Practical 10)
 */
require_once __DIR__ . '/php/student-auth.php';

$currentUser = getCurrentUser();
$student = [
    "name" => $currentUser['name'],
    "email" => $currentUser['email'],
    "mobile" => "9876543210",
    "course" => "B.Tech Computer Science & Engineering (CSE)",
    "year" => "2nd Year (Semester 3)",
    "gender" => "Male",
    "status" => "Active"
];

if ($db_connected && isset($conn)) {
    $stmt = $conn->prepare("SELECT name, email, mobile, course, year, gender, status FROM students WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $currentUser['email']);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $student = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile | StudentHub Portal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <script src="js/main.js" defer></script>
</head>
<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <header class="site-header">
        <div class="container header-inner">
            <a href="index.html" class="brand-logo">🎓 StudentHub <span class="brand-badge">Campus Portal</span></a>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="events.html">Events</a></li>
                    <li><a href="profile.php" class="active" aria-current="page">Profile</a></li>
                    <li><a href="faq.html">FAQ</a></li>
                    <li><a href="feedback.html">Feedback</a></li>
                </ul>
            </nav>
            <div class="nav-cta-group">
                <button type="button" id="theme-toggle-btn" class="theme-toggle-btn" aria-label="Toggle theme">🌙</button>
                <span style="font-size: 0.9rem; font-weight: 600; color: var(--primary-600);">
                    👤 <?php echo htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8'); ?>
                </span>
                <a href="php/logout.php" class="btn btn-secondary btn-sm">Sign Out</a>
            </div>
        </div>
    </header>

    <main id="main-content">
        <div class="container">
            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Student Profile</li>
                </ol>
            </nav>

            <header style="margin-bottom: 2rem;">
                <h1>My Academic Profile</h1>
                <p>Manage your verified university identity and view active enrollment details.</p>
            </header>

            <div class="grid-2">
                <section class="card">
                    <h2 style="font-size: 1.35rem; margin-bottom: 1.25rem;">Student Identity Record</h2>
                    <table aria-label="Student details">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 35%;">Full Name</th>
                                <td><?php echo htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">University Email</th>
                                <td><?php echo htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Department</th>
                                <td><?php echo htmlspecialchars($student['course'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Academic Year</th>
                                <td><?php echo htmlspecialchars($student['year'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Gender</th>
                                <td><?php echo htmlspecialchars($student['gender'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Primary Mobile</th>
                                <td><?php echo htmlspecialchars($student['mobile'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Enrollment Status</th>
                                <td><span class="status-badge status-confirmed"><?php echo htmlspecialchars($student['status'] ?? 'Active', ENT_QUOTES, 'UTF-8'); ?></span></td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section class="card">
                    <h2 style="font-size: 1.35rem; margin-bottom: 1.25rem;">Edit Contact Information</h2>
                    <form action="profile.php" method="POST">
                        <div class="form-group">
                            <label for="p-name">Full Name</label>
                            <input type="text" id="p-name" class="form-control" value="<?php echo htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="p-email">Email (Read-Only)</label>
                            <input type="email" id="p-email" class="form-control" value="<?php echo htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8'); ?>" readonly style="background-color: var(--secondary-100); cursor: not-allowed;">
                        </div>
                        <div class="form-group">
                            <label for="p-mobile">Mobile Number</label>
                            <input type="tel" id="p-mobile" class="form-control" value="<?php echo htmlspecialchars($student['mobile'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div style="margin-top: 1.5rem;">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2026 StudentHub - CHARUSAT CSPIT.</p>
            </div>
        </div>
    </footer>
</body>
</html>
