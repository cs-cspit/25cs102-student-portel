<?php
/**
 * StudentHub - Administrative Student Management CRUD (Practical 11)
 * Supports CREATE, READ, UPDATE, DELETE with search, department filtering,
 * confirmation modals, prepared statements, and security audit logging.
 */

require_once __DIR__ . '/../php/admin-auth.php';

$successMsg = "";
$errorMsg = "";

// 1. Handle Form Actions (Create, Update, Delete)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $csrfToken = $_POST['csrf_token'] ?? '';

    // Enforce CSRF token verification
    if (!verifyCsrfToken($csrfToken)) {
        $errorMsg = "Security validation failed: Invalid or expired CSRF token. Please refresh and try again.";
    } else {
        // CREATE STUDENT
        if ($action === "create") {
        $name = trim(strip_tags($_POST['name'] ?? ''));
        $email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
        $mobile = trim(strip_tags($_POST['mobile'] ?? ''));
        $course = trim(strip_tags($_POST['course'] ?? ''));
        $year = trim(strip_tags($_POST['year'] ?? ''));
        $gender = trim(strip_tags($_POST['gender'] ?? 'Male'));

        if (empty($name) || empty($email) || empty($mobile) || empty($course) || empty($year)) {
            $errorMsg = "All fields are required to register a student.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg = "Invalid student email address.";
        } else {
            if ($db_connected && isset($conn)) {
                $check = executeQuery($conn, "SELECT id FROM users WHERE email = ? LIMIT 1", "s", [$email]);
                if ($check && $check->num_rows > 0) {
                    $errorMsg = "A user with this email address already exists.";
                } else {
                    $conn->begin_transaction();
                    try {
                        $defaultPass = password_hash("Student@123", PASSWORD_DEFAULT);
                        $uStmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'student')");
                        $uStmt->bind_param("sss", $name, $email, $defaultPass);
                        $uStmt->execute();
                        $userId = $conn->insert_id;

                        $sStmt = $conn->prepare("INSERT INTO students (user_id, name, email, mobile, course, year, gender, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Active')");
                        $sStmt->bind_param("issssss", $userId, $name, $email, $mobile, $course, $year, $gender);
                        $sStmt->execute();
                        $newStudentId = $conn->insert_id;

                        logAuditEvent($conn, $_SESSION['user_id'], "STUDENT_CREATED", "students", $newStudentId, "Admin added student: " . $name);
                        $conn->commit();
                        $successMsg = "Student record #{$newStudentId} ({$name}) successfully created.";
                    } catch (Exception $e) {
                        $conn->rollback();
                        $errorMsg = "Failed to create student: " . $e->getMessage();
                    }
                }
            }
        }
    }

    // UPDATE STUDENT
    elseif ($action === "update") {
        $studentId = intval($_POST['student_id'] ?? 0);
        $name = trim(strip_tags($_POST['name'] ?? ''));
        $mobile = trim(strip_tags($_POST['mobile'] ?? ''));
        $course = trim(strip_tags($_POST['course'] ?? ''));
        $year = trim(strip_tags($_POST['year'] ?? ''));
        $status = trim(strip_tags($_POST['status'] ?? 'Active'));

        if ($studentId > 0 && !empty($name) && !empty($mobile)) {
            if ($db_connected && isset($conn)) {
                $stmt = $conn->prepare("UPDATE students SET name = ?, mobile = ?, course = ?, year = ?, status = ? WHERE id = ?");
                $stmt->bind_param("sssssi", $name, $mobile, $course, $year, $status, $studentId);
                if ($stmt->execute()) {
                    logAuditEvent($conn, $_SESSION['user_id'], "STUDENT_UPDATED", "students", $studentId, "Admin updated details for student ID: " . $studentId);
                    $successMsg = "Student record #{$studentId} updated successfully.";
                } else {
                    $errorMsg = "Update failed.";
                }
            }
        }
    }

    // DELETE STUDENT
    elseif ($action === "delete") {
        $studentId = intval($_POST['student_id'] ?? 0);
        if ($studentId > 0 && $db_connected && isset($conn)) {
            // Find user_id first to delete associated user account
            $res = executeQuery($conn, "SELECT user_id, name FROM students WHERE id = ? LIMIT 1", "i", [$studentId]);
            if ($res && $row = $res->fetch_assoc()) {
                $delName = $row['name'];
                $userId = $row['user_id'];
                if ($userId) {
                    $delStmt = $conn->prepare("DELETE FROM users WHERE id = ?");
                    $delStmt->bind_param("i", $userId);
                    $delStmt->execute();
                } else {
                    $delStmt = $conn->prepare("DELETE FROM students WHERE id = ?");
                    $delStmt->bind_param("i", $studentId);
                    $delStmt->execute();
                }
                logAuditEvent($conn, $_SESSION['user_id'], "STUDENT_DELETED", "students", $studentId, "Admin removed student: " . $delName);
                $successMsg = "Student #{$studentId} ({$delName}) deleted successfully.";
            }
        }
    }
    }
}

