<?php
declare(strict_types=1);
require dirname(__DIR__) . '/includes/bootstrap.php';

$count = (int)db()->query('SELECT COUNT(*) FROM admins')->fetchColumn();
if ($count > 0) {
    redirect('admin/login.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $setupKey = (string)($_POST['setup_key'] ?? '');
    $name = trim((string)($_POST['name'] ?? ''));
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? '');
    if (!hash_equals((string)$config['admin_setup_key'], $setupKey)) {
        $error = 'The setup key is incorrect.';
    } elseif (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 12) {
        $error = 'Enter a valid name, email and a password of at least 12 characters.';
    } else {
        $stmt = db()->prepare('INSERT INTO admins (name, email, password_hash, created_at) VALUES (?, ?, ?, NOW())');
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
        redirect('admin/login.php?created=1');
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Create admin — Herbal Crown</title><link rel="stylesheet" href="../assets/css/admin.min.css"></head>
<body class="admin-auth"><form class="auth-card" method="post"><img src="../assets/images/crown-mark.svg" alt=""><p>ONE-TIME SETUP</p><h1>Create administrator</h1>
<?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<label>Name<input name="name" required maxlength="100"></label><label>Email<input name="email" type="email" required maxlength="160"></label>
<label>Password<input name="password" type="password" minlength="12" required autocomplete="new-password"></label>
<label>Setup key<input name="setup_key" type="password" required></label><button>Create admin</button></form></body></html>
