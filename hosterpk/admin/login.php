<?php
declare(strict_types=1);
require dirname(__DIR__) . '/includes/bootstrap.php';
if (admin_logged_in()) redirect('admin/index.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? '');
    if (!rate_limit('admin-login', client_ip(), 10, 900)) {
        $error = 'Too many login attempts. Please wait and try again.';
    } else {
        $stmt = db()->prepare('SELECT id, name, password_hash FROM admins WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $admin = $stmt->fetch();
        if ($admin && password_verify($password, $admin['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int)$admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['admin_last_seen'] = time();
            redirect('admin/index.php');
        }
        $error = 'Invalid email or password.';
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin login — Herbal Crown</title><link rel="stylesheet" href="../assets/css/admin.min.css"></head>
<body class="admin-auth"><form class="auth-card" method="post"><img src="../assets/images/crown-mark.svg" alt=""><p>HERBAL CROWN ADMIN</p><h1>Welcome back</h1>
<?php if (isset($_GET['created'])): ?><div class="success">Administrator created. You can now sign in.</div><?php endif; ?>
<?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><label>Email<input name="email" type="email" required autocomplete="username"></label>
<label>Password<input name="password" type="password" required autocomplete="current-password"></label><button>Sign in</button>
<small>No account yet? <a href="setup.php">Run one-time setup</a></small></form></body></html>
