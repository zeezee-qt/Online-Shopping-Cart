<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

$message = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $comments = trim($_POST['comments'] ?? '');
        $stmt = db()->prepare('INSERT INTO feedback (name, email, comments) VALUES (:name, :email, :comments)');
        $stmt->execute(['name' => $name, 'email' => $email, 'comments' => $comments]);
        $message = 'Thank you for your feedback!';
    } catch (Throwable $e) {
        $error = 'Unable to save feedback. Ensure database is configured.';
    }
}
?>
<h2>Customer Feedback</h2>
<?php if ($message): ?><p class="success"><?= htmlspecialchars($message) ?></p><?php endif; ?>
<?php if ($error): ?><p class="notice"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" class="form-card">
  <label>Name <input type="text" name="name" required></label>
  <label>Email <input type="email" name="email" required></label>
  <label>Feedback <textarea name="comments" rows="5" required></textarea></label>
  <button class="btn" type="submit">Send Feedback</button>
</form>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
