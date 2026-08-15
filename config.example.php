<?php

/**
 * PORTFOLIO CONFIG (EXAMPLE)
 * ==========================
 * Copy this file to config.php and fill in your real values.
 * config.php is ignored by git so your credentials never get pushed.
 */

declare(strict_types=1);

return [

    /* ----------------------- MySQL DATABASE ----------------------- */
    'db' => [
        'host'     => 'localhost',
        'port'     => 3306,
        'name'     => 'portfolio_db',      // your database name
        'user'     => 'root',              // your MySQL username
        'pass'     => '',                  // your MySQL password
        'charset'  => 'utf8mb4',
    ],

    /* ----------------------- SMTP (Gmail) -------------------------
       Gmail requires an App Password instead of your normal password:
       1. Enable 2-Step Verification on your Google account.
       2. Go to https://myaccount.google.com/apppasswords
       3. Create an app password, copy the 16-char code below.
    ---------------------------------------------------------------- */
    'smtp' => [
        'enabled'    => true,
        'host'       => 'smtp.gmail.com',
        'port'       => 587,
        'encryption' => 'tls',             // 'tls' or 'ssl'
        'username'   => 'youremail@gmail.com',
        'password'   => 'YOUR_16_CHAR_APP_PASSWORD',  // App Password, NOT your login password
        'from_name'  => 'Portfolio Contact Form',
        'to_email'   => 'youremail@gmail.com',
        'to_name'    => 'Your Name',
    ],

    /* ----------------------- ADMIN VIEWER -------------------------
       Password used by admin/index.php to view saved messages. */
    'admin' => [
        'password' => 'change-me-123',
    ],
];
