<?php
/**
 * StudentHub - Contact Form Server Processor (Practical 07)
 */

header('Content-Type: text/html; charset=UTF-8');

$errors = [];
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : '';
    $email = isset($_POST['email']) ? trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
    $subject = isset($_POST['subject']) ? trim(strip_tags($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';

    if (empty($name)) $errors['name'] = "Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Valid email is required.";
    if (empty($subject)) $errors['subject'] = "Subject selection is required.";
    if (empty($message)) $errors['message'] = "Message content is required.";

    if (empty($errors)) {
        $dataFile = __DIR__ . "/../data/inquiries.json";
        $records = [];
        if (file_exists($dataFile)) {
            $records = json_decode(file_get_contents($dataFile), true) ?: [];
        }

        $records[] = [
            "id" => count($records) + 1,
            "name" => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
            "email" => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
            "subject" => htmlspecialchars($subject, ENT_QUOTES, 'UTF-8'),
            "message" => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
            "submitted_at" => date("Y-m-d H:i:s")
        ];

        file_put_contents($dataFile, json_encode($records, JSON_PRETTY_PRINT));
        $successMessage = "Thank you! Your message has been received by our support team.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Status | StudentHub</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a href="../index.html" class="brand-logo">🎓 StudentHub</a>
        </div>
    </header>
    <main class="container" style="max-width: 550px; margin-top: 3rem;">
        <div class="card" style="text-align: center; padding: 2rem;">
            <?php if (!empty($successMessage)): ?>
                <h1 style="color: var(--success-700); font-size: 1.5rem;">Message Received</h1>
                <p><?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?></p>
                <a href="../index.html" class="btn btn-primary">Back to Home</a>
            <?php else: ?>
                <h1 style="color: var(--danger-700); font-size: 1.5rem;">Submission Error</h1>
                <p>Please complete all required fields.</p>
                <a href="../contact.html" class="btn btn-secondary">Try Again</a>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
