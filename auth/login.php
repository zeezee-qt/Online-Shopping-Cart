<?php
require_once __DIR__ . '/../includes/header.php';

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        if (login($email, $password)) {
            $role = currentUser()['role'];
            $route = match ($role) {
                'admin' => '/admin/dashboard.php',
                'employee' => '/employee/dashboard.php',
                default => '/customer/dashboard.php',
            };
            header('Location: ' . $route);
            exit;
        }
        $error = 'Invalid credentials.';
    } catch (Throwable $e) {
        $error = 'Login unavailable until database is configured.';
    }
}
?>
<h2>Login</h2>
<?php if ($error): ?><p class="notice"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" class="form-card">
  <label>Email <input type="email" name="email" required></label>
  <label>Password <input type="password" name="password" required></label>
  <button class="btn" type="submit">Login</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
