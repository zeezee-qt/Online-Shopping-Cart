<?php
require_once __DIR__ . '/../includes/header.php';

$message = null;
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $ok = registerCustomer(
            trim($_POST['full_name'] ?? ''),
            trim($_POST['email'] ?? ''),
            $_POST['password'] ?? '',
            trim($_POST['phone'] ?? ''),
            trim($_POST['address'] ?? '')
        );

        if ($ok) {
            $message = 'Registration successful. Please login.';
        } else {
            $error = 'Email already exists.';
        }
    } catch (Throwable $e) {
        $error = 'Registration unavailable until database is configured.';
    }
}
?>
<h2>Create Customer Account</h2>
<?php if ($message): ?><p class="success"><?= htmlspecialchars($message) ?></p><?php endif; ?>
<?php if ($error): ?><p class="notice"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" class="form-card">
  <label>Full Name <input type="text" name="full_name" required></label>
  <label>Email <input type="email" name="email" required></label>
  <label>Password <input type="password" name="password" minlength="6" required></label>
  <label>Phone <input type="text" name="phone" required></label>
  <label>Address <textarea name="address" rows="3" required></textarea></label>
  <button class="btn" type="submit">Register</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
