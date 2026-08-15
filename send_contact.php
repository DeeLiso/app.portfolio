<?php

/**
 * CONTACT FORM HANDLER
 * --------------------
 * 1) Validates the form input.
 * 2) Saves the message to MySQL (table `contacts` is auto-created).
 * 3) Sends the message to your inbox via Gmail SMTP (PHPMailer).
 *
 * Configuration lives in config.php.
 */

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
$config = require __DIR__ . '/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;

/* ---------- Only accept POST ---------- */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php#contact');
    exit;
}

/* ---------- Anti-spam backend checks ---------- */
// Honeypot: real users never fill hidden fields, bots do.
if (!empty($_POST['website'])) {
    header('Location: index.php#contact');
    exit;
}

// Rate limit: min 5s between submits, max 5 per hour (per session).
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();

$now = time();
$_SESSION['contact_window'] = $_SESSION['contact_window'] ?? $now;
$_SESSION['contact_count']  = $_SESSION['contact_count']  ?? 0;
$_SESSION['last_contact']   = $_SESSION['last_contact']   ?? 0;

if ($now - $_SESSION['contact_window'] > 3600) {
    $_SESSION['contact_count'] = 0;
    $_SESSION['contact_window'] = $now;
}
if ($now - $_SESSION['last_contact'] < 5 || $_SESSION['contact_count'] >= 5) {
    header('Location: index.php?error=true#contact');
    exit;
}
$_SESSION['last_contact'] = $now;
$_SESSION['contact_count']++;

/* ---------- Validate input ---------- */
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

$nameOk    = mb_strlen($name) >= 2;
$emailOk   = filter_var($email, FILTER_VALIDATE_EMAIL);
$subjectOk = mb_strlen($subject) >= 3;
$messageOk = mb_strlen($message) >= 10;

if (!$nameOk || !$emailOk || !$subjectOk || !$messageOk) {
    header('Location: index.php?sent=false&error=true#contact');
    exit;
}

/* ---------- Save to MySQL ---------- */
$dbSaved = false;
$dbError = null;

try {
    $db = $config['db'];
    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=%s',
        $db['host'], $db['port'], $db['name'], $db['charset']
    );

    $pdo = new PDO($dsn, $db['user'], $db['pass'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    // Auto-create the table so the form works even on a fresh database.
    $pdo->exec("CREATE TABLE IF NOT EXISTS contacts (
        id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name        VARCHAR(100)    NOT NULL,
        email       VARCHAR(255)    NOT NULL,
        subject     VARCHAR(255)    NOT NULL,
        message     TEXT            NOT NULL,
        ip_address  VARCHAR(45)     DEFAULT NULL,
        user_agent  VARCHAR(255)    DEFAULT NULL,
        is_read     TINYINT(1)      NOT NULL DEFAULT 0,
        created_at  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_created_at (created_at),
        INDEX idx_email      (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $stmt = $pdo->prepare(
        'INSERT INTO contacts (name, email, subject, message, ip_address, user_agent)
         VALUES (:name, :email, :subject, :message, :ip, :ua)'
    );
    $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':subject' => $subject,
        ':message' => $message,
        ':ip'      => $_SERVER['REMOTE_ADDR'] ?? null,
        ':ua'      => mb_substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255),
    ]);

    $dbSaved = true;
} catch (PDOException $e) {
    $dbError = $e->getMessage();
}

/* ---------- Send email via Gmail SMTP ---------- */
$mailSent = false;
$mailError = null;

$smtp = $config['smtp'];

if (!empty($smtp['enabled']) && !empty($smtp['password']) && $smtp['password'] !== 'YOUR_16_CHAR_APP_PASSWORD') {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $smtp['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp['username'];
        $mail->Password   = $smtp['password'];
        $mail->SMTPSecure = $smtp['encryption'];
        $mail->Port       = $smtp['port'];

        $mail->setFrom($smtp['username'], $smtp['from_name']);
        $mail->addAddress($smtp['to_email'], $smtp['to_name']);
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "New Job Application: $subject";
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $mail->Body    = <<<HTML
            <div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden">
                <div style="background:linear-gradient(135deg,#06b6d4,#7c3aed);padding:18px 24px;color:#fff">
                    <h2 style="margin:0;font-size:20px">New Contact / Job Application</h2>
                </div>
                <div style="padding:24px">
                    <p><strong>Name:</strong> {$name}</p>
                    <p><strong>Email:</strong> <a href="mailto:{$email}">{$email}</a></p>
                    <p><strong>Subject:</strong> {$subject}</p>
                    <p><strong>Message:</strong></p>
                    <div style="background:#f8fafc;border-left:4px solid #06b6d4;padding:14px;border-radius:8px">
                        <p style="margin:0;white-space:pre-line">{$message}</p>
                    </div>
                </div>
                <div style="background:#f1f5f9;padding:12px 24px;font-size:12px;color:#64748b">
                    Sent from the portfolio contact form &middot; {$ip}
                </div>
            </div>
            HTML;
        $mail->AltBody = "Name: $name\nEmail: $email\nSubject: $subject\n\n$message";

        $mail->send();
        $mailSent = true;
    } catch (MailerException $e) {
        $mailError = $mail->ErrorInfo;
    }
} else {
    // SMTP not configured yet — attempt the basic mail() fallback.
    $mailSent = @mail(
        $smtp['to_email'],
        'New Job Application: ' . $subject,
        "Name: $name\nEmail: $email\nSubject: $subject\n\n$message",
        "From: $email\r\nReply-To: $email"
    );
}

/* ---------- Redirect back with status ---------- */
$db   = $dbSaved ? '1' : '0';
$mail = $mailSent ? '1' : '0';

if ($dbSaved || $mailSent) {
    header("Location: index.php?sent=true&db={$db}&mail={$mail}#contact");
} else {
    header("Location: index.php?sent=false&error=true#contact");
}
exit;