// 2. Fetch Students with Search & Filters
$searchQuery = trim($_GET['q'] ?? '');
$courseFilter = trim($_GET['course'] ?? 'all');
$yearFilter = trim($_GET['year'] ?? 'all');

$students = [];
if ($db_connected && isset($conn)) {
    $sql = "SELECT id, name, email, mobile, course, year, gender, status, created_at FROM students WHERE 1=1";
    $params = [];
    $types = "";

    if (!empty($searchQuery)) {
        $sql .= " AND (name LIKE ? OR email LIKE ? OR mobile LIKE ?)";
        $searchTerm = "%" . $searchQuery . "%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $types .= "sss";
    }

    if ($courseFilter !== 'all' && !empty($courseFilter)) {
        $sql .= " AND course = ?";
        $params[] = $courseFilter;
        $types .= "s";
    }

    if ($yearFilter !== 'all' && !empty($yearFilter)) {
        $sql .= " AND year LIKE ?";
        $params[] = "%" . $yearFilter . "%";
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
}

// Fallback seed list if database offline
if (empty($students) && empty($searchQuery) && $courseFilter === 'all') {
    $jsonPath = __DIR__ . '/../data/students.json';
    if (file_exists($jsonPath)) {
        $students = json_decode(file_get_contents($jsonPath), true) ?: [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Directory CRUD | StudentHub Administration</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/admin.css">
    <script src="../js/main.js" defer></script>
    <script src="../js/api.js" defer></script>
</head>
<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Toast Notification Container -->
    <div id="toast-container" style="position: fixed; top: 1.5rem; right: 1.5rem; z-index: 99999; display: flex; flex-direction: column; gap: 0.5rem; pointer-events: none;"></div>

    <header class="site-header" style="background-color: var(--secondary-900); border-bottom: 1px solid var(--secondary-800);">
        <div class="container header-inner">
            <a href="index.php" class="brand-logo" style="color: #ffffff;">
                ⚙️ StudentHub <span class="brand-badge" style="background-color: #dc2626; color: #ffffff;">Admin Console</span>
            </a>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php" style="color: #cbd5e1;">Dashboard</a></li>
                    <li><a href="students.php" class="active" style="color: #60a5fa;">Students</a></li>
                    <li><a href="events.php" style="color: #cbd5e1;">Events</a></li>
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
                    <h1>Student Directory & Management</h1>
                    <p>Search, filter, enroll new students, edit records, and manage academic profiles via MySQL Prepared Statements or RESTful Fetch API.</p>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="button" class="btn btn-primary" data-modal-target="add-student-modal">+ Add New Student</button>
                </div>
            </header>

            <?php if (!empty($successMsg)): ?>
                <div class="alert alert-success" role="alert"><?php echo htmlspecialchars($successMsg, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <?php if (!empty($errorMsg)): ?>
                <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($errorMsg, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <!-- Search & Filter Bar -->
            <section class="card" style="margin-bottom: 1.5rem;">
                <form action="students.php" method="GET">
                    <div class="grid-3" style="margin-bottom: 0;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="q">Search by Name / Email / Phone</label>
                            <input type="search" id="q" name="q" class="form-control" value="<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Search student...">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="course">Filter by Department</label>
                            <select id="course" name="course" class="form-control">
                                <option value="all" <?php echo $courseFilter==='all'?'selected':''; ?>>All Departments</option>
                                <option value="B.Tech CSE" <?php echo $courseFilter==='B.Tech CSE'?'selected':''; ?>>B.Tech CSE</option>
                                <option value="B.Tech IT" <?php echo $courseFilter==='B.Tech IT'?'selected':''; ?>>B.Tech IT</option>
                                <option value="B.Tech CE" <?php echo $courseFilter==='B.Tech CE'?'selected':''; ?>>B.Tech CE</option>
                                <option value="B.Tech EC" <?php echo $courseFilter==='B.Tech EC'?'selected':''; ?>>B.Tech EC</option>
                                <option value="B.Tech ME" <?php echo $courseFilter==='B.Tech ME'?'selected':''; ?>>B.Tech ME</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom: 0; display: flex; align-items: flex-end; gap: 0.5rem;">
                            <button type="submit" class="btn btn-primary" style="flex: 1;">Apply</button>
                            <a href="students.php" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </section>

            <!-- Student Directory Table -->
            <section class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                    <h2 style="font-size: 1.25rem; margin-bottom: 0;">Enrolled Students (<span id="student-count-display"><?php echo count($students); ?></span> Records)</h2>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">⚡ Supports both standard form mutations and Fetch API AJAX CRUD</span>
                </div>

                <div class="table-responsive">
                    <table id="students-table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Department</th>
                                <th scope="col">Year</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="students-tbody">
                            <?php if (empty($students)): ?>
                                <tr id="empty-row">
                                    <td colspan="8" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                                        No student records found matching the specified filters.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($students as $s): ?>
                                    <tr id="student-row-<?php echo $s['id']; ?>">
                                        <td><strong>#<?php echo htmlspecialchars($s['id'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                        <td class="col-name"><?php echo htmlspecialchars($s['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="col-email"><?php echo htmlspecialchars($s['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="col-mobile"><?php echo htmlspecialchars($s['mobile'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="col-course"><?php echo htmlspecialchars($s['course'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="col-year"><?php echo htmlspecialchars($s['year'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><span class="status-badge status-confirmed"><?php echo htmlspecialchars($s['status'] ?? 'Active', ENT_QUOTES, 'UTF-8'); ?></span></td>
                                        <td>
                                            <div style="display: flex; gap: 0.35rem; flex-wrap: wrap;">
                                                <button type="button" class="btn btn-secondary btn-sm" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($s), ENT_QUOTES, 'UTF-8'); ?>)">Edit</button>
                                                <!-- Form POST Delete with CSRF -->
                                                <form action="students.php" method="POST" onsubmit="return confirm('Delete student #<?php echo $s['id']; ?> (<?php echo addslashes($s['name']); ?>)?');" style="display:inline;">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8'); ?>">
                                                    <input type="hidden" name="student_id" value="<?php echo $s['id']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                                <!-- Asynchronous AJAX Delete without page reload -->
                                                <button type="button" class="btn btn-outline btn-sm" onclick="ajaxDeleteStudent(<?php echo $s['id']; ?>, '<?php echo addslashes($s['name']); ?>', this)" title="Delete without page reload via Fetch API">⚡ AJAX</button>
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

    <!-- Modal: Add New Student -->
    <div id="add-student-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="modal-box" style="max-width: 600px;">
            <button type="button" class="modal-close-btn" data-modal-close aria-label="Close dialog">&times;</button>
            <h2 style="color: var(--primary-600); margin-bottom: 1rem;">Enroll New Student</h2>
            <form id="add-student-form" action="students.php" method="POST">
                <input type="hidden" name="action" value="create">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8'); ?>">
                <div class="form-group">
                    <label for="m-name">Full Name *</label>
                    <input type="text" id="m-name" name="name" class="form-control" required placeholder="Student name">
                </div>
                <div class="form-group">
                    <label for="m-email">Email Address *</label>
                    <input type="email" id="m-email" name="email" class="form-control" required placeholder="student@charusat.edu.in">
                </div>
                <div class="form-group">
                    <label for="m-mobile">Mobile Number *</label>
                    <input type="tel" id="m-mobile" name="mobile" class="form-control" required placeholder="9876543210">
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label for="m-course">Department *</label>
                        <select id="m-course" name="course" class="form-control" required>
                            <option value="B.Tech CSE">B.Tech CSE</option>
                            <option value="B.Tech IT">B.Tech IT</option>
                            <option value="B.Tech CE">B.Tech CE</option>
                            <option value="B.Tech EC">B.Tech EC</option>
                            <option value="B.Tech ME">B.Tech ME</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="m-year">Academic Year *</label>
                        <select id="m-year" name="year" class="form-control" required>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year" selected>2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                    </div>
                </div>
                <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 0.5rem; flex-wrap: wrap;">
                    <button type="button" class="btn btn-secondary" data-modal-close>Cancel</button>
                    <button type="button" class="btn btn-outline" onclick="ajaxCreateStudent(this)">⚡ Add via Fetch API</button>
                    <button type="submit" class="btn btn-primary">Save Student</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Edit Student -->
    <div id="edit-student-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="modal-box" style="max-width: 600px;">
            <button type="button" class="modal-close-btn" onclick="closeEditModal()" aria-label="Close dialog">&times;</button>
            <h2 style="color: var(--primary-600); margin-bottom: 1rem;">Edit Student Record</h2>
            <form id="edit-student-form" action="students.php" method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" id="edit-student-id" name="student_id" value="">
                <div class="form-group">
                    <label for="edit-name">Full Name</label>
                    <input type="text" id="edit-name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit-mobile">Mobile Number</label>
                    <input type="tel" id="edit-mobile" name="mobile" class="form-control" required>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label for="edit-course">Department</label>
                        <select id="edit-course" name="course" class="form-control" required>
                            <option value="B.Tech CSE">B.Tech CSE</option>
                            <option value="B.Tech IT">B.Tech IT</option>
                            <option value="B.Tech CE">B.Tech CE</option>
                            <option value="B.Tech EC">B.Tech EC</option>
                            <option value="B.Tech ME">B.Tech ME</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-year">Year</label>
                        <select id="edit-year" name="year" class="form-control" required>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit-status">Status</label>
                    <select id="edit-status" name="status" class="form-control">
                        <option value="Active">Active</option>
                        <option value="Pending">Pending</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 0.5rem; flex-wrap: wrap;">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    <button type="button" class="btn btn-outline" onclick="ajaxUpdateStudent(this)">⚡ Update via Fetch API</button>
                    <button type="submit" class="btn btn-primary">Update Record</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showToast(message, isError = false) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.style.padding = '0.85rem 1.25rem';
            toast.style.background = isError ? '#991b1b' : '#065f46';
            toast.style.color = '#ffffff';
            toast.style.borderRadius = '8px';
            toast.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.2)';
            toast.style.fontSize = '0.9rem';
            toast.style.fontWeight = '500';
            toast.style.pointerEvents = 'auto';
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            toast.style.transition = 'all 0.3s ease';
            toast.innerHTML = message;
            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateY(0)';
            }, 10);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-10px)';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        function openEditModal(student) {
            document.getElementById('edit-student-id').value = student.id;
            document.getElementById('edit-name').value = student.name;
            document.getElementById('edit-mobile').value = student.mobile;
            document.getElementById('edit-course').value = student.course;
            document.getElementById('edit-year').value = student.year;
            document.getElementById('edit-status').value = student.status || 'Active';
            
            const modal = document.getElementById('edit-student-modal');
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeEditModal() {
            const modal = document.getElementById('edit-student-modal');
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
        }

        // Asynchronous Delete using Fetch API (No page reload)
        async function ajaxDeleteStudent(id, name, btn) {
            if (!confirm(`[Fetch API / AJAX] Permanently delete student #${id} (${name}) without page reload?`)) {
                return;
            }
            btn.disabled = true;
            btn.textContent = '...';

            const res = await StudentHubAPI.delete('../api/students.php', { id: id });
            if (res.ok) {
                const row = document.getElementById(`student-row-${id}`) || btn.closest('tr');
                if (row) {
                    row.style.transition = 'all 0.4s ease';
                    row.style.backgroundColor = '#fee2e2';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        const countEl = document.getElementById('student-count-display');
                        if (countEl) {
                            const cur = parseInt(countEl.textContent, 10);
                            if (cur > 0) countEl.textContent = cur - 1;
                        }
                    }, 400);
                }
                showToast(`✅ Student #${id} (${name}) deleted successfully via Fetch API (No page reload).`);
            } else {
                showToast(`❌ Failed to delete student: ${res.data?.message || res.error || 'Server error'}`, true);
                btn.disabled = false;
                btn.textContent = '⚡ AJAX';
            }
        }

        // Asynchronous Create using Fetch API (No page reload)
        async function ajaxCreateStudent(btn) {
            const name = document.getElementById('m-name').value.trim();
            const email = document.getElementById('m-email').value.trim();
            const mobile = document.getElementById('m-mobile').value.trim();
            const course = document.getElementById('m-course').value;
            const year = document.getElementById('m-year').value;

            if (!name || !email || !mobile) {
                alert('Please fill out all required fields.');
                return;
            }

            btn.disabled = true;
            btn.textContent = '⏳ Creating...';

            const payload = { name, email, mobile, course, year, gender: 'Male' };
            const res = await StudentHubAPI.post('../api/students.php', payload);

            btn.disabled = false;
            btn.textContent = '⚡ Add via Fetch API';

            if (res.ok && res.data && res.data.data) {
                const newStudent = res.data.data;
                const tbody = document.getElementById('students-tbody');
                const emptyRow = document.getElementById('empty-row');
                if (emptyRow) emptyRow.remove();

                const newRow = document.createElement('tr');
                newRow.id = `student-row-${newStudent.id}`;
                newRow.style.backgroundColor = '#dcfce7';
                newRow.style.transition = 'background-color 1s ease';
                newRow.innerHTML = `
                    <td><strong>#${newStudent.id}</strong></td>
                    <td class="col-name">${newStudent.name}</td>
                    <td class="col-email">${newStudent.email}</td>
                    <td class="col-mobile">${mobile}</td>
                    <td class="col-course">${newStudent.course}</td>
                    <td class="col-year">${newStudent.year}</td>
                    <td><span class="status-badge status-confirmed">Active</span></td>
                    <td>
                        <div style="display: flex; gap: 0.35rem; flex-wrap: wrap;">
                            <button type="button" class="btn btn-secondary btn-sm" onclick="openEditModal(${JSON.stringify({id: newStudent.id, name: newStudent.name, email: newStudent.email, mobile: mobile, course: newStudent.course, year: newStudent.year, status: 'Active'})})">Edit</button>
                            <button type="button" class="btn btn-outline btn-sm" onclick="ajaxDeleteStudent(${newStudent.id}, '${newStudent.name.replace(/'/g, "\\'")}', this)">⚡ AJAX</button>
                        </div>
                    </td>
                `;
                tbody.prepend(newRow);
                setTimeout(() => { newRow.style.backgroundColor = ''; }, 1500);

                const countEl = document.getElementById('student-count-display');
                if (countEl) countEl.textContent = parseInt(countEl.textContent, 10) + 1;

                // Close modal and reset form
                const modal = document.getElementById('add-student-modal');
                if (modal) {
                    modal.classList.remove('active');
                    modal.setAttribute('aria-hidden', 'true');
                }
                document.getElementById('add-student-form').reset();
                showToast(`🎉 Student #${newStudent.id} (${newStudent.name}) created via Fetch API!`);
            } else {
                showToast(`❌ Create failed: ${res.data?.message || res.data?.errors?.email || 'Error'}`, true);
            }
        }

        // Asynchronous Update using Fetch API (No page reload)
        async function ajaxUpdateStudent(btn) {
            const id = document.getElementById('edit-student-id').value;
            const name = document.getElementById('edit-name').value.trim();
            const mobile = document.getElementById('edit-mobile').value.trim();
            const course = document.getElementById('edit-course').value;
            const year = document.getElementById('edit-year').value;
            const status = document.getElementById('edit-status').value;

            btn.disabled = true;
            btn.textContent = '⏳ Updating...';

            const payload = { id, name, mobile, course, year, status };
            const res = await StudentHubAPI.put('../api/students.php', payload);

            btn.disabled = false;
            btn.textContent = '⚡ Update via Fetch API';

            if (res.ok) {
                const row = document.getElementById(`student-row-${id}`);
                if (row) {
                    row.querySelector('.col-name').textContent = name;
                    row.querySelector('.col-mobile').textContent = mobile;
                    row.querySelector('.col-course').textContent = course;
                    row.querySelector('.col-year').textContent = year;
                    row.style.backgroundColor = '#dbeafe';
                    setTimeout(() => { row.style.backgroundColor = ''; }, 1200);
                }
                closeEditModal();
                showToast(`✅ Student #${id} details updated via Fetch API!`);
            } else {
                showToast(`❌ Update failed: ${res.data?.message || 'Error'}`, true);
            }
        }
    </script>
</body>
</html>
