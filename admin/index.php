<?php

/**
 * ADMIN MESSAGE VIEWER
 * --------------------
 * Password-protected page to read the messages saved in the `contacts` table.
 * Set the password in config.php -> ['admin']['password'].
 *
 * URL: http://localhost:8000/admin/
 */

declare(strict_types=1);

session_start();

$config = require __DIR__ . '/../config.php';
$adminPw = $config['admin']['password'];

function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $db = $GLOBALS['config']['db'];
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', $db['host'], $db['port'], $db['name'], $db['charset']);
        $pdo = new PDO($dsn, $db['user'], $db['pass'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

$flash = '';

/* ---------- Login / logout ---------- */
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

if (isset($_POST['password']) && is_string($_POST['password'])) {
    if (hash_equals($adminPw, $_POST['password'])) {
        $_SESSION['admin'] = true;
    } else {
        $flash = 'Wrong password.';
    }
}

$loggedIn = !empty($_SESSION['admin']);

/* ---------- Actions (only when logged in) ---------- */
if ($loggedIn) {
    if (isset($_GET['toggle'], $_GET['token']) && hash_equals($_SESSION['csrf'] ?? '', $_GET['token'])) {
        $stmt = db()->prepare('UPDATE contacts SET is_read = NOT is_read WHERE id = ?');
        $stmt->execute([(int) $_GET['toggle']]);
        header('Location: index.php');
        exit;
    }

    if (isset($_GET['delete'], $_GET['token']) && hash_equals($_SESSION['csrf'] ?? '', $_GET['token'])) {
        $stmt = db()->prepare('DELETE FROM contacts WHERE id = ?');
        $stmt->execute([(int) $_GET['delete']]);
        header('Location: index.php');
        exit;
    }

    $_SESSION['csrf'] = bin2hex(random_bytes(16));

    $dbDown = false;
    try {
        $messages = db()->query('SELECT * FROM contacts ORDER BY created_at DESC, id DESC')->fetchAll();
    } catch (PDOException $e) {
        $dbDown = true;
        $messages = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <style>
        body { background: #070710; }
        ::-webkit-scrollbar { width: 9px; }
        ::-webkit-scrollbar-track { background: #070710; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #06b6d4, #7c3aed); border-radius: 9999px; }
    </style>
</head>
<body class="text-slate-200 font-sans min-h-screen">

<div class="max-w-5xl mx-auto px-6 py-10">

    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-2xl font-bold text-white">
                <i class="fa-solid fa-inbox text-cyan-400 mr-2"></i>Messages
            </h1>
            <p class="text-sm text-slate-500 mt-1">Job applications from the contact form</p>
        </div>
        <?php if ($loggedIn): ?>
            <form method="POST">
                <button name="logout" value="1"
                        class="px-4 py-2 rounded-lg border border-white/15 text-sm hover:border-red-400 hover:text-red-300 transition-colors">
                    <i class="fa-solid fa-right-from-bracket mr-1"></i>Log out
                </button>
            </form>
        <?php endif; ?>
    </div>

    <?php if ($flash): ?>
        <div class="mb-6 rounded-lg border border-red-500/30 bg-red-500/10 text-red-300 text-sm p-3"><?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>

    <?php if (!$loggedIn): ?>
        <!-- Login card -->
        <div class="max-w-sm mx-auto bg-white/5 border border-white/10 rounded-2xl p-8 mt-20">
            <h2 class="text-lg font-semibold text-white text-center mb-6">Admin Login</h2>
            <form method="POST">
                <label class="block text-xs uppercase tracking-wider text-slate-500 mb-2">Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white outline-none focus:border-cyan-400/60 mb-5">
                <button class="w-full py-2.5 rounded-lg text-white font-semibold text-sm"
                        style="background:linear-gradient(135deg,#06b6d4,#7c3aed)">
                    <i class="fa-solid fa-lock-open mr-1"></i>Login
                </button>
            </form>
            <p class="text-xs text-slate-600 text-center mt-5">Password: set in config.php → admin</p>
        </div>
    <?php elseif ($dbDown): ?>
        <div class="rounded-xl border border-amber-500/30 bg-amber-500/10 p-5 text-sm text-amber-300">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i>
            Could not connect to the database. Check the credentials in config.php and make sure MySQL is running.
        </div>
    <?php elseif (empty($messages)): ?>
        <div class="text-center py-20 text-slate-500">
            <i class="fa-solid fa-envelope-open-text text-4xl mb-4 opacity-40"></i>
            <p>No messages yet. Submit the contact form to see them here.</p>
        </div>
    <?php else: ?>
        <!-- Message list -->
        <div class="space-y-4">
            <?php foreach ($messages as $m): ?>
                <div class="rounded-2xl border p-5 <?= $m['is_read'] ? 'border-white/10 bg-white/[0.02]' : 'border-cyan-400/30 bg-cyan-400/[0.05]' ?>">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 font-semibold text-sm"
                                  style="background:linear-gradient(135deg,#06b6d4,#7c3aed)">
                                <?= htmlspecialchars(mb_strtoupper(mb_substr($m['name'], 0, 1))) ?>
                            </span>
                            <div class="min-w-0">
                                <p class="font-semibold text-white truncate">
                                    <?= htmlspecialchars($m['name']) ?>
                                    <?php if (!$m['is_read']): ?>
                                        <span class="ml-2 text-[10px] uppercase tracking-wider px-2 py-0.5 rounded-full bg-cyan-400/20 text-cyan-300">New</span>
                                    <?php endif; ?>
                                </p>
                                <p class="text-xs text-slate-500 truncate">
                                    <a href="mailto:<?= htmlspecialchars($m['email']) ?>" class="hover:text-cyan-400"><?= htmlspecialchars($m['email']) ?></a>
                                    &middot; <?= htmlspecialchars(date('M j, Y · g:i A', strtotime($m['created_at']))) ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="?toggle=<?= $m['id'] ?>&token=<?= htmlspecialchars($_SESSION['csrf']) ?>"
                               title="<?= $m['is_read'] ? 'Mark unread' : 'Mark read' ?>"
                               class="w-9 h-9 rounded-lg border border-white/10 flex items-center justify-center text-slate-400 hover:text-cyan-300 transition-colors">
                                <i class="fa-solid <?= $m['is_read'] ? 'fa-eye' : 'fa-eye-slash' ?>"></i>
                            </a>
                            <a href="?delete=<?= $m['id'] ?>&token=<?= htmlspecialchars($_SESSION['csrf']) ?>"
                               title="Delete" onclick="return confirm('Delete this message?')"
                               class="w-9 h-9 rounded-lg border border-white/10 flex items-center justify-center text-slate-400 hover:text-red-400 transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </div>

                    <p class="mt-3 text-sm text-cyan-300 font-medium">
                        <i class="fa-solid fa-tag mr-1 opacity-60"></i><?= htmlspecialchars($m['subject']) ?>
                    </p>
                    <p class="mt-2 text-sm text-slate-300 leading-relaxed whitespace-pre-line"><?= htmlspecialchars($m['message']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
</body>
</html>
