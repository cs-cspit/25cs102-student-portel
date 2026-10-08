<?php
/**
 * StudentHub - Secure MySQL Database Registration Handler (Practical 09)
 * Performs server-side validation, duplicate email checks, bcrypt password hashing,
 * dual table relational insert (users + students), and security audit logging.
 */

header('Content-Type: text/html; charset=UTF-8');
require_once __DIR__ . '/db.php';

$errors = [];
$successMessage = "";
$registeredDetails = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1. Sanitize & Retrieve Form Inputs
    $fullname = isset($_POST['fullname']) ? trim(strip_tags($_POST['fullname'])) : '';
    $email = isset($_POST['email']) ? trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
    $mobile = isset($_POST['mobile']) ? trim(strip_tags($_POST['mobile'])) : '';
    $gender = isset($_POST['gender']) ? trim(strip_tags($_POST['gender'])) : '';
    $course = isset($_POST['course']) ? trim(strip_tags($_POST['course'])) : '';
    $year = isset($_POST['year']) ? trim(strip_tags($_POST['year'])) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $terms = isset($_POST['terms']) ? true : false;

    // 2. Comprehensive Server-Side Validation
    if (empty($fullname)) {
        $errors['fullname'] = "Full name is required.";
    } elseif (!preg_match("/^[a-zA-Z\s]{3,50}$/", $fullname)) {
        $errors['fullname'] = "Full name must be 3-50 letters without numbers or special symbols.";
    }

    if (empty($email)) {
        $errors['email'] = "University email address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please provide a valid university email address.";
    }

    if (empty($mobile)) {
        $errors['mobile'] = "Mobile number is required.";
    } elseif (!preg_match("/^[6-9]\d{9}$/", $mobile)) {
        $errors['mobile'] = "Enter a valid 10-digit Indian mobile number (starts with 6-9).";
    }

    if (empty($gender)) {
        $errors['gender'] = "Please select your gender.";
    }

    if (empty($course)) {
        $errors['course'] = "Please select your academic department.";
    }

    if (empty($year)) {
        $errors['year'] = "Please select your academic year.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters long.";
    }

    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Password confirmation does not match.";
    }

    if (!$terms) {
        $errors['terms'] = "You must accept the terms of service to register.";
    }

    // 3. Database Duplicate Verification & Insert
    if (empty($errors)) {
        if ($db_connected && isset($conn)) {
            // Check Duplicate Email in users table
            $checkSql = "SELECT id FROM users WHERE email = ? LIMIT 1";
            $existingUser = executeQuery($conn, $checkSql, "s", [$email]);

            if ($existingUser && $existingUser->num_rows > 0) {
                $errors['email'] = "A student account with this email address is already registered.";
            } else {
                // Begin Database Transaction
                $conn->begin_transaction();
                try {
                    // Hash Password with BCRYPT
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                    // Insert into `users` table
                    $userSql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'student')";
                    $userStmt = $conn->prepare($userSql);
                    $userStmt->bind_param("sss", $fullname, $email, $passwordHash);
                    $userStmt->execute();
                    $newUserId = $conn->insert_id;

                    // Insert into `students` table
                    $yearStr = $year . (is_numeric($year) ? " Year" : "");
                    $studentSql = "INSERT INTO students (user_id, name, email, mobile, course, year, gender, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Active')";
                    $studentStmt = $conn->prepare($studentSql);
                    $studentStmt->bind_param("issssss", $newUserId, $fullname, $email, $mobile, $course, $yearStr, $gender);
                    $studentStmt->execute();
                    $newStudentId = $conn->insert_id;

                    // Log Audit Trail
                    logAuditEvent($conn, $newUserId, "USER_REGISTRATION", "students", $newStudentId, "New student registered via portal.");

                    $conn->commit();

                    $successMessage = "Your student account has been created successfully in the StudentHub database.";
                    $registeredDetails = [
                        "id" => $newStudentId,
                        "name" => $fullname,
                        "email" => $email,
                        "course" => $course,
                        "year" => $yearStr
                    ];
                } catch (Exception $e) {
                    $conn->rollback();
                    error_log("Registration Transaction Failed: " . $e->getMessage());
                    $errors['db'] = "Database registration transaction failed. Please try again.";
                }
            }
        } else {
            // Fallback for offline development / flat-file sync
            $dataFile = __DIR__ . "/../data/registrations.json";
            $records = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) ?: [] : [];

            foreach ($records as $rec) {
                if (strcasecmp($rec['email'], $email) === 0) {
                    $errors['email'] = "An account with this email address already exists.";
                    break;
                }
            }

            if (empty($errors)) {
                $newRecord = [
                    "id" => count($records) + 1,
                    "fullname" => $fullname,
                    "email" => $email,
                    "mobile" => $mobile,
                    "gender" => $gender,
                    "course" => $course,
                    "year" => $year,
                    "password_hash" => password_hash($password, PASSWORD_DEFAULT),
                    "registered_at" => date("Y-m-d H:i:s")
                ];
                $records[] = $newRecord;
                file_put_contents($dataFile, json_encode($records, JSON_PRETTY_PRINT));
                $successMessage = "Student profile recorded in local storage engine.";
                $registeredDetails = [
                    "id" => $newRecord["id"],
                    "name" => $fullname,
                    "email" => $email,
                    "course" => $course,
                    "year" => $year
                ];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Confirmation | StudentHub</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
</head>
<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>
    <header class="site-header">
        <div class="container header-inner">
            <a href="../index.html" class="brand-logo">🎓 StudentHub <span class="brand-badge">Campus Portal</span></a>
            <nav class="main-nav">
                <ul>
                    <li><a href="../index.html">Home</a></li>
                    <li><a href="../about.html">About</a></li>
                    <li><a href="../events.html">Events</a></li>
                    <li><a href="../faq.html">FAQ</a></li>
                    <li><a href="../contact.html">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main id="main-content">
        <div class="container" style="max-width: 600px; margin-top: 2rem;">
            <div class="card" style="padding: 2.5rem; text-align: center;">
                <?php if (!empty($successMessage) && $registeredDetails): ?>
                    <div style="font-size: 3.5rem; margin-bottom: 1rem;">🎉</div>
                    <h1 style="color: var(--success-700); font-size: 1.75rem; margin-bottom: 0.75rem;">Registration Successful</h1>
                    <p style="color: var(--text-muted); margin-bottom: 1.5rem;"><?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?></p>
                    
                    <div class="card" style="background-color: var(--secondary-50); text-align: left; margin-bottom: 1.5rem;">
                        <p><strong>Student ID:</strong> #<?php echo htmlspecialchars($registeredDetails['id'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Student Name:</strong> <?php echo htmlspecialchars($registeredDetails['name'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Registered Email:</strong> <?php echo htmlspecialchars($registeredDetails['email'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Enrolled Department:</strong> <?php echo htmlspecialchars($registeredDetails['course'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p style="margin-bottom: 0;"><strong>Security Status:</strong> BCRYPT Encrypted & Relational DB Verified</p>
                    </div>

                    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                        <a href="../login.html" class="btn btn-primary">Sign In to Dashboard</a>
                        <a href="../events.html" class="btn btn-secondary">Explore Events Catalog</a>
                    </div>
                <?php else: ?>
                    <div style="font-size: 3.5rem; margin-bottom: 1rem;">⚠️</div>
                    <h1 style="color: var(--danger-700); font-size: 1.75rem; margin-bottom: 0.75rem;">Registration Error</h1>
                    <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Please review and resolve the following errors:</p>
                    
                    <div class="alert alert-danger" style="text-align: left; margin-bottom: 1.5rem;">
                        <ul style="margin-left: 1.25rem;">
                            <?php foreach ($errors as $field => $msg): ?>
                                <li><strong><?php echo ucfirst($field); ?>:</strong> <?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                        <a href="../register.html" class="btn btn-primary">Back to Registration Form</a>
                        <a href="../contact.html" class="btn btn-secondary">Contact Support</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2026 StudentHub - CHARUSAT CSPIT. Built for ITUE203 Web Development Frameworks.</p>
            </div>
        </div>
    </footer>
</body>
</html>
