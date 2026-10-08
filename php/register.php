<?php
/**
 * StudentHub - PHP Server-Side Form Processing & JSON Storage (Practical 07)
 * Validates, sanitizes, and records student registration into data/registrations.json
 */

header('Content-Type: text/html; charset=UTF-8');

$errors = [];
$successMessage = "";

// Ensure request is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1. Sanitize & Retrieve Inputs
    $fullname = isset($_POST['fullname']) ? trim(strip_tags($_POST['fullname'])) : '';
    $email = isset($_POST['email']) ? trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
    $mobile = isset($_POST['mobile']) ? trim(strip_tags($_POST['mobile'])) : '';
    $gender = isset($_POST['gender']) ? trim(strip_tags($_POST['gender'])) : '';
    $course = isset($_POST['course']) ? trim(strip_tags($_POST['course'])) : '';
    $year = isset($_POST['year']) ? trim(strip_tags($_POST['year'])) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $terms = isset($_POST['terms']) ? true : false;

    // 2. Strict Server-Side Validation Rules
    if (empty($fullname)) {
        $errors['fullname'] = "Full name is required.";
    } elseif (!preg_match("/^[a-zA-Z\s]{3,50}$/", $fullname)) {
        $errors['fullname'] = "Full name must be 3-50 letters without numbers or special symbols.";
    }

    if (empty($email)) {
        $errors['email'] = "University email address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please provide a valid email address.";
    }

    if (empty($mobile)) {
        $errors['mobile'] = "Mobile number is required.";
    } elseif (!preg_match("/^[6-9]\d{9}$/", $mobile)) {
        $errors['mobile'] = "Enter a valid 10-digit Indian mobile number (starting with 6-9).";
    }

    if (empty($gender)) {
        $errors['gender'] = "Please select your gender.";
    }

    if (empty($course)) {
        $errors['course'] = "Please select your academic department.";
    }

    if (empty($year)) {
        $errors['year'] = "Please select your year of study.";
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

    // 3. Duplicate Check & File Storage in data/registrations.json
    if (empty($errors)) {
        $dataFile = __DIR__ . "/../data/registrations.json";
        $existingRecords = [];

        if (file_exists($dataFile)) {
            $jsonContent = file_get_contents($dataFile);
            $existingRecords = json_decode($jsonContent, true) ?: [];
        }

        // Check duplicate email
        foreach ($existingRecords as $record) {
            if (strcasecmp($record['email'], $email) === 0) {
                $errors['email'] = "An account with this email address already exists.";
                break;
            }
        }

        if (empty($errors)) {
            $newRecord = [
                "id" => count($existingRecords) + 1,
                "fullname" => htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8'),
                "email" => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
                "mobile" => htmlspecialchars($mobile, ENT_QUOTES, 'UTF-8'),
                "gender" => htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'),
                "course" => htmlspecialchars($course, ENT_QUOTES, 'UTF-8'),
                "year" => htmlspecialchars($year, ENT_QUOTES, 'UTF-8'),
                "password_hash" => password_hash($password, PASSWORD_DEFAULT),
                "registered_at" => date("Y-m-d H:i:s")
            ];

            $existingRecords[] = $newRecord;
            file_put_contents($dataFile, json_encode($existingRecords, JSON_PRETTY_PRINT));
            $successMessage = "Registration successful! Your student profile has been recorded.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Status | StudentHub</title>
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
                <?php if (!empty($successMessage)): ?>
                    <div style="font-size: 3.5rem; margin-bottom: 1rem;">✅</div>
                    <h1 style="color: var(--success-700); font-size: 1.75rem; margin-bottom: 0.75rem;">Registration Confirmed</h1>
                    <p style="color: var(--text-muted); margin-bottom: 1.5rem;"><?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?></p>
                    <div class="card" style="background-color: var(--secondary-50); text-align: left; margin-bottom: 1.5rem;">
                        <p><strong>Student Name:</strong> <?php echo htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Email Address:</strong> <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Course & Department:</strong> <?php echo htmlspecialchars($course, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p style="margin-bottom: 0;"><strong>Storage Engine:</strong> JSON File (data/registrations.json)</p>
                    </div>
                    <div style="display: flex; gap: 1rem; justify-content: center;">
                        <a href="../login.html" class="btn btn-primary">Proceed to Login</a>
                        <a href="../events.html" class="btn btn-secondary">Explore Events</a>
                    </div>
                <?php else: ?>
                    <div style="font-size: 3.5rem; margin-bottom: 1rem;">⚠️</div>
                    <h1 style="color: var(--danger-700); font-size: 1.75rem; margin-bottom: 0.75rem;">Registration Failed</h1>
                    <p style="color: var(--text-muted); margin-bottom: 1.5rem;">The following server-side validation errors were encountered:</p>
                    <div class="alert alert-danger" style="text-align: left; margin-bottom: 1.5rem;">
                        <ul style="margin-left: 1.25rem;">
                            <?php foreach ($errors as $field => $msg): ?>
                                <li><strong><?php echo ucfirst($field); ?>:</strong> <?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div style="display: flex; gap: 1rem; justify-content: center;">
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
